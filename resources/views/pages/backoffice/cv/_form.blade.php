@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- Modern Page Header -->
    <div class="intro-y mt-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('cv.index') }}" class="flex items-center justify-center w-10 h-10 bg-slate-100 rounded-lg hover:bg-slate-200 transition">
                    <x-base.lucide class="w-5 h-5 text-slate-600" icon="ArrowLeft" />
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $type == 'create' ? 'Tambah' : 'Edit' }} {{ $title }}</h1>
                    <p class="text-slate-600 mt-1">{{ $type == 'create' ? 'Tambahkan CV baru' : 'Ubah data CV' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('failed'))
        <x-base.alert class="mb-6 flex items-center bg-red-50 border-red-200" variant="outline-danger" data-dismissible="true">
            <x-base.lucide class="mr-3 h-5 w-5 text-red-600" icon="AlertCircle" />
            <span class="text-red-800">{{ session('failed') }}</span>
            <x-base.alert.dismiss-button class="btn-close ml-auto" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif

    <!-- Form -->
    <div class="intro-y box p-8">
        <form action="{{ $route }}" method="post">
            @csrf
            @if ($type != 'create')
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama CV -->
                <div class="col-span-2">
                    <div class="input-form">
                        <x-base.form-label for="name" class="flex items-center">
                            <span class="text-slate-700 font-semibold">Nama CV</span>
                            <span class="ml-1 text-red-500">*</span>
                        </x-base.form-label>
                        <x-base.form-input 
                            class="w-full mt-2 {{ $errors->has('name') ? 'border-red-500' : '' }}" 
                            id="name" 
                            type="text" 
                            name="name"
                            value="{{ $data->name ?? old('name') }}" 
                            placeholder="Masukkan nama CV..." 
                            required
                        />
                        @if ($errors->has('name'))
                            <div class="text-red-600 text-sm mt-1">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>

                <!-- NPWP -->
                <div>
                    <div class="input-form">
                        <x-base.form-label for="npwp" class="flex items-center">
                            <span class="text-slate-700 font-semibold">NPWP</span>
                        </x-base.form-label>
                        <x-base.form-input 
                            class="w-full mt-2 {{ $errors->has('npwp') ? 'border-red-500' : '' }}" 
                            id="npwp" 
                            type="text" 
                            name="npwp"
                            value="{{ $data->npwp ?? old('npwp') }}" 
                            placeholder="Masukkan NPWP..."
                            maxlength="20"
                        />
                        @if ($errors->has('npwp'))
                            <div class="text-red-600 text-sm mt-1">{{ $errors->first('npwp') }}</div>
                        @endif
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <div class="input-form">
                        <x-base.form-label for="address" class="flex items-center">
                            <span class="text-slate-700 font-semibold">Alamat</span>
                        </x-base.form-label>
                        <x-base.form-input 
                            class="w-full mt-2 {{ $errors->has('address') ? 'border-red-500' : '' }}" 
                            id="address" 
                            type="text" 
                            name="address"
                            value="{{ $data->address ?? old('address') }}" 
                            placeholder="Masukkan alamat..."
                        />
                        @if ($errors->has('address'))
                            <div class="text-red-600 text-sm mt-1">{{ $errors->first('address') }}</div>
                        @endif
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="col-span-2">
                    <div class="input-form">
                        <x-base.form-label for="description" class="flex items-center">
                            <span class="text-slate-700 font-semibold">Deskripsi</span>
                        </x-base.form-label>
                        <x-base.form-textarea 
                            class="w-full mt-2 {{ $errors->has('description') ? 'border-red-500' : '' }}" 
                            id="description" 
                            name="description"
                            placeholder="Masukkan deskripsi CV..."
                            rows="4"
                        >{{ $data->description ?? old('description') }}</x-base.form-textarea>
                        @if ($errors->has('description'))
                            <div class="text-red-600 text-sm mt-1">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex items-center justify-end space-x-3 pt-6 border-t border-slate-200">
                <a href="{{ route('cv.index') }}">
                    <x-base.button 
                        class="px-6 py-2.5 border-slate-300 text-slate-700 hover:bg-slate-50" 
                        type="button" 
                        variant="outline-secondary">
                        <x-base.lucide class="w-4 h-4 mr-2" icon="X" />
                        Batal
                    </x-base.button>
                </a>
                <x-base.button 
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white shadow-lg shadow-blue-600/20" 
                    type="submit" 
                    variant="primary">
                    <x-base.lucide class="w-4 h-4 mr-2" icon="Save" />
                    {{ $type == 'create' ? 'Simpan' : 'Update' }}
                </x-base.button>
            </div>
        </form>
    </div>
@endsection
