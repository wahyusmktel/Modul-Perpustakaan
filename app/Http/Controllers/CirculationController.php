<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\BookItem;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Services\LoanPolicyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CirculationController extends Controller
{
    // ====== PINJAM ======
    public function loanForm(Request $request, LoanPolicyService $policy)
    {
        // sesi "cart" sederhana: member_code + daftar barcodes
        $cart = session('loan_cart', ['member_code' => null, 'items' => []]);

        $member = null;
        if ($cart['member_code']) {
            $member = Member::where('code', $cart['member_code'])->first();
        }

        $items = collect($cart['items'])->map(function ($barcode) {
            return BookItem::with('book')->where('barcode', $barcode)->first();
        })->filter();

        return view('circulation.loan', [
            'member' => $member,
            'items'  => $items,
            'max'    => $policy->maxItems(),
        ]);
    }

    public function loanAddItem(Request $request, LoanPolicyService $policy)
    {
        $request->validate([
            'member_or_code' => 'nullable|string|max:100',
            'barcode'        => 'nullable|string|max:100',
            'action'         => 'required|in:set_member,add_item,remove_item',
        ]);

        $cart = session('loan_cart', ['member_code' => null, 'items' => []]);

        switch ($request->action) {
            case 'set_member':
                $code = trim((string) $request->member_or_code);
                $member = Member::where('code', $code)->first();
                if (!$member) return back()->with('error', 'Anggota tidak ditemukan.');
                $cart['member_code'] = $member->code;
                break;

            case 'add_item':
                if (count($cart['items']) >= $policy->maxItems())
                    return back()->with('error', 'Maksimal item pada transaksi ini tercapai.');
                $barcode = trim((string) $request->barcode);
                $item = BookItem::where('barcode', $barcode)->first();
                if (!$item) return back()->with('error', 'Eksemplar tidak ditemukan.');
                if ($item->status !== 'available') return back()->with('error', 'Eksemplar tidak tersedia.');
                if (!in_array($barcode, $cart['items'])) $cart['items'][] = $barcode;
                break;

            case 'remove_item':
                $barcode = trim((string) $request->barcode);
                $cart['items'] = array_values(array_filter($cart['items'], fn($b) => $b !== $barcode));
                break;
        }

        session(['loan_cart' => $cart]);
        return redirect()->route('circulation.loan.form');
    }

    public function loanCommit(Request $request, LoanPolicyService $policy)
    {
        $cart = session('loan_cart', ['member_code' => null, 'items' => []]);
        if (!$cart['member_code']) return back()->with('error', 'Anggota belum diset.');
        if (empty($cart['items'])) return back()->with('error', 'Tidak ada item.');

        $member = Member::where('code', $cart['member_code'])->firstOrFail();
        $items  = BookItem::whereIn('barcode', $cart['items'])->lockForUpdate()->get();

        if ($items->count() !== count($cart['items'])) return back()->with('error', 'Ada item yang tidak valid.');

        // validasi ketersediaan ulang
        foreach ($items as $it) {
            if ($it->status !== 'available') return back()->with('error', 'Ada item sudah tidak tersedia.');
        }

        DB::transaction(function () use ($member, $items, $policy) {
            $loan = Loan::create([
                'member_id' => $member->id,
                'loan_date' => now()->toDateString(),
                'due_date'  => $policy->dueDate()->toDateString(),
                'status'    => 'open',
            ]);

            foreach ($items as $it) {
                LoanItem::create([
                    'loan_id'      => $loan->id,
                    'book_item_id' => $it->id,
                    'fine_amount'  => 0,
                ]);
                $it->status = 'on_loan';
                $it->save();
            }
        });

        session()->forget('loan_cart');
        return redirect()->route('circulation.loan.form')->with('success', 'Peminjaman berhasil dibuat.');
    }

    public function loanReset()
    {
        session()->forget('loan_cart');
        return redirect()->route('circulation.loan.form');
    }

    // ====== KEMBALI ======
    public function returnForm()
    {
        return view('circulation.return');
    }

    public function returnProcess(Request $request, LoanPolicyService $policy)
    {
        $request->validate(['barcode' => 'required|string|max:100']);

        $item = BookItem::where('barcode', trim($request->barcode))->first();
        if (!$item) return back()->with('error', 'Eksemplar tidak ditemukan.');

        // Temukan loan item aktif
        $loanItem = LoanItem::where('book_item_id', $item->id)
            ->whereNull('returned_at')
            ->orderByDesc('id')
            ->first();

        if (!$loanItem) return back()->with('error', 'Eksemplar ini tidak sedang dipinjam.');

        DB::transaction(function () use ($loanItem, $item, $policy) {
            $loanItem->returned_at = now();
            // hitung denda per item
            $fine = $policy->fineForReturn($loanItem->loan->due_date, $loanItem->returned_at);
            $loanItem->fine_amount = $fine;
            $loanItem->save();

            // update item
            $item->status = 'available';
            $item->save();

            // update loan summary
            $loan = $loanItem->loan;
            $loan->total_fine = $loan->items()->sum('fine_amount');
            // jika semua kembali, set return_date & status
            $allReturned = $loan->items()->whereNull('returned_at')->count() === 0;
            if ($allReturned) {
                $loan->return_date = now()->toDateString();
                $loan->status = $loan->total_fine > 0 ? 'overdue' : 'closed';
            }
            $loan->save();
        });

        return back()->with('success', 'Pengembalian diproses.');
    }
}
