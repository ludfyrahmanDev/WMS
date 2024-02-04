@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">{{ $title }}</h2>
    </div>
    @if (session('failed'))
        <x-base.alert class="mb-2 flex items-center" variant="outline-danger">
            <x-base.lucide class="mr-2 h-6 w-6" icon="AlertOctagon" />
            {{ session('failed') }}
            <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
    <div class="mt-5 grid grid-cols-12 gap-6">

        <div class="intro-y col-span-12 lg:col-span-12">

            <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($type != 'create')
                    @method('PUT')
                @endif
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5" id="myForm">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Tanggal</x-base.form-label>
                            <x-base.form-input class="w-full" id="tanggal" type="date" name="tanggal"
                                value="{{ $data['header']->date ?? date('Y-m-d') }}" required
                                placeholder="Pilih Tanggal Pembelian" />
                            @error('tanggal')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="driver">Driver</x-base.form-label>
                            <x-base.tom-select name="driver" id="driver" class="w-full" data-placeholder="Pilih Driver"
                                required>
                                <option value="">Pilih Driver</option>
                                @foreach ($data['driver'] as $driver)
                                    <option value="{{ $driver->id }}"
                                        {{ $data['header']->driver_id == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }}</option>
                                @endforeach
                            </x-base.tom-select>
                            @error('driver')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="kendaraan">Kendaraan</x-base.form-label>
                            <x-base.tom-select name="kendaraan" id="kendaraan" class="w-full"
                                data-placeholder="Pilih Kendaraan" required>
                                <option value="">Pilih Kendaraan</option>
                                @foreach ($data['vehicle'] as $vehicle)
                                    <option value="{{ $vehicle->id }}"
                                        {{ $data['header']->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->name }} -
                                        {{ $vehicle->license_plate }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                            @error('kendaraan')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <hr style="border: 1px solid black;">

                    <div class="mt-3 grid grid-cols-12 gap-2">
                        {{-- <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Kategori</x-base.form-label>
                            <x-base.tom-select name="kategori" id="kategori" class="w-full"
                                data-placeholder="Pilih Kategori">
                                <option value="">Pilih Kategori</option>
                                @foreach ($data['spendingCategory'] as $kategori)
                                    <option value="{{ $kategori->id }}_{{ $kategori->spending_category }}">
                                        {{ $kategori->spending_category }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                        </div> --}}
                        <div class="input-form col-span-6">
                            <x-base.form-label for="crud-form-1">Keterangan</x-base.form-label>
                            <x-base.form-textarea class="form-control" id="keterangan" name="keterangan"
                                placeholder="Input Keterangan" value=""></x-base.form-textarea>
                        </div>
                        <div class="input-form col-span-6">
                            <x-base.form-label for="crud-form-1">Total Pengeluaran</x-base.form-label>
                            <x-base.form-input class="w-full" id="crud-form-1" type="text" name="total_pengeluaran"
                                id="total_pengeluaran" value="" placeholder="Input Total Pengeluaran"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-12">
                        <div class="col-span-6 flex">
                            {{-- <h3><strong>Produk</strong></h3> --}}
                        </div>
                        <div class="col-span-6 flex justify-end">
                            <x-base.button onclick="tambahPengeluaran()" type="button" variant="primary">
                                Tambah Pengeluaran
                            </x-base.button>
                        </div>
                    </div>
                    <br>
                    @error('keterangan')
                        <div class="pristine-error text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                    <table class="min-w-full bg-white border-gray-300" id="table_pengeluaran">
                        <thead>
                            <tr class="bg-dark text-white">
                                {{-- <th class="py-2 px-4 border-b text-left w-1/4">Kategori</th> --}}
                                <th class="py-2 px-4 border-b text-left w-1/4">Keterangan</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Total Pengeluaran</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Action</th>
                                <!-- Tambahkan header lainnya sesuai kebutuhan -->
                            </tr>
                        </thead>
                        <tbody id="servisKendaraan">
                            @if (isset($data['detail']))
                                @foreach ($data['detail'] as $item)
                                    <tr class="row-data">
                                        {{-- <td class="py-2 px-4 kategori_id" hidden>{{ $item['spending_category_id'] }}<input
                                                type="hidden" name="kategori_id[]" id="kategori_id[]"
                                                value="{{ $item['spending_category_id'] }}" /></td>
                                        <td class="py-2 px-4 w-1/4">{{ $item['spendingCategory']['spending_category'] }}
                                        </td> --}}
                                        <td class="py-2 px-4 keterangan w-1/4">{{ $item['description'] }}<input
                                                type="hidden" class="column_keterangan" name="keterangan[]"
                                                id="keterangan[]" value="{{ $item['description'] }}" /></td>
                                        <td class="py-2 px-4 total_pengeluaran w-1/4">
                                            {{ $item['amount_of_expenditure'] }}<input type="hidden"
                                                name="total_pengeluaran[]" id="total_pengeluaran[]"
                                                value="{{ $item['amount_of_expenditure'] }}" /></td>
                                        <td class="py-2 px-4 w-1/4">
                                            <button onclick="hapusRow(this)" class="flex items-center text-danger">
                                                Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div class="mode"></div>

                    <div class="mt-5 text-right">
                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            <a href="{{ route('vehicle_service.index') }}" variant="outline-secondary">
                                Cancel
                            </a>
                        </x-base.button>
                        <x-base.button class="w-24" type="submit" variant="primary">
                            Save
                        </x-base.button>
                    </div>
                </div>
                <!-- END: Form Layout -->
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function tambahPengeluaran() {
                // var kategori = $('#kategori').val().split('_');
                var total_pengeluaran = $('#total_pengeluaran').val();
                var keterangan = $('#keterangan').val();

                // kategori.length == 1 || 
                if (total_pengeluaran == "" || keterangan == "") {
                    alert('Harap mengisi form kategori, total pengeluaran, keterangan');
                    return false;
                }

                // <td class="py-2 px-4 kategori_id" hidden>${kategori[0]}<input type="hidden" name="kategori_id[]" id="kategori_id[]" value="${kategori[0]}" /></td>
                // <td class="py-2 px-4 w-1/4">${kategori[1]}</td>
                var pengeluaran = `
                    <tr class="row-data">
                            <td class="py-2 px-4 keterangan w-1/4">${keterangan}<input type="hidden" class="column_keterangan" name="keterangan[]" id="keterangan[]" value="${keterangan}" /></td>
                            <td class="py-2 px-4 total_pengeluaran w-1/4">${total_pengeluaran}<input type="hidden" name="total_pengeluaran[]" id="total_pengeluaran[]" value="${total_pengeluaran}" /></td>
                            <td class="py-2 px-4 w-1/4"> 
                                <button onclick="hapusRow(this)" class="flex items-center text-danger">
                                Hapus</button>
                            </td>
                    </tr>
                `;

                $('#servisKendaraan').html($('#servisKendaraan').html() + pengeluaran);
            }

            function hapusRow(event) {
                event.closest('tr').remove();
            }

            // function saveDeliveryOrder() {
            //     // Header
            //     var tanggal_pembelian = $('#tanggal_pembelian').val();
            //     var tanggal_pengambilan = $('#tanggal_pengambilan').val();
            //     var supplier = $('#supplier').val();
            //     var driver = $('#driver').val();
            //     var kendaraan = $('#kendaraan').val();

            //     var arr = [];
            //     // getProdukID
            //     $('.produk_id').each(function() {
            //         var produk_id = $(this).text();

            //         arr.push({
            //             produk_id: produk_id,
            //             qty: 0,
            //             subtotal: 0,
            //         })
            //     })

            //     $('.jumlah_qty').each(function(i, v) {
            //         var qty = $(this).text();

            //         arr[i].qty = qty
            //     })

            //     $('.subtotal').each(function(i, v) {
            //         var subtotal = $(this).text();

            //         arr[i].subtotal = subtotal
            //     })

            //     // $.ajax({
            //     //     type: "POST",
            //     //     url: "{{ route('delivery_order.store') }}",
            //     //     data: {
            //     //         tanggal_pembelian: tanggal_pembelian,
            //     //         tanggal_pengambilan: tanggal_pengambilan,
            //     //         supplier: supplier,
            //     //         driver: driver,
            //     //         kendaraan: kendaraan,
            //     //         detail: arr
            //     //     },
            //     //     dataType: "JSON",
            //     //     success: function(response) {

            //     //     }
            //     // })
            // }

            function confirmDeliveryOrder() {
                $('.mode').html('<input type="hidden" name="mode" id="mode" value="konfirmasi"/>');
            }
        </script>
    @endpush
@endsection
