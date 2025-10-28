<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Pengembalian</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div
                    class="px-3 py-2 rounded-md text-sm bg-emerald-50 text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-200">
                    {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div
                    class="px-3 py-2 rounded-md text-sm bg-rose-50 text-rose-700 dark:bg-rose-900/20 dark:text-rose-200">
                    {{ session('error') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('circulation.return.process') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Scan/Ketik Barcode
                            Eksemplar</label>
                        <input name="barcode" autofocus
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        @error('barcode')
                            <div class="text-xs text-rose-500">{{ $message }}</div>
                        @enderror
                    </div>
                    <button
                        class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm">Proses</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
