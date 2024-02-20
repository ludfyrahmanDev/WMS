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
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-4">
            <div @class([
                'relative zoom-in',
                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
            ])>
                <div class="box p-5">
                    <div class="flex">
                        <x-base.lucide class="h-[28px] w-[28px] text-primary" icon="ShoppingCart" />
                        <div class="ml-auto hidden">
                            <x-base.tippy
                                class="flex cursor-pointer items-center rounded-full bg-success py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                as="div" content="33% Higher than last month">
                                33%
                                <x-base.lucide class="ml-0.5 h-4 w-4" icon="ChevronUp" />
                            </x-base.tippy>
                        </div>
                    </div>
                    <div class="mt-6 text-3xl font-medium leading-8">{{ toThousand($total ?? 0) }}</div>
                    <div class="mt-1 text-base text-slate-500">Total Penjualan</div>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-4">
            <div @class([
                'relative zoom-in',
                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
            ])>
                <div class="box p-5">
                    <div class="flex">
                        <x-base.lucide class="h-[28px] w-[28px] text-pending" icon="CreditCard" />
                        <div class="ml-auto hidden">
                            <x-base.tippy
                                class="flex cursor-pointer items-center rounded-full bg-danger py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                as="div" content="2% Lower than last month">
                                2%
                                <x-base.lucide class="ml-0.5 h-4 w-4" icon="ChevronDown" />
                            </x-base.tippy>
                        </div>
                    </div>
                    <div class="mt-6 text-3xl font-medium leading-8">{{ toThousand($completed ?? 0) }}</div>
                    <div class="mt-1 text-base text-slate-500">Total Terbayar</div>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-4">
            <div @class([
                'relative zoom-in',
                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
            ])>
                <div class="box p-5">
                    <div class="flex">
                        <x-base.lucide class="h-[28px] w-[28px] text-warning" icon="Coins" />
                        <div class="ml-auto hidden">
                            <x-base.tippy
                                class="flex cursor-pointer items-center rounded-full bg-success py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                as="div" content="12% Higher than last month">
                                12%
                                <x-base.lucide class="ml-0.5 h-4 w-4" icon="ChevronUp" />
                            </x-base.tippy>
                        </div>
                    </div>
                    <div class="mt-6 text-3xl font-medium leading-8">{{ toThousand($inCompleted ?? 0) }}</div>
                    <div class="mt-1 text-base text-slate-500">
                        Total Piutang
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route($route . '.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    Buat transaksi baru
                </x-base.button>
            </a>
            <x-base.menu>
                <x-base.menu.button class="!box px-2" as="x-base.button">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <x-base.lucide class="h-4 w-4" icon="file" />
                    </span>
                </x-base.menu.button>
                <x-base.menu.items class="w-40">
                    <x-base.menu.item href="{{ route($route . '.export', $request) }}" target="_blank">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="sheet" /> Export to Excel
                    </x-base.menu.item>
                    <x-base.menu.item href="{{ route($route . '.export-pdf', $request) }}">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Export to PDF
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>
            <div class="mx-auto hidden text-slate-500 md:block">
                Showing 1 to 10 of 150 entries
            </div>
            <div class="mt-3 w-full flex sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <div class=" flex w-72">
                    <x-base.form-input  class="datepicker !box mr-4 sm:w-56" id="start_date" type="date"
                        value="{{ $request['start_date'] ?? old('start_date') }}" required placeholder="Tanggal Mulai" />
                    <x-base.form-input  class="datepicker !box mr-4 sm:w-56" id="end_date" type="date"
                        value="{{ $request['end_date'] ?? old('end_date') }}" required placeholder="Tanggal Mulai" />
                </div>
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input class="!box w-56 pr-10" type="text" placeholder="Search..." id="search"
                        value="{{ request()->get('search') }}" />
                    <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4" icon="Search" />
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-auto">
            <x-base.table class="mt-2 border-separate border-spacing-y-[10px]">
                <x-base.table.thead>
                    <x-base.table.tr>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            No
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0">
                            Tanggal
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Customer
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Supir
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Metode Pembayaran
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Tipe Pembayaran
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Jumlah Pembayaran
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Status
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
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $loop->iteration }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ date('d-m-Y', strtotime($item['date'])) }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['customer']['name'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['driver']['name'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['purchasing_method'] == 'kontan' ? 'Kontan' : ($item['purchasing_method'] == 'titipan' ? 'Titipan' : 'Tempo') }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['payment_type'] == 'cash' ? 'Cash' : 'Transfer' }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ toThousand($item['grand_total']) }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['status'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                <div class="flex items-center justify-center">
                                    @if ($item['status'] == 'On Progress')
                                        <a class="mr-3 flex items-center" href="#" data-tw-toggle="modal"
                                            data-tw-target="#status-confirmation-modal-{{ $item->id }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="CheckCircle" />
                                            Konfirmasi
                                        </a>
                                        <a class="mr-3 flex items-center text-info"
                                            href="{{ route($route . '.show', $item->id) }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Eye" />
                                            Detail
                                        </a>
                                    @elseif ($item['status'] == 'Completed')
                                        <a class="mr-3 flex items-center text-info"
                                            href="{{ route($route . '.show', $item->id) }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Eye" />
                                            Detail
                                        </a>
                                        <a class="mr-3 flex items-center text-success"
                                            href="{{ route($route . '.export-one', $item->id) }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="file" />
                                            Export
                                            </a>
                                    @else
                                        <a class="mr-3 flex items-center text-warning"
                                            href="{{ route('selling.edit', $item->id) }}">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" />
                                            Edit
                                        </a>
                                        <a class="flex items-center text-danger" data-tw-toggle="modal"
                                            data-tw-target="#delete-confirmation-modal-{{ $item->id }}"
                                            href="#">
                                            <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Delete
                                        </a>
                                    @endif
                                    <x-base.dialog id="delete-confirmation-modal-{{ $item->id }}">
                                        <x-base.dialog.panel>
                                            <div class="p-5 text-center">
                                                <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger"
                                                    icon="XCircle" />
                                                <div class="mt-5 text-3xl">Apakah anda yakin?</div>
                                                <div class="mt-2 text-slate-500">
                                                    Proses ini tidak dapat dibatalkan.
                                                </div>
                                            </div>
                                            <div class="px-5 pb-8 text-center flex justify-center">
                                                <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button"
                                                    variant="outline-secondary">
                                                    Cancel
                                                </x-base.button>
                                                <form action="{{ route('selling.destroy', $item->id) }}" method="post"
                                                    class="w-24">
                                                    @method('delete')
                                                    @csrf
                                                    <x-base.button class="w-24" type="submit" variant="danger">
                                                        Delete
                                                    </x-base.button>
                                                </form>
                                            </div>
                                        </x-base.dialog.panel>
                                    </x-base.dialog>

                                    <x-base.dialog id="status-confirmation-modal-{{ $item->id }}">
                                        <x-base.dialog.panel>
                                            <div class="p-5 text-center">
                                                <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger"
                                                    icon="XCircle" />
                                                <div class="mt-5 text-3xl">Apakah anda yakin?</div>
                                                <div class="mt-2 text-slate-500">
                                                    Ingin konfirmasi data ini.
                                                </div>
                                            </div>
                                            <div class="px-5 pb-8 text-center flex justify-center">
                                                <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button"
                                                    variant="outline-secondary">
                                                    Cancel
                                                </x-base.button>
                                                <form action="{{ route($route . '.update', $item->id) }}" method="post"
                                                    class="w-24">
                                                    @method('PUT')
                                                    @csrf
                                                    <input type="hidden" name="mode" id="mode"
                                                        value="Konfirmasi Lunas">
                                                    <x-base.button class="w-24" type="submit" variant="danger">
                                                        Konfirmasi
                                                    </x-base.button>
                                                </form>
                                            </div>
                                        </x-base.dialog.panel>
                                    </x-base.dialog>
                                </div>
                            </x-base.table.td>
                        </x-base.table.tr>
                    @endforeach

                </x-base.table.tbody>
                @if ($data->isEmpty())
                    <x-base.table.tbody>
                        <x-base.table.tr>
                            <x-base.table.td
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                colspan="9">
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
                <div class="mt-5 text-3xl">Apakah anda yakin?</div>
                <div class="mt-2 text-slate-500">
                    Proses ini tidak dapat dibatalkan.
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
@endsection
