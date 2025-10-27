<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Buku (ke Sarpras)
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-4">

                <a href="{{ route('books.index') }}"
                    class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs rounded-md">
                    ← Kembali
                </a>

                <form method="POST" action="{{ route('books.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf

                    <div class="md:col-span-2">
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Judul/Nama Buku</label>
                        <input name="name" value="{{ old('name') }}" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        @error('name')
                            <div class="text-xs text-rose-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Tahun</label>
                        <select name="purchase_year" class="select2 w-full" required data-placeholder="Pilih Tahun">
                            @foreach ($years as $y)
                                <option value="{{ $y }}" @selected(old('purchase_year') == $y)>{{ $y }}
                                </option>
                            @endforeach
                        </select>
                        @error('purchase_year')
                            <div class="text-xs text-rose-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Status</label>
                        <select name="status" class="select2 w-full" data-placeholder="Pilih Status">
                            <option value="">(default: Aktif)</option>
                            @foreach ($allStatuses as $s)
                                <option value="{{ $s }}" @selected(old('status') == $s)>{{ $s }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="text-xs text-rose-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Institution</label>
                                <select id="institution_id" name="institution_id" class="select2 w-full"
                                    required></select>
                                @error('institution_id')
                                    <div class="text-xs text-rose-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Person In Charge
                                    (PIC)</label>
                                <select id="person_in_charge_id" name="person_in_charge_id"
                                    class="select2 w-full"></select>
                                @error('person_in_charge_id')
                                    <div class="text-xs text-rose-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Building</label>
                                <select id="building_id" name="building_id" class="select2 w-full"></select>
                                @error('building_id')
                                    <div class="text-xs text-rose-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Room</label>
                                <select id="room_id" name="room_id" class="select2 w-full"
                                    data-placeholder="Pilih ruangan (opsional)"></select>
                                @error('room_id')
                                    <div class="text-xs text-rose-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Harga (Rp)</label>
                                <input name="purchase_cost" value="{{ old('purchase_cost') }}" type="number"
                                    step="1" min="0"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                                @error('purchase_cost')
                                    <div class="text-xs text-rose-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <button class="px-4 py-2 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white text-sm">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function initSelect2(selector, url, extraDataFn) {
                    $(selector).select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                        placeholder: 'Pilih...',
                        ajax: {
                            url: url,
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                const base = {
                                    q: params.term || '',
                                    page: params.page || 1
                                };
                                if (typeof extraDataFn === 'function') {
                                    Object.assign(base, extraDataFn());
                                }
                                return base;
                            },
                            processResults: function(data) {
                                return {
                                    results: data.results || [],
                                    pagination: {
                                        more: data.pagination && data.pagination.more
                                    }
                                };
                            },
                            cache: true
                        },
                        minimumInputLength: 0
                    });
                }

                // Master data umum
                initSelect2('#institution_id', "{{ route('proxy.master.institutions') }}");
                initSelect2('#person_in_charge_id', "{{ route('proxy.master.persons') }}");
                initSelect2('#building_id', "{{ route('proxy.master.buildings') }}");

                // ROOM: tidak menunggu building — langsung bisa cari semua ruangan
                // Jika suatu saat building dipilih dan backend sudah punya relasi, param building_id akan ikut terkirim.
                function roomsExtra() {
                    const bid = $('#building_id').val();
                    return bid ? {
                        building_id: bid
                    } : {};
                }
                initSelect2('#room_id', "{{ route('proxy.master.rooms') }}", roomsExtra);

                // Jika building berubah, cukup trigger refresh data di Room (tanpa destroy)
                $('#building_id').on('change', function() {
                    // clear pilihan room agar user pilih lagi sesuai building (kalau filter tersedia)
                    $('#room_id').val(null).trigger('change');
                });
            });
        </script>
    @endpush

</x-app-layout>
