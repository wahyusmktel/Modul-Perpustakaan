<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tambah Anggota</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('members.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400">Kode (NIS/NIP)</label>
                        <input name="code" value="{{ old('code') }}" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        @error('code')
                            <div class="text-xs text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400">Nama</label>
                        <input name="name" value="{{ old('name') }}" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        @error('name')
                            <div class="text-xs text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        @error('email')
                            <div class="text-xs text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400">Telepon</label>
                        <input name="phone" value="{{ old('phone') }}"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        @error('phone')
                            <div class="text-xs text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs text-gray-500 dark:text-gray-400">Alamat</label>
                        <input name="address" value="{{ old('address') }}"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        @error('address')
                            <div class="text-xs text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400">Berlaku s.d.</label>
                        <input name="expires_at" type="date" value="{{ old('expires_at') }}"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        @error('expires_at')
                            <div class="text-xs text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-gray-400">Status</label>
                        <select name="status"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                            <option value="active" @selected(old('status', 'active') === 'active')>Aktif</option>
                            <option value="inactive" @selected(old('status') === 'inactive')>Nonaktif</option>
                        </select>
                        @error('status')
                            <div class="text-xs text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="md:col-span-2 flex items-center gap-2">
                        <a href="{{ route('members.index') }}"
                            class="px-3 py-2 rounded-md bg-gray-600 hover:bg-gray-700 text-white text-sm">← Kembali</a>
                        <button
                            class="px-3 py-2 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
