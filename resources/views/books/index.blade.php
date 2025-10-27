<x-app-layout>
    {{-- Slot Header dengan Judul Halaman dan Tombol Aksi Utama --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Daftar Buku Perpustakaan
            </h2>

            {{-- Tombol Aksi Utama (Level Halaman) --}}
            <div class="flex items-center gap-2 mt-4 md:mt-0">
                <a href="{{ route('books.export.excel', request()->query()) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium transition-colors shadow-sm">
                    {{-- Ikon Heroicons: arrow-down-tray --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.28 8.43a.75.75 0 10-1.06 1.06l4.25 4.25a.75.75 0 001.06 0l4.25-4.25a.75.75 0 10-1.06-1.06l-2.97 2.97V2.75z" />
                        <path
                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                    Export Excel
                </a>
                <a href="{{ route('books.export.pdf', request()->query()) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium transition-colors shadow-sm">
                    {{-- Ikon Heroicons: arrow-down-tray --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.28 8.43a.75.75 0 10-1.06 1.06l4.25 4.25a.75.75 0 001.06 0l4.25-4.25a.75.75 0 10-1.06-1.06l-2.97 2.97V2.75z" />
                        <path
                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                    </svg>
                    Export PDF
                </a>
                <a href="{{ route('books.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition-colors shadow-sm">
                    {{-- Ikon Heroicons: plus --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path
                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    Tambah Buku
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
            {{-- Pesan Error --}}
            @if (session('error'))
                <div
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm bg-rose-50 text-rose-800 dark:bg-rose-900/30 dark:text-rose-200 border border-rose-200 dark:border-rose-800">
                    {{-- Ikon Heroicons: x-circle --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Kartu Konten Utama (Filter + Tabel + Paginasi) --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">

                {{-- Bagian Filter dan Pencarian --}}
                <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
                    <form method="GET" action="{{ route('books.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            {{-- Pencarian --}}
                            <div class="md:col-span-2">
                                <label for="q"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pencarian</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        {{-- Ikon Heroicons: magnifying-glass --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5 text-gray-400">
                                            <path fill-rule="evenodd"
                                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" name="q" id="q" value="{{ $q }}"
                                        placeholder="Cari nama/kode buku..."
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 pl-10 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>
                            </div>

                            {{-- Tahun (Select2) --}}
                            <div>
                                <label for="year"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                                <select name="year" id="year"
                                    class="select2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                    data-placeholder="Semua Tahun">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($years as $y)
                                        <option value="{{ $y }}" @selected((string) $year === (string) $y)>
                                            {{ $y }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Status (Select2 multiple) --}}
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                <select name="status[]" id="status" multiple
                                    class="select2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                    data-placeholder="Semua Status">
                                    @foreach ($allStatuses as $st)
                                        <option value="{{ $st }}" @selected(collect($statuses)->contains($st))>
                                            {{ $st }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tombol --}}
                            <div class="md:col-span-4 flex items-center justify-end gap-2">
                                <button
                                    class="inline-flex justify-center w-full md:w-auto px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition-colors">
                                    Filter
                                </button>
                                <a href="{{ route('books.index') }}"
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
                                    Kode Aset YPT</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Judul/Nama Buku</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Tahun</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Lokasi</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    PIC</th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Status</th>
                                <th scope="col"
                                    class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($books as $i => $b)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $paginator->firstItem() + $i }}
                                    </td>
                                    <td class="px-4 py-3 font-mono text-xs text-gray-700 dark:text-gray-300">
                                        {{ $b['asset_code_ypt'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $b['name'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $b['purchase_year'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $b['building'] ?? '-' }} / {{ $b['room'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $b['person_in_charge'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $s = $b['status'] ?? '-';
                                            $cls = match ($s) {
                                                'Aktif'
                                                    => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200',
                                                'Dipinjam'
                                                    => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-200',
                                                'Maintenance'
                                                    => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-200',
                                                'Rusak'
                                                    => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-200',
                                                'Disposed'
                                                    => 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                                                default
                                                    => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200',
                                            };
                                        @endphp
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $cls }}">{{ $s }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('books.show', $b['id']) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs rounded-md font-medium transition-colors">
                                            {{-- Ikon Heroicons: information-circle --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="w-4 h-4">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7.5-1.25a.75.75 0 00-1.5 0v5a.75.75 0 001.5 0v-5zM10 12.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                {{-- Tampilan Saat Data Kosong --}}
                                <tr>
                                    <td colspan="8">
                                        <div class="flex flex-col items-center justify-center text-center py-16 px-6">
                                            {{-- Ikon Heroicons: book-open --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-16 h-16 text-gray-400 dark:text-gray-500 mb-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                Data Buku Tidak Ditemukan
                                            </h3>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                Tidak ada buku yang cocok dengan kriteria filter Anda.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Bagian Paginasi --}}
                @if ($paginator->hasPages())
                    <div class="p-4 md:p-6 border-t border-gray-200 dark:border-gray-700">
                        {{ $paginator->links() }}
                    </div>
                @endif

            </div> {{-- Akhir Kartu Konten Utama --}}

        </div>
    </div>

    {{-- Script untuk Select2 (jika diperlukan) --}}
    @push('scripts')
        <script>
            // Inisialisasi Select2 jika Anda menggunakannya
            // $(document).ready(function() {
            //     $('.select2').select2();
            // });
        </script>
    @endpush
</x-app-layout>
