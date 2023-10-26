@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>CRUD Form - Midone - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Form Layout</h2>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div>
                    <x-base.form-label for="crud-form-1">Nama</x-base.form-label>
                    <x-base.form-input
                        class="w-full"
                        id="crud-form-1"
                        type="text"
                        required
                        placeholder="Input Nama"
                    />
                </div>
                <div class="mt-3">
                    <x-base.form-label for="crud-form-1">Email</x-base.form-label>
                    <x-base.form-input
                        class="w-full"
                        id="crud-form-1"
                        type="email"
                        required
                        placeholder="Input Email"
                    />
                </div>
                <div class="mt-3">
                    <x-base.form-label for="crud-form-1">Password</x-base.form-label>
                    <x-base.form-input
                        class="w-full"
                        id="crud-form-1"
                        type="password"
                        required
                        placeholder="Input Password"
                    />
                </div>
                <div class="mt-3">
                    <x-base.form-label for="crud-form-1">Password Konfirmasi</x-base.form-label>
                    <x-base.form-input
                        class="w-full"
                        id="crud-form-1"
                        type="password"
                        required
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
                        type="button"
                        variant="primary"
                    >
                        Save
                    </x-base.button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection
