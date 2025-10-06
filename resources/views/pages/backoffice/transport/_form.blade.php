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
                <input type="hidden" name="mode" value="Edit">
                <div class="intro-y box p-5">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="border-b input-form col-span-4">
                            <x-base.tom-select name="mode" class="w-full" data-placeholder="Pilih Sumber" id="mode">
                                <option value="">Pilih Sumber</option>
                                <option value="0">Dari Penjualan</option>
                                <option value="1">Custom</option>
                            </x-base.tom-select>
                        </div>
                        <div class="border-b input-form col-span-4 hidden" id="invoice_div">
                            <x-base.tom-select name="invoice" class="w-full" data-placeholder="Pilih Invoice"
                                id="invoice">
                                <option value="">Pilih Invoice</option>
                                @foreach ($data['invoices'] as $row)
                                    <option value="{{ $row->id }}">{{ $row->no_invoice }}</option>
                                @endforeach
                            </x-base.tom-select>
                        </div>
                    </div>
                    <hr class="mt-5" style="border: 1px solid #000;">
                    <div class="grid grid-cols-12 gap-2 mt-5">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Tanggal</x-base.form-label>
                            <x-base.form-input class="w-full" id="tgl_jual" type="date" name="tgl_jual"
                                value="{{ $data['header']->date ?? date('Y-m-d') }}"
                                placeholder="Pilih Tanggal Pembelian" />
                            @error('tgl_jual')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Kendaraan</x-base.form-label>
                            <x-base.tom-select name="vehicle" class="w-full" data-placeholder="Pilih Kendaraan"
                                id="vehicle">
                                <option value="">Pilih Kendaraan</option>
                                @foreach ($data['vehicle'] as $row)
                                    <option value="{{ $row->id }}"
                                        {{ $data['header']->vehicle_id == $row->id ? 'selected' : '' }}>
                                        {{ $row->name }}</option>
                                @endforeach
                            </x-base.tom-select>
                            @error('vehicle')
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
                    <div class="grid grid-cols-12 gap-2 mt-3">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="product">Produk</x-base.form-label>
                            <x-base.form-input class="w-full" id="product" type="text" name="product"
                                value="{{ $data['header']->product ?? old('product') }}"
                                placeholder="Masukkan nama merk produk" />
                            @error('product')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="customer">Penerima</x-base.form-label>
                            <x-base.form-input class="w-full" id="customer" type="text" name="customer"
                                value="{{ $data['header']->customer ?? old('customer') }}"
                                placeholder="Masukkan nama penerima" />
                            @error('customer')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="weight">Berat</x-base.form-label>
                            <x-base.form-input class="w-full" id="weight" type="text" name="weight"
                                value="{{ $data['header']->weight ?? old('weight') }}"
                                placeholder="Masukkan berat produk" />
                            @error('weight')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-2 mt-3">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="ongkosan">Ongkosan</x-base.form-label>
                            <x-base.form-input class="w-full" id="ongkosan" type="text" name="ongkosan"
                                value="{{ $data['header']->ongkosan ?? old('ongkosan') }}"
                                placeholder="Masukkan nama merk produk"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" price="true" />
                            @error('ongkosan')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="drivers_pocket_money">Uang Saku</x-base.form-label>
                            <x-base.form-input class="w-full" id="drivers_pocket_money" type="text"
                                name="drivers_pocket_money"
                                value="{{ $data['header']->drivers_pocket_money ?? old('drivers_pocket_money') }}"
                                placeholder="Masukkan nama penerima"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" price="true" />
                            @error('drivers_pocket_money')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4">
                            <x-base.form-label for="setoran">Setoran</x-base.form-label>
                            <x-base.form-input class="w-full" id="setoran" type="text" name="setoran"
                                value="{{ $data['header']->setoran ?? old('setoran') }}"
                                placeholder="Masukkan berat produk"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" price="true" />
                            @error('setoran')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>


                    <div class="mt-5 text-right">

                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            <a href="{{ route('transport.index') }}" variant="outline-secondary">
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
            document.addEventListener('DOMContentLoaded', function() {

                // Event ketika mode berubah
                document.getElementById('mode').addEventListener('change', function() {
                    var mode = this.value;
                    var invoiceDiv = document.getElementById('invoice_div');
                    var invoice = document.getElementById('invoice');

                    if (mode === '0') {
                        invoiceDiv.classList.remove('hidden');
                        invoice.setAttribute('required', true);
                        invoice.value = "";
                    } else {
                        invoiceDiv.classList.add('hidden');
                        invoice.removeAttribute('required');
                        invoice.value = "";
                        // kalau pakai select2 atau select option lain
                        // var event = new Event('change');
                        // invoice.dispatchEvent(event);
                    }
                });

                // Event ketika invoice berubah
                document.getElementById('invoice').addEventListener('change', function() {
                    var id = this.value;

                    fetch("{{ route('transport.getInvoice') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                id: id
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('product').value = data.product;
                            document.getElementById('customer').value = data.name;
                            document.getElementById('weight').value = data.qty;
                            document.getElementById('tgl_jual').value = data.date;
                        })
                        .catch(error => console.error('Error:', error));
                });

            });
        </script>
    @endpush
@endsection
