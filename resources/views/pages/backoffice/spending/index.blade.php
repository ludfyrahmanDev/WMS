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
            <div class="mt-3 w-full sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
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
            <div class="overflow-x-auto">
                <x-base.table>

                    <x-base.table.tbody>
                        <x-base.table.tr>
                            <x-base.table.td class="border-b dark:border-darkmode-400">
                                <div class="whitespace-nowrap font-medium">
                                    Pemasukan Penjualan
                                </div>
                                <div class="mt-0.5 whitespace-nowrap text-sm text-slate-500">
                                    data penjualan telah dibayar
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="w-32 border-b text-right dark:border-darkmode-400 text-green-800">
                                {{ toThousand($sellingCompleted ?? 0) }}
                            </x-base.table.td>

                        </x-base.table.tr>
                        <x-base.table.tr>
                            <x-base.table.td class="border-b dark:border-darkmode-400">
                                <div class="whitespace-nowrap font-medium">
                                    Penjualan Belum Lunas(Piutang)
                                </div>
                                <div class="mt-0.5 whitespace-nowrap text-sm text-slate-500">
                                    data penjualan belum dibayar
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="w-32 border-b text-right dark:border-darkmode-400 text-danger">
                                {{ toThousand($sellingInCompleted ?? 0) }}
                            </x-base.table.td>

                        </x-base.table.tr>
                        <x-base.table.tr>
                            <x-base.table.td class="border-b dark:border-darkmode-400">
                                <div class="whitespace-nowrap font-medium">
                                    Pemasukan Pembelian
                                </div>
                                <div class="mt-0.5 whitespace-nowrap text-sm text-slate-500">
                                    data pembelian telah dibayar
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="w-32 border-b text-right dark:border-darkmode-400 text-green-800">
                                {{ toThousand($purchaseCompleted ?? 0) }}
                            </x-base.table.td>

                        </x-base.table.tr>
                        <x-base.table.tr>
                            <x-base.table.td>
                                <div class="whitespace-nowrap font-medium">
                                    Pembelian Belum Lunas(Hutang)
                                </div>
                                <div class="mt-0.5 whitespace-nowrap text-sm text-slate-500">
                                    data pembelian belum dibayar
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="w-32 text-right text-danger">
                                {{ toThousand($purchaseInCompleted ?? 0) }}
                            </x-base.table.td>

                        </x-base.table.tr>
                        <x-base.table.tr>
                            <x-base.table.td>
                                <div class="whitespace-nowrap font-medium">
                                    Mutasi Masuk
                                </div>
                                <div class="mt-0.5 whitespace-nowrap text-sm text-slate-500">
                                    data transaksi lain lain mutasi masuk
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="w-32 text-right text-green-800">
                                {{ toThousand($income ?? 0) }}
                            </x-base.table.td>
                        </x-base.table.tr>
                        <x-base.table.tr>
                            <x-base.table.td>
                                <div class="whitespace-nowrap font-medium">
                                    Mutasi Keluar
                                </div>
                                <div class="mt-0.5 whitespace-nowrap text-sm text-slate-500">
                                    data transaksi lain lain mutasi keluar
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="w-32 text-right text-danger">
                                {{ toThousand($outcome ?? 0) }}
                            </x-base.table.td>

                        </x-base.table.tr>
                        <x-base.table.tr>
                            <x-base.table.td>
                                <div class="whitespace-nowrap font-medium">
                                    Service Kendaraan
                                </div>
                                <div class="mt-0.5 whitespace-nowrap text-sm text-slate-500">
                                    data service kendaraan
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="w-32 text-right text-danger">
                                {{ toThousand($total ?? 0) }}
                            </x-base.table.td>

                        </x-base.table.tr>
                        <x-base.table.tr class="text-xl text-primary font-bold">
                            <x-base.table.td>
                                <h1>Total Saldo</h1>
                            </x-base.table.td>
                            <x-base.table.td class="w-52 text-right">
                                {{ toThousand($saldo ?? 0) }}
                            </x-base.table.td>

                        </x-base.table.tr>
                    </x-base.table.tbody>
                </x-base.table>
            </div>

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
                            Pembuat
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Kategori Pengeluaran
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
                                class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium">
                                    {{ $item['date'] }}
                                </a>
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium">
                                    {{ $item['who_update'] }}
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
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
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
