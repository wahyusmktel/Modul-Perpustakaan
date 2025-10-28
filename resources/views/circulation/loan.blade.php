<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Sirkulasi Peminjaman Buku
            </h2>
            {{-- Form Reset Sesi kita pindah ke sini agar lebih rapi --}}
            <form id="reset-loan" method="POST" action="{{ route('circulation.loan.reset') }}">
                @csrf
                <button type_="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium transition-colors shadow-sm">
                    {{-- Ikon Heroicons: arrow-path --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M15.312 11.424a5.5 5.5 0 01-9.204-4.59l.783.783a.75.75 0 101.06-1.06L6.03 4.636a.75.75 0 00-1.06 0L3.048 6.558a.75.75 0 101.06 1.06l.783-.783a7 7 0 109.42-3.927.75.75 0 00-1.04-.017 5.5 5.5 0 01-8.19 6.53zM4.688 8.576a5.5 5.5 0 019.204 4.59l-.783-.783a.75.75 0 10-1.06 1.06l1.922 1.922a.75.75 0 001.06 0l1.922-1.922a.75.75 0 10-1.06-1.06l-.783.783a7 7 0 10-9.42 3.927.75.75 0 001.04.017 5.5 5.5 0 018.19-6.53z"
                            clip-rule="evenodd" />
                    </svg>
                    Reset Sesi
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm bg-emerald-50 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800">
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- KARTU 1: TENTUKAN ANGGOTA --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        1. Tentukan Anggota Peminjam
                    </h3>

                    @if ($member)
                        {{-- Tampilan jika anggota SUDAH di-set --}}
                        <div
                            class="p-4 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-6 h-6 text-emerald-600 dark:text-emerald-400">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div class="text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Anggota Terpilih:</span>
                                    <strong
                                        class="block text-base text-gray-900 dark:text-gray-100">{{ $member->name }}</strong>
                                    <span
                                        class="font-mono text-xs text-gray-500 dark:text-gray-400">({{ $member->code }})</span>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Tampilan jika anggota BELUM di-set --}}
                        <form method="POST" action="{{ route('circulation.loan.addItem') }}"
                            class="flex gap-2 items-end">
                            @csrf
                            <input type="hidden" name="action" value="set_member">
                            <div class="flex-grow">
                                <label for="member_or_code"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode
                                    Anggota</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-5 h-5 text-gray-400">
                                            <path
                                                d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.095a1.23 1.23 0 00.41-1.412A9.99 9.99 0 0010 12.75a9.99 9.99 0 00-6.535 1.743z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="member_or_code" id="member_or_code"
                                        value="{{ $member->code ?? '' }}"
                                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 pl-10 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                        placeholder="Masukkan Kode Anggota...">
                                </div>
                            </div>
                            <button
                                class="inline-flex items-center gap-2 h-10 px-4 py-2 rounded-md bg-sky-600 hover:bg-sky-700 text-white text-sm font-medium transition-colors">
                                {{-- Ikon Heroicons: arrow-right-circle --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                Set
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- KARTU 2: SCAN EKSEMPLAR (Nonaktif jika member belum diset) --}}
            <fieldset @disabled(!$member)
                class="disabled:opacity-50 disabled:pointer-events-none transition-opacity">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        2. Scan Eksemplar Buku
                    </h3>
                    <form method="POST" action="{{ route('circulation.loan.addItem') }}" class="flex gap-2 items-end">
                        @csrf
                        <input type="hidden" name="action" value="add_item">
                        <div class="flex-grow">
                            <label for="barcode"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Barcode
                                Eksemplar</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    {{-- Ikon Heroicons: barcode --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5 text-gray-400">
                                        <path fill-rule="evenodd"
                                            d="M1.5 4.5A1.5 1.5 0 013 3h1.5a.75.75 0 010 1.5H3a.75.75 0 00-.75.75V6a.75.75 0 01-1.5 0V4.5zM3 15.75A.75.75 0 003.75 15H5.25a.75.75 0 010 1.5H3A1.5 1.5 0 011.5 15v-1.5a.75.75 0 011.5 0v1.5zM17 3a1.5 1.5 0 011.5 1.5v1.5a.75.75 0 01-1.5 0V5.25a.75.75 0 00-.75-.75H14.75a.75.75 0 010-1.5H17zM15.75 15a.75.75 0 00-.75.75v.75H14.75a.75.75 0 010 1.5H17a1.5 1.5 0 011.5-1.5v-1.5a.75.75 0 01-1.5 0v1.5zM5 6.25a.75.75 0 01.75-.75h.5a.75.75 0 010 1.5h-.5a.75.75 0 01-.75-.75zM8.25 5.5a.75.75 0 01.75.75v9a.75.75 0 01-1.5 0v-9a.75.75 0 01.75-.75zM11.5 6.25a.75.75 0 01.75-.75h.5a.75.75 0 010 1.5h-.5a.75.75 0 01-.75-.75zM14.75 5.5a.75.75 0 01.75.75v9a.75.75 0 01-1.5 0v-9a.75.75 0 01.75-.75z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="barcode" id="barcode"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 pl-10 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                    placeholder="Scan barcode buku di sini..."
                                    @if ($member) autofocus @endif>
                            </div>
                        </div>
                        <button
                            class="inline-flex items-center gap-2 h-10 px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition-colors">
                            {{-- Ikon Heroicons: plus --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-5 h-5">
                                <path
                                    d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Tambah
                        </button>
                    </form>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">Maksimal item dipinjam:
                        <strong>{{ $max }}</strong>
                    </div>
                </div>
            </fieldset>

            {{-- KARTU 3: KERANJANG PEMINJAMAN (Nonaktif jika member belum diset) --}}
            <fieldset @disabled(!$member)
                class="disabled:opacity-50 disabled:pointer-events-none transition-opacity">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            3. Keranjang Peminjaman ({{ $items->count() }} / {{ $max }} item)
                        </h3>

                        {{-- Tabel Keranjang --}}
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/40">
                                    <tr>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                            Barcode</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                            Judul</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                            Copy #</th>
                                        <th scope="col"
                                            class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($items as $it)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/40 transition-colors">
                                            <td class="px-4 py-3 text-sm font-mono text-gray-700 dark:text-gray-300">
                                                {{ $it->barcode }}</td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $it->book->title }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                                #{{ $it->copy_no }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <form method="POST"
                                                    action="{{ route('circulation.loan.addItem') }}">
                                                    @csrf
                                                    <input type="hidden" name="action" value="remove_item">
                                                    <input type="hidden" name="barcode"
                                                        value="{{ $it->barcode }}">
                                                    <button type="submit"
                                                        class="p-1.5 rounded-md bg-rose-600 hover:bg-rose-700 text-white transition-colors"
                                                        title="Hapus item">
                                                        {{-- Ikon Heroicons: trash --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-4 h-4">
                                                            <path fill-rule="evenodd"
                                                                d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.84-10.518.149.022a.75.75 0 10.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.84 0a.75.75 0 01-1.5.06l-.3 7.5a.75.75 0 111.5-.06l.3-7.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div
                                                    class="flex flex-col items-center justify-center text-center py-12 px-6">
                                                    {{-- Ikon Heroicons: shopping-cart --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.121 0 .239.035.348.104.109.068.203.16.27.271l2.813 5.033c.07.124.105.26.105.401V20.25a.75.75 0 01-.75.75H5.633a.75.75 0 01-.75-.75v-1.828a.75.75 0 01.105-.401l2.813-5.033a.75.75 0 01.27-.271.75.75 0 01.348-.104zM6 18a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                    </svg>
                                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                        Keranjang Kosong
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                        Silakan scan barcode buku di atas untuk memulai.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tombol Aksi Final (Commit) --}}
                    <div
                        class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                        <form method="POST" action="{{ route('circulation.loan.commit') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                                @disabled($items->isEmpty())>
                                {{-- Ikon Heroicons: check-circle --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd" />
                                </svg>
                                Proses Peminjaman
                            </button>
                        </form>
                    </div>
                </div>
            </fieldset>

        </div>
    </div>
</x-app-layout>
