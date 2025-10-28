<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Sinkronisasi Buku dari Sarpras
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div
                    class="px-3 py-2 rounded-md text-sm bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-4">
                <form method="POST" action="{{ route('books.sync.run') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    @csrf
                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Pencarian (opsional)</label>
                        <input type="text" name="q"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                            placeholder="judul/kode">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Tahun (opsional)</label>
                        <input type="number" name="year"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                            min="1900" max="{{ now()->year }}">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Status</label>
                        <select name="status[]" class="select2 w-full" multiple data-placeholder="Pilih status">
                            @foreach (['Aktif', 'Dipinjam', 'Maintenance', 'Rusak', 'Disposed'] as $s)
                                <option value="{{ $s }}" @selected(in_array($s, old('status', ['Aktif', 'Dipinjam', 'Maintenance', 'Rusak'])))>{{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-4">
                        <button class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm">Mulai
                            Sync</button>
                    </div>
                </form>

                <div class="text-sm text-gray-600 dark:text-gray-300">
                    <div>Sinkron terakhir: <strong>{{ $last ?? '—' }}</strong></div>
                    <div class="mt-2">
                        <div>Ringkasan:</div>
                        <ul class="list-disc ms-5">
                            <li>Judul dibuat: <strong>{{ $sum['createdBooks'] ?? 0 }}</strong></li>
                            <li>Judul diperbarui: <strong>{{ $sum['updatedBooks'] ?? 0 }}</strong></li>
                            <li>Eksemplar dibuat: <strong>{{ $sum['createdItems'] ?? 0 }}</strong></li>
                            <li>Eksemplar diperbarui: <strong>{{ $sum['updatedItems'] ?? 0 }}</strong></li>
                        </ul>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('books.index') }}"
                        class="px-3 py-1.5 rounded-md bg-gray-600 hover:bg-gray-700 text-white text-xs">
                        ← Kembali ke Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
