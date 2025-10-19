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
                    <div class="grid grid-cols-12 gap-2 mt-5">
                        <div class="input-form col-span-4">
                            <x-base.form-label for="crud-form-1">Tanggal</x-base.form-label>
                            <x-base.form-input class="w-full" id="tgl_jual" type="date" name="tgl_jual"
                                value="{{ $data['header']->date ?? date('Y-m-d') }}" disabled
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
                                id="vehicle" disabled>
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
                            <x-base.tom-select name="driver" class="w-full" data-placeholder="Pilih driver" id="driver" disabled>
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
                                value="{{ $data['header']->product ?? old('product') }}" disabled
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
                                value="{{ $data['header']->customer ?? old('customer') }}" disabled
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
                                value="{{ $data['header']->weight ?? old('weight') }}" disabled
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
                                value="{{ $data['header']->ongkosan ?? old('ongkosan') }}" disabled
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
                                value="{{ $data['header']->drivers_pocket_money ?? old('drivers_pocket_money') }}" disabled
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
                                value="{{ $data['header']->setoran ?? old('setoran') }}" disabled
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
                    </div>
                </div>
                <!-- END: Form Layout -->
            </form>
        </div>
    </div>
@endsection
