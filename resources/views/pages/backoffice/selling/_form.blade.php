@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Form Penjualan</h2>
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
                <div class="intro-y box p-5">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Tanggal Penjualan</x-base.form-label>
                            <x-base.form-input class="w-full" id="crud-form-1" type="date" name="tgl_jual"
                                value="{{ $data->tgl_jual ?? date('Y-m-d') }}" placeholder="Pilih Tanggal Pembelian" />
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
                                @foreach ($customer as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
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
                                @foreach ($driver as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
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
                                @foreach ($vehicle as $data)
                                    <option value="{{ $data->id }}">
                                        {{ '[' . $data->license_plate . '] ' . $data->name }}
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
                                id="uang_saku" value="{{ $data->uang_saku ?? old('uang_saku') }}"
                                placeholder="Masukkan uang saku pengemudi"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="tipe_pembelian">Tipe Pembelian</x-base.form-label>
                            <x-base.tom-select name="tipe_pembelian" id="tipe_pembelian" class="w-full"
                                data-placeholder="Pilih Tipe Pembelian" required>
                                <option value="Tempo">Tempo Panjang</option>
                                <option value="Titipan">Titipan</option>
                                <option value="Kontan">Kontan</option>
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
                                <option value="Cash">Cash</option>
                                <option value="Transfer">Transfer</option>
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
                                placeholder="Masukkan catatan (Optional)..." value=""></x-base.form-textarea>
                        </div>
                    </div>
                    <br>
                    <hr style="border: 1px solid black;">
                    <div class="mt-3 grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Produk</x-base.form-label>
                            <x-base.tom-select name="produk" id="produk" class="w-full" data-placeholder="Pilih Produk">
                                <option value="">Pilih Produk</option>
                                @foreach ($product as $data)
                                    <option value="{{ $data->id }}_{{ $data->product }}">{{ $data->product }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="harga">Harga/KG</x-base.form-label>
                            <x-base.form-input class="w-full" type="text" name="harga"
                                value="0" id="harga" disabled />
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="harga_jual">Harga Jual</x-base.form-label>
                            <x-base.form-input class="w-full" type="text" name="harga_jual"
                                value="0" id="harga_jual" disabled />
                        </div>
                        <div class="input-form col-span-6">
                            <x-base.form-label for="qty_jual">Qty</x-base.form-label>
                            <x-base.form-input class="w-full" type="text" name="qty_jual"
                                id="qty_jual" placeholder="Masukkan jumlah beli"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>
                        <div class="input-form col-span-6">
                            <x-base.form-label for="crud-form-1">Subtotal</x-base.form-label>
                            <x-base.form-input class="w-full" type="text" name="subtotal" id="subtotal"
                                value="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                disabled />
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
                                <th class="py-2 px-4 border-b text-left w-1/4">Subtotal</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Action</th>
                                <!-- Tambahkan header lainnya sesuai kebutuhan -->
                            </tr>
                        </thead>
                        <tbody id="transDetail">

                        </tbody>
                        <tfoot>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-center" colspan="3">Laba Bersih</th>
                                <th class="py-2 px-4 border-b text-center laba_bersih">
                                    {{ $data['header']->net_profit ?? 0 }}</th>
                                <th class="py-2 px-4 border-b text-center" hidden><x-base.form-input
                                        class="w-3/5 text-center" id="laba_bersih" type="text" name="laba_bersih"
                                        value="{{ $data['header']->net_profit ?? 0 }}" /></th>
                            </tr>
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

                    <div class="mt-5 text-right">
                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            <a href="{{ route('selling.index') }}" variant="outline-secondary">
                                Cancel
                            </a>
                        </x-base.button>
                        <x-base.button class="w-24 lala" type="submit" variant="primary">
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
            document.getElementById('produk').addEventListener('change', function() {
                var produk = this.value.split('_');

                var xhr = new XMLHttpRequest();
                var url = "/product/" + produk[0];

                xhr.open('GET', url, true);
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            var response = JSON.parse(xhr.responseText);
                            // console.log(response);
                            document.getElementById('harga_jual').innerHTML = '';
                            document.getElementById('subtotal').value = '';
                            document.getElementById('qty_jual').value = '';
                            document.getElementById('harga').value = response.price;
                            document.getElementById('harga_jual').value = response.price_sell;
                        } else {
                            console.log('Error:', xhr.status);
                        }
                    }
                };

                xhr.send();
            });

            document.getElementById('qty_jual').addEventListener('keyup', function() {
                var harga_jual = document.getElementById('harga_jual').value;
                var qty_jual = this.value;

                var subtotal = parseInt(harga_jual) * parseInt(qty_jual);

                // Mengosongkan dan mengatur nilai elemen dengan ID "subtotal"
                document.getElementById('subtotal').value = '';
                document.getElementById('subtotal').value = subtotal;
            });


            function tambahProduk() {
                var produk = $('#produk').val().split('_');
                var qty = $('#qty_jual').val();
                var harga = $('#harga').val();
                var harga_jual = $('#harga_jual').val();
                var profit = parseInt((harga_jual - harga) * qty);
                var subtotal = $('#subtotal').val();

                if (produk == "" || qty == "") {
                    alert("Harap pilih produk atau lengkapi qty terlebih dahulu!");
                    return false;
                }

                var products = `
                    <tr class="row-data">
                        <td class="py-2 px-4 produk_id" hidden>${produk[0]}<input type="hidden" name="produk_id[]" id="produk_id[]" value="${produk[0]}" /></td>
                        <td class="py-2 px-4 harga_jual" hidden><input type="hidden" name="harga_jual[]" id="harga_jual[]" value="${harga_jual}" /></td>
                        <td class="py-2 px-4 profit_peritem" hidden><input type="hidden" name="profit_peritem[]" id="profit_peritem[]" class="column_profit_peritem" value="${profit}" /></td>
                        <td class="py-2 px-4 harga_awal" hidden><input type="hidden" name="harga_awal[]" id="harga_awal[]" value="${harga}" /></td>
                        <td class="py-2 px-4 w-1/4">${produk[1]}</td>
                        <td class="py-2 px-4 jumlah_qty w-1/4">${qty}<input type="hidden" name="jumlah_qty[]" id="jumlah_qty[]" value="${qty}" /></td>
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
        </script>
    @endpush
@endsection
