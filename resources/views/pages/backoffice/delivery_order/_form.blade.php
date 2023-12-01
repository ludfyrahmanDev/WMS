@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Form Layout</h2>
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
                        <x-base.form-label for="crud-form-1">Tanggal Pembelian</x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="date" name="tanggal_pembelian"
                            value="{{ $data->tanggal_pembelian ?? date('Y-m-d') }}" placeholder="Pilih Tanggal Pembelian" />
                        @error('tanggal_pembelian')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-form col-span-4">
                        <x-base.form-label for="crud-form-1">Tanggal Pengambilan</x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="date" name="tanggal_pengambilan"
                            value="{{ $data->tanggal_pengambilan ?? date('Y-m-d') }}"
                            placeholder="Pilih Tanggal Pengambilan" />
                        @error('tanggal_pengambilan')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-form col-span-4">
                        <x-base.form-label for="crud-form-1">Supplier</x-base.form-label>
                        <x-base.tom-select name="supplier" class="w-full" data-placeholder="Pilih Supplier">
                            <option value="">Pilih Supplier Pengeluaran</option>
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
                        <x-base.form-label for="crud-form-1">Driver</x-base.form-label>
                        <x-base.tom-select name="driver" class="w-full" data-placeholder="Pilih Driver">
                            <option value="">Pilih Driver</option>
                        </x-base.tom-select>
                        @error('driver')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-form col-span-4">
                        <x-base.form-label for="crud-form-1">Kendaraan</x-base.form-label>
                        <x-base.tom-select name="kendaraan" class="w-full" data-placeholder="Pilih Kendaraan">
                            <option value="">Pilih Kendaraan</option>
                            <option value="a">Mobil</option>
                            <option value="b">Sepeda Motor</option>
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
                    <div class="input-form col-span-4">
                        <x-base.form-label for="crud-form-1">Produk</x-base.form-label>
                        <x-base.tom-select name="kendaraanA" id="kendaraanA" class="w-full"
                            data-placeholder="Pilih Kendaraan">
                            <option value="">Pilih Produk</option>
                            <option value="kedelai a">Kedelai a</option>
                            <option value="kedelai b">Kedelai b</option>
                        </x-base.tom-select>
                    </div>
                    <div class="input-form col-span-4">
                        <x-base.form-label for="crud-form-1">Qty</x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="qty" id="qty"
                            value="{{ $data->nominal ?? old('nominal') }}" placeholder="Input Nominal Pengeluaran"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                    </div>
                    <div class="input-form col-span-4">
                        <x-base.form-label for="crud-form-1">Subtotal</x-base.form-label>
                        <x-base.form-input class="w-full" type="text" name="subtotal" id="subtotal"
                            value="{{ $data->nominal ?? old('nominal') }}" placeholder="Input Nominal Pengeluaran"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                    </div>
                    {{-- <div class="input-form col-span-1">
                        <x-base.form-label for="crud-form-1">Action</x-base.form-label><br>
                        <button class="flex items-center text-danger">
                            <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" />
                            Hapus
                        </button>
                    </div> --}}
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
                <table class="min-w-full bg-white border-gray-300" id="table2">
                    <thead>
                        <tr class="bg-dark text-white">
                            <th class="py-2 px-4 border-b text-left">Header 1</th>
                            <th class="py-2 px-4 border-b text-left">Header 2</th>
                            <th class="py-2 px-4 border-b text-left">Header 3</th>
                            <!-- Tambahkan header lainnya sesuai kebutuhan -->
                        </tr>
                    </thead>
                    <tbody id="products">
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

                <x-base.table id="table_product">
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
                </x-base.table>

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
                var kendaraan = $('#kendaraanA').val();
                var qty = $('#qty').val();
                var subtotal = $('#subtotal').val();
                var products = `
                    <tr class="row-data">
                            <td class="py-2 px-4">${kendaraan}</td>
                            <td class="py-2 px-4">${qty}</td>
                            <td class="py-2 px-4">${subtotal}</td>
                    </tr>
                `;
                $('#products').html($('#products').html() + products);
            }
        </script>
    @endpush
@endsection
