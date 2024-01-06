@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{$title}}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">{{$title}}</h2>
    </div>
    @if (session('failed'))
    <x-base.alert
        class="mb-2 flex items-center"
        variant="outline-danger"
    >
        <x-base.lucide
            class="mr-2 h-6 w-6"
            icon="AlertOctagon"
        />
        {{ session('failed') }}
        <x-base.alert.dismiss-button
            class="btn-close"
            type="button"
            aria-label="Close"
        >
            <x-base.lucide
                class="h-4 w-4"
                icon="X"
            />
        </x-base.alert.dismiss-button>
    </x-base.alert>
    @endif
    <div class="mt-5 grid grid-cols-12 gap-6">

        <div class="intro-y col-span-12 lg:col-span-12">

            <form action="{{$route}}" method="post" enctype="multipart/form-data">
                @csrf
                @if($type != 'create')
                    @method('PUT')
                @endif
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div class="input-form">
                        <x-base.form-label for="crud-form-1">Nama</x-base.form-label>
                        <x-base.form-input
                            class="w-full"
                            id="crud-form-1"
                            type="text"
                            required
                            name="name"
                            value="{{ $data->name ?? old('name') }}"
                            placeholder="Input Nama"
                        />
                        @error('name')
                        <div class="pristine-error text-danger mt-2">
                        {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Email</x-base.form-label>
                        <x-base.form-input
                            class="w-full"
                            id="crud-form-1"
                            type="email"
                            value="{{ $data->email ?? old('email') }}"
                            required
                            name="email"
                            placeholder="Input Email"
                        />
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Password</x-base.form-label>
                        <x-base.form-input
                            class="w-full"
                            id="crud-form-1"
                            type="password"
                            name="password"
                            placeholder="Input Password"
                        />
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Password Konfirmasi</x-base.form-label>
                        <x-base.form-input
                            class="w-full"
                            id="crud-form-1"
                            type="password"
                            name="password_confirmation"
                            placeholder="Input Password Konfirmasi"
                        />
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Role</x-base.form-label>
                        <x-base.form-select id="category" name='role' required>
                            @php
                                $oldrole = $data->role ?? old('role');
                            @endphp
                            <option value="">Pilih Role</option>
                            @foreach ($role as $item)
                                <option
                                    value="{{ $item['value'] }}"
                                    {{$oldrole == $item['value'] ? 'selected' : ''}}
                                >{{ $item['label'] }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Jenis Kelamin</x-base.form-label>
                        <x-base.form-select id="gender" name='gender' required>
                            @php
                                $oldGender = $data->gender ?? old('gender');
                            @endphp
                            <option value="">Pilih Jenis Kelamin</option>
                            @foreach ($gender as $item)
                                <option
                                    value="{{ $item['value'] }}"
                                    {{$oldGender == $item['value'] ? 'selected' : ''}}
                                >{{ $item['label'] }}</option>
                            @endforeach
                        </x-base.form-select>
                    </div>
                    <div class="mt-3 input-form">
                        <x-base.form-label for="crud-form-1">Photo</x-base.form-label>
                        <x-base.form-input
                            class="w-full"
                            id="crud-form-1"
                            type="file"
                            name="file"
                            placeholder="Input Password Konfirmasi"
                        />
                    </div>

                    <div class="mt-5 text-right">
                        <x-base.button
                            class="mr-1 w-24"
                            type="button"
                            variant="outline-secondary"
                        >
                            Cancel
                        </x-base.button>
                        <x-base.button
                            class="w-24"
                            type="submit"
                            variant="primary"
                        >
                            Save
                        </x-base.button>
                    </div>
                </div>
                <!-- END: Form Layout -->
            </form>
        </div>
    </div>
@endsection
