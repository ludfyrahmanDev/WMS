@extends('../layouts/' . $layout)

@section('subhead')
    <title>{{$title}}</title>
@endsection

@section('subcontent')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium">Ubah Profil</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-12 2xl:col-span-9">
            <!-- BEGIN: Display Information -->
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="mr-auto text-base font-medium">
                        Informasi Pribadi
                    </h2>
                </div>
                <div class="p-5">
                    <div class="flex flex-col xl:flex-row">
                        <div class="flex-1 mt-6 xl:mt-0">
                            <div class="grid grid-cols-12 gap-x-5">
                                <div class="col-span-12">
                                    <x-base.form-label for="update-profile-form-1">
                                        Nama
                                    </x-base.form-label>
                                    <x-base.form-input
                                        id="update-profile-form-1"
                                        type="text"
                                        value="{{ $data->name }}"
                                        placeholder="Input text"
                                        disabled
                                    />
                                </div>
                                <div class="mt-3 col-span-12">
                                    <x-base.form-label for="update-profile-form-1">
                                        Email
                                    </x-base.form-label>
                                    <x-base.form-input
                                        id="update-profile-form-2"
                                        type="text"
                                        value="{{ $data->email }}"
                                        placeholder="Input text"
                                        disabled
                                    />
                                </div>
                                <div class="col-span-12 2xl:col-span-6">
                                    <div class="mt-3 2xl:mt-0">
                                        <x-base.form-label for="update-profile-form-3">
                                            Jenis Kelamin
                                        </x-base.form-label>
                                        <x-base.tom-select
                                            class="w-full"
                                            id="update-profile-form-3"
                                        >
                                            <option {{$data->gender == 'male' ? 'selected' : ''}}  value="male">
                                                Laki laki
                                            </option>
                                            <option {{$data->gender == 'female' ? 'selected' : ''}} value="female">
                                                Perempuan
                                            </option>
                                        </x-base.tom-select>
                                    </div>
                                </div>
                            </div>
                            <x-base.button
                                class="w-20 mt-3"
                                type="button"
                                variant="primary"
                            >
                                Save
                            </x-base.button>
                        </div>
                        <div class="mx-auto w-52 xl:mr-0 xl:ml-6">
                            <div
                                class="p-5 border-2 border-dashed rounded-md shadow-sm border-slate-200/60 dark:border-darkmode-400">
                                <div class="relative h-40 mx-auto cursor-pointer image-fit zoom-in">
                                    <img
                                        class="rounded-md"
                                        src="{{ Vite::asset($fakers[0]['photos'][0]) }}"
                                        alt="Midone Tailwind HTML Admin Template"
                                    />
                                    <x-base.tippy
                                        class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 -mt-2 -mr-2 text-white rounded-full bg-danger"
                                        as="div"
                                        content="Remove this profile photo?"
                                    >
                                        <x-base.lucide
                                            class="w-4 h-4"
                                            icon="X"
                                        />
                                    </x-base.tippy>
                                </div>
                                <div class="relative mx-auto mt-5 cursor-pointer">
                                    <x-base.button
                                        class="w-full"
                                        type="button"
                                        variant="primary"
                                    >
                                        Change Photo
                                    </x-base.button>
                                    <x-base.form-input
                                        class="absolute top-0 left-0 w-full h-full opacity-0"
                                        type="file"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Display Information -->
        </div>
    </div>
@endsection
