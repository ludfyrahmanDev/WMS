<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
</div>
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
                <div class="intro-y box p-5">
                    <div class="grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="name">Nama Customer</x-base.form-label>
                                <x-base.form-input class="w-full mb-3" id="name" type="text" name="name"
                                    value="{{ $data->name ?? old('name') }}" placeholder="Masukkan nama customer..." />
                                @if ($errors->has('name'))
                                    <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                        role="alert">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="npwp">NPWP</x-base.form-label>
                                <x-base.form-input class="w-full" id="npwp" type="text" name="npwp"
                                    value="{{ $data->npwp ?? old('npwp') }}"
                                    placeholder="Masukkan no NPWP 22 digit customer..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                                <small style="padding-left: 0; margin-left: 0;" class="text-pending"
                                    role="alert"><i>Kalau tidak ada NPWP customer, harap isi dengan angka nol 16 digit
                                        (0000000000000000)</i></small>
                                @if ($errors->has('npwp'))
                                    <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                        role="alert">{{ $errors->first('npwp') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="nik">NIK</x-base.form-label>
                                <x-base.form-input class="w-full" id="nik" type="text" name="nik"
                                    value="{{ $data->nik ?? old('nik') }}" placeholder="Masukkan NIK 16 digit customer..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                                <small style="padding-left: 0; margin-left: 0;" class="text-pending"
                                    role="alert"><i>Kalau tidak ada NIK customer, harap isi dengan angka nol 16 digit
                                        (0000000000000000)</i></small>
                                @if ($errors->has('nik'))
                                    <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                        role="alert">{{ $errors->first('nik') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="phone">No. Handphone <sup>(optional)</sup></x-base.form-label>
                                <x-base.form-input class="w-full mb-3" id="phone" type="text" name="phone"
                                    value="{{ $data->phone ?? old('phone') }}"
                                    placeholder="Masukkan no handphone customer..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                                @if ($errors->has('phone'))
                                    <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                        role="alert">{{ $errors->first('phone') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="ongkosan">Ongkosan (Rp)</x-base.form-label>
                                <x-base.form-input class="w-full mb-3" id="ongkosan" type="text" name="ongkosan"
                                    price="true" value="{{ $data->ongkosan ?? old('ongkosan') }}"
                                    placeholder="Masukkan harga ongkosan..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                                @if ($errors->has('ongkosan'))
                                    <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                        role="alert">{{ $errors->first('ongkosan') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="borongan">Borongan (Rp)</x-base.form-label>
                                <x-base.form-input class="w-full mb-3" id="borongan" type="text" name="borongan"
                                    price="true" value="{{ $data->borongan ?? old('borongan') }}"
                                    placeholder="Masukkan harga borongan..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                                @if ($errors->has('borongan'))
                                    <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                        role="alert">{{ $errors->first('borongan') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 grid grid-cols-12 gap-2">
                        <div class="input-form col-span-12">
                            <div class="input-form">
                                <x-base.form-label for="address">Alamat <sup>(optional)</sup></x-base.form-label>
                                <x-base.form-textarea class="form-control" id="address" name="address"
                                    placeholder="Masukkan alamat..." value="{{ $data->address ?? old('address') }}">
                                </x-base.form-textarea>
                                @if ($errors->has('address'))
                                    <small style="padding-left: 0; margin-left: 0;" class="text-danger mb-3"
                                        role="alert">{{ $errors->first('address') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr style="border: 1px solid black;">

                    <div class="mt-4 mb-4 grid grid-cols-12">
                        <div class="col-span-6 flex">
                            <h2><strong>Form Customer Alias</strong></h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="name2">Nama Alias</x-base.form-label>
                                <x-base.form-input class="w-full mb-3" id="name2" type="text" name="name2"
                                    placeholder="Masukkan nama alias..." />
                            </div>
                        </div>
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="npwp2">NPWP</x-base.form-label>
                                <x-base.form-input class="w-full" id="npwp2" type="text" name="npwp2"
                                    placeholder="Masukkan no NPWP 22 digit customer..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                                <small style="padding-left: 0; margin-left: 0;" class="text-pending"
                                    role="alert"><i>Kalau tidak ada NPWP customer, harap isi dengan angka nol 16 digit
                                        (0000000000000000)</i></small>
                            </div>
                        </div>
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="nik2">NIK</x-base.form-label>
                                <x-base.form-input class="w-full" id="nik2" type="text" name="nik2"
                                    placeholder="Masukkan NIK 16 digit customer..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                                <small style="padding-left: 0; margin-left: 0;" class="text-pending"
                                    role="alert"><i>Kalau tidak ada NIK customer, harap isi dengan angka nol 16 digit
                                        (0000000000000000)</i></small>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-2">
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="phone2">No. Handphone Alias
                                    <sup>(optional)</sup></x-base.form-label>
                                <x-base.form-input class="w-full mb-3" id="phone2" type="text" name="2"
                                    placeholder="Masukkan no handphone alias..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                            </div>
                        </div>
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="ongkosan2">Ongkosan (Rp)</x-base.form-label>
                                <x-base.form-input class="w-full mb-3" id="ongkosan2" type="text" name="ongkosan2"
                                    price="true" placeholder="Masukkan harga ongkosan..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                            </div>
                        </div>
                        <div class="input-form col-span-4">
                            <div class="input-form">
                                <x-base.form-label for="borongan2">Borongan (Rp)</x-base.form-label>
                                <x-base.form-input class="w-full mb-3" id="borongan2" type="text" name="borongan2"
                                    price="true" placeholder="Masukkan harga borongan..."
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-12 gap-2">
                        <div class="input-form col-span-12">
                            <div class="input-form">
                                <x-base.form-label for="address2">Alamat Alias <sup>(optional)</sup></x-base.form-label>
                                <x-base.form-textarea class="form-control" id="address2" name="address2"
                                    placeholder="Masukkan alamat...">
                                </x-base.form-textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-12">
                        <div class="col-span-6 flex">
                            <h2><strong>Daftar Customer Alias</strong></h2>
                        </div>
                        <div class="col-span-6 flex justify-end">
                            <x-base.button type="button" onclick="tambahAlias()" variant="primary">
                                Tambah Alias
                            </x-base.button>
                        </div>
                    </div>
                    <br>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border-gray-300" id="aliasTable">
                            <thead>
                                <tr class="bg-dark text-white">
                                    <th class="py-2 px-4 border-b text-left w-1/4">Alias</th>
                                    <th class="py-2 px-4 border-b text-left w-1/4">NPWP</th>
                                    <th class="py-2 px-4 border-b text-left w-1/4">NIK</th>
                                    <th class="py-2 px-4 border-b text-left w-1/4">No. Handphone</th>
                                    <th class="py-2 px-4 border-b text-left w-1/4">Ongkosan</th>
                                    <th class="py-2 px-4 border-b text-left w-1/4">Borongan</th>
                                    <th class="py-2 px-4 border-b text-left w-1/4">Alamat</th>
                                    <th class="py-2 px-4 border-b text-left w-1/4">Action</th>
                                </tr>
                            </thead>
                            <tbody id="listAlias">
                                @if (isset($data) && isset($data->alias))
                                    @foreach ($data->alias as $alias)
                                        <tr class="row-data">
                                            <td class="py-2 px-4">{{ $alias->name }}
                                                <input type="hidden" name="alias[]" value="{{ $alias->name }}" />
                                            </td>
                                            <td class="py-2 px-4">{{ $alias->npwp }}
                                                <input type="hidden" name="npwp_alias[]" value="{{ $alias->npwp }}" />
                                            </td>
                                            <td class="py-2 px-4">{{ $alias->nik }}
                                                <input type="hidden" name="nik_alias[]" value="{{ $alias->nik }}" />
                                            </td>
                                            <td class="py-2 px-4">{{ $alias->phone }}
                                                <input type="hidden" name="phone_alias[]" value="{{ $alias->phone }}" />
                                            </td>
                                            <td class="py-2 px-4">{{ toThousand($alias->ongkosan) }}
                                                <input type="hidden" name="ongkosan_alias[]"
                                                    value="{{ toThousand($alias->ongkosan) }}" />
                                            </td>
                                            <td class="py-2 px-4">{{ toThousand($alias->borongan) }}
                                                <input type="hidden" name="borongan_alias[]"
                                                    value="{{ toThousand($alias->borongan) }}" />
                                            </td>
                                            <td class="py-2 px-4">{{ $alias->address }}
                                                <input type="hidden" name="address_alias[]"
                                                    value="{{ $alias->address }}" />
                                            </td>
                                            <td class="py-2 px-4">
                                                <button onclick="hapusRow(this)"
                                                    class="flex items-center text-danger">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5 text-right">
                        <x-base.button onclick="location.href='{{ route('customer.index') }}'" class="mr-1 w-24"
                            type="button" variant="outline-secondary">
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

    @push('scripts')
        <script>
            function tambahAlias() {
                var alias = $('#name2').val();
                var npwp = $('#npwp2').val();
                var nik = $('#nik2').val();
                var phone = $('#phone2').val();
                var ongkosan = $('#ongkosan2').val();
                var borongan = $('#borongan2').val();
                var address = $('#address2').val();

                if (alias === '' || npwp === '' || nik == '' || ongkosan === '' || borongan === '') {
                    alert('Harap lengkapi form alias untuk menambahkan data alias!');
                    return;
                }

                var row = `<tr class="row-data">
                    <td class="py-2 px-4">${alias}<input type="hidden" name="alias[]" value="${alias}" /></td>
                    <td class="py-2 px-4">${npwp}<input type="hidden" name="npwp_alias[]" value="${npwp}" /></td>
                    <td class="py-2 px-4">${nik}<input type="hidden" name="nik_alias[]" value="${nik}" /></td>
                    <td class="py-2 px-4">${phone}<input type="hidden" name="phone_alias[]" value="${phone}" /></td>
                    <td class="py-2 px-4">${ongkosan}<input type="hidden" name="ongkosan_alias[]" value="${ongkosan}" /></td>
                    <td class="py-2 px-4">${borongan}<input type="hidden" name="borongan_alias[]" value="${borongan}" /></td>
                    <td class="py-2 px-4">${address}<input type="hidden" name="address_alias[]" value="${address}" /></td>
                    <td class="py-2 px-4">
                        <button onclick="hapusRow(this)" class="flex items-center text-danger">Hapus</button>
                    </td>
                </tr>`;

                $('#listAlias').append(row);

                $('#name2').val('');
                $('#npwp2').val('');
                $('#nik2').val('');
                $('#phone2').val('');
                $('#ongkosan2').val('');
                $('#borongan2').val('');
                $('#address2').val('');
            }

            function hapusRow(button) {
                $(button).closest('tr').remove();
            }
        </script>
    @endpush
@endsection
