@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- Header Section -->
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-2xl font-bold text-slate-800 mr-auto">{{ $title }}</h2>
        <div class="flex items-center space-x-2">
            <div class="hidden md:flex items-center text-slate-600">
                <x-base.lucide class="w-4 h-4 mr-2" icon="Archive" />
                <span class="text-sm">Total: {{ $data->total() }} stok</span>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <x-base.alert class="mb-4 mt-5 flex items-center bg-success/10 border border-success/20" variant="outline-success">
            <x-base.lucide class="mr-3 h-5 w-5 text-success" icon="CheckCircle" />
            <div class="text-success font-medium">{{ session('success') }}</div>
            <x-base.alert.dismiss-button class="btn-close ml-auto" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
    @if (session('failed'))
        <x-base.alert class="mb-4 mt-5 flex items-center bg-danger/10 border border-danger/20" variant="outline-danger">
            <x-base.lucide class="mr-3 h-5 w-5 text-danger" icon="AlertTriangle" />
            <div class="text-danger font-medium">{{ session('failed') }}</div>
            <x-base.alert.dismiss-button class="btn-close ml-auto" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif

    <!-- Action Bar -->
    <div class="intro-y bg-white rounded-lg shadow-sm border border-slate-200 p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="text-slate-600 font-medium">
                    <x-base.lucide class="w-5 h-5 mr-2 inline" icon="Archive" />
                    Manajemen Stok
                </div>
                
                <x-base.menu class="ml-4">
                    <x-base.menu.button class="!box px-3 py-2 border border-slate-300" as="x-base.button">
                        <x-base.lucide class="w-4 h-4 mr-2" icon="Download" />
                        Export
                        <x-base.lucide class="w-4 h-4 ml-2" icon="ChevronDown" />
                    </x-base.menu.button>
                    <x-base.menu.items class="w-48">
                        <x-base.menu.item href="{{ route($route . '.export', $request) }}" target="_blank">
                            <x-base.lucide class="mr-2 h-4 w-4 text-slate-500" icon="FileSpreadsheet" /> 
                            <span>Export to Excel</span>
                        </x-base.menu.item>
                        <x-base.menu.item href="{{ route($route . '.export-pdf', $request) }}">
                            <x-base.lucide class="mr-2 h-4 w-4 text-slate-500" icon="FileText" /> 
                            <span>Export to PDF</span>
                        </x-base.menu.item>
                    </x-base.menu.items>
                </x-base.menu>
            </div>

            <div class="flex items-center space-x-3">
                <div class="text-slate-500 text-sm hidden lg:block">
                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() }} entries
                </div>
                <div class="relative">
                    <x-base.form-input class="!box w-64 pr-10 bg-slate-50 border-slate-300" type="text" id="search"
                        value="{{ request()->get('search') }}" placeholder="Cari stok produk..." />
                    <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4 text-slate-400" icon="Search" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="intro-y bg-slate-50 rounded-lg border border-slate-200 p-4 mt-5">
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <div class="flex items-center space-x-2">
                <x-base.lucide class="w-4 h-4 text-slate-500" icon="Filter" />
                <span class="text-slate-600 font-medium">Filter Tanggal:</span>
            </div>
            <div class="flex items-center space-x-3">
                <x-base.form-input class="datepicker !box w-40" id="start_date" type="date"
                    value="{{ $request['start_date'] ?? old('start_date') }}" placeholder="Tanggal Mulai" />
                <span class="text-slate-500">hingga</span>
                <x-base.form-input class="datepicker !box w-40" id="end_date" type="date"
                    value="{{ $request['end_date'] ?? old('end_date') }}" placeholder="Tanggal Akhir" />
                <x-base.button class="bg-primary text-white px-4 py-2" id="filter-btn">
                    <x-base.lucide class="w-4 h-4 mr-2" icon="Search" />
                    Filter
                </x-base.button>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-12 gap-6">
        <!-- Data Table -->
        <div class="intro-y col-span-12 overflow-hidden">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <x-base.table class="border-spacing-y-[10px] border-separate">
                    <x-base.table.thead>
                        <x-base.table.tr class="bg-slate-50">
                            <x-base.table.th class="border-b-0 py-4 px-6 text-left font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span>No</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-left font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Package" />
                                    <span>Produk</span>
                                </div>
                            </x-base.table.th>
                            {{-- <x-base.table.th class="border-b-0 py-4 px-6 text-left font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Building" />
                                    <span>Supplier</span>
                                </div>
                            </x-base.table.th> --}}
                            <x-base.table.th class="border-b-0 py-4 px-6 text-center font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Archive" />
                                    <span>Stok Masuk</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-center font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="TrendingUp" />
                                    <span>Stok Keluar</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-center font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="BarChart" />
                                    <span>Sisa Stok</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-center font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Calendar" />
                                    <span>Tanggal Update</span>
                                </div>
                            </x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        @forelse ($data as $item)
                            <x-base.table.tr class="intro-x hover:bg-slate-50 transition-colors duration-200">
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-slate-600 font-medium">
                                    <div class="flex items-center justify-center w-8 h-8 bg-slate-100 rounded-full text-sm">
                                        {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                                    </div>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-600 rounded-full mr-3">
                                            <x-base.lucide class="w-5 h-5" icon="Package" />
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800">{{ $item->product->product ?? 'N/A' }}</div>
                                            <div class="text-sm text-slate-500">{{ $item->product->category->name ?? 'Uncategorized' }}</div>
                                        </div>
                                    </div>
                                </x-base.table.td>
                                {{-- <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 bg-orange-100 text-orange-600 rounded-full mr-2">
                                            <x-base.lucide class="w-4 h-4" icon="Building" />
                                        </div>
                                        <span class="text-slate-700">{{ $item->supplier->name ?? 'N/A' }}</span>
                                    </div>
                                </x-base.table.td> --}}
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <x-base.lucide class="w-3 h-3 mr-1" icon="Plus" />
                                        {{ number_format($item['first_stock'], 0, ',', '.') }} kg
                                    </span>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <x-base.lucide class="w-3 h-3 mr-1" icon="Minus" />
                                        {{ number_format($item['stock_in_use'], 0, ',', '.') }} kg
                                    </span>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-center">
                                    @php
                                        $remaining = $item['last_stock'];
                                        $alertClass = $remaining < 10 ? 'bg-red-100 text-red-800' : 
                                                     ($remaining < 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800');
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $alertClass }}">
                                        <x-base.lucide class="w-3 h-3 mr-1" icon="BarChart" />
                                        {{ number_format($remaining, 0, ',', '.') }} kg
                                    </span>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-center">
                                    <div class="flex items-center justify-center">
                                        <x-base.lucide class="w-4 h-4 mr-2 text-slate-400" icon="Calendar" />
                                        <span class="text-slate-700">{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }}</span>
                                    </div>
                                </x-base.table.td>
                            </x-base.table.tr>
                        @empty
                            <x-base.table.tr>
                                <x-base.table.td colspan="7" class="py-12 text-center border-b border-slate-200">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-base.lucide class="w-16 h-16 text-slate-300 mb-4" icon="Archive" />
                                        <h3 class="text-lg font-medium text-slate-600 mb-2">Tidak ada data stok</h3>
                                        <p class="text-slate-500 mb-4">Belum ada data stok yang tersedia untuk periode ini</p>
                                    </div>
                                </x-base.table.td>
                            </x-base.table.tr>
                        @endforelse
                    </x-base.table.tbody>
                </x-base.table>
            </div>
        </div>

        <!-- Pagination -->
        @if($data->hasPages())
        <div class="intro-y col-span-12 mt-6">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-slate-600 text-sm">
                        Menampilkan {{ $data->firstItem() ?? 0 }} hingga {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} entri
                    </div>
                    <div class="flex items-center">
                        <x-base.pagination.base :data="$data" class="pagination-modern"></x-base.pagination.base>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
        <script>
            (function () {
                "use strict";
                
                // Live search functionality
                let searchTimeout;
                const searchInput = document.getElementById('search');
                
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            const searchValue = this.value;
                            const url = new URL(window.location.href);
                            
                            if (searchValue.trim()) {
                                url.searchParams.set('search', searchValue);
                            } else {
                                url.searchParams.delete('search');
                            }
                            
                            window.location.href = url.toString();
                        }, 500);
                    });
                }

                // Date filter functionality
                const filterBtn = document.getElementById('filter-btn');
                const startDateInput = document.getElementById('start_date');
                const endDateInput = document.getElementById('end_date');

                if (filterBtn && startDateInput && endDateInput) {
                    filterBtn.addEventListener('click', function() {
                        const startDate = startDateInput.value;
                        const endDate = endDateInput.value;
                        const url = new URL(window.location.href);
                        
                        if (startDate) {
                            url.searchParams.set('start_date', startDate);
                        } else {
                            url.searchParams.delete('start_date');
                        }
                        
                        if (endDate) {
                            url.searchParams.set('end_date', endDate);
                        } else {
                            url.searchParams.delete('end_date');
                        }
                        
                        window.location.href = url.toString();
                    });
                }
                
                // Auto dismiss alerts after 5 seconds
                setTimeout(() => {
                    const alerts = document.querySelectorAll('[data-dismissible]');
                    alerts.forEach(alert => {
                        if (alert.querySelector('.btn-close')) {
                            alert.querySelector('.btn-close').click();
                        }
                    });
                }, 5000);
                
            })();
        </script>
    @endpush
@endsection