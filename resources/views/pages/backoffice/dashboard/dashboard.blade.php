@extends('../layouts/' . $layout)

@section('subhead')
    <title>Dashboard - WMS</title>
@endsection

@section('subcontent')
    <!-- Welcome Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-200">Welcome to WMS Dashboard</h1>
                <p class="mt-1 text-slate-600 dark:text-slate-400">Monitor your business performance and manage operations</p>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                @can('selling.create')
                    <x-base.button
                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg hover:shadow-xl transition-all duration-200"
                        href="{{ route('selling.create') }}"
                        as="a"
                    >
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Plus" />
                        New Sale
                    </x-base.button>
                @endcan
                @can('products.create')
                    <x-base.button
                        class="bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg hover:shadow-xl transition-all duration-200"
                        href="{{ route('product.create') }}"
                        as="a"
                    >
                        <x-base.lucide class="mr-2 h-4 w-4" icon="Package" />
                        Add Product
                    </x-base.button>
                @endcan
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <!-- BEGIN: Stats Cards -->
            <div class="mb-8">
                <div class="intro-y flex h-10 items-center mb-6">
                    <h2 class="mr-5 truncate text-xl font-semibold text-slate-800 dark:text-slate-200">Business Overview</h2>
                    <div class="ml-auto flex items-center space-x-3">
                        <div class="flex items-center text-slate-500 text-sm">
                            <x-base.lucide class="mr-1 h-4 w-4" icon="Calendar" />
                            {{ date('F j, Y') }}
                        </div>
                        <button
                            class="flex items-center text-primary hover:text-primary/80 transition-colors"
                            onclick="window.location.reload()"
                        >
                            <x-base.lucide class="mr-2 h-4 w-4" icon="RefreshCcw" />
                            Refresh
                        </button>
                    </div>
                </div>
                
                <!-- Company Access Status -->
                @auth
                    @if(auth()->user()->hasCompanyAccess())
                        <div class="mb-6">
                            <div class="bg-gradient-to-r from-emerald-50 to-blue-50 dark:from-emerald-900/20 dark:to-blue-900/20 rounded-2xl border-2 border-emerald-200 dark:border-emerald-700 p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4">
                                            <x-base.lucide class="h-6 w-6 text-white" icon="Building" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-emerald-800 dark:text-emerald-200">
                                                Company Data Access Active
                                            </h3>
                                            <p class="text-sm text-emerald-600 dark:text-emerald-400 mb-3">
                                                @if(auth()->user()->hasFullCompanyAccess())
                                                    You have full access to all company data and financial reports
                                                @else
                                                    You have {{ ucfirst(auth()->user()->getCompanyAccessLevel()) }} access to company data
                                                @endif
                                            </p>
                                            
                                            <!-- Show accessible companies -->
                                            @if(auth()->user()->getCompanyAccessLevel() === 'limited')
                                                <div class="mt-3">
                                                    <p class="text-xs text-emerald-700 dark:text-emerald-300 font-medium mb-2">Accessible Companies:</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach(auth()->user()->getAccessibleCvs() as $cv)
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-800 dark:text-emerald-200">
                                                                <x-base.lucide class="mr-1 h-3 w-3" icon="Building2" />
                                                                {{ $cv->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @elseif(auth()->user()->getCompanyAccessLevel() === 'all')
                                                <div class="mt-3">
                                                    <p class="text-xs text-emerald-700 dark:text-emerald-300 font-medium mb-2">All Companies Available:</p>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach(App\Models\CV::all() as $cv)
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-200">
                                                                <x-base.lucide class="mr-1 h-3 w-3" icon="Building2" />
                                                                {{ $cv->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if(auth()->user()->getCompanyAccessLevel() !== 'none')
                                                <span class="text-xs text-emerald-600 dark:text-emerald-400">
                                                    {{ auth()->user()->getAccessibleCvs()->count() }} 
                                                    {{ auth()->user()->getCompanyAccessLevel() === 'all' ? 'of ' . App\Models\CV::count() : '' }} 
                                                    {{ auth()->user()->getAccessibleCvs()->count() === 1 ? 'company' : 'companies' }} accessible
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if(session('cv_id') && auth()->user()->getCompanyAccessLevel() !== 'none')
                                            @php
                                                $selectedCv = App\Models\CV::find(session('cv_id'));
                                            @endphp
                                            @if($selectedCv)
                                                <div class="flex items-center">
                                                    <span class="text-xs text-emerald-700 dark:text-emerald-300 mr-2">Currently viewing:</span>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-emerald-200 text-emerald-900 dark:bg-emerald-700 dark:text-emerald-100">
                                                        <x-base.lucide class="mr-1 h-3 w-3" icon="Eye" />
                                                        {{ $selectedCv->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Item Sales Card -->
                    <div class="intro-y">
                        <a
                            href="{{route('product.index')}}"
                            class="block group transition-all duration-300 hover:scale-105"
                        >
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-2xl transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                        <x-base.lucide
                                            class="h-8 w-8"
                                            icon="ShoppingCart"
                                        />
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold">{{number_format($item_sellings->count())}}</div>
                                        <div class="text-blue-100 text-sm">Item Sales</div>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-blue-100 text-sm">View Details</span>
                                    <x-base.lucide class="h-4 w-4 text-blue-100 group-hover:translate-x-1 transition-transform" icon="ArrowRight" />
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Orders Card -->
                    <div class="intro-y">
                        <a
                            href="{{route('selling.index')}}"
                            class="block group transition-all duration-300 hover:scale-105"
                        >
                            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-2xl transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                        <x-base.lucide
                                            class="h-8 w-8"
                                            icon="CreditCard"
                                        />
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold">{{number_format($sellings->count())}}</div>
                                        <div class="text-green-100 text-sm">Total Orders</div>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-green-100 text-sm">Manage Orders</span>
                                    <x-base.lucide class="h-4 w-4 text-green-100 group-hover:translate-x-1 transition-transform" icon="ArrowRight" />
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Products Card -->
                    <div class="intro-y">
                        <a
                            href="{{route('product.index')}}"
                            class="block group transition-all duration-300 hover:scale-105"
                        >
                            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-2xl transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                        <x-base.lucide
                                            class="h-8 w-8"
                                            icon="Package"
                                        />
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold">{{number_format($products->count())}}</div>
                                        <div class="text-purple-100 text-sm">Total Products</div>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-purple-100 text-sm">Manage Inventory</span>
                                    <x-base.lucide class="h-4 w-4 text-purple-100 group-hover:translate-x-1 transition-transform" icon="ArrowRight" />
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Delivery Orders Card -->
                    <div class="intro-y">
                        <a
                            href="{{route('delivery_order.index')}}"
                            class="block group transition-all duration-300 hover:scale-105"
                        >
                            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-2xl transition-all duration-300">
                                <div class="flex items-center justify-between">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                        <x-base.lucide
                                            class="h-8 w-8"
                                            icon="Truck"
                                        />
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold">{{number_format($delivery_orders->count())}}</div>
                                        <div class="text-orange-100 text-sm">Delivery Orders</div>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-orange-100 text-sm">Track Deliveries</span>
                                    <x-base.lucide class="h-4 w-4 text-orange-100 group-hover:translate-x-1 transition-transform" icon="ArrowRight" />
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        <a href="{{ route('selling.create') }}" class="group">
                            <div class="bg-white dark:bg-darkmode-600 rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 dark:border-darkmode-400 hover:border-blue-300 dark:hover:border-blue-600">
                                <div class="flex flex-col items-center text-center">
                                    <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-full mb-3 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors">
                                        <x-base.lucide class="h-6 w-6 text-blue-600 dark:text-blue-400" icon="Plus" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">New Sale</span>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('product.create') }}" class="group">
                            <div class="bg-white dark:bg-darkmode-600 rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 dark:border-darkmode-400 hover:border-green-300 dark:hover:border-green-600">
                                <div class="flex flex-col items-center text-center">
                                    <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded-full mb-3 group-hover:bg-green-100 dark:group-hover:bg-green-900/50 transition-colors">
                                        <x-base.lucide class="h-6 w-6 text-green-600 dark:text-green-400" icon="Package" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Add Product</span>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('customer.index') }}" class="group">
                            <div class="bg-white dark:bg-darkmode-600 rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 dark:border-darkmode-400 hover:border-purple-300 dark:hover:border-purple-600">
                                <div class="flex flex-col items-center text-center">
                                    <div class="p-3 bg-purple-50 dark:bg-purple-900/30 rounded-full mb-3 group-hover:bg-purple-100 dark:group-hover:bg-purple-900/50 transition-colors">
                                        <x-base.lucide class="h-6 w-6 text-purple-600 dark:text-purple-400" icon="Users" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Customers</span>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('stockIndex') }}" class="group">
                            <div class="bg-white dark:bg-darkmode-600 rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 dark:border-darkmode-400 hover:border-orange-300 dark:hover:border-orange-600">
                                <div class="flex flex-col items-center text-center">
                                    <div class="p-3 bg-orange-50 dark:bg-orange-900/30 rounded-full mb-3 group-hover:bg-orange-100 dark:group-hover:bg-orange-900/50 transition-colors">
                                        <x-base.lucide class="h-6 w-6 text-orange-600 dark:text-orange-400" icon="Archive" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Stock</span>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('spending.index') }}" class="group">
                            <div class="bg-white dark:bg-darkmode-600 rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 dark:border-darkmode-400 hover:border-red-300 dark:hover:border-red-600">
                                <div class="flex flex-col items-center text-center">
                                    <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded-full mb-3 group-hover:bg-red-100 dark:group-hover:bg-red-900/50 transition-colors">
                                        <x-base.lucide class="h-6 w-6 text-red-600 dark:text-red-400" icon="CreditCard" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Cash Flow</span>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('vehicle_service.index') }}" class="group">
                            <div class="bg-white dark:bg-darkmode-600 rounded-xl p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 dark:border-darkmode-400 hover:border-teal-300 dark:hover:border-teal-600">
                                <div class="flex flex-col items-center text-center">
                                    <div class="p-3 bg-teal-50 dark:bg-teal-900/30 rounded-full mb-3 group-hover:bg-teal-100 dark:group-hover:bg-teal-900/50 transition-colors">
                                        <x-base.lucide class="h-6 w-6 text-teal-600 dark:text-teal-400" icon="Wrench" />
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Vehicle Service</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- END: Stats Cards -->
            
            <!-- BEGIN: Sales Chart Section -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
                <!-- Sales Report Chart -->
                <div class="col-span-2">
                    <div class="intro-y">
                        <div class="bg-white dark:bg-darkmode-600 rounded-2xl shadow-lg border border-slate-200 dark:border-darkmode-400">
                            <div class="p-6 border-b border-slate-200 dark:border-darkmode-400">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200">Sales Analytics</h2>
                                        <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Track your sales performance over time</p>
                                    </div>
                                    <div class="flex space-x-3 mt-4 sm:mt-0">
                                        <x-base.form-input  
                                            class="datepicker !box w-32 text-sm" 
                                            id="start_date" 
                                            type="date"
                                            value="{{ $request->start_date ?? old('start_date') }}" 
                                            placeholder="Start Date" 
                                        />
                                        <x-base.form-input  
                                            class="datepicker !box w-32 text-sm" 
                                            id="end_date" 
                                            type="date"
                                            value="{{ $request->end_date ?? old('end_date') }}" 
                                            placeholder="End Date" 
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center mb-6">
                                    <div class="flex-1">
                                        <div class="text-3xl font-bold text-slate-800 dark:text-slate-200">
                                            Rp {{number_format($salesReportChart['total'], 0, ',', '.')}}
                                        </div>
                                        <div class="text-slate-600 dark:text-slate-400 text-sm">Total Sales Revenue</div>
                                    </div>
                                    <div class="flex items-center space-x-2 text-green-600">
                                        <x-base.lucide class="h-4 w-4" icon="TrendingUp" />
                                        <span class="text-sm font-medium">This Period</span>
                                    </div>
                                </div>
                                <div class="relative">
                                    <x-report-line-chart
                                        :data="$salesReportChart"
                                        class="-mb-6"
                                        height="h-[300px]"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Revenue Summary -->
                <div class="col-span-1">
                    <div class="space-y-6">
                        <!-- Revenue Summary -->
                        <div class="intro-y">
                            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold">Monthly Revenue</h3>
                                    <x-base.lucide class="h-6 w-6 text-indigo-200" icon="DollarSign" />
                                </div>
                                <div class="text-2xl font-bold mb-2">Rp {{number_format($salesReportChart['total'], 0, ',', '.')}}</div>
                                <div class="flex items-center text-indigo-200">
                                    <x-base.lucide class="h-4 w-4 mr-1" icon="Calendar" />
                                    <span class="text-sm">{{ date('F Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="intro-y">
                            <div class="bg-white dark:bg-darkmode-600 rounded-2xl shadow-lg border border-slate-200 dark:border-darkmode-400 p-6">
                                <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-4">Performance</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                                            <span class="text-sm text-slate-600 dark:text-slate-400">Products Sold</span>
                                        </div>
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{number_format($item_sellings->count())}}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                            <span class="text-sm text-slate-600 dark:text-slate-400">Total Orders</span>
                                        </div>
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{number_format($sellings->count())}}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                                            <span class="text-sm text-slate-600 dark:text-slate-400">Deliveries</span>
                                        </div>
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{number_format($delivery_orders->count())}}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                                            <span class="text-sm text-slate-600 dark:text-slate-400">Products</span>
                                        </div>
                                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{number_format($products->count())}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Sales Chart Section -->
            <!-- BEGIN: Recent Transactions -->
            <div class="intro-y">
                <div class="bg-white dark:bg-darkmode-600 rounded-2xl shadow-lg border border-slate-200 dark:border-darkmode-400">
                    <div class="p-6 border-b border-slate-200 dark:border-darkmode-400">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200">Recent Transactions</h2>
                                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Latest sales activity</p>
                            </div>
                            <a
                                href="{{route('selling.index')}}"
                                class="flex items-center text-primary hover:text-primary/80 transition-colors"
                            >
                                <span class="text-sm font-medium mr-2">View All</span>
                                <x-base.lucide class="h-4 w-4" icon="ArrowRight" />
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @forelse ($sellings->slice(0,5) as $selling)
                                <a
                                    href="{{route('selling.show', $selling->id)}}"
                                    class="intro-x block group"
                                >
                                    <div class="flex items-center p-4 rounded-xl border border-slate-200 dark:border-darkmode-400 hover:border-blue-300 dark:hover:border-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-all duration-300">
                                        <div class="flex-shrink-0">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                                <x-base.lucide class="w-6 h-6 text-white" icon="ShoppingBag" />
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="font-semibold text-slate-800 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                        {{ $selling->customer->name ?? 'Unknown Customer' }}
                                                    </div>
                                                    <div class="text-sm text-slate-500 dark:text-slate-400 flex items-center mt-1">
                                                        <x-base.lucide class="w-4 h-4 mr-1" icon="Calendar" />
                                                        {{ $selling['created_at']->format('M d, Y • H:i') }}
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="font-bold text-lg text-green-600 dark:text-green-400">
                                                        Rp {{ number_format($selling->grand_total, 0, ',', '.') }}
                                                    </div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                                        Completed
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <x-base.lucide class="w-5 h-5 text-slate-400 group-hover:text-blue-500 group-hover:translate-x-1 transition-all duration-300" icon="ChevronRight" />
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-12">
                                    <div class="w-24 h-24 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <x-base.lucide class="w-12 h-12 text-slate-400" icon="ShoppingCart" />
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-2">No Transactions Yet</h3>
                                    <p class="text-slate-600 dark:text-slate-400 mb-6">Start making sales to see transactions here</p>
                                    <a
                                        href="{{ route('selling.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        <x-base.lucide class="w-4 h-4 mr-2" icon="Plus" />
                                        Create Sale
                                    </a>
                                </div>
                            @endforelse
                        </div>
                        
                        @if($sellings->count() > 0)
                            <div class="mt-6 pt-4 border-t border-slate-200 dark:border-darkmode-400">
                                <a
                                    href="{{route('selling.index')}}"
                                    class="block w-full py-3 text-center text-primary hover:text-primary/80 font-medium border-2 border-primary/20 hover:border-primary/40 rounded-xl transition-all duration-300 hover:bg-primary/5"
                                >
                                    View All Transactions
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- END: Recent Transactions -->
        </div>
    </div>

    @push('scripts')
    <script type="module">
        // Date range functionality for sales chart
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        
        if (startDate && endDate) {
            [startDate, endDate].forEach(input => {
                input.addEventListener('change', function() {
                    if (startDate.value && endDate.value) {
                        const url = new URL(window.location.href);
                        url.searchParams.set('start_date', startDate.value);
                        url.searchParams.set('end_date', endDate.value);
                        window.location.href = url.toString();
                    }
                });
            });
        }
    </script>
    @endpush
@endsection
