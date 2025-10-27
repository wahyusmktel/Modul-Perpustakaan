<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Buku
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs rounded-md">
                        ← Kembali
                    </a>
                    <div class="text-xs text-gray-500">
                        Terakhir diperbarui: {{ $book['data']['updated_at'] ?? '-' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-gray-500">Kode Aset YPT</div>
                        <div class="font-mono">{{ $book['data']['asset_code_ypt'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Judul/Nama Buku</div>
                        <div class="font-semibold">{{ $book['data']['name'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Tahun</div>
                        <div>{{ $book['data']['purchase_year'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Lokasi</div>
                        <div>{{ $book['data']['building'] ?? '-' }} / {{ $book['data']['room'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">PIC</div>
                        <div>{{ $book['data']['person_in_charge'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Status</div>
                        @php
                            $s = $book['data']['status'] ?? '-';
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
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Harga (Rp)</div>
                        <div>Rp {{ number_format((float) ($book['data']['purchase_cost'] ?? 0), 0, ',', '.') }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
