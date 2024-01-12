@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Form Penjualan</h2>
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
                <div class="intro-y box p-5">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Tanggal Penjualan</x-base.form-label>
                            <x-base.form-input class="w-full" id="crud-form-1" type="date" name="tgl_jual"
                                value="{{ $data['header']->date ?? date('Y-m-d') }}"
                                placeholder="Pilih Tanggal Pembelian" />
                            @error('tgl_jual')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Pelanggan</x-base.form-label>
                            <x-base.tom-select name="customer" class="w-full" data-placeholder="Pilih Pelanggan"
                                id="customer">
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($data['customer'] as $row)
                                    <option value="{{ $row->id }}"
                                        {{ $data['header']->customer_id == $row->id ? 'selected' : '' }}>
                                        {{ $row->name }}</option>
                                @endforeach
                            </x-base.tom-select>
                            @error('customer')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Pengemudi</x-base.form-label>
                            <x-base.tom-select name="driver" class="w-full" data-placeholder="Pilih driver" id="driver">
                                <option value="">Pilih Pengemudi</option>
                                @foreach ($data['driver'] as $row)
                                    <option value="{{ $row->id }}"
                                        {{ $data['header']->driver_id == $row->id ? 'selected' : '' }}>
                                        {{ $row->name }}</option>
                                @endforeach
                            </x-base.tom-select>
                            @error('driver')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2 grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Kendaraan</x-base.form-label>
                            <x-base.tom-select name="kendaraan" class="w-full" data-placeholder="Pilih Kendaraan"
                                id="kendaraan">
                                <option value="">Pilih Kendaraan</option>
                                @foreach ($data['vehicle'] as $row)
                                    <option value="{{ $row->id }}"
                                        {{ $data['header']->vehicle_id == $row->id ? 'selected' : '' }}>
                                        {{ '[ ' . $row->license_plate . ' ] ' . $row->name }}
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
                            <x-base.form-label for="crud-form-1">Uang Saku Pengemudi</x-base.form-label>
                            <x-base.form-input class="w-full" id="crud-form-1" type="text" name="uang_saku"
                                id="uang_saku" value="{{ $data['header']->drivers_pocket_money ?? old('uang_saku') }}"
                                placeholder="Masukkan uang saku pengemudi"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="tipe_pembelian">Tipe Pembelian</x-base.form-label>
                            <x-base.tom-select name="tipe_pembelian" id="tipe_pembelian" class="w-full"
                                data-placeholder="Pilih Tipe Pembelian" required>
                                <option value="tempo"
                                    {{ $data['header']->purchasing_method == 'tempo' ? 'selected' : '' }}>Tempo Panjang
                                </option>
                                <option value="titipan"
                                    {{ $data['header']->purchasing_method == 'titipan' ? 'selected' : '' }}>Titipan
                                </option>
                                <option value="kontan"
                                    {{ $data['header']->purchasing_method == 'kontan' ? 'selected' : '' }}>Kontan</option>
                            </x-base.tom-select>
                            @error('tipe_pembelian')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="tipe_pembayaran">Tipe Pembayaran</x-base.form-label>
                            <x-base.tom-select name="tipe_pembayaran" id="tipe_pembayaran" class="w-full"
                                data-placeholder="Pilih Tipe Pembayaran" required>
                                <option value="cash" {{ $data['header']->payment_type == 'cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="transfer"
                                    {{ $data['header']->payment_type == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </x-base.tom-select>
                            @error('tipe_pembayaran')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-8">
                            <x-base.form-label for="catatan">Catatan</x-base.form-label>
                            <x-base.form-textarea class="form-control" id="catatan" name="catatan"
                                placeholder="Masukkan catatan (Optional)..."
                                value="{{ $data['header']->notes ?? old('catatan') }}"></x-base.form-textarea>
                        </div>
                    </div>
                    <br>
                    <hr style="border: 1px solid black;">
                    <div class="mt-3 grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Produk</x-base.form-label>
                            <x-base.tom-select name="produk" id="produk" class="w-full"
                                data-placeholder="Pilih Produk">
                                <option value="">Pilih Produk</option>
                                @foreach ($data['product'] as $row)
                                    <option value="{{ $row->id }}_{{ $row->product }}_{{ $row->last_stock }}">
                                        {{ $row->product . ' ( Sisa Stok : ' . $row->last_stock . ' )' }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="qty_jual">Qty</x-base.form-label>
                            <x-base.input-group inputGroup>
                                <x-base.form-input class="w-full" type="text" name="qty_jual" id="qty_jual"
                                    placeholder="Masukkan jumlah beli"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                    onchange="getHargaStock(this.value)" disabled />
                                <x-base.input-group.text>
                                    <x-base.button type="button" id="modalDetailStockHarga" data-tw-toggle="modal"
                                        data-tw-target="#detailStockHarga" variant="primary" disabled>
                                        <x-base.lucide class="h-4 w-4" icon="Eye" />
                                    </x-base.button>
                                </x-base.input-group.text>
                            </x-base.input-group>
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="harga_jual">Harga Jual</x-base.form-label>
                            <x-base.form-input class="w-full" type="text" name="harga_jual" value=""
                                id="harga_jual" placeholder="Masukkan Harga Jual" />
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-12">
                        <div class="col-span-6 flex">
                            {{-- <h3><strong>Produk</strong></h3> --}}
                        </div>
                        <div class="col-span-6 flex justify-end">
                            <x-base.button type="button" onclick="tambahProduk()" variant="primary">
                                Tambah Produk
                            </x-base.button>
                        </div>
                    </div>
                    <br>
                    <table class="min-w-full bg-white border-gray-300" id="transDetail">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-left w-1/4">Produk</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Qty</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Harga Jual</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Subtotal</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Action</th>
                            </tr>
                        </thead>
                        <tbody id="transDetail">
                            @if (isset($data['detail']))
                                @foreach ($data['detail'] as $item)
                                    <tr class="row-data">
                                        <td class="py-2 px-4 produk_id" hidden>{{ $item['id'] }}<input type="hidden"
                                                name="produk_id[]" id="produk_id[]" value="{{ $item['id'] }}" /></td>
                                        <td class="py-2 px-4 profit_peritem" hidden><input type="hidden"
                                                name="profit_peritem[]" id="profit_peritem[]"
                                                class="column_profit_peritem" value="{{ $item['labaPerItem'] }}" /></td>
                                        <td class="py-2 px-4 w-1/4">{{ $item['product'] }}</td>
                                        <td class="py-2 px-4 jumlah_qty w-1/4">{{ $item['total_qty'] }}<input
                                                type="hidden" name="jumlah_qty[]" id="jumlah_qty[]"
                                                value="{{ $item['total_qty'] }}" /></td>
                                        <td class="py-2 px-4 harga_jual">{{ $item['price_sell'] }}<input type="hidden"
                                                name="harga_jual[]" id="harga_jual[]"
                                                value="{{ $item['price_sell'] }}" /></td>
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
                                <th class="py-2 px-4 border-b text-center" colspan="4">Laba Bersih</th>
                                <th class="py-2 px-4 border-b text-center laba_bersih">
                                    {{ $data['header']->net_profit ?? 0 }}</th>
                                <th class="py-2 px-4 border-b text-center" hidden><x-base.form-input
                                        class="w-3/5 text-center" id="laba_bersih" type="text" name="laba_bersih"
                                        value="{{ $data['header']->net_profit ?? 0 }}" /></th>
                            </tr>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-center" colspan="4">Grand Total</th>
                                <th class="py-2 px-4 border-b text-center grand_total">
                                    {{ $data['header']->grand_total ?? 0 }}</th>
                                <th class="py-2 px-4 border-b text-center" hidden><x-base.form-input
                                        class="w-3/5 text-center" id="grand_total" type="text" name="grand_total"
                                        value="{{ $data['header']->grand_total ?? 0 }}" /></th>
                            </tr>
                            <tr class="bg-dark ">
                                <th class="py-2 px-4 border-b text-center text-white" colspan="4">Total Bayar</th>
                                <th class="py-2 px-4 border-b text-center">
                                    <x-base.form-input class="w-3/3 text-center" id="total_bayar" type="text"
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
                            <a href="{{ route('selling.index') }}" variant="outline-secondary">
                                Cancel
                            </a>
                        </x-base.button>
                        <x-base.button class="w-24 lala" type="submit" variant="primary">
                            Save
                        </x-base.button>
                        @if ($type != 'create')
                            <x-base.button class="w-24" type="submit" onclick="closingSelling()" variant="success">
                                Konfirmasi
                            </x-base.button>
                        @endif
                    </div>

                    <!-- BEGIN: Modal Content -->
                    <x-base.dialog id="detailStockHarga">
                        <x-base.dialog.panel class="p-10 text-center">
                            <table class="min-w-full bg-white border-gray-300">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <th class="py-2 px-4 border-b text-left w-1/4 text-center">No</th>
                                        <th class="py-2 px-4 border-b text-left w-1/4 text-center">Stock</th>
                                        <th class="py-2 px-4 border-b text-left w-1/4 text-center">Harga/Kg</th>
                                    </tr>
                                </thead>
                                <tbody id="tableDetailStockHarga">
                                </tbody>
                        </x-base.dialog.panel>
                    </x-base.dialog>
                    <!-- END: Modal Content -->
                </div>
                <!-- END: Form Layout -->
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            var arrLaba = [];

            document.getElementById('produk').addEventListener('change', function() {
                // var produk = this.value.split('_');

                // var xhr = new XMLHttpRequest();
                // var url = "/product/" + produk[0];

                // xhr.open('GET', url, true);
                // xhr.setRequestHeader('Content-Type', 'application/json');

                // xhr.onreadystatechange = function() {
                //     if (xhr.readyState == 4) {
                //         if (xhr.status == 200) {
                //             var response = JSON.parse(xhr.responseText);
                //             // console.log(response);
                //             document.getElementById('harga_jual').innerHTML = '';
                //             // document.getElementById('subtotal').value = '';
                //             document.getElementById('qty_jual').value = '';
                //             // document.getElementById('harga').value = response.price;
                //             // document.getElementById('harga_jual').value = response.price_sell;
                //         } else {
                //             console.log('Error:', xhr.status);
                //         }
                //     }
                // };

                // xhr.send();

                $('#qty_jual').removeAttr('disabled');
            });

            // document.getElementById('qty_jual').addEventListener('keyup', function() {
            //     var harga_jual = document.getElementById('harga_jual').value;
            //     var qty_jual = this.value;

            //     var subtotal = parseInt(harga_jual) * parseInt(qty_jual);

            //     // Mengosongkan dan mengatur nilai elemen dengan ID "subtotal"
            //     document.getElementById('subtotal').value = '';
            //     document.getElementById('subtotal').value = subtotal;
            // });


            function tambahProduk() {
                var produk = $('#produk').val().split('_');
                var qty = $('#qty_jual').val();
                // var harga = $('#harga').val();
                var harga_jual = $('#harga_jual').val();
                // var profit = parseInt((harga_jual - harga) * qty);
                var profit = $('#laba_bersih').val();
                var subtotal = parseInt(harga_jual) * parseInt(qty);

                document.getElementById('qty_jual').value = '';
                document.getElementById('qty_jual').disabled = true;
                $("#qty_jual").attr('disabled')
                // $("#qty_jual").prop('disabled', true)
                document.getElementById('modalDetailStockHarga').disabled = true;
                document.getElementById('produk').value = '';
                document.getElementById('produk').dispatchEvent(new Event('change'));
                document.getElementById('harga_jual').value = '';


                if (produk == "" || qty == "" || harga_jual == "") {
                    alert("Harap pilih produk, qty, harga terjual terlebih dahulu!");
                    return false;
                }

                if (parseInt(qty) > parseInt(produk[2])) {
                    alert("Stok tidak cukup!");
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

                var totalLaba = parseInt(profit) == '' ? 0 : parseInt(profit);
                var labaPerItem = 0;

                for (let i = 0; i < arrLaba.length; i++) {
                    const price_kg = arrLaba[i].price_kg;
                    const stock = arrLaba[i].stock;

                    totalLaba += (parseInt(harga_jual) - parseInt(price_kg)) * parseInt(stock);
                    labaPerItem += (parseInt(harga_jual) - parseInt(price_kg)) * parseInt(stock);
                }

                var products = `
                    <tr class="row-data">
                        <td class="py-2 px-4 produk_id" hidden>${produk[0]}<input type="hidden" name="produk_id[]" id="produk_id[]" value="${produk[0]}" /></td>
                        <td class="py-2 px-4 profit_peritem" hidden><input type="hidden" name="profit_peritem[]" id="profit_peritem[]" class="column_profit_peritem" value="${labaPerItem}" /></td>
                        <td class="py-2 px-4 w-1/4">${produk[1]}</td>
                        <td class="py-2 px-4 jumlah_qty w-1/4">${qty}<input type="hidden" name="jumlah_qty[]" id="jumlah_qty[]" value="${qty}" /></td>
                        <td class="py-2 px-4 harga_jual">${harga_jual}<input type="hidden" name="harga_jual[]" id="harga_jual[]" value="${harga_jual}" /></td>
                        <td class="py-2 px-4 subtotal w-1/4">${subtotal}<input type="hidden" class="column_subtotal" name="subtotal_produk[]" id="subtotal_produk[]" value="${subtotal}" /></td>
                        <td class="py-2 px-4 w-1/4"> 
                            <button onclick="hapusRow(this)" class="flex items-center text-danger">
                            Hapus</button>
                        </td>
                    </tr>
                `;
                $('#transDetail > tbody').html($('#transDetail > tbody').html() + products);

                var totalSubtotal = 0;
                $('.column_subtotal').each(function() {
                    totalSubtotal += parseInt($(this).val())
                })

                $('.laba_bersih').text(totalLaba);
                $('#laba_bersih').val(totalLaba);
                $('.grand_total').text(totalSubtotal);
                $('#grand_total').val(totalSubtotal);

                arrLaba = [];

            }

            function hapusRow(event) {
                event.closest('tr').remove();

                var totalSubtotal = 0;
                $('.column_subtotal').each(function() {
                    totalSubtotal += parseInt($(this).val())
                })

                var profitPerItem = 0;
                $('.column_profit_peritem').each(function() {
                    profitPerItem += parseInt($(this).val())
                })

                var totalProfit = profitPerItem;

                $('.laba_bersih').text(totalProfit);
                $('#laba_bersih').val(totalProfit);

                $('.grand_total').text(totalSubtotal);
                $('#grand_total').val(totalSubtotal);
            }

            function closingSelling() {
                $('.mode').html('<input type="hidden" name="mode" id="mode" value="confirm"/>');
            }

            function getHargaStock(qty) {
                var produk = $('#produk').val().split('_');
                $('#tableDetailStockHarga').html('');

                if (qty == "") {
                    alert('qty tidak boleh kosong!');
                    return false;
                } else if (parseInt(qty) > parseInt(produk[2])) {
                    alert('stok tidak cukup!');
                    return false;
                }

                var xhr = new XMLHttpRequest();
                var url = "/getHargaStock?produk=" + produk[0] + "&qty=" + qty;

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            arrLaba = [];

                            var response = JSON.parse(xhr.responseText);

                            for (let i = 0; i < response.length; i++) {
                                var stockHarga = `
                                    <tr class="row-data">
                                        <td class="py-2 px-4 w-1/4">${i + 1}</td>
                                        <td class="py-2 px-4 w-1/4">${response[i].stock}</td>
                                        <td class="py-2 px-4 w-1/4">${response[i].price_kg}</td>
                                    </tr>
                                `;

                                $('#tableDetailStockHarga').html($('#tableDetailStockHarga').html() + stockHarga);

                                arrLaba.push(response[i]);
                            }
                        } else {
                            console.log('Error:', xhr.status);
                        }
                    }
                };

                xhr.open("GET", url, true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send();

                $('#modalDetailStockHarga').removeAttr('disabled');
            }
        </script>
    @endpush
@endsection
