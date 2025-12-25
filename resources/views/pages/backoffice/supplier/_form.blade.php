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
                        <x-base.form-label for="npwp">NPWP</x-base.form-label>
                        <x-base.form-input class="w-full" id="npwp" type="text" name="npwp"
                            value="{{ $data->npwp ?? old('npwp') }}" placeholder="Masukkan no NPWP 22 digit supplier..." />
                            <small style="padding-left: 0; margin-left: 0;" class="text-pending"
                                    role="alert"><i>Kalau tidak ada NPWP supplier, harap isi dengan angka nol 16 digit
                                        (0000000000000000)</i></small>
                        @error('npwp')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-form">
                        <x-base.form-label for="nik">NIK</x-base.form-label>
                        <x-base.form-input class="w-full" id="nik" type="text" name="nik"
                            value="{{ $data->nik ?? old('nik') }}" placeholder="Masukkan no NIK 16 digit supplier..." />
                            <small style="padding-left: 0; margin-left: 0;" class="text-pending"
                                    role="alert"><i>Kalau tidak ada NIK supplier, harap isi dengan angka nol 16 digit
                                        (0000000000000000)</i></small>
                        @error('nik')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="name">Nama</x-base.form-label>
                        <x-base.form-input class="w-full" id="name" type="text" name="name"
                            value="{{ $data->name ?? old('name') }}" placeholder="Masukkan nama supplier..." required />
                        @error('name')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="alamat">Alamat</x-base.form-label>
                        <x-base.form-textarea class="form-control" id="alamat" name="address"
                            placeholder="Masukkan alamat supplier..." required rows="3"
                            value="{{ $data->address ?? old('address') }}"></x-base.form-textarea>
                        @error('address')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="phone">No Telp <sup>(optional)</sup></x-base.form-label>
                        <x-base.form-input class="w-full" id="phone" type="text"
                            value="{{ $data->phone ?? old('phone') }}" name="phone" placeholder="Masukkan No Telp..." onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        @error('phone')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="pic">PIC (Penanggung Jawab)</x-base.form-label>
                        <x-base.form-input class="w-full" id="pic" type="text" required
                            value="{{ $data->pic ?? old('pic') }}" name="pic" placeholder="Masukkan Penanggung Jawab..." />
                        @error('pic')
                            <div class="pristine-error text-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mt-5 text-right">

                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            <a href="{{ route('supplier.index') }}" variant="outline-secondary">
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
