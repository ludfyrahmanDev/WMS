<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
</div>
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
                        <x-base.form-label for="name">Nama Customer</x-base.form-label>
                        <x-base.form-input class="w-full mb-3" id="name" type="text" name="name"
                            value="{{ $data->name ?? old('name') }}" placeholder="Masukkan nama customer..." />
                        @if ($errors->has('name'))
                            <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                role="alert">{{ $errors->first('name') }}</small>
                        @endif
                    </div>
                    <div class="input-form">
                        <x-base.form-label for="phone">No. Handphone</x-base.form-label>
                        <x-base.form-input class="w-full mb-3" id="phone" type="text" name="phone"
                            value="{{ $data->phone ?? old('phone') }}" placeholder="Masukkan no handphone customer..."
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                        @if ($errors->has('phone'))
                            <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                role="alert">{{ $errors->first('phone') }}</small>
                        @endif
                    </div>
                    <div class="input-form">
                        <x-base.form-label for="ongkosan">Ongkosan (Rp)</x-base.form-label>
                        <x-base.form-input class="w-full mb-3" id="ongkosan" type="text" name="ongkosan"
                            value="{{ $data->ongkosan ?? old('ongkosan') }}" placeholder="Masukkan harga ongkosan..."
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                        @if ($errors->has('ongkosan'))
                            <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                role="alert">{{ $errors->first('ongkosan') }}</small>
                        @endif
                    </div>
                    <div class="input-form">
                        <x-base.form-label for="borongan">Borongan (Rp)</x-base.form-label>
                        <x-base.form-input class="w-full mb-3" id="borongan" type="text" name="borongan"
                            value="{{ $data->borongan ?? old('borongan') }}" placeholder="Masukkan harga borongan..."
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                        @if ($errors->has('borongan'))
                            <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                role="alert">{{ $errors->first('borongan') }}</small>
                        @endif
                    </div>
                    <div class="input-form">
                        <x-base.form-label for="address">Alamat</x-base.form-label>
                        <x-base.form-textarea class="form-control" id="address" name="address"
                            placeholder="Masukkan alamat..." value="{{ $data->address ?? old('address') }}">
                        </x-base.form-textarea>
                        @if ($errors->has('address'))
                            <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                role="alert">{{ $errors->first('address') }}</small>
                        @endif
                    </div>

                    <div class="mt-5 text-right">
                        <x-base.button onclick="location.href='{{ route('customer.index') }}'" class="mr-1 w-24" type="button" variant="outline-secondary">
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
