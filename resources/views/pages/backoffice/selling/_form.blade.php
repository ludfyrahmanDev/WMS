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

            {{-- <form action="{{ $route }}" method="post" enctype="multipart/form-data"> --}}
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
                        <x-base.tom-select name="customer" class="w-full" data-placeholder="Pilih Pelanggan">
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
                        <x-base.tom-select name="driver" class="w-full" data-placeholder="Pilih driver">
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
                        <x-base.tom-select name="kendaraan" class="w-full" data-placeholder="Pilih Kendaraan">
                            <option value="">Pilih Kendaraan</option>
                            @foreach ($vehicle as $data) 
                                <option value="{{ $data->id }}">{{ '[' . $data->license_plate . '] ' . $data->name }}</option>
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
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="uang_saku" id="uang_saku"
                            value="{{ $data->uang_saku ?? old('uang_saku') }}" placeholder="Masukkan uang saku pengemudi"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
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
                            <option value="kedelai a">Kedelai a</option>
                            <option value="kedelai b">Kedelai b</option>
                        </x-base.tom-select>
                    </div>
                    <div class="input-form col-span-4">
                        <x-base.form-label for="crud-form-1">Qty</x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="qty" id="qty"
                            value="{{ $data->qty ?? old('qty') }}" placeholder="Masukkan jumlah beli"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                    </div>
                    <div class="input-form col-span-4">
                        <x-base.form-label for="crud-form-1">Subtotal</x-base.form-label>
                        <x-base.form-input class="w-full" type="text" name="subtotal" id="subtotal"
                            value="{{ $data->subtotal ?? old('subtotal') }}" placeholder="0"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" disabled />
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-12">
                    <div class="col-span-6 flex">
                        {{-- <h3><strong>Produk</strong></h3> --}}
                    </div>
                    <div class="col-span-6 flex justify-end">
                        <x-base.button type="submit" onclick="tambahProduk()" variant="primary">
                            Tambah Produk
                        </x-base.button>
                    </div>
                </div>
                <br>
                <table class="min-w-full bg-white border-gray-300" id="transDetail">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th class="py-2 px-4 border-b text-left">No</th>
                            <th class="py-2 px-4 border-b text-left">Produk</th>
                            <th class="py-2 px-4 border-b text-left">Qty</th>
                            <th class="py-2 px-4 border-b text-left">Subtotal</th>
                            <th class="py-2 px-4 border-b text-left">Action</th>
                            <!-- Tambahkan header lainnya sesuai kebutuhan -->
                        </tr>
                    </thead>
                    <tbody id="transDetail">
                        {{-- <tr class="border-b">
                            <td class="py-2 px-4">Data 1</td>
                            <td class="py-2 px-4">Data 2</td>
                            <td class="py-2 px-4">Data 3</td>
                            <!-- Tambahkan data lainnya sesuai kebutuhan -->
                        </tr>
                        <tr class="border-b">
                            <td class="py-2 px-4">Data 4</td>
                            <td class="py-2 px-4">Data 5</td>
                            <td class="py-2 px-4">Data 6</td>
                            <!-- Tambahkan data lainnya sesuai kebutuhan -->
                        </tr> --}}
                        <!-- Tambahkan baris lainnya sesuai kebutuhan -->
                    </tbody>
                </table>

                {{-- <x-base.table id="table_product">
                    <x-base.table.thead variant="dark">
                        <x-base.table.tr>
                            <x-base.table.th class="whitespace-nowrap">
                                Produk
                            </x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap">
                                Qty
                            </x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap">
                                Subtotal
                            </x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap">
                                Action
                            </x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody id="testTR">
                        <x-base.table.tr>
                            <x-base.table.td><x-base.tom-select name="kendaraan" class="w-full"
                                    data-placeholder="Pilih Kendaraan">
                                    <option value="">Pilih Kendaraan</option>
                                </x-base.tom-select></x-base.table.td>
                            <x-base.table.td> <x-base.form-input class="w-full" id="crud-form-1" type="text"
                                    name="nominal" value="{{ $data->nominal ?? old('nominal') }}"
                                    placeholder="Input Nominal Pengeluaran"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" /></x-base.table.td>
                            <x-base.table.td> <x-base.form-input class="w-full" id="crud-form-1" type="text"
                                    name="nominal" value="{{ $data->nominal ?? old('nominal') }}"
                                    placeholder="Input Nominal Pengeluaran"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" /></x-base.table.td>
                            <x-base.table.td>
                                <button class="flex items-center text-danger">
                                    <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" />
                                    Hapus
                                </button>
                            </x-base.table.td>
                        </x-base.table.tr>
                        <x-base.table.tr>
                            <x-base.table.td><x-base.tom-select name="kendaraan" class="w-full"
                                    data-placeholder="Pilih Kendaraan">
                                    <option value="">Pilih Kendaraan</option>
                                </x-base.tom-select></x-base.table.td>
                            <x-base.table.td> <x-base.form-input class="w-full" id="crud-form-1" type="text"
                                    name="nominal" value="{{ $data->nominal ?? old('nominal') }}"
                                    placeholder="Input Nominal Pengeluaran"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" /></x-base.table.td>
                            <x-base.table.td> <x-base.form-input class="w-full" id="crud-form-1" type="text"
                                    name="nominal" value="{{ $data->nominal ?? old('nominal') }}"
                                    placeholder="Input Nominal Pengeluaran"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" /></x-base.table.td>
                            <x-base.table.td> <button class="flex items-center text-danger">
                                    <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" />
                                    Hapus
                                </button></x-base.table.td>
                        </x-base.table.tr>
                    </x-base.table.tbody>
                    <x-base.table.tfoot>
                        <x-base.table.tr style="background-color: aliceblue !important;">
                            <x-base.table.td colspan="2" class="text-center">GRAND TOTAL</x-base.table.td>
                            <x-base.table.td colspan="2" class="text-center">400000</x-base.table.td>
                        </x-base.table.tr>
                        <x-base.table.tr style="background-color: aliceblue !important;">
                            <x-base.table.td colspan="2" class="text-center">Total Bayar</x-base.table.td>
                            <x-base.table.td colspan="2" class="text-center"><x-base.form-input class="w-full"
                                    id="crud-form-1" type="text" name="nominal"
                                    value="{{ $data->nominal ?? old('nominal') }}"
                                    placeholder="Input Nominal Pengeluaran"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" /></x-base.table.td>
                        </x-base.table.tr>
                    </x-base.table.tfoot>
                </x-base.table> --}}

                <div class="mt-5 text-right">
                    <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                        <a href="{{ route('spending.index') }}" variant="outline-secondary">
                            Cancel
                        </a>
                    </x-base.button>
                    <x-base.button class="w-24 lala" type="submit" variant="primary">
                        Save
                    </x-base.button>
                </div>
            </div>
            <!-- END: Form Layout -->
            {{-- </form> --}}
        </div>
    </div>

    @push('scripts')
        <script>
            function tambahProduk() {
                var produk = $('#produk').val();
                var qty = $('#qty').val();
                var subtotal = $('#subtotal').val();
                var noCount = $("#transDetail > tbody > tr").length + 1;
                var products = `
                    <tr class="row-data">
                            <td class="py-2 px-4">${noCount++}</td>
                            <td class="py-2 px-4">${produk}</td>
                            <td class="py-2 px-4">${qty}</td>
                            <td class="py-2 px-4">${subtotal}</td>
                            <td class="py-2 px-4">
                                <button class="flex items-center text-danger" onclick="delRow('${noCount++}', $(this))">
                                    <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" />
                                    Hapus
                                </button>
                            </td>
                    </tr>
                `;
                $('#transDetail > tbody').html($('#transDetail > tbody').html() + products);
            }

            function delrow(idx, el) {
                el.closest('tr').remove();
            }
        </script>
    @endpush
@endsection
