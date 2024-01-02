@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">{{$title}}</h2>
    </div>
    @if (session('success'))
        <x-base.alert class="mb-2 mt-5 flex items-center" variant="outline-success">
            <x-base.lucide class="mr-2 h-6 w-6" icon="AlertOctagon" />
            {{ session('success') }}
            <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
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
                            <x-base.form-label for="crud-form-1">Tanggal Pembelian</x-base.form-label>
                            <x-base.form-input class="w-full" id="tanggal_pembelian" type="date" name="tanggal_pembelian"
                                value="{{ $data['header']->purchase_date ?? date('Y-m-d') }}" required
                                placeholder="Pilih Tanggal Pembelian" />
                            @error('tanggal_pembelian')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Tanggal Pengambilan</x-base.form-label>
                            <x-base.form-input class="w-full" id="tanggal_pengambilan" type="date"
                                name="tanggal_pengambilan" value="{{ $data['header']->pick_up_date ?? date('Y-m-d') }}"
                                placeholder="Pilih Tanggal Pengambilan" required />
                            @error('tanggal_pengambilan')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="supplier">Supplier</x-base.form-label>
                            <x-base.tom-select name="supplier" id="supplier" class="w-full"
                                data-placeholder="Pilih Supplier" required>
                                <option value="">Pilih Supplier</option>
                                @foreach ($data['supplier'] as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ $data['header']->supplier_id == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                            @error('supplier')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2 grid grid-cols-12 gap-2">
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
                        <div class="input-form col-span-4">
                            <x-base.form-label for="tipe_pembelian">Tipe Pembelian</x-base.form-label>
                            <x-base.tom-select name="tipe_pembelian" id="tipe_pembelian" class="w-full"
                                data-placeholder="Pilih Tipe Pembelian" required>
                                <option value="">Pilih Tipe Pembelian</option>
                                <option value="Tempo Panjang"
                                    {{ $data['header']->transaction_type == 'Tempo Panjang' ? 'selected' : '' }}>Tempo
                                    Panjang</option>
                                <option value="Kontan"
                                    {{ $data['header']->transaction_type == 'Kontan' ? 'selected' : '' }}>Kontan</option>
                            </x-base.tom-select>
                            @error('tipe_pembelian')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <hr style="border: 1px solid black;">

                    <div class="mt-3 grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Produk</x-base.form-label>
                            <x-base.tom-select name="produk" id="produk" class="w-full" data-placeholder="Pilih Produk">
                                <option value="">Pilih Produk</option>
                                @foreach ($data['product'] as $product)
                                    <option value="{{ $product->id }}_{{ $product->product }}">{{ $product->product }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Qty</x-base.form-label>
                            <x-base.form-input class="w-full" id="crud-form-1" type="text" name="qty" id="qty"
                                value="" placeholder="Input Qty Produk"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Subtotal</x-base.form-label>
                            <x-base.form-input class="w-full" type="text" name="subtotal" id="subtotal" value=""
                                placeholder="Input Subtotal Produk"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-12">
                        <div class="col-span-6 flex">
                            {{-- <h3><strong>Produk</strong></h3> --}}
                        </div>
                        <div class="col-span-6 flex justify-end">
                            <x-base.button onclick="tambahProduk()" type="button" variant="primary">
                                Tambah Produk
                            </x-base.button>
                        </div>
                    </div>
                    <br>
                    @error('produk_id')
                        <div class="pristine-error text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('total_bayar')
                        <div class="pristine-error text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                    <table class="min-w-full bg-white border-gray-300" id="table_product">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-left w-1/4">Produk</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Qty</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Subtotal</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Action</th>
                                <!-- Tambahkan header lainnya sesuai kebutuhan -->
                            </tr>
                        </thead>
                        <tbody id="products">
                            @if (isset($data['detail']))
                                @foreach ($data['detail'] as $item)
                                    <tr class="row-data">
                                        <td class="py-2 px-4 produk_id" hidden>{{ $item['product_id'] }}<input
                                                type="hidden" name="produk_id[]" id="produk_id[]"
                                                value="{{ $item['product_id'] }}" /></td>
                                        <td class="py-2 px-4 w-1/4">{{ $item['product']['product'] }}</td>
                                        <td class="py-2 px-4 jumlah_qty w-1/4">{{ $item['purchase_amount'] }}<input
                                                type="hidden" name="jumlah_qty[]" id="jumlah_qty[]"
                                                value="{{ $item['purchase_amount'] }}" /></td>
                                        <td class="py-2 px-4 subtotal w-1/4">{{ $item['subtotal'] }}<input type="hidden"
                                                class="column_subtotal" name="subtotal_produk[]" id="subtotal_produk[]"
                                                value="{{ $item['subtotal'] }}" /></td>
                                        <td class="py-2 px-4 w-1/4">
                                            <button onclick="hapusRow(this)" class="flex items-center text-danger">
                                                Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-center" colspan="3">Grand Total</th>
                                <th class="py-2 px-4 border-b text-center grand_total">
                                    {{ $data['header']->grand_total ?? 0 }}</th>
                                <th class="py-2 px-4 border-b text-center" hidden><x-base.form-input
                                        class="w-3/5 text-center" id="grand_total" type="text" name="grand_total"
                                        value="{{ $data['header']->grand_total ?? 0 }}" /></th>
                            </tr>
                            <tr class="bg-dark ">
                                <th class="py-2 px-4 border-b text-center text-white" colspan="3">Total Bayar</th>
                                <th class="py-2 px-4 border-b text-center">
                                    <x-base.form-input class="w-3/5 text-center" id="total_bayar" type="text"
                                        name="total_bayar" value="{{ $data['header']->total_payment ?? 0 }}"
                                        placeholder="Input Total Bayar" required
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                </th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="mode"></div>

                    <div class="mt-5 text-right">
                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            <a href="{{ route('delivery_order.index') }}" variant="outline-secondary">
                                Cancel
                            </a>
                        </x-base.button>
                        <x-base.button class="w-24" onclick="saveDeliveryOrder()" type="submit" variant="primary">
                            Save
                        </x-base.button>
                        @if ($type != 'create')
                            <x-base.button class="w-24" onclick="confirmDeliveryOrder()" type="submit"
                                variant="success">
                                Konfirmasi
                            </x-base.button>
                        @endif
                    </div>
                </div>
                <!-- END: Form Layout -->
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function tambahProduk() {
                var produk = $('#produk').val().split('_');
                var qty = $('#qty').val();
                var subtotal = $('#subtotal').val();

                if (produk.length == 1 || qty == "" || subtotal == "") {
                    alert('Harap mengisi form produk, qty, subtotal');
                    return false;
                }

                var boolean = true
                $('.produk_id').each(function() {
                    var produk_id = $(this).text();
                    if (produk_id == produk[0]) {
                        boolean = false;
                    }
                })

                if (boolean == false) {
                    alert('Produk ini sudah ada');
                    return false;
                }

                var products = `
                    <tr class="row-data">
                            <td class="py-2 px-4 produk_id" hidden>${produk[0]}<input type="hidden" name="produk_id[]" id="produk_id[]" value="${produk[0]}" /></td>
                            <td class="py-2 px-4 w-1/4">${produk[1]}</td>
                            <td class="py-2 px-4 jumlah_qty w-1/4">${qty}<input type="hidden" name="jumlah_qty[]" id="jumlah_qty[]" value="${qty}" /></td>
                            <td class="py-2 px-4 subtotal w-1/4">${subtotal}<input type="hidden" class="column_subtotal" name="subtotal_produk[]" id="subtotal_produk[]" value="${subtotal}" /></td>
                            <td class="py-2 px-4 w-1/4"> 
                                <button onclick="hapusRow(this)" class="flex items-center text-danger">
                                Hapus</button>
                            </td>
                    </tr>
                `;
                $('#products').html($('#products').html() + products);

                var totalSubtotal = 0;
                $('.column_subtotal').each(function() {
                    totalSubtotal += parseInt($(this).val())
                })

                $('.grand_total').text(totalSubtotal);
                $('#grand_total').val(totalSubtotal);
            }

            function hapusRow(event) {
                event.closest('tr').remove();

                var totalSubtotal = 0;
                $('.column_subtotal').each(function() {
                    totalSubtotal += parseInt($(this).val())
                })

                $('.grand_total').text(totalSubtotal);
                $('#grand_total').val(totalSubtotal);
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
