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
                            <x-base.form-input disabled class="w-full" id="crud-form-1" type="date" name="tgl_jual"
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
                            <x-base.tom-select disabled name="customer" class="w-full" data-placeholder="Pilih Pelanggan"
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
                            <x-base.tom-select disabled name="driver" class="w-full" data-placeholder="Pilih driver"
                                id="driver">
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
                            <x-base.tom-select disabled name="kendaraan" class="w-full" data-placeholder="Pilih Kendaraan"
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
                            <x-base.form-input disabled class="w-full" id="crud-form-1" type="text" name="uang_saku"
                                id="uang_saku" value="{{ $data['header']->drivers_pocket_money ?? old('uang_saku') }}"
                                placeholder="Masukkan uang saku pengemudi"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="tipe_pembelian">Tipe Pembelian</x-base.form-label>
                            <x-base.tom-select disabled name="tipe_pembelian" id="tipe_pembelian" class="w-full"
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
                            <x-base.tom-select disabled name="tipe_pembayaran" id="tipe_pembayaran" class="w-full"
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
                            @if ($data['header']->status != 'On Progress')
                                <x-base.form-label for="catatan">Catatan</x-base.form-label>
                                <x-base.form-textarea disabled class="form-control" id="catatan" name="catatan"
                                    placeholder="Masukkan catatan (Optional)..."
                                    value="{{ $data['header']->notes ?? old('catatan') }}"></x-base.form-textarea>
                            @else
                                <x-base.form-label for="catatan">Catatan</x-base.form-label>
                                <x-base.form-textarea class="form-control" id="catatan" name="catatan"
                                    placeholder="Masukkan catatan (Optional)..."
                                    value="{{ $data['header']->notes ?? old('catatan') }}"></x-base.form-textarea>
                            @endif
                        </div>
                    </div>
                    <br>
                    <hr style="border: 1px solid black;">
                    <br>
                    @error('angsuran')
                        <div class="pristine-error text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                    <table class="min-w-full bg-white border-gray-300" id="transDetail">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-left w-1/4">Produk</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Qty</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Harga Jual</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="transDetail">
                            @if (isset($data['detail']))
                                @foreach ($data['detail'] as $item)
                                    <?php $profit = 0; ?>
                                    <?php $profit += intVal(($item['price_sell'] - $item['price']) * $item['qty']); ?>
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
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-center" colspan="3">Laba Bersih</th>
                                <th class="py-2 px-4 border-b text-center laba_bersih">
                                    {{ $data['header']->net_profit ?? 0 }}</th>
                            </tr>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-center" colspan="3">Grand Total</th>
                                <th class="py-2 px-4 border-b text-center grand_total">
                                    {{ $data['header']->grand_total ?? 0 }}</th>
                            </tr>
                            @if ($data['header']->status == 'On Progress')
                                <tr class="bg-dark text-white">
                                    <th class="py-2 px-4 border-b text-center text-white" colspan="3">Total Bayar</th>
                                    <th class="py-2 px-4 border-b text-center">
                                        {{ $data['header']->total_payment ?? 0 }}
                                    </th>
                                </tr>
                                <tr class="bg-dark ">
                                    <th class="py-2 px-4 border-b text-center text-white" colspan="3">Angsuran</th>
                                    <th class="py-2 px-4 border-b text-center">
                                        <x-base.form-input class="w-3/5 text-center" id="angsuran" type="text"
                                            name="angsuran" value="" placeholder="Input Angsuran" required
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                    </th>
                                </tr>
                            @else
                                <tr class="bg-dark text-white">
                                    <th class="py-2 px-4 border-b text-center text-white" colspan="3">Total Bayar</th>
                                    <th class="py-2 px-4 border-b text-center">
                                        {{ $data['header']->total_payment ?? 0 }}
                                    </th>
                                </tr>
                            @endif

                        </tfoot>
                    </table>

                    <input type="hidden" name="mode" id="mode" value="angsuran" />

                    <div class="mt-5 text-right">
                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            <a href="{{ route('selling.index') }}" variant="outline-secondary">
                                Cancel
                            </a>
                        </x-base.button>
                        @if ($data['header']->status == 'On Progress')
                            <x-base.button class="w-24" type="submit" variant="primary">
                                Save
                            </x-base.button>
                        @endif
                    </div>
                </div>
                <!-- END: Form Layout -->
            </form>
        </div>
    </div>

@endsection
