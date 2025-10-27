<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\MemberUpdateRequest;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $q      = trim((string)$request->get('q', ''));
        $status = (string)$request->get('status', '');

        $members = Member::query()
            ->when(
                $q !== '',
                fn($qq) =>
                $qq->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('code', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%");
                })
            )
            ->when(in_array($status, ['active', 'inactive'], true), fn($qq) => $qq->where('status', $status))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('members.index', compact('members', 'q', 'status'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(MemberStoreRequest $request)
    {
        Member::create($request->validated());
        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(MemberUpdateRequest $request, Member $member)
    {
        $member->update($request->validated());
        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
