@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">{{ $title }}</h2>
    @if (session('success'))
        <x-base.alert class="mb-2 mt-5 flex items-center" variant="outline-success">
            <x-base.lucide class="mr-2 h-6 w-6" icon="AlertOctagon" />
            {{ session('success') }}
            <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
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
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            @if (COUNT($cekDataDateNow) > 0)
                <x-base.button class="mr-2 shadow-md" data-tw-toggle="modal" data-tw-target="#modal-closing" variant="primary" disabled>
                    Closing
                </x-base.button>
            @else
                <x-base.button class="mr-2 shadow-md" data-tw-toggle="modal" data-tw-target="#modal-closing" variant="primary">
                    Closing
                </x-base.button>
            @endif

            <x-base.menu>
                <x-base.menu.button class="!box px-2" as="x-base.button">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <x-base.lucide class="h-4 w-4" icon="file" />
                    </span>
                </x-base.menu.button>
                <x-base.menu.items class="w-40">
                    <x-base.menu.item href="{{ route('closing.export', $request) }}" target="_blank">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="sheet" /> Export to Excel
                    </x-base.menu.item>
                    <x-base.menu.item href="{{ route('closing.export-pdf', $request) }}">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Export to PDF
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>

            <div class="mx-auto hidden text-slate-500 md:block">
                Showing 1 to {{ $data->total() < 10 ? $data->total() : 10 }} of {{ $data->total() }} entries
            </div>
            <div class="mt-3 w-full flex sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <div class=" flex w-72">
                    <x-base.form-input  class="datepicker !box mr-4 sm:w-56" id="start_date" type="date"
                        value="{{ $request['start_date'] ?? old('start_date') }}" required placeholder="Tanggal Mulai" />
                    <x-base.form-input  class="datepicker !box mr-4 sm:w-56" id="end_date" type="date"
                        value="{{ $request['end_date'] ?? old('end_date') }}" required placeholder="Tanggal Mulai" />
                </div>
                {{-- make live search --}}
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input class="!box w-56 pr-10" type="text" id="search"
                        value="{{ request()->get('search') }}" placeholder="Search..." />
                    <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4" icon="Search" />
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <x-base.table class="-mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            No
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Tanggal
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Customer Belum Bayar
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Saldo Individu
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Hutang
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Piutang Toko
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Modal Toko
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            ACTIONS
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($data as $item)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium" href="">
                                    {{ $item['created_at'] }}
                                </a>
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['cust_has_not_paid'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['main_balance'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['debt'] }}
                            </x-base.table.td>
                            {{-- <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['bri_balance'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['business_balance'] }}
                            </x-base.table.td> --}}
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['shop_receivables'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['shop_capital'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <x-base.button title="Detail Customer Belum Bayar" type="button" id="modalDetailClosing"
                                    data-tw-toggle="modal" data-tw-target="#detailClosing"
                                    onclick="detailClosing('{{ $item['id'] }}')" variant="primary">
                                    <x-base.lucide class="h-4 w-4" icon="Eye" />
                                </x-base.button>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach
                </x-base.table.tbody>
                {{-- make if empty data --}}
                @if ($data->isEmpty())
                    <x-base.table.tbody>
                        <x-base.table.tr>
                            <x-base.table.td
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                colspan="10">
                                <div class="flex justify-center items-center">
                                    <x-base.lucide class="h-16 w-16 text-slate-500" icon="Inbox" />
                                    <div class="ml-2 text-slate-500">
                                        Data not found
                                    </div>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    </x-base.table.tbody>
                @endif
            </x-base.table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <x-base.pagination.base :data="$data"></x-base.pagination.base>
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                <div class="mt-5 text-3xl">Are you sure?</div>
                <div class="mt-2 text-slate-500">
                    Do you really want to delete these records? <br />
                    This process cannot be undone.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                    Cancel
                </x-base.button>
                <x-base.button class="w-24" type="button" variant="danger">
                    Delete
                </x-base.button>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->
    <!-- BEGIN: Modal Content -->
    <x-base.dialog id="modal-closing">
        <x-base.dialog.panel>
            <form action="{{ $route }}" method="post">
                @csrf
                <x-base.dialog.title>
                    <h2 class="mr-auto text-base font-medium">
                        Closing
                    </h2>
                    <x-base.menu class="sm:hidden">
                        <x-base.menu.button class="block h-5 w-5" href="#">
                            <x-base.lucide class="h-5 w-5 text-slate-500" icon="MoreHorizontal" />
                        </x-base.menu.button>
                        <x-base.menu.items class="w-40">
                            <x-base.menu.item>
                                <x-base.lucide class="mr-2 h-4 w-4" icon="File" />
                                Download Docs
                            </x-base.menu.item>
                        </x-base.menu.items>
                    </x-base.menu>
                </x-base.dialog.title>
                <x-base.dialog.description class="grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="modal-form-3">
                            Piutang Toko
                        </x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="piutang_toko"
                            id="piutang_toko" value="" placeholder="Input Piutang Toko"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <x-base.form-label for="modal-form-4">
                            Modal Toko
                        </x-base.form-label>
                        <x-base.form-input class="w-full" id="crud-form-1" type="text" name="modal_toko"
                            id="modal_toko" value="" placeholder="Input Modal Toko"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" required />
                    </div>
                </x-base.dialog.description>
                <x-base.dialog.footer>
                    <x-base.button class="mr-1 w-20" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                        Cancel
                    </x-base.button>
                    <x-base.button class="w-20" type="submit" variant="primary">
                        save
                    </x-base.button>
                </x-base.dialog.footer>
            </form>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Modal Content -->
    <!-- BEGIN: Modal Content -->
    <x-base.dialog id="detailClosing">
        <x-base.dialog.panel class="p-10 text-center">
            <table class="min-w-full bg-white border-gray-300">
                <thead>
                    <tr class="bg-dark text-white">
                        <th class="py-2 px-4 border-b text-left w-1/4 text-center">No</th>
                        <th class="py-2 px-4 border-b text-left w-1/4 text-center">Nama</th>
                        <th class="py-2 px-4 border-b text-left w-1/4 text-center">Nominal</th>
                    </tr>
                </thead>
                <tbody id="tableDetailClosing">
                </tbody>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Modal Content -->

    @push('scripts')
        <script>
            function detailClosing(closing_id) {
                $('#tableDetailClosing').html('');

                var xhr = new XMLHttpRequest();
                var url = "/getDetailClosingByID?closing_id=" + closing_id;

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            arrLaba = [];

                            var response = JSON.parse(xhr.responseText);

                            if (response.length > 0) {
                                for (let i = 0; i < response.length; i++) {
                                    var dataDetailClosing = `
                                    <tr class="row-data">
                                        <td class="py-2 px-4 w-1/4">${i + 1}</td>
                                        <td class="py-2 px-4 w-1/4">${response[i].name}</td>
                                        <td class="py-2 px-4 w-1/4">${response[i].nominal}</td>
                                    </tr>
                                `;

                                    $('#tableDetailClosing').html($('#tableDetailClosing').html() + dataDetailClosing);
                                }
                            } else {
                                var dataDetailClosing = `
                                    <tr class="row-data">
                                        <td colspan="3" class="py-2 px-4 w-1/4">Data Kosong</td>
                                    </tr> `;

                                $('#tableDetailClosing').html($('#tableDetailClosing').html() + dataDetailClosing);
                            }

                        } else {
                            console.log('Error:', xhr.status);
                        }
                    }
                };

                xhr.open("GET", url, true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send();
            }
        </script>
    @endpush
@endsection
