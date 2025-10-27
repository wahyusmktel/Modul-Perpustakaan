<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Buku (Perpustakaan)
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="px-3 py-2 rounded-md text-sm bg-emerald-50 text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="px-3 py-2 rounded-md text-sm bg-rose-50 text-rose-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{-- kosong / info kecil opsional --}}
                    </div>
                    <a href="{{ route('books.create') }}"
                        class="inline-flex items-center px-3 py-2 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white text-sm">
                        + Tambah Buku
                    </a>
                </div>

                <form method="GET" action="{{ route('books.index') }}"
                    class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-2 items-start">
                    {{-- Pencarian --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Pencarian</label>
                        <input type="text" name="q" value="{{ $q }}"
                            placeholder="Cari nama/kode buku..."
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                    </div>

                    {{-- Tahun (Select2) --}}
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Tahun</label>
                        <select name="year"
                            class="select2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                            data-placeholder="Semua Tahun">
                            <option value="">Semua Tahun</option>
                            @foreach ($years as $y)
                                <option value="{{ $y }}" @selected((string) $year === (string) $y)>{{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status (Select2 multiple) --}}
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Status</label>
                        <select name="status[]" multiple
                            class="select2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                            data-placeholder="Semua Status">
                            @foreach ($allStatuses as $st)
                                <option value="{{ $st }}" @selected(collect($statuses)->contains($st))>{{ $st }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex gap-2 items-end">
                        <button
                            class="px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm">Filter</button>
                        <a href="{{ route('books.index') }}"
                            class="px-3 py-2 rounded-md bg-gray-600 hover:bg-gray-700 text-white text-sm">Reset</a>
                    </div>

                    {{-- Export di baris bawah, full width --}}
                    <div class="md:col-span-5 flex items-center gap-2 mt-2">
                        <div class="ms-auto"></div>
                        <a href="{{ route('books.export.excel', request()->query()) }}"
                            class="inline-flex items-center px-3 py-2 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white text-sm">⬇️
                            Export Excel</a>
                        <a href="{{ route('books.export.pdf', request()->query()) }}"
                            class="inline-flex items-center px-3 py-2 rounded-md bg-rose-600 hover:bg-rose-700 text-white text-sm">⬇️
                            Export PDF</a>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">#</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Kode Aset YPT</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Judul/Nama Buku</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Tahun</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Lokasi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">PIC</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Status</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($books as $i => $b)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $paginator->firstItem() + $i }}</td>
                                    <td class="px-4 py-3 font-mono text-xs">{{ $b['asset_code_ypt'] ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $b['name'] ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $b['purchase_year'] ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $b['building'] ?? '-' }} / {{ $b['room'] ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">{{ $b['person_in_charge'] ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $s = $b['status'] ?? '-';
                                            $cls = match ($s) {
                                                'Aktif' => 'bg-green-100 text-green-800',
                                                'Dipinjam' => 'bg-blue-100 text-blue-800',
                                                'Maintenance' => 'bg-amber-100 text-amber-800',
                                                'Rusak' => 'bg-rose-100 text-rose-800',
                                                'Disposed' => 'bg-gray-200 text-gray-800',
                                                default => 'bg-slate-100 text-slate-800',
                                            };
                                        @endphp
                                        <span
                                            class="px-2 py-0.5 rounded text-xs font-medium {{ $cls }}">{{ $s }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('books.show', $b['id']) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs rounded-md">
                                            🔍 Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada
                                        data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{-- Paginasi lokal dari paginator --}}
                    {{ $paginator->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
