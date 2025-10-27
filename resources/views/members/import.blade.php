<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Import Anggota (Excel)
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 flex items-center justify-between">
                    <a href="{{ route('members.index') }}"
                        class="px-3 py-2 rounded-md bg-gray-600 hover:bg-gray-700 text-white text-sm">← Kembali</a>
                    <a href="{{ route('members.import.template') }}"
                        class="px-3 py-2 rounded-md bg-slate-700 hover:bg-slate-800 text-white text-sm">⬇️ Unduh
                        Template</a>
                </div>

                <form method="POST" action="{{ route('members.import.handle') }}" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">File Excel
                            (.xlsx/.xls/.csv)</label>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 p-2">
                        @error('file')
                            <div class="text-xs text-rose-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        Kolom wajib: <code>code</code>, <code>name</code>. Opsi: <code>email</code>, <code>phone</code>,
                        <code>address</code>, <code>expires_at</code> (YYYY-MM-DD), <code>status</code>
                        (active/inactive).
                        <br>Baris dengan <b>code</b> yang sama akan di-<i>update</i>.
                    </div>

                    <div>
                        <button class="px-4 py-2 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white text-sm">
                            Import Sekarang
                        </button>
                    </div>
                </form>
            </div>

            @if (session('import_errors'))
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-semibold mb-2">Detail Error Import</div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr>
                                    <th class="px-2 py-1 border">Row</th>
                                    <th class="px-2 py-1 border">Kolom</th>
                                    <th class="px-2 py-1 border">Pesan</th>
                                    <th class="px-2 py-1 border">Values</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('import_errors') as $err)
                                    <tr>
                                        <td class="px-2 py-1 border align-top">{{ $err['row'] }}</td>
                                        <td class="px-2 py-1 border align-top">{{ $err['attribute'] }}</td>
                                        <td class="px-2 py-1 border align-top">
                                            <ul class="list-disc ms-4">
                                                @foreach ($err['errors'] as $e)
                                                    <li>{{ $e }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="px-2 py-1 border align-top">
                                            <pre class="text-xs">{{ json_encode($err['values'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
