<x-app-layout>
    {{-- Slot Header dengan Judul Halaman dan Tombol Aksi Utama --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Daftar Anggota Perpustakaan
            </h2>

            {{-- Tombol Aksi Utama (Level Halaman) --}}
            <div class="flex items-center gap-2 mt-4 md:mt-0">
                <a href="{{ route('members.import.form') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium transition-colors shadow-sm">
                    {{-- Ikon Heroicons: arrow-up-on-square --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v5.59L7.72 9.72a.75.75 0 00-1.06 1.06l2.5 2.5a.75.75 0 001.06 0l2.5-2.5a.75.75 0 10-1.06-1.06L10.75 13.59V6.75z"
                            clip-rule="evenodd" />
                    </svg>
                    Import Excel
                </a>
                <a href="{{ route('members.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition-colors shadow-sm">
                    {{-- Ikon Heroicons: plus --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Tambah Anggota
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm bg-emerald-50 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800">
                    {{-- Ikon Heroicons: check-circle --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Kartu Konten Utama (Filter + Tabel + Paginasi) --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">

                {{-- Bagian Filter dan Pencarian --}}
                <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
                    <form method="GET">
                        <div class="flex flex-col md:flex-row md:items-center gap-3">
                            {{-- Input Pencarian dengan Ikon --}}
                            <div class="relative flex-grow">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    {{-- Ikon Heroicons: magnifying-glass --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd"
                                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="q" value="{{ $q }}"
                                    placeholder="Cari nama, kode, email, atau telepon..."
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 pl-10 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            </div>
                            {{-- Select Status --}}
                            <select name="status"
                                class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="">Semua Status</option>
                                <option value="active" @selected($status === 'active')>Aktif</option>
                                <option value="inactive" @selected($status === 'inactive')>Nonaktif</option>
                            </select>
                            {{-- Tombol Filter dan Reset --}}
                            <div class="flex items-center gap-2">
                                <button
                                    class="inline-flex justify-center w-full md:w-auto px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition-colors">
                                    Filter
                                </button>
                                <a href="{{ route('members.index') }}"
                                    class="inline-flex justify-center w-full md:w-auto px-4 py-2 rounded-md bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium transition-colors">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Kontainer Tabel agar Responsif --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    #</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Kode</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Nama</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Kontak</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Status</th>
                                <th scope="col"
                                    class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($members as $i => $m)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $members->firstItem() + $i }}</td>
                                    <td class="px-4 py-3 text-sm font-mono text-gray-900 dark:text-gray-100">
                                        {{ $m->code }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $m->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        <div>{{ $m->email ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $m->phone ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @php
                                            $cls =
                                                $m->status === 'active'
                                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200'
                                                    : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200';
                                        @endphp
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $cls }}">{{ $m->status }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium">
                                        {{-- Wrapper untuk Tombol Aksi --}}
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('members.edit', $m) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-xs transition-colors">
                                                {{-- Ikon Heroicons: pencil-square --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" class="w-4 h-4">
                                                    <path
                                                        d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3L14.5 9.42a4 4 0 01-1.343 2.342L9.617 15.433A2.121 2.121 0 017.5 16.25h-1.875a1.875 1.875 0 01-1.875-1.875v-1.875a2.121 2.121 0 01.708-1.583zM16.25 5.75l-1 1-3-3 1-1a.625.625 0 01.884 0l1.233 1.233a.625.625 0 010 .884z" />
                                                    <path
                                                        d="M6.25 10.333V15.75a.625.625 0 00.625.625h5.417a.625.625 0 00.625-.625v-5.417a.625.625 0 00-.625-.625h-5.417a.625.625 0 00-.625.625z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('members.destroy', $m) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Anda yakin ingin menghapus anggota ini?');">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-rose-600 hover:bg-rose-700 text-white text-xs transition-colors">
                                                    {{-- Ikon Heroicons: trash --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="w-4 h-4">
                                                        <path fill-rule="evenodd"
                                                            d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.84-10.518.149.022a.75.75 0 10.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.84 0a.75.75 0 01-1.5.06l-.3 7.5a.75.75 0 111.5-.06l.3-7.5z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- Tampilan Saat Data Kosong --}}
                                <tr>
                                    <td colspan="6">
                                        <div class="flex flex-col items-center justify-center text-center py-16 px-6">
                                            {{-- Ikon Heroicons: user-group --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M18 18.72a9.094 9.094 0 00-12 0m12 0a9.094 9.094 0 01-12 0m12 0A9.094 9.094 0 016 18.72m12 0A9.094 9.094 0 006 18.72m0 0A9.094 9.094 0 006 18.72M3 12.036A9.001 9.001 0 0112 3c4.97 0 9 4.03 9 9s-4.03 9-9 9-9-4.03-9-9zM15 9a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                Data Tidak Ditemukan
                                            </h3>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                Tidak ada anggota yang cocok dengan kriteria pencarian Anda.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Bagian Paginasi --}}
                @if ($members->hasPages())
                    <div class="p-4 md:p-6 border-t border-gray-200 dark:border-gray-700">
                        {{ $members->links() }}
                    </div>
                @endif

            </div> {{-- Akhir Kartu Konten Utama --}}
        </div>
    </div>
</x-app-layout>
