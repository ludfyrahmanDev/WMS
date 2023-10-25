@extends('../layouts/' . $layout)

@section('subhead')
    <title>Dashboard - Midone - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
    <div class="relative">
        <div class="grid grid-cols-12 gap-6">
            <div class="z-20 col-span-12 xl:col-span-9 2xl:col-span-9">
                <div class="mt-6 -mb-6 intro-y">
                    <x-base.alert
                        class="flex items-center mb-6 box dark:border-darkmode-600"
                        variant="primary"
                        dismissible
                    >
                        <span>
                            Introducing new dashboard! Download now at
                            <a
                                class="ml-1 underline"
                                href="https://themeforest.net/item/midone-jquery-tailwindcss-html-admin-template/26366820"
                                target="blank"
                            >
                                themeforest.net
                            </a>
                            .
                            <button
                                class="-my-3 ml-2 rounded-md bg-white bg-opacity-20 py-0.5 px-2 hover:bg-opacity-30 dark:bg-darkmode-300"
                            >
                                Live Preview
                            </button>
                        </span>
                        <x-base.alert.dismiss-button class="text-white">
                            <x-base.lucide
                                class="w-4 h-4"
                                icon="X"
                            />
                        </x-base.alert.dismiss-button>
                    </x-base.alert>
                </div>
                <div class="grid grid-cols-12 mb-3 intro-y mt-14 sm:gap-10">
                    <div
                        class="relative col-span-12 py-6 text-center sm:col-span-6 sm:pl-5 sm:text-left md:col-span-4 md:pl-0 lg:pl-5">
                        <x-base.menu class="absolute top-0 right-0 mt-5 pt-0.5 2xl:mt-6 2xl:pt-0">
                            <x-base.menu.button
                                class="block"
                                href="#"
                                as="a"
                            >
                                <x-base.lucide
                                    class="w-5 h-5 text-slate-500"
                                    icon="MoreVertical"
                                />
                            </x-base.menu.button>
                            <x-base.menu.items class="w-40">
                                <x-base.menu.item>
                                    <x-base.lucide
                                        class="w-4 h-4 mr-2"
                                        icon="FileText"
                                    />
                                    Monthly Report
                                </x-base.menu.item>
                                <x-base.menu.item>
                                    <x-base.lucide
                                        class="w-4 h-4 mr-2"
                                        icon="FileText"
                                    />
                                    Annual Report
                                </x-base.menu.item>
                            </x-base.menu.items>
                        </x-base.menu>
                        <div class="-mb-1 text-sm font-medium 2xl:text-base">
                            Hi Angelina,
                            <span class="font-normal text-slate-600 dark:text-slate-300">
                                welcome back!
                            </span>
                        </div>
                        <div
                            class="flex items-center justify-center text-base leading-3 mt-14 text-slate-600 dark:text-slate-300 sm:justify-start 2xl:mt-24 2xl:text-lg">
                            My Total Assets
                            <x-base.tippy
                                as="div"
                                content="Total value of your sales: $158.409.416"
                            >
                                <x-base.lucide
                                    class="ml-1.5 mt-0.5 h-5 w-5"
                                    icon="AlertCircle"
                                />
                            </x-base.tippy>
                        </div>
                        <div class="mt-5 mb-3 2xl:flex">
                            <div class="flex items-center justify-center sm:justify-start">
                                <div class="relative pl-3 text-2xl font-medium leading-6 2xl:pl-4 2xl:text-3xl">
                                    <span class="absolute top-0 left-0 -mt-1 text-xl 2xl:mt-0 2xl:text-2xl">
                                        $
                                    </span>
                                    142,402,210
                                </div>
                                <a
                                    class="ml-4 text-slate-500 2xl:ml-16"
                                    href=""
                                >
                                    <x-base.lucide
                                        class="w-4 h-4"
                                        icon="RefreshCcw"
                                    />
                                </a>
                            </div>
                            <div
                                class="mt-5 2xl:mt-0 2xl:-ml-20 2xl:flex 2xl:w-14 2xl:flex-none 2xl:justify-center 2xl:pl-2.5">
                                <x-base.tippy
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success 2xl:flex 2xl:justify-center 2xl:bg-transparent 2xl:p-0 2xl:text-sm 2xl:text-success"
                                    as="div"
                                    content="49% Higher than last month"
                                >
                                    49%
                                    <x-base.lucide
                                        class="ml-0.5 h-4 w-4"
                                        icon="ChevronUp"
                                    />
                                </x-base.tippy>
                            </div>
                        </div>
                        <div class="text-slate-500">Last updated 1 hour ago</div>
                        <div class="mt-6 -mb-1 text-slate-600 dark:text-slate-300 2xl:text-base">
                            Total net margin
                            <a
                                class="underline text-primary decoration-dotted underline-offset-4 dark:text-slate-400"
                                href=""
                            >
                                $12,921,050
                            </a>
                        </div>
                        <x-base.menu
                            class="mt-14 w-44 2xl:mt-24 2xl:w-52"
                            placement="bottom-start"
                        >
                            <x-base.menu.button
                                class="relative justify-start w-full px-4"
                                as="x-base.button"
                                variant="primary"
                                rounded
                            >
                                Download Reports
                                <span
                                    class="absolute top-0 bottom-0 right-0 flex items-center justify-center w-8 h-8 my-auto ml-auto mr-1"
                                >
                                    <x-base.lucide
                                        class="w-4 h-4"
                                        icon="ChevronDown"
                                    />
                                </span>
                            </x-base.menu.button>
                            <x-base.menu.items class="w-44 2xl:w-52">
                                <x-base.menu.item>
                                    <x-base.lucide
                                        class="w-4 h-4 mr-2"
                                        icon="FileText"
                                    />
                                    Monthly Report
                                </x-base.menu.item>
                                <x-base.menu.item>
                                    <x-base.lucide
                                        class="w-4 h-4 mr-2"
                                        icon="FileText"
                                    />
                                    Annual Report
                                </x-base.menu.item>
                            </x-base.menu.items>
                        </x-base.menu>
                    </div>
                    <div
                        class="col-span-12 row-start-2 px-10 py-6 -mx-5 border-t border-black border-dashed border-opacity-10 sm:px-28 md:col-span-4 md:row-start-auto md:border-t-0 md:border-l md:border-r md:px-5">
                        <div class="flex flex-wrap items-center">
                            <div
                                class="flex items-center justify-center w-full mb-5 mr-auto sm:w-auto sm:justify-start 2xl:mb-0">
                                <div class="w-2 h-2 -mt-4 rounded-full bg-primary"></div>
                                <div class="ml-3.5">
                                    <div
                                        class="relative pl-3.5 text-xl font-medium leading-6 2xl:pl-4 2xl:text-2xl 2xl:leading-5">
                                        <span class="absolute top-0 left-0 text-base 2xl:-mt-1.5 2xl:text-xl">
                                            $
                                        </span>
                                        47,578.77
                                    </div>
                                    <div class="mt-2 text-slate-500">Yearly budget</div>
                                </div>
                            </div>
                            <x-base.form-select
                                class="mx-auto -mt-2 w-auto border-black border-opacity-10 bg-transparent py-1.5 px-3 dark:border-darkmode-400 dark:bg-transparent sm:mx-0"
                            >
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                                <option value="custom-date">Custom Date</option>
                            </x-base.form-select>
                        </div>
                        <div class="mt-10 text-slate-600 dark:text-slate-300">
                            You have spent about 35% of your annual budget.
                        </div>
                        <div class="mt-6">
                            <x-report-bar-chart-1 height="h-[290px]" />
                        </div>
                    </div>
                    <x-base.tab.group
                        class="col-span-12 py-6 pl-4 -ml-4 border-t border-l border-black border-dashed border-opacity-10 sm:col-span-6 sm:border-t-0 md:col-span-4 md:ml-0 md:border-l-0 md:pl-0"
                    >
                        <x-base.tab.list
                            class="w-3/4 p-1 mx-auto rounded-md bg-slate-200 dark:bg-black/10 2xl:w-4/6"
                            variant="pills"
                        >
                            <x-base.tab
                                id="active-users-tab"
                                selected
                            >
                                <x-base.tab.button
                                    class="w-full py-1.5 px-2"
                                    as="button"
                                >
                                    Active
                                </x-base.tab.button>
                            </x-base.tab>
                            <x-base.tab id="inactive-users-tab">
                                <x-base.tab.button
                                    class="w-full py-1.5 px-2"
                                    as="button"
                                >
                                    Inactive
                                </x-base.tab.button>
                            </x-base.tab>
                        </x-base.tab.list>
                        <x-base.tab.panels class="mt-6">
                            <x-base.tab.panel
                                id="active-users"
                                selected
                            >
                                <div class="relative mt-8">
                                    <x-report-donut-chart-2 height="h-[215px]" />
                                    <div
                                        class="absolute top-0 left-0 flex flex-col items-center justify-center w-full h-full">
                                        <div class="text-xl font-medium 2xl:text-2xl">2.501</div>
                                        <div class="mt-0.5 text-slate-500">Active Users</div>
                                    </div>
                                </div>
                                <div class="w-10/12 mx-auto mt-8 2xl:w-2/3">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 mr-3 rounded-full bg-primary"></div>
                                        <span class="truncate">17 - 30 Years old</span>
                                        <span class="font-medium xl:ml-auto">62%</span>
                                    </div>
                                    <div class="flex items-center mt-4">
                                        <div class="w-2 h-2 mr-3 rounded-full bg-pending"></div>
                                        <span class="truncate">31 - 50 Years old</span>
                                        <span class="font-medium xl:ml-auto">33%</span>
                                    </div>
                                    <div class="flex items-center mt-4">
                                        <div class="w-2 h-2 mr-3 rounded-full bg-warning"></div>
                                        <span class="truncate">&gt;= 50 Years old</span>
                                        <span class="font-medium xl:ml-auto">10%</span>
                                    </div>
                                </div>
                            </x-base.tab.panel>
                        </x-base.tab.panels>
                    </x-base.tab.group>
                </div>
            </div>
            <div @class([
                'z-10 col-span-12 px-5 pt-8 -mx-[16px] md:-mx-[22px] relative pb-14',
                'before:content-[\'\'] before:rounded-[30px_30px_0px_0px] before:w-full before:h-full before:bg-slate-200/70 before:dark:bg-opacity-50 before:absolute before:top-0 before:left-0 before:right-0 before:dark:bg-darkmode-500',
            ])>
                <div class="relative grid grid-cols-12 gap-6 intro-y">
                    <div class="col-span-12 px-0 sm:col-span-4 lg:px-6 xl:col-span-3 xl:px-0 2xl:px-6">
                        <div class="flex flex-wrap items-center gap-3 lg:flex-nowrap">
                            <div class="mr-auto text-lg font-medium truncate sm:w-full lg:w-auto">
                                Summary Report
                            </div>
                            <div
                                class="cursor-pointer truncate rounded-full bg-slate-300/50 py-1 px-2.5 text-xs text-slate-600 dark:bg-darkmode-400 dark:text-slate-300">
                                180 Campaign
                            </div>
                        </div>
                        <div class="px-10 sm:px-0">
                            <x-simple-line-chart-3
                                class="mt-8 -ml-1 -mb-7"
                                height="h-[110px]"
                            />
                        </div>
                    </div>
                    <div class="col-span-12 px-0 sm:col-span-4 lg:px-6 xl:col-span-3 xl:px-0 2xl:px-6">
                        <div class="flex flex-wrap items-center gap-3 lg:flex-nowrap">
                            <div class="mr-auto text-lg font-medium truncate sm:w-full lg:w-auto">
                                Social Media
                            </div>
                            <a
                                class="flex items-center text-primary"
                                href=""
                            >
                                <div class="truncate 2xl:mr-auto">View Details</div>
                                <x-base.lucide
                                    class="w-4 h-4 ml-3"
                                    icon="ArrowRight"
                                />
                            </a>
                        </div>
                        <div class="flex items-center justify-center mt-10">
                            <div class="text-right">
                                <div class="text-3xl font-medium">149</div>
                                <div class="mt-1 truncate text-slate-500">Active Lenders</div>
                            </div>
                            <div
                                class="w-px h-16 mx-4 border border-r border-dashed border-slate-300 dark:border-darkmode-400 xl:mx-6">
                            </div>
                            <div>
                                <div class="text-3xl font-medium">135</div>
                                <div class="mt-1 truncate text-slate-500">Total Lenders</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 px-0 sm:col-span-4 lg:px-6 xl:col-span-3 xl:px-0 2xl:px-6">
                        <div class="flex flex-wrap items-center gap-3 lg:flex-nowrap">
                            <div class="mr-auto text-lg font-medium truncate sm:w-full lg:w-auto">
                                Posted Ads
                            </div>
                            <div
                                class="cursor-pointer truncate rounded-full bg-slate-300/50 py-1 px-2.5 text-xs text-slate-600 dark:bg-darkmode-400 dark:text-slate-300">
                                320 Followers
                            </div>
                        </div>
                        <div class="px-10 sm:px-0">
                            <x-simple-line-chart-4
                                class="mt-8 -ml-1 -mb-7"
                                height="h-[110px]"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="top-0 right-0 z-30 grid w-full h-full grid-cols-12 gap-6 pb-6 -mt-8 xl:absolute xl:z-auto xl:mt-0 xl:pb-0">
            <div class="z-30 col-span-12 xl:col-span-3 xl:col-start-10 xl:pb-16">
                <div class="flex flex-col h-full">
                    <div class="p-5 mt-6 box intro-x bg-primary">
                        <div class="flex flex-wrap gap-3">
                            <div class="mr-auto">
                                <div class="flex items-center leading-3 text-white text-opacity-70 dark:text-slate-300">
                                    AVAILABLE FUNDS
                                    <x-base.tippy
                                        as="div"
                                        content="Total value of your sales: $158.409.416"
                                    >
                                        <x-base.lucide
                                            class="ml-1.5 h-4 w-4"
                                            icon="AlertCircle"
                                        />
                                    </x-base.tippy>
                                </div>
                                <div class="relative mt-3.5 pl-4 text-2xl font-medium leading-5 text-white">
                                    <span class="absolute top-0 left-0 -mt-1.5 text-xl"> $ </span>
                                    479,578.77
                                </div>
                            </div>
                            <a
                                class="flex items-center justify-center w-12 h-12 text-white bg-white rounded-full bg-opacity-20 hover:bg-opacity-30 dark:bg-darkmode-300"
                                href=""
                            >
                                <x-base.lucide
                                    class="w-6 h-6"
                                    icon="Plus"
                                />
                            </a>
                        </div>
                    </div>
                    <div class="intro-x xl:min-h-0">
                        <x-base.tab.group class="max-h-full mt-5 box xl:overflow-y-auto">
                            <div class="top-0 px-5 pt-5 pb-6 xl:sticky">
                                <div class="flex items-center">
                                    <div class="mr-5 text-lg font-medium truncate">
                                        Summary Report
                                    </div>
                                    <a
                                        class="flex items-center ml-auto text-primary"
                                        href=""
                                    >
                                        <x-base.lucide
                                            class="w-4 h-4 mr-3"
                                            icon="RefreshCcw"
                                        />
                                        Refresh
                                    </a>
                                </div>
                                <x-base.tab.list
                                    class="p-1 mx-auto mt-5 border border-dashed rounded-md border-slate-300 dark:border-darkmode-300"
                                    variant="pills"
                                >
                                    <x-base.tab
                                        id="weekly-report-tab"
                                        selected
                                    >
                                        <x-base.tab.button
                                            class="w-full py-1.5 px-2"
                                            as="button"
                                        >
                                            Weekly
                                        </x-base.tab.button>
                                    </x-base.tab>
                                    <x-base.tab id="monthly-report-tab">
                                        <x-base.tab.button
                                            class="w-full py-1.5 px-2"
                                            as="button"
                                        >
                                            Monthly
                                        </x-base.tab.button>
                                    </x-base.tab>
                                </x-base.tab.list>
                            </div>
                            <x-base.tab.panels class="px-5 pb-5">
                                <x-base.tab.panel
                                    class="grid grid-cols-12 gap-y-6"
                                    id="weekly-report"
                                    selected
                                >
                                    <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-12">
                                        <div class="text-slate-500">Unpaid Loan</div>
                                        <div class="mt-1.5 flex items-center">
                                            <div class="text-lg">$155.430.000</div>
                                            <x-base.tippy
                                                class="flex ml-2 text-xs font-medium cursor-pointer text-danger"
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
                                    <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-12">
                                        <div class="text-slate-500">Active Funding Partner</div>
                                        <div class="mt-1.5 flex items-center">
                                            <div class="text-lg">52 Partner</div>
                                            <x-base.tippy
                                                class="flex ml-2 text-xs font-medium cursor-pointer text-success"
                                                as="div"
                                                content="0.1% Lower than last month"
                                            >
                                                49%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronUp"
                                                />
                                            </x-base.tippy>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-12">
                                        <div class="text-slate-500">Paid Installment</div>
                                        <div class="mt-1.5 flex items-center">
                                            <div class="text-lg">$75.430.000</div>
                                            <x-base.tippy
                                                class="flex ml-2 text-xs font-medium cursor-pointer text-success"
                                                as="div"
                                                content="49% Higher than last month"
                                            >
                                                36%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronUp"
                                                />
                                            </x-base.tippy>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-12">
                                        <div class="text-slate-500">Success Payment</div>
                                        <div class="mt-1.5 flex items-center">
                                            <div class="text-lg">100%</div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-12">
                                        <div class="text-slate-500">Waiting For Disbursement</div>
                                        <div class="mt-1.5 flex items-center">
                                            <div class="text-lg">0</div>
                                        </div>
                                    </div>
                                    <div class="col-span-12 sm:col-span-6 md:col-span-4 xl:col-span-12">
                                        <div class="text-slate-500">Unpaid Loan</div>
                                        <div class="mt-1.5 flex items-center">
                                            <div class="text-lg">$21.430.000</div>
                                            <x-base.tippy
                                                class="flex ml-2 text-xs font-medium cursor-pointer text-danger"
                                                as="div"
                                                content="2% Lower than last month"
                                            >
                                                23%
                                                <x-base.lucide
                                                    class="ml-0.5 h-4 w-4"
                                                    icon="ChevronDown"
                                                />
                                            </x-base.tippy>
                                        </div>
                                    </div>
                                    <x-base.button
                                        class="relative justify-start col-span-12 mb-2 border-dashed border-slate-300 dark:border-darkmode-300"
                                        variant="outline-secondary"
                                    >
                                        <span class="mr-5 truncate"> My Portfolio Details </span>
                                        <span
                                            class="absolute right-0 top-0 bottom-0 my-auto ml-auto mr-0.5 flex h-8 w-8 items-center justify-center"
                                        >
                                            <x-base.lucide
                                                class="w-4 h-4"
                                                icon="ArrowRight"
                                            />
                                        </span>
                                    </x-base.button>
                                </x-base.tab.panel>
                            </x-base.tab.panels>
                        </x-base.tab.group>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div @class([
        'z-40 grid grid-cols-12 gap-6 -mb-10 -mx-[16px] md:-mx-[22px] relative px-[22px] min-h-[400px] xl:-mt-5 2xl:-mt-8 2xl:z-10',
        'before:content-[\'\'] before:rounded-t-[30px] xl:before:rounded-t-[30px] before:rounded-b-[30px] xl:before:shadow-[0px_3px_20px_#0000000b] before:w-full before:h-full before:bg-slate-100 before:absolute before:top-0 before:left-0 before:right-0 before:dark:bg-darkmode-700',
    ])>
        <div class="relative col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Official Store -->
                <div class="col-span-12 mt-6 xl:col-span-8">
                    <div class="items-center block h-10 intro-y sm:flex">
                        <h2 class="mr-5 text-lg font-medium truncate">Official Store</h2>
                        <div class="relative mt-3 text-slate-500 sm:ml-auto sm:mt-0">
                            <x-base.lucide
                                class="absolute inset-y-0 left-0 z-10 w-4 h-4 my-auto ml-3"
                                icon="MapPin"
                            />
                            <x-base.form-input
                                class="!box pl-10 sm:w-56"
                                type="text"
                                placeholder="Filter by city"
                            />
                        </div>
                    </div>
                    <div class="p-5 mt-12 intro-y box sm:mt-5">
                        <div>
                            250 Official stores in 21 countries, click the marker to see
                            location details.
                        </div>
                        <x-leaflet-map class="mt-5 h-[310px] rounded-md bg-slate-200" />
                    </div>
                </div>
                <!-- END: Official Store -->
                <!-- BEGIN: Weekly Best Sellers -->
                <div class="col-span-12 mt-6 xl:col-span-4">
                    <div class="flex items-center h-10 intro-y">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Weekly Best Sellers
                        </h2>
                    </div>
                    <div class="mt-5">
                        @foreach (array_slice($fakers, 0, 4) as $faker)
                            <div class="intro-y">
                                <div class="flex items-center px-4 py-4 mb-3 box zoom-in">
                                    <div class="flex-none w-10 h-10 overflow-hidden rounded-md image-fit">
                                        <img
                                            src="{{ Vite::asset($faker['photos'][0]) }}"
                                            alt="Midone Tailwind HTML Admin Template"
                                        />
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium">{{ $faker['users'][0]['name'] }}</div>
                                        <div class="mt-0.5 text-xs text-slate-500">
                                            {{ $faker['dates'][0] }}
                                        </div>
                                    </div>
                                    <div
                                        class="px-2 py-1 text-xs font-medium text-white rounded-full cursor-pointer bg-success">
                                        137 Sales
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <a
                            class="block w-full py-4 text-center border border-dotted rounded-md intro-y border-slate-400 text-slate-500 dark:border-darkmode-300"
                            href=""
                        >
                            View More
                        </a>
                    </div>
                </div>
                <!-- END: Weekly Best Sellers -->
                <!-- BEGIN: Weekly Top Products -->
                <div class="col-span-12 mt-6">
                    <div class="items-center block h-10 intro-y sm:flex">
                        <h2 class="mr-5 text-lg font-medium truncate">
                            Weekly Top Products
                        </h2>
                        <div class="flex items-center mt-3 sm:ml-auto sm:mt-0">
                            <x-base.button class="!box flex items-center text-slate-600 dark:text-slate-300">
                                <x-base.lucide
                                    class="hidden w-4 h-4 mr-2 sm:block"
                                    icon="FileText"
                                />
                                Export to Excel
                            </x-base.button>
                            <x-base.button class="!box ml-3 flex items-center text-slate-600 dark:text-slate-300">
                                <x-base.lucide
                                    class="hidden w-4 h-4 mr-2 sm:block"
                                    icon="FileText"
                                />
                                Export to PDF
                            </x-base.button>
                        </div>
                    </div>
                    <div class="mt-8 overflow-auto intro-y sm:mt-0 lg:overflow-visible">
                        <x-base.table class="border-separate border-spacing-y-[10px] sm:mt-2">
                            <x-base.table.thead>
                                <x-base.table.tr>
                                    <x-base.table.th class="border-b-0 whitespace-nowrap">
                                        IMAGES
                                    </x-base.table.th>
                                    <x-base.table.th class="border-b-0 whitespace-nowrap">
                                        PRODUCT NAME
                                    </x-base.table.th>
                                    <x-base.table.th class="text-center border-b-0 whitespace-nowrap">
                                        STOCK
                                    </x-base.table.th>
                                    <x-base.table.th class="text-center border-b-0 whitespace-nowrap">
                                        STATUS
                                    </x-base.table.th>
                                    <x-base.table.th class="text-center border-b-0 whitespace-nowrap">
                                        ACTIONS
                                    </x-base.table.th>
                                </x-base.table.tr>
                            </x-base.table.thead>
                            <x-base.table.tbody>
                                @foreach (array_slice($fakers, 0, 4) as $faker)
                                    <x-base.table.tr class="intro-x">
                                        <x-base.table.td
                                            class="w-40 border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                        >
                                            <div class="flex">
                                                <div class="w-10 h-10 image-fit zoom-in">
                                                    <x-base.tippy
                                                        class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                        src="{{ Vite::asset($faker['images'][0]) }}"
                                                        alt="Midone Tailwind HTML Admin Template"
                                                        as="img"
                                                        content="{{ 'Uploaded at ' . $faker['dates'][0] }}"
                                                    />
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <x-base.tippy
                                                        class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                        src="{{ Vite::asset($faker['photos'][1]) }}"
                                                        alt="Midone Tailwind HTML Admin Template"
                                                        as="img"
                                                        content="{{ 'Uploaded at ' . $faker['dates'][1] }}"
                                                    />
                                                </div>
                                                <div class="w-10 h-10 -ml-5 image-fit zoom-in">
                                                    <x-base.tippy
                                                        class="rounded-full shadow-[0px_0px_0px_2px_#fff,_1px_1px_5px_rgba(0,0,0,0.32)] dark:shadow-[0px_0px_0px_2px_#3f4865,_1px_1px_5px_rgba(0,0,0,0.32)]"
                                                        src="{{ Vite::asset($faker['photos'][2]) }}"
                                                        alt="Midone Tailwind HTML Admin Template"
                                                        as="img"
                                                        content="{{ 'Uploaded at ' . $faker['dates'][2] }}"
                                                    />
                                                </div>
                                            </div>
                                        </x-base.table.td>
                                        <x-base.table.td
                                            class="border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                        >
                                            <a
                                                class="font-medium whitespace-nowrap"
                                                href=""
                                            >
                                                {{ $faker['products'][0]['name'] }}
                                            </a>
                                            <div class="mt-0.5 whitespace-nowrap text-xs text-slate-500">
                                                {{ $faker['products'][0]['category'] }}
                                            </div>
                                        </x-base.table.td>
                                        <x-base.table.td
                                            class="border-b-0 bg-white text-center shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                        >
                                            {{ $faker['stocks'][0] }}
                                        </x-base.table.td>
                                        <x-base.table.td
                                            class="w-40 border-b-0 bg-white shadow-[20px_3px_20px_#0000000b] first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600"
                                        >
                                            <div @class([
                                                'flex items-center justify-center',
                                                'text-success' => $faker['true_false'][0],
                                                'text-danger' => !$faker['true_false'][0],
                                            ])>
                                                <x-base.lucide
                                                    class="w-4 h-4 mr-2"
                                                    icon="CheckSquare"
                                                />
                                                {{ $faker['true_false'][0] ? 'Active' : 'Inactive' }}
                                            </div>
                                        </x-base.table.td>
                                        <x-base.table.td
                                            class="relative w-56 border-b-0 bg-white py-0 shadow-[20px_3px_20px_#0000000b] before:absolute before:inset-y-0 before:left-0 before:my-auto before:block before:h-8 before:w-px before:bg-slate-200 first:rounded-l-md last:rounded-r-md dark:bg-darkmode-600 before:dark:bg-darkmode-400"
                                        >
                                            <div class="flex items-center justify-center">
                                                <a
                                                    class="flex items-center mr-3"
                                                    href=""
                                                >
                                                    <x-base.lucide
                                                        class="w-4 h-4 mr-1"
                                                        icon="CheckSquare"
                                                    />
                                                    Edit
                                                </a>
                                                <a
                                                    class="flex items-center text-danger"
                                                    href=""
                                                >
                                                    <x-base.lucide
                                                        class="w-4 h-4 mr-1"
                                                        icon="Trash"
                                                    />
                                                    Delete
                                                </a>
                                            </div>
                                        </x-base.table.td>
                                    </x-base.table.tr>
                                @endforeach
                            </x-base.table.tbody>
                        </x-base.table>
                    </div>
                    <div class="flex flex-wrap items-center mt-3 intro-y sm:flex-row sm:flex-nowrap">
                        <x-base.pagination class="w-full sm:mr-auto sm:w-auto">
                            <x-base.pagination.link>
                                <x-base.lucide
                                    class="w-4 h-4"
                                    icon="ChevronsLeft"
                                />
                            </x-base.pagination.link>
                            <x-base.pagination.link>
                                <x-base.lucide
                                    class="w-4 h-4"
                                    icon="ChevronLeft"
                                />
                            </x-base.pagination.link>
                            <x-base.pagination.link>...</x-base.pagination.link>
                            <x-base.pagination.link>1</x-base.pagination.link>
                            <x-base.pagination.link active>2</x-base.pagination.link>
                            <x-base.pagination.link>3</x-base.pagination.link>
                            <x-base.pagination.link>...</x-base.pagination.link>
                            <x-base.pagination.link>
                                <x-base.lucide
                                    class="w-4 h-4"
                                    icon="ChevronRight"
                                />
                            </x-base.pagination.link>
                            <x-base.pagination.link>
                                <x-base.lucide
                                    class="w-4 h-4"
                                    icon="ChevronsRight"
                                />
                            </x-base.pagination.link>
                        </x-base.pagination>
                        <x-base.form-select class="!box mt-3 w-20 sm:mt-0">
                            <option>10</option>
                            <option>25</option>
                            <option>35</option>
                            <option>50</option>
                        </x-base.form-select>
                    </div>
                </div>
                <!-- END: Weekly Top Products -->
            </div>
        </div>
        <div class="relative z-10 col-span-12 2xl:col-span-3">
            <div class="pb-10 intro-y 2xl:border-l">
                <div class="grid grid-cols-12 gap-x-6 gap-y-6 2xl:gap-x-0 2xl:pl-6">
                    <!-- BEGIN: Recent Activities -->
                    <div class="col-span-12 mt-3 md:col-span-6 2xl:col-span-12 2xl:mt-6">
                        <div class="flex items-center h-10 intro-x">
                            <h2 class="mr-5 text-lg font-medium truncate">
                                Recent Activities
                            </h2>
                            <a
                                class="ml-auto truncate text-primary"
                                href=""
                            > Show More </a>
                        </div>
                        <div
                            class="relative mt-5 before:absolute before:ml-5 before:mt-5 before:block before:h-[85%] before:w-px before:bg-slate-200 before:dark:bg-darkmode-400">
                            <div class="relative flex items-center mb-3 intro-x">
                                <div
                                    class="before:absolute before:mt-5 before:ml-5 before:block before:h-px before:w-20 before:bg-slate-200 before:dark:bg-darkmode-400">
                                    <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                        <img
                                            src="{{ Vite::asset($fakers[9]['photos'][0]) }}"
                                            alt="Midone Tailwind HTML Admin Template"
                                        />
                                    </div>
                                </div>
                                <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                    <div class="flex items-center">
                                        <div class="font-medium">
                                            {{ $fakers[9]['users'][0]['name'] }}
                                        </div>
                                        <div class="ml-auto text-xs text-slate-500">07:00 PM</div>
                                    </div>
                                    <div class="mt-1 text-slate-500">Has joined the team</div>
                                </div>
                            </div>
                            <div class="relative flex items-center mb-3 intro-x">
                                <div
                                    class="before:absolute before:mt-5 before:ml-5 before:block before:h-px before:w-20 before:bg-slate-200 before:dark:bg-darkmode-400">
                                    <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                        <img
                                            src="{{ Vite::asset($fakers[8]['photos'][0]) }}"
                                            alt="Midone Tailwind HTML Admin Template"
                                        />
                                    </div>
                                </div>
                                <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                    <div class="flex items-center">
                                        <div class="font-medium">
                                            {{ $fakers[8]['users'][0]['name'] }}
                                        </div>
                                        <div class="ml-auto text-xs text-slate-500">07:00 PM</div>
                                    </div>
                                    <div class="text-slate-500">
                                        <div class="mt-1">Added 3 new photos</div>
                                        <div class="flex mt-2">
                                            <x-base.tippy
                                                class="w-8 h-8 mr-1 image-fit zoom-in"
                                                as="div"
                                                content="{{ $fakers[0]['products'][0]['name'] }}"
                                            >
                                                <img
                                                    class="border border-white rounded-md"
                                                    src="{{ Vite::asset($fakers[8]['photos'][0]) }}"
                                                    alt="Midone Tailwind HTML Admin Template"
                                                />
                                            </x-base.tippy>
                                            <x-base.tippy
                                                class="w-8 h-8 mr-1 image-fit zoom-in"
                                                as="div"
                                                content="{{ $fakers[1]['products'][0]['name'] }}"
                                            >
                                                <img
                                                    class="border border-white rounded-md"
                                                    src="{{ Vite::asset($fakers[8]['photos'][1]) }}"
                                                    alt="Midone Tailwind HTML Admin Template"
                                                />
                                            </x-base.tippy>
                                            <x-base.tippy
                                                class="w-8 h-8 mr-1 image-fit zoom-in"
                                                as="div"
                                                content="{{ $fakers[2]['products'][0]['name'] }}"
                                            >
                                                <img
                                                    class="border border-white rounded-md"
                                                    src="{{ Vite::asset($fakers[8]['photos'][2]) }}"
                                                    alt="Midone Tailwind HTML Admin Template"
                                                />
                                            </x-base.tippy>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-4 text-xs text-center intro-x text-slate-500">
                                12 November
                            </div>
                            <div class="relative flex items-center mb-3 intro-x">
                                <div
                                    class="before:absolute before:mt-5 before:ml-5 before:block before:h-px before:w-20 before:bg-slate-200 before:dark:bg-darkmode-400">
                                    <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                        <img
                                            src="{{ Vite::asset($fakers[7]['photos'][0]) }}"
                                            alt="Midone Tailwind HTML Admin Template"
                                        />
                                    </div>
                                </div>
                                <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                    <div class="flex items-center">
                                        <div class="font-medium">
                                            {{ $fakers[7]['users'][0]['name'] }}
                                        </div>
                                        <div class="ml-auto text-xs text-slate-500">07:00 PM</div>
                                    </div>
                                    <div class="mt-1 text-slate-500">
                                        Has changed
                                        <a
                                            class="text-primary"
                                            href=""
                                        >
                                            {{ $fakers[7]['products'][0]['name'] }}
                                        </a>
                                        price and description
                                    </div>
                                </div>
                            </div>
                            <div class="relative flex items-center mb-3 intro-x">
                                <div
                                    class="before:absolute before:mt-5 before:ml-5 before:block before:h-px before:w-20 before:bg-slate-200 before:dark:bg-darkmode-400">
                                    <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                        <img
                                            src="{{ Vite::asset($fakers[6]['photos'][0]) }}"
                                            alt="Midone Tailwind HTML Admin Template"
                                        />
                                    </div>
                                </div>
                                <div class="flex-1 px-5 py-3 ml-4 box zoom-in">
                                    <div class="flex items-center">
                                        <div class="font-medium">
                                            {{ $fakers[6]['users'][0]['name'] }}
                                        </div>
                                        <div class="ml-auto text-xs text-slate-500">07:00 PM</div>
                                    </div>
                                    <div class="mt-1 text-slate-500">
                                        Has changed
                                        <a
                                            class="text-primary"
                                            href=""
                                        >
                                            {{ $fakers[6]['products'][0]['name'] }}
                                        </a>
                                        description
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Recent Activities -->
                    <!-- BEGIN: Transactions -->
                    <div class="col-span-12 mt-3 md:col-span-6 2xl:col-span-12">
                        <div class="flex items-center h-10 intro-x">
                            <h2 class="mr-5 text-lg font-medium truncate">Transactions</h2>
                        </div>
                        <div class="mt-5">
                            @foreach (array_slice($fakers, 0, 5) as $faker)
                                <div class="intro-x">
                                    <div class="flex items-center px-5 py-3 mb-3 box zoom-in">
                                        <div class="flex-none w-10 h-10 overflow-hidden rounded-full image-fit">
                                            <img
                                                src="{{ Vite::asset($faker['photos'][0]) }}"
                                                alt="Midone Tailwind HTML Admin Template"
                                            />
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <div class="font-medium">{{ $faker['users'][0]['name'] }}</div>
                                            <div class="mt-0.5 text-xs text-slate-500">
                                                {{ $faker['dates'][0] }}
                                            </div>
                                        </div>
                                        <div @class([
                                            'text-success' => $faker['true_false'][0],
                                            'text-danger' => !$faker['true_false'][0],
                                        ])>
                                            {{ $faker['true_false'][0] ? '+' : '-' }}${{ $faker['totals'][0] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <a
                                class="block w-full py-3 text-center border border-dotted rounded-md intro-x border-slate-400 text-slate-500 dark:border-darkmode-300"
                                href=""
                            >
                                View More
                            </a>
                        </div>
                    </div>
                    <!-- END: Transactions -->
                </div>
            </div>
        </div>
    </div>
@endsection
