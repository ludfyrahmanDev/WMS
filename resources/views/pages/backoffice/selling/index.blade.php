@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>
        {{ $title }}
    </title>
@endsection

@section('subcontent')
    <!-- Modern Page Header -->
    <div class="intro-y mt-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-xl">
                    <x-base.lucide class="w-6 h-6 text-blue-600" icon="ShoppingCart" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $title ?? 'Data Penjualan' }}</h1>
                    <p class="text-slate-600 mt-1">Kelola data transaksi penjualan dan pembayaran</p>
                </div>
            </div>
            <div class="flex items-center space-x-2 text-sm text-slate-500">
                <x-base.lucide class="w-4 h-4" icon="Calendar" />
                <span>{{ now()->format('d M Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <x-base.alert class="mb-6 flex items-center bg-emerald-50 border-emerald-200" variant="outline-success" data-dismissible="true">
            <x-base.lucide class="mr-3 h-5 w-5 text-emerald-600" icon="CheckCircle" />
            <span class="text-emerald-800">{{ session('success') }}</span>
            <x-base.alert.dismiss-button class="btn-close ml-auto" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif

    @if (session('failed'))
        <x-base.alert class="mb-6 flex items-center bg-red-50 border-red-200" variant="outline-danger" data-dismissible="true">
            <x-base.lucide class="mr-3 h-5 w-5 text-red-600" icon="AlertCircle" />
            <span class="text-red-800">{{ session('failed') }}</span>
            <x-base.alert.dismiss-button class="btn-close ml-auto" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif

    <!-- Enhanced Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Penjualan</p>
                    <p class="text-2xl font-bold">{{ toThousand($total ?? 0) }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-blue-200" icon="ShoppingCart" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Terbayar</p>
                    <p class="text-2xl font-bold">{{ toThousand($completed ?? 0) }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-green-200" icon="CheckCircle" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Pending Payment</p>
                    <p class="text-2xl font-bold">{{ toThousand($pending ?? 0) }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-orange-200" icon="Clock" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Transaksi Hari Ini</p>
                    <p class="text-2xl font-bold">{{ $data->where('created_at', '>=', now()->startOfDay())->count() ?? 0 }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-purple-200" icon="TrendingUp" />
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="intro-y mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Left Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route($route . '.create') }}">
                        <x-base.button class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white shadow-lg shadow-blue-600/20" variant="primary">
                            <x-base.lucide class="w-4 h-4 mr-2" icon="Plus" />
                            Tambah Penjualan
                        </x-base.button>
                    </a>

                    <x-base.menu class="inline-block">
                        <x-base.menu.button class="w-full sm:w-auto" as="x-base.button" variant="outline-secondary">
                            <x-base.lucide class="w-4 h-4 mr-2" icon="Download" />
                            Export Data
                            <x-base.lucide class="w-4 h-4 ml-2" icon="ChevronDown" />
                        </x-base.menu.button>
                        <x-base.menu.items class="w-48">
                            <x-base.menu.item>
                                <x-base.lucide class="mr-2 h-4 w-4 text-slate-500" icon="FileText" />
                                Export ke Excel
                            </x-base.menu.item>
                            <x-base.menu.item>
                                <x-base.lucide class="mr-2 h-4 w-4 text-slate-500" icon="FileImage" />
                                Export ke PDF
                            </x-base.menu.item>
                            <x-base.menu.item>
                                <x-base.lucide class="mr-2 h-4 w-4 text-slate-500" icon="Printer" />
                                Print Report
                            </x-base.menu.item>
                        </x-base.menu.items>
                    </x-base.menu>
                </div>

                <!-- Right Actions -->
                <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                    <form method="GET" action="{{ route($route . '.index') }}" class="flex-1 sm:flex-initial">
                        <div class="relative">
                            <x-base.lucide class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400" icon="Search" />
                            <x-base.form-input
                                id="search"
                                class="pl-10 pr-4 py-2 w-full sm:w-64 border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg"
                                name="search"
                                type="text"
                                placeholder="Cari transaksi..."
                                value="{{ request()->get('search') }}"
                            />
                        </div>
                    </form>
                    <x-base.button variant="outline-secondary" class="w-full sm:w-auto">
                        <x-base.lucide class="w-4 h-4 mr-2" icon="Filter" />
                        Filter
                    </x-base.button>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12">
            <div class="box">
                <!-- Table Header -->
                <div class="p-5 border-b">
                    <h3 class="text-lg font-semibold">Daftar Penjualan</h3>
                </div>

                <!-- Table Content -->
                <div class="lg:overflow-x-hidden overflow-x-auto overflow-y-hidden">
                    <x-base.table class="border-spacing-y-[10px] border-separate">
                        <x-base.table.thead>
                            <x-base.table.tr>
                                <x-base.table.th class="border-b-0 font-semibold">
                                    No
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold">
                                    Tanggal
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center font-semibold">
                                    Customer
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center font-semibold">
                                    Metode Pembayaran
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center font-semibold">
                                    Tipe Pembayaran
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center font-semibold">
                                    Jumlah Pembayaran
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center font-semibold">
                                    Status
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center font-semibold">
                                    Aksi
                                </x-base.table.th>
                            </x-base.table.tr>
                        </x-base.table.thead>
                        <x-base.table.tbody>
                            @foreach ($data as $item)
                                <x-base.table.tr class="intro-x hover:bg-slate-50 transition-colors">
                                    <x-base.table.td class="py-4">
                                        {{ $loop->iteration }}
                                    </x-base.table.td>
                                    <x-base.table.td class="py-4">
                                        {{ date('d M Y', strtotime($item['date'])) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        {{ $item['customer']['name'] }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        @php
                                            $methodColor = match($item['purchasing_method']) {
                                                'kontan' => 'text-green-600',
                                                'titipan' => 'text-blue-600',
                                                default => 'text-orange-600'
                                            };
                                        @endphp
                                        <span class="{{ $methodColor }} font-medium">
                                            {{ $item['purchasing_method'] == 'kontan' ? 'Kontan' : ($item['purchasing_method'] == 'titipan' ? 'Titipan' : 'Tempo') }}
                                        </span>
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        @php
                                            $typeColor = $item['payment_type'] == 'cash' ? 'text-green-600' : 'text-blue-600';
                                        @endphp
                                        <span class="{{ $typeColor }} font-medium">
                                            {{ $item['payment_type'] == 'cash' ? 'Cash' : 'Transfer' }}
                                        </span>
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4 font-semibold">
                                        {{ toThousand($item['grand_total']) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        @php
                                            $statusColor = match($item['status']) {
                                                'Pending' => 'text-yellow-600',
                                                'On Progress' => 'text-blue-600',
                                                'Completed' => 'text-green-600',
                                                default => 'text-gray-600'
                                            };
                                        @endphp
                                        <span class="{{ $statusColor }} font-medium">{{ $item['status'] }}</span>
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            @if ($item['status'] == 'On Progress')
                                                <x-base.button 
                                                    size="sm" 
                                                    variant="success"
                                                    data-tw-toggle="modal"
                                                    data-tw-target="#status-confirmation-modal-{{ $item->id }}">
                                                    Konfirmasi
                                                </x-base.button>
                                                <x-base.button 
                                                    size="sm" 
                                                    variant="outline-primary"
                                                    as="a"
                                                    href="{{ route($route . '.show', $item->id) }}">
                                                    Detail
                                                </x-base.button>
                                            @elseif ($item['status'] == 'Completed')
                                                <x-base.button 
                                                    size="sm" 
                                                    variant="outline-primary"
                                                    as="a"
                                                    href="{{ route($route . '.show', $item->id) }}">
                                                    Detail
                                                </x-base.button>
                                                <x-base.button 
                                                    size="sm" 
                                                    variant="outline-success"
                                                    as="a"
                                                    href="{{ route($route . '.export-one', $item->id) }}">
                                                    Export
                                                </x-base.button>
                                            @else
                                                <x-base.button 
                                                    size="sm" 
                                                    variant="outline-warning"
                                                    as="a"
                                                    href="{{ route('selling.edit', $item->id) }}">
                                                    Edit
                                                </x-base.button>
                                                <x-base.button 
                                                    size="sm" 
                                                    variant="outline-danger"
                                                    data-tw-toggle="modal"
                                                    data-tw-target="#delete-confirmation-modal-{{ $item->id }}">
                                                    Hapus
                                                </x-base.button>
                                            @endif
                                        </div>
                                        <!-- Delete Confirmation Modal -->
                                        <x-base.dialog id="delete-confirmation-modal-{{ $item->id }}">
                                            <x-base.dialog.panel>
                                                <div class="p-8 text-center">
                                                    <h3 class="text-xl font-semibold mb-4">Hapus Data Penjualan</h3>
                                                    <p class="text-slate-500 mb-4">
                                                        Apakah Anda yakin ingin menghapus data penjualan ini?
                                                    </p>
                                                    <div class="bg-slate-50 p-3 rounded mb-4">
                                                        <div class="text-sm text-slate-600">
                                                            <strong>Customer:</strong> {{ $item['customer']['name'] }}<br>
                                                            <strong>Tanggal:</strong> {{ date('d M Y', strtotime($item['date'])) }}
                                                        </div>
                                                    </div>
                                                    <p class="text-xs text-red-600">
                                                        Tindakan ini tidak dapat dibatalkan
                                                    </p>
                                                </div>
                                                <div class="px-8 pb-8 flex justify-center gap-3">
                                                    <x-base.button data-tw-dismiss="modal" type="button" variant="outline-secondary">
                                                        Batal
                                                    </x-base.button>
                                                    <form action="{{ route('selling.destroy', $item->id) }}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <x-base.button type="submit" variant="danger">
                                                            Ya, Hapus
                                                        </x-base.button>
                                                    </form>
                                                </div>
                                            </x-base.dialog.panel>
                                        </x-base.dialog>

                                        <!-- Status Confirmation Modal -->
                                        <x-base.dialog id="status-confirmation-modal-{{ $item->id }}">
                                            <x-base.dialog.panel>
                                                <div class="p-8 text-center">
                                                    <h3 class="text-xl font-semibold mb-4">Konfirmasi Pembayaran</h3>
                                                    <p class="text-slate-500 mb-4">
                                                        Apakah Anda yakin ingin mengkonfirmasi pembayaran untuk penjualan ini?
                                                    </p>
                                                    <div class="bg-slate-50 p-3 rounded mb-4">
                                                        <div class="text-sm text-slate-600">
                                                            <strong>Customer:</strong> {{ $item['customer']['name'] }}<br>
                                                            <strong>Tanggal:</strong> {{ date('d M Y', strtotime($item['date'])) }}<br>
                                                            <strong>Status akan berubah menjadi:</strong> <span class="text-green-600 font-semibold">Completed</span>
                                                        </div>
                                                    </div>
                                                    <p class="text-xs text-blue-600">
                                                        Pastikan pembayaran sudah diterima sebelum konfirmasi
                                                    </p>
                                                </div>
                                                <div class="px-8 pb-8 flex justify-center gap-3">
                                                    <x-base.button data-tw-dismiss="modal" type="button" variant="outline-secondary">
                                                        Batal
                                                    </x-base.button>
                                                    <form action="{{ route($route . '.update', $item->id) }}" method="post">
                                                        @method('PUT')
                                                        @csrf
                                                        <input type="hidden" name="mode" value="Konfirmasi Lunas">
                                                        <x-base.button type="submit" variant="success">
                                                            Ya, Konfirmasi
                                                        </x-base.button>
                                                    </form>
                                                </div>
                                            </x-base.dialog.panel>
                                        </x-base.dialog>
                                    </x-base.table.td>
                                </x-base.table.tr>
                            @endforeach

                            <!-- Empty State -->
                            @if ($data->isEmpty())
                                <x-base.table.tr>
                                    <x-base.table.td colspan="9" class="py-16 text-center">
                                        <div>
                                            <h3 class="text-lg font-semibold mb-2">Belum Ada Data Penjualan</h3>
                                            <p class="text-slate-500 mb-4">
                                                Belum ada transaksi penjualan yang tercatat.
                                            </p>
                                            <a href="{{ route($route . '.create') }}">
                                                <x-base.button variant="primary">
                                                    Buat Transaksi Pertama
                                                </x-base.button>
                                            </a>
                                        </div>
                                    </x-base.table.td>
                                </x-base.table.tr>
                            @endif
                        </x-base.table.tbody>
                    </x-base.table>
                </div>
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

@push('js')
<script>
    // Search functionality
    let searchTimeout;
    const searchInput = document.getElementById('search');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    function performSearch() {
        const searchValue = searchInput.value;
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        const params = new URLSearchParams(window.location.search);
        
        if (searchValue) {
            params.set('search', searchValue);
        } else {
            params.delete('search');
        }
        
        if (startDate) {
            params.set('start_date', startDate);
        } else {
            params.delete('start_date');
        }
        
        if (endDate) {
            params.set('end_date', endDate);
        } else {
            params.delete('end_date');
        }

        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    // Debounced search for text input
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 500);
        });
    }

    // Immediate search for date inputs
    if (startDateInput) {
        startDateInput.addEventListener('change', performSearch);
    }

    if (endDateInput) {
        endDateInput.addEventListener('change', performSearch);
    }

    // Auto-dismiss alerts
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                if (alert && alert.parentNode) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }
            }, 5000);
        });
    });

    // Enhanced table interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8fafc';
                this.style.transform = 'scale(1.01)';
                this.style.transition = 'all 0.2s ease';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = '';
            });
        });

        // Smooth scroll to top when pagination changes
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });

        // Status-specific styling enhancements
        const statusElements = document.querySelectorAll('[class*="text-yellow-600"], [class*="text-blue-600"], [class*="text-green-600"]');
        statusElements.forEach(el => {
            el.classList.add('px-2', 'py-1', 'rounded', 'text-xs', 'font-semibold', 'uppercase', 'tracking-wide');
            if (el.textContent.includes('Pending')) {
                el.classList.add('bg-yellow-100');
            } else if (el.textContent.includes('Progress')) {
                el.classList.add('bg-blue-100');
            } else if (el.textContent.includes('Completed')) {
                el.classList.add('bg-green-100');
            }
        });
    });
</script>
@endpush
