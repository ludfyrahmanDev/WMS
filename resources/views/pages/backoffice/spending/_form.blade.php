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
                        <x-base.form-label for="crud-form-1">Tanggal</x-base.form-label>
                        <x-base.form-input class="w-full" id="tanggal" type="date" name="tanggal"
                            value="{{ $data->date ?? date('Y-m-d') }}" required placeholder="Pilih Tanggal" />
                        @error('tanggal')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Mutasi</x-base.form-label>
                        <x-base.tom-select name="mutasi" class="w-full" data-placeholder="Pilih Mutasi" required>
                            <option value="">Pilih Mutasi</option>
                            <option value="Uang Masuk" {{ $data->mutation == 'Uang Masuk' ? 'selected' : '' }}>Uang
                                Masuk</option>
                            <option value="Uang Keluar" {{ $data->mutation == 'Uang Keluar' ? 'selected' : '' }}>Uang
                                Keluar</option>
                        </x-base.tom-select>
                        @error('mutasi')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Kategori Pengeluaran</x-base.form-label>
                        <x-base.tom-select name="spending_category" class="w-full"
                            data-placeholder="Pilih Kategori Pengeluaran" required> 
                            <option value="">Pilih Kategori Pengeluaran</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{$data->spending_category_id == $item->id ? 'selected' : ''}}>{{ $item->spending_category  }}</option>
                            @endforeach
                        </x-base.tom-select>
                        @error('spending_category')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Deskripsi</x-base.form-label>
                        <x-base.form-textarea class="form-control" id="validation-form-6" name="description"
                            placeholder="Input Deskripsi"
                            value="{{ $data->description ?? old('description') }}" required></x-base.form-textarea>
                        @error('description')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Metode Pembayaran</x-base.form-label>
                        <x-base.tom-select name="payment_method" class="w-full" data-placeholder="Pilih Metode Pembayaran" required>
                           @foreach ($enum as $option)
                               <option value="{{$option['value']}}" {{$data->payment_method == $option['value'] ? 'selected' : ''}}>{{$option['label']}}</option>
                           @endforeach
                        </x-base.tom-select>
                        @error('payment_method')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Nominal</x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="nominal"
                            value="{{ $data->nominal ?? old('nominal') }}" placeholder="Input Nominal Pengeluaran"
                            required onkeypress="return event.charCode >= 48 && event.charCode <= 57"  />
                        @error('nominal')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mt-5 text-right">

                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            <a href="{{ route('spending.index') }}" variant="outline-secondary">
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
