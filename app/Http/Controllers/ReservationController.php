<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Member;
use App\Models\Book;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q', ''));
        $status = (string)$request->get('status', '');

        $res = Reservation::with(['member', 'book'])
            ->when($q !== '', function ($qq) use ($q) {
                $qq->whereHas('member', fn($m) => $m->where('name', 'like', "%{$q}%")->orWhere('code', 'like', "%{$q}%"))
                    ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%{$q}%"));
            })
            ->when(
                in_array($status, ['queued', 'ready', 'picked', 'cancelled'], true),
                fn($qq) => $qq->where('status', $status)
            )
            ->orderByRaw("FIELD(status,'ready','queued','picked','cancelled')") // ready duluan
            ->orderBy('queued_at', 'asc')
            ->paginate(10)->withQueryString();

        return view('reservations.index', compact('res', 'q', 'status'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_code' => 'required|string|max:100',
            'book_id'     => 'required|exists:books,id',
        ]);

        $member = Member::where('code', $data['member_code'])->first();
        if (!$member) return back()->with('error', 'Anggota tidak ditemukan.');

        // Cegah duplikat aktif
        $exists = Reservation::where('member_id', $member->id)
            ->where('book_id', $data['book_id'])
            ->active()->exists();
        if ($exists) return back()->with('error', 'Reservasi aktif sudah ada.');

        Reservation::create([
            'member_id' => $member->id,
            'book_id'   => (int) $data['book_id'],
            'status'    => 'queued',
            'queued_at' => now(),
        ]);

        return back()->with('success', 'Reservasi ditambahkan ke antrean.');
    }

    public function markReady(Reservation $res, \App\Services\LoanPolicyService $policy)
    {
        if ($res->status !== 'queued') return back()->with('error', 'Reservasi bukan antrean.');
        $res->status = 'ready';
        $res->ready_at = now();
        $res->ready_expire_at = now()->addDays($policy->readyDays());
        $res->save();
        return back()->with('success', 'Reservasi ditandai siap diambil.');
    }

    public function markPicked(Reservation $res)
    {
        if ($res->status !== 'ready') return back()->with('error', 'Reservasi belum siap.');
        $res->status = 'picked';
        $res->picked_at = now();
        $res->save();
        return back()->with('success', 'Reservasi ditandai sudah diambil.');
    }

    public function cancel(Reservation $res)
    {
        if (in_array($res->status, ['picked', 'cancelled'], true))
            return back()->with('error', 'Reservasi tidak bisa dibatalkan.');

        $res->status = 'cancelled';
        $res->save();
        return back()->with('success', 'Reservasi dibatalkan.');
    }
}
