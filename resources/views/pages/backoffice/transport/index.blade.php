@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">{{ $title }}</h2>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <x-base.menu>
                <x-base.menu.button
                    class="!box px-2"
                    as="x-base.button"
                >
                    <span class="flex h-5 w-5 items-center justify-center">
                        <x-base.lucide
                            class="h-4 w-4"
                            icon="file"
                        />
                    </span>
                </x-base.menu.button>
                <x-base.menu.items class="w-40">
                    <x-base.menu.item href="{{ route($route . '.export', $request) }}" target="_blank">
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="sheet"
                        /> Export to Excel
                    </x-base.menu.item>
                    <x-base.menu.item href="{{ route($route . '.export-pdf', $request) }}">
                        <x-base.lucide
                            class="mr-2 h-4 w-4"
                            icon="FileText"
                        /> Export to PDF
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>
            <div class="mx-auto hidden text-slate-500 md:block">
                Showing 1 to {{ $data->total() < 10 ? $data->total() : 10 }} of {{ $data->total() }} entries
            </div>
            <div class="mt-3 w-full sm:mt-0 flex sm:ml-auto sm:w-auto md:ml-0">
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
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            No
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Tanggal
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Nopol
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Pengemudi
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Penerima
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Ongkosan
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Saku Sopir
                        </x-base.table.th>
                        <x-base.table.th class="whitespace-nowrap border-b-0 text-center">
                            Setoran
                        </x-base.table.th>
                    </x-base.table.tr>
                </x-base.table.thead>
                <x-base.table.tbody>
                    @foreach ($data as $item)
                        <x-base.table.tr class="intro-x">
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                <a class="whitespace-nowrap font-medium" href="">
                                    {{ $item['date'] }}
                                </a>
                            </x-base.table.td>
                            <x-base.table.td
                                class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['vehicle']['license_plate'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['driver']['name'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ $item['customer']['name'] }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ toThousand($item['customer']['ongkosan']) }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ toThousand($item['drivers_pocket_money']) }}
                            </x-base.table.td>
                            <x-base.table.td
                                class="w-40 border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600">
                                {{ toThousand($item['customer']['ongkosan'] - $item['drivers_pocket_money']) }}
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
                                colspan="8">
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
@endsection
