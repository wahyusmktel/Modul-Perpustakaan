<x-app-layout>
    {{-- Tombol "Kembali" kita pindah ke header biar rapi --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Health Check — Integrasi Sarpras
            </h2>
            <a href="{{ route('books.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium transition-colors shadow-sm">
                {{-- Ikon Heroicons: arrow-left --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                        clip-rule="evenodd" />
                </svg>
                Kembali ke Daftar Buku
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">

                {{-- 1. BLOK STATUS UTAMA (Paling Penting) --}}
                @if ($ok)
                    <div
                        class="flex items-start gap-4 p-6 bg-emerald-50 dark:bg-emerald-900/30 border-b border-emerald-200 dark:border-emerald-800">
                        {{-- Ikon Heroicons: check-circle --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-12 h-12 text-emerald-500 dark:text-emerald-400 shrink-0">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-emerald-800 dark:text-emerald-200">Koneksi Berhasil
                            </h3>
                            <p class="text-sm text-emerald-700 dark:text-emerald-300 mt-1">
                                OK — Koneksi ke API Sarpras dan token berhasil divalidasi.
                            </p>
                        </div>
                    </div>
                @else
                    <div
                        class="flex items-start gap-4 p-6 bg-rose-50 dark:bg-rose-900/30 border-b border-rose-200 dark:border-rose-800">
                        {{-- Ikon Heroicons: x-circle --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-12 h-12 text-rose-500 dark:text-rose-400 shrink-0">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-rose-800 dark:text-rose-200">Koneksi Gagal</h3>
                            <p class="text-sm text-rose-700 dark:text-rose-300 mt-1">
                                ERROR — {{ $error }}
                            </p>
                        </div>
                    </div>
                @endif

                <div class="p-6 space-y-6">
                    {{-- 2. BLOK KONFIGURASI --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-3">Detail Konfigurasi
                        </h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Endpoint API</dt>
                                <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100 break-words">
                                    {{ $config['base_url'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Token API</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    @if ($config['token_set'])
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200">
                                            TERPASANG
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-200">
                                            TIDAK TERPASANG
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Timeout / Retry</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $config['timeout'] }} detik / {{ $config['retry'] }}x percobaan
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Latency (Waktu Respon)
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    @php
                                        // Logika badge kondisional untuk latency
                                        if ($latencyMs <= 1000) {
                                            $latencyCls =
                                                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200'; // Cepat (<= 1s)
                                        } elseif ($latencyMs <= 3000) {
                                            $latencyCls =
                                                'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-200'; // Sedang (1s - 3s)
                                        } else {
                                            $latencyCls =
                                                'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-200'; // Lambat (> 3s)
                                        }
                                    @endphp
                                    <span
                                        class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $latencyCls }}">
                                        {{ $latencyMs }} ms
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    {{-- 3. BLOK SAMPEL DATA --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-3">Sampel Data Aktual
                            (Limit 5)</h4>
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
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
                                            Nama</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                            Tahun</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($samples as $i => $s)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                                {{ $i + 1 }}
                                            </td>
                                            <td class="px-4 py-3 text-sm font-mono text-gray-700 dark:text-gray-300">
                                                {{ $s['asset_code_ypt'] ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $s['name'] ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                                {{ $s['purchase_year'] ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                                Tidak ada sampel data yang diterima dari API.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
