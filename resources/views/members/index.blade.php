<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Anggota Perpustakaan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div
                    class="px-3 py-2 rounded-md text-sm bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <form method="GET" class="flex flex-wrap items-center gap-2">
                        <input type="text" name="q" value="{{ $q }}"
                            placeholder="Cari nama/kode/email/telepon..."
                            class="w-64 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        <select name="status" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                            <option value="">Semua Status</option>
                            <option value="active" @selected($status === 'active')>Aktif</option>
                            <option value="inactive" @selected($status === 'inactive')>Nonaktif</option>
                        </select>
                        <button
                            class="px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm">Filter</button>
                        <a href="{{ route('members.index') }}"
                            class="px-3 py-2 rounded-md bg-gray-600 hover:bg-gray-700 text-white text-sm">Reset</a>
                    </form>
                    <a href="{{ route('members.create') }}"
                        class="inline-flex items-center px-3 py-2 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white text-sm">
                        + Tambah Anggota
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">#</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Kode</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Kontak</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($members as $i => $m)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40">
                                    <td class="px-4 py-3 text-sm">{{ $members->firstItem() + $i }}</td>
                                    <td class="px-4 py-3 text-sm font-mono">{{ $m->code }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $m->name }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div>{{ $m->email ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $m->phone ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @php
                                            $cls =
                                                $m->status === 'active'
                                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-200'
                                                    : 'bg-slate-200 text-slate-800 dark:bg-slate-700 dark:text-slate-200';
                                        @endphp
                                        <span
                                            class="px-2 py-0.5 rounded text-xs font-medium {{ $cls }}">{{ $m->status }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('members.edit', $m) }}"
                                            class="inline-flex items-center px-3 py-1.5 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-xs">Edit</a>
                                        <form action="{{ route('members.destroy', $m) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Hapus anggota ini?');">
                                            @csrf @method('DELETE')
                                            <button
                                                class="inline-flex items-center px-3 py-1.5 rounded-md bg-rose-600 hover:bg-rose-700 text-white text-xs">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada
                                        data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $members->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
