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
            <a href="{{ route($route . '.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    Add Data
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
            
            <!-- BEGIN: Neraca -->
            <div class="mt-8">
                <div class="text-xl text-primary font-bold mb-5">
                    <h3>NERACA</h3>
                    <p class="text-sm text-slate-500 font-normal">Per {{ date('d F Y') }}</p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- AKTIVA -->
                    <div class="intro-y">
                        <x-base.table class="border-separate border-spacing-y-[2px]">
                            <x-base.table.thead>
                                <x-base.table.tr>
                                    <x-base.table.th class="bg-primary text-white text-center font-bold text-lg" colspan="2">
                                        AKTIVA
                                    </x-base.table.th>
                                </x-base.table.tr>
                            </x-base.table.thead>
                            <x-base.table.tbody>
                                <!-- Aktiva Lancar -->
                                <x-base.table.tr>
                                    <x-base.table.td class="bg-slate-100 font-bold text-center" colspan="2">
                                        AKTIVA LANCAR
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Kas & Bank
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand($saldo ?? 0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Piutang Dagang
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand($sellingInCompleted ?? 0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Persediaan Barang
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand($inventoryValue ?? 0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr class="border-t-2 border-primary">
                                    <x-base.table.td class="bg-slate-50 font-bold">
                                        Total Aktiva Lancar
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-slate-50 text-right font-bold">
                                        {{ toThousand(($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                
                                <!-- Aktiva Tetap -->
                                <x-base.table.tr>
                                    <x-base.table.td class="bg-slate-100 font-bold text-center" colspan="2">
                                        AKTIVA TETAP
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Kendaraan & Peralatan
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand(0) }} {{-- Nilai aset tetap perlu dihitung --}}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr class="border-t-2 border-primary">
                                    <x-base.table.td class="bg-slate-50 font-bold">
                                        Total Aktiva Tetap
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-slate-50 text-right font-bold">
                                        {{ toThousand(0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                
                                <!-- Total Aktiva -->
                                <x-base.table.tr class="border-t-4 border-primary">
                                    <x-base.table.td class="bg-primary text-white font-bold text-lg">
                                        TOTAL AKTIVA
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-primary text-white text-right font-bold text-lg">
                                        {{ toThousand(($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                            </x-base.table.tbody>
                        </x-base.table>
                    </div>
                    
                    <!-- PASSIVA -->
                    <div class="intro-y">
                        <x-base.table class="border-separate border-spacing-y-[2px]">
                            <x-base.table.thead>
                                <x-base.table.tr>
                                    <x-base.table.th class="bg-danger text-white text-center font-bold text-lg" colspan="2">
                                        PASSIVA
                                    </x-base.table.th>
                                </x-base.table.tr>
                            </x-base.table.thead>
                            <x-base.table.tbody>
                                <!-- Kewajiban -->
                                <x-base.table.tr>
                                    <x-base.table.td class="bg-slate-100 font-bold text-center" colspan="2">
                                        KEWAJIBAN
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Hutang Dagang
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand(abs($purchaseInCompleted ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Hutang Lain-lain
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand(0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr class="border-t-2 border-danger">
                                    <x-base.table.td class="bg-slate-50 font-bold">
                                        Total Kewajiban
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-slate-50 text-right font-bold">
                                        {{ toThousand(abs($purchaseInCompleted ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                
                                <!-- Modal -->
                                <x-base.table.tr>
                                    <x-base.table.td class="bg-slate-100 font-bold text-center" colspan="2">
                                        MODAL
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Modal Pemilik
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand((($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0)) - abs($purchaseInCompleted ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Laba Ditahan
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand(0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr class="border-t-2 border-danger">
                                    <x-base.table.td class="bg-slate-50 font-bold">
                                        Total Modal
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-slate-50 text-right font-bold">
                                        {{ toThousand((($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0)) - abs($purchaseInCompleted ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                
                                <!-- Total Passiva -->
                                <x-base.table.tr class="border-t-4 border-danger">
                                    <x-base.table.td class="bg-danger text-white font-bold text-lg">
                                        TOTAL PASSIVA
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-danger text-white text-right font-bold text-lg">
                                        {{ toThousand((abs($purchaseInCompleted ?? 0)) + (($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0) - abs($purchaseInCompleted ?? 0))) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                            </x-base.table.tbody>
                        </x-base.table>
                    </div>
                </div>
            </div>
            <!-- END: Neraca -->
            
            <div class="mt-8 text-xl text-primary font-bold">
                <h3>Laporan Kas/ Bank Harian</h3>
            </div>
            <div class="overflow-x-auto overflow-y-hidden mt-5">
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
                                Uraian
                            </x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                Kategori Transaksi
                            </x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                Metode Pembayaran
                            </x-base.table.th>
                            <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                                Mutasi
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
                                    class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 ">
                                    <a class="whitespace-nowrap font-medium">
                                        {{ $item['date'] }}
                                    </a>
                                </x-base.table.td>
                                <x-base.table.td
                                    class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 w-1/4">
                                    <a class="whitespace font-medium">
                                        {{ $item['description'] }}
                                    </a>
                                </x-base.table.td>
                                <x-base.table.td
                                    class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                    {{ $item['spendingCategory']['spending_category'] }}
                                </x-base.table.td>
                                <x-base.table.td
                                    class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                    {{ $item['payment_method'] }}
                                </x-base.table.td>
                                <x-base.table.td
                                    class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 font-bold {{ $item['mutation'] == 'Uang Masuk' ? 'text-green-800' : 'text-danger' }}" >
                                    {{ toThousand($item->nominal) }} <br />{{ $item['mutation'] }}
                                </x-base.table.td>
                                <x-base.table.td
                                    class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400">
                                    <div class="flex items-center justify-center">
                                        @if (
                                            $item['spendingCategory']['spending_category'] != 'Saldo Utama' &&
                                                $item['spendingCategory']['spending_category'] != 'Saldo Kendaraan')
                                            <a class="mr-3 flex items-center" href="{{ route('spending.edit', $item->id) }}">
                                                <x-base.lucide class="mr-1 h-4 w-4" icon="CheckSquare" />
                                                Edit
                                            </a>
                                            <a class="flex items-center text-danger" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal-{{ $item->id }}" href="#">
                                                <x-base.lucide class="mr-1 h-4 w-4" icon="Trash" /> Delete
                                            </a>
                                        @endif
                                        <x-base.dialog id="delete-confirmation-modal-{{ $item->id }}">
                                            <x-base.dialog.panel>
                                                <div class="p-5 text-center">
                                                    <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
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
                                                    <form action="{{ route('spending.destroy', $item->id) }}" method="post"
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
                                    colspan="7">
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
