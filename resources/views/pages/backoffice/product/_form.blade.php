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

            <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($type != 'create')
                    @method('PUT')
                @endif
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div class="input-form">
                        <x-base.form-label for="crud-form-1">Kategori Produk</x-base.form-label>
                        <x-base.tom-select name="product_category" class="w-full"
                            data-placeholder="Pilih Kategori Pengeluaran" required> 
                            <option value="">Pilih Kategori Produk</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{$data->product_category_id == $item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                            @endforeach
                        </x-base.tom-select>
                        @error('product_category')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Produk</x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="product"
                            value="{{ $data->product ?? old('product') }}" placeholder="Masukkan nama produk..."/>
                        @error('product')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Stok</x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="stock"
                            value="{{ $data->stock ?? old('stock') }}" placeholder="Masukkan stok produk..." onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
                        @error('stock')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Harga/KG</x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="price"
                            value="{{ $data->price ?? old('price') }}" placeholder="Masukkan harga/KG..." onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
                        @error('price')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Harga Jual</x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="price_sell"
                            value="{{ $data->price_sell ?? old('price_sell') }}" placeholder="Masukkan harga jual..." onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
                        @error('price_sell')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mt-5 text-right">

                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            <a href="{{ route('product.index') }}" variant="outline-secondary">
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
@endsection
