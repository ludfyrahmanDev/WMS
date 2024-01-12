<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
</div>
@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">{{$title}}</h2>
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
                        <x-base.form-label for="spending_category">Kategori pengeluaran</x-base.form-label>
                        <x-base.form-input class="w-full" id="spending_category" type="text" name="spending_category"
                            value="{{ $data->spending_category ?? old('spending_category') }}" placeholder="Masukkan kategori pengeluaran..." />
                        @error('spending_category')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    {{-- <div class="mt-3 input-form">
                        <x-base.form-label for="spending_types">Tipe pengeluaran</x-base.form-label>
                        <x-base.form-input class="w-full" id="spending_types" type="text" name="spending_types"
                            value="{{ $data->spending_types ?? old('spending_types') }}" placeholder="Masukkan tipe pengeluaran..." />
                        @error('spending_types')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
                    <div class="mt-3 input-form">
                        <x-base.form-label for="spending_types">Tipe pengeluaran</x-base.form-label>
                        <x-base.tom-select name="spending_types" id="spending_types" class="w-full" data-placeholder="Pilih Tipe Pengeluaran">
                            <option value="">Pilih Tipe Pengeluaran</option>
                            <option value="Kendaraan">Kendaraan</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </x-base.tom-select>
                    </div>

                    <div class="mt-5 text-right">
                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            Cancel
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
