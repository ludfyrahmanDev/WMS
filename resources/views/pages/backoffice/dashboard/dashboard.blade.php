@extends('../layouts/' . $layout)

@section('subhead')
    <title>Dashboard - Midone - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">General Report</h2>
                        <a
                            class="ml-auto flex items-center text-primary"
                            href=""
                        >
                            <x-base.lucide
                                class="mr-3 h-4 w-4"
                                icon="RefreshCcw"
                            /> Reload Data
                        </a>
                    </div>
                    <div class="mt-5 grid grid-cols-12 gap-6">
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-primary"
                                            icon="ShoppingCart"
                                        />
                                        <div class="ml-auto hidden">
                                            <x-base.tippy
                                                class="flex cursor-pointer items-center rounded-full bg-success py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                as="div"
                                                content="33% Higher than last month"
                                            >
                                                33%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronUp"
                                                />
                                            </x-base.tippy>
                                        </div>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{$item_sellings->count()}}</div>
                                    <div class="mt-1 text-base text-slate-500">Item Sales</div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-pending"
                                            icon="CreditCard"
                                        />
                                        <div class="ml-auto hidden">
                                            <x-base.tippy
                                                class="flex cursor-pointer items-center rounded-full bg-danger py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                as="div"
                                                content="2% Lower than last month"
                                            >
                                                2%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronDown"
                                                />
                                            </x-base.tippy>
                                        </div>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{$sellings->count()}}</div>
                                    <div class="mt-1 text-base text-slate-500">New Orders</div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-warning"
                                            icon="Monitor"
                                        />
                                        <div class="ml-auto hidden">
                                            <x-base.tippy
                                                class="flex cursor-pointer items-center rounded-full bg-success py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                as="div"
                                                content="12% Higher than last month"
                                            >
                                                12%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronUp"
                                                />
                                            </x-base.tippy>
                                        </div>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{$products->count()}}</div>
                                    <div class="mt-1 text-base text-slate-500">
                                        Total Products
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-6 xl:col-span-3">
                            <div @class([
                                'relative zoom-in',
                                'before:content-[\'\'] before:w-[90%] before:shadow-[0px_3px_20px_#0000000b] before:bg-slate-50 before:h-full before:mt-3 before:absolute before:rounded-md before:mx-auto before:inset-x-0 before:dark:bg-darkmode-400/70',
                            ])>
                                <div class="box p-5">
                                    <div class="flex">
                                        <x-base.lucide
                                            class="h-[28px] w-[28px] text-success"
                                            icon="shopping-bag"
                                        />
                                        <div class="ml-auto hidden">
                                            <x-base.tippy
                                                class="flex cursor-pointer items-center rounded-full bg-success py-[3px] pl-2 pr-1 text-xs font-medium text-white"
                                                as="div"
                                                content="22% Higher than last month"
                                            >
                                                22%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronUp"
                                                />
                                            </x-base.tippy>
                                        </div>
                                    </div>
                                    <div class="mt-6 text-3xl font-medium leading-8">{{$delivery_orders->count()}}</div>
                                    <div class="mt-1 text-base text-slate-500">
                                        New Purchase
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
                <!-- BEGIN: Sales Report -->
                <div class="col-span-12 mt-8 lg:col-span-12">
                    <div class="intro-y block h-10 items-center sm:flex">
                        <h2 class="mr-5 truncate text-lg font-medium">Laporan Penjualan</h2>
                        <div class="relative mt-3 text-slate-500 sm:ml-auto sm:mt-0">
                            <x-base.lucide
                                class="absolute inset-y-0 left-0 z-10 my-auto ml-3 h-4 w-4"
                                icon="Calendar"
                            />
                            <x-base.litepicker
                                class="datepicker !box pl-10 sm:w-56"
                                type="text"
                            />
                        </div>
                    </div>
                    <div class="intro-y box mt-12 p-5 sm:mt-5">
                        <div class="flex flex-col md:flex-row md:items-center">
                            <div class="flex">
                                <div>
                                    <div class="text-lg font-medium text-primary dark:text-slate-300 xl:text-xl">
                                        {{toThousand($salesReportChart['total'])}}
                                    </div>
                                    {{-- <div class="mt-0.5 text-slate-500">This Month</div> --}}
                                </div>
                                <div
                                    class="mx-4 h-12 w-px border border-r border-dashed border-slate-200 dark:border-darkmode-300 xl:mx-5">
                                </div>
                                <div class="hidden">
                                    <div class="text-lg font-medium text-slate-500 xl:text-xl">
                                        $10,000
                                    </div>
                                    <div class="mt-0.5 text-slate-500">Last Month</div>
                                </div>
                            </div>
                            <x-base.menu class="mt-5 md:ml-auto md:mt-0">
                                <x-base.menu.button
                                    class="font-normal"
                                    as="x-base.button"
                                    variant="outline-secondary"
                                >
                                    Filter by Category
                                    <x-base.lucide
                                        class="ml-2 h-4 w-4"
                                        icon="ChevronDown"
                                    />
                                </x-base.menu.button>
                                <x-base.menu.items class="h-32 w-40 overflow-y-auto">
                                    <x-base.menu.item>PC & Laptop</x-base.menu.item>
                                    <x-base.menu.item>Smartphone</x-base.menu.item>
                                    <x-base.menu.item>Electronic</x-base.menu.item>
                                    <x-base.menu.item>Photography</x-base.menu.item>
                                    <x-base.menu.item>Sport</x-base.menu.item>
                                </x-base.menu.items>
                            </x-base.menu>
                        </div>
                        <div @class([
                            'relative',
                        ])>
                            <x-report-line-chart
                                :data="$salesReportChart"
                                class="mt-6 -mb-6"
                                height="h-[275px]"
                            />
                        </div>
                    </div>
                </div>
                <!-- END: Sales Report -->
                <!-- BEGIN: Weekly Top Seller -->
                
                <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-3 hidden">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">Weekly Top Seller</h2>
                        <a
                            class="ml-auto truncate text-primary"
                            href=""
                        > Show More </a>
                    </div>
                    <div class="intro-y box mt-5 p-5">
                        <div class="mt-3">
                            <x-report-pie-chart height="h-[213px]" />
                        </div>
                        <div class="mx-auto mt-8 w-52 sm:w-auto">
                            <div class="flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-primary"></div>
                                <span class="truncate">17 - 30 Years old</span>
                                <span class="ml-auto font-medium">62%</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-pending"></div>
                                <span class="truncate">31 - 50 Years old</span>
                                <span class="ml-auto font-medium">33%</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-warning"></div>
                                <span class="truncate">&gt;= 50 Years old</span>
                                <span class="ml-auto font-medium">10%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Weekly Top Seller -->
                <!-- BEGIN: Sales Report -->
                <div class="col-span-12 mt-8 sm:col-span-6 lg:col-span-3 hidden">
                    <div class="intro-y flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">Sales Report</h2>
                        <a
                            class="ml-auto truncate text-primary"
                            href=""
                        > Show More </a>
                    </div>
                    <div class="intro-y box mt-5 p-5">
                        <div class="mt-3">
                            <x-report-donut-chart height="h-[213px]" />
                        </div>
                        <div class="mx-auto mt-8 w-52 sm:w-auto">
                            <div class="flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-primary"></div>
                                <span class="truncate">17 - 30 Years old</span>
                                <span class="ml-auto font-medium">62%</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-pending"></div>
                                <span class="truncate">31 - 50 Years old</span>
                                <span class="ml-auto font-medium">33%</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <div class="mr-3 h-2 w-2 rounded-full bg-warning"></div>
                                <span class="truncate">&gt;= 50 Years old</span>
                                <span class="ml-auto font-medium">10%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Sales Report -->
                <div class="col-span-12 mt-3 md:col-span-12 xl:col-span-12 2xl:col-span-12 2xl:mt-8">
                    <div class="intro-x flex h-10 items-center">
                        <h2 class="mr-5 truncate text-lg font-medium">Transactions</h2>
                    </div>
                    <div class="mt-5">
                        @foreach ($sellings->slice(0,5) as $selling)
                            <div class="intro-x">
                                <div class="box zoom-in mb-3 flex items-center px-5 py-3">
                                    <div class="image-fit hidden h-10 w-10 flex-none overflow-hidden rounded-full">
                                        <img
                                            src="/dist/images/profile-13.jpg"
                                            alt="Midone Tailwind HTML Admin Template"
                                        />
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium uppercase">{{ $selling->customer->name ?? '-' }}</div>
                                        <div class="mt-0.5 text-xs text-slate-500">
                                            {{ $selling['created_at']->format('d, M Y') }}
                                        </div>
                                    </div>
                                    <div @class([
                                        'text-success' => $selling['created_at'],
                                        'text-danger' => !$selling['created_at'],
                                    ])>
                                     {{ toThousand($selling->grand_total) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @empty($sellings->count())
                            <div class="intro-x">
                                <div class="box zoom-in mb-3 flex items-center px-5 py-3">
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium uppercase">Data Transaksi Tidak ada</div>
                                        <div class="mt-0.5 text-xs text-slate-500">
                                            Transaksi tidak ada karena tidak ada penjualan produk
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        @endempty
                        <a
                            class="intro-x block w-full rounded-md border border-dotted border-slate-400 py-3 text-center text-slate-500 dark:border-darkmode-300"
                            href="{{route('selling.index')}}"
                        >
                            View More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
