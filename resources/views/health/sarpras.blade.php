<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Health Check — Integrasi Sarpras
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <div class="text-xs text-gray-500">Endpoint</div>
                        <div class="font-mono">{{ $config['base_url'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Token</div>
                        <div>{{ $config['token_set'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Timeout / Retry</div>
                        <div>{{ $config['timeout'] }}s / {{ $config['retry'] }}x</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500">Latency</div>
                        <div>{{ $latencyMs }} ms</div>
                    </div>
                </div>

                <div>
                    <div class="text-sm font-semibold mb-1">Status</div>
                    @if ($ok)
                        <div
                            class="px-3 py-2 rounded bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-200">
                            OK — Koneksi & token valid.
                        </div>
                    @else
                        <div class="px-3 py-2 rounded bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-200">
                            ERROR — {{ $error }}
                        </div>
                    @endif
                </div>

                <div>
                    <div class="text-sm font-semibold mb-2">Sampel Data</div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm border">
                            <thead>
                                <tr>
                                    <th class="border px-2 py-1">#</th>
                                    <th class="border px-2 py-1">Kode</th>
                                    <th class="border px-2 py-1">Nama</th>
                                    <th class="border px-2 py-1">Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($samples as $i => $s)
                                    <tr>
                                        <td class="border px-2 py-1">{{ $i + 1 }}</td>
                                        <td class="border px-2 py-1">{{ $s['asset_code_ypt'] ?? '-' }}</td>
                                        <td class="border px-2 py-1">{{ $s['name'] ?? '-' }}</td>
                                        <td class="border px-2 py-1">{{ $s['purchase_year'] ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border px-2 py-2 text-center text-gray-500">Tidak ada
                                            sampel.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('books.index') }}"
                        class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs rounded-md">
                        ← Kembali ke Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
