@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- Modern Page Header -->
    <div class="intro-y mt-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="flex items-center justify-center w-12 h-12 bg-indigo-100 rounded-xl">
                    <x-base.lucide class="w-6 h-6 text-indigo-600" icon="Wrench" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $title ?? 'Data Service Kendaraan' }}</h1>
                    <p class="text-slate-600 mt-1">Kelola data service dan maintenance kendaraan</p>
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
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm">Total Service</p>
                    <p class="text-2xl font-bold">{{ $data->total() ?? 0 }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-indigo-200" icon="Wrench" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-red-500 to-red-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm">Total Biaya</p>
                    <p class="text-2xl font-bold">{{ toThousand($total ?? 0) }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-red-200" icon="DollarSign" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Service Bulan Ini</p>
                    <p class="text-2xl font-bold">{{ $data->where('created_at', '>=', now()->startOfMonth())->count() ?? 0 }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-purple-200" icon="Calendar" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Pending Service</p>
                    <p class="text-2xl font-bold">{{ $data->where('status', 'pending')->count() ?? 0 }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-orange-200" icon="Clock" />
            </div>
        </div>
    </div>
    <!-- Actions & Filters -->
    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <div class="box p-5">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route($route . '.create') }}">
                            <x-base.button variant="primary">
                                Tambah Data Service
                            </x-base.button>
                        </a>
                        
                        <x-base.menu>
                            <x-base.menu.button as="x-base.button" variant="outline-secondary">
                                Export Data
                            </x-base.menu.button>
                            <x-base.menu.items class="w-48">
                                <x-base.menu.item href="{{ route($route . '.export', $request) }}" target="_blank">
                                    Export ke Excel
                                </x-base.menu.item>
                                <x-base.menu.item href="{{ route($route . '.export-pdf', $request) }}">
                                    Export ke PDF
                                </x-base.menu.item>
                            </x-base.menu.items>
                        </x-base.menu>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:w-auto w-full">
                        <x-base.form-input 
                            class="!box w-full sm:w-56" 
                            type="text" 
                            id="search"
                            value="{{ request()->get('search') }}" 
                            placeholder="Cari service..." 
                        />
                        <x-base.form-input 
                            class="!box" 
                            id="start_date" 
                            type="date"
                            value="{{ $request['start_date'] ?? old('start_date') }}" 
                        />
                        <x-base.form-input 
                            class="!box" 
                            id="end_date" 
                            type="date"
                            value="{{ $request['end_date'] ?? old('end_date') }}" 
                        />
                    </div>
                </div>
                
                <!-- Data Info -->
                <div class="text-slate-500 text-sm mt-3 pt-3 border-t">
                    Menampilkan 1 hingga {{ $data->total() < 10 ? $data->total() : 10 }} dari {{ $data->total() }} data
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12">
            <div class="box">
                <!-- Table Header -->
                <div class="p-5 border-b">
                    <h3 class="text-lg font-semibold">Daftar Service Kendaraan</h3>
                </div>

                <!-- Table Content -->
                <div class="overflow-hidden">
                    <x-base.table class="border-spacing-y-[10px] border-separate">
                        <x-base.table.thead>
                            <x-base.table.tr>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    No
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Tanggal
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Nama Driver
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Kendaraan
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Total Biaya
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Jenis Pembayaran
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Aksi
                                </x-base.table.th>
                            </x-base.table.tr>
                        </x-base.table.thead>
                        <x-base.table.tbody>
                            @foreach ($data as $item)
                                <x-base.table.tr class="intro-x hover:bg-slate-50 transition-colors">
                                    <x-base.table.td class="text-center py-4">
                                        {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        {{ date('d M Y', strtotime($item['date'])) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        {{ $item['driver']['name'] ?? '-' }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4 font-semibold">
                                        {{ $item['vehicle']['name'] }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4 font-semibold text-red-600">
                                        {{ toThousand($item->vehicleServiceDetail->sum('amount_of_expenditure')) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        @if ($item['payment_method'] == 'CASH')
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-sm">{{ $item['payment_method'] }}</span>
                                        @elseif ($item['payment_method'] == 'TRANSFER')
                                            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">{{ $item['payment_method'] }}</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 font-semibold text-sm">-</span>
                                        @endif
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <x-base.button 
                                                size="sm" 
                                                variant="outline-warning"
                                                as="a"
                                                href="{{ route($route . '.edit', $item->id) }}">
                                                Edit
                                            </x-base.button>
                                            <x-base.button 
                                                size="sm" 
                                                variant="outline-danger"
                                                data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal-{{ $item->id }}">
                                                Hapus
                                            </x-base.button>
                                        </div>
                                        <!-- Delete Confirmation Modal -->
                                        <x-base.dialog id="delete-confirmation-modal-{{ $item->id }}">
                                            <x-base.dialog.panel>
                                                <div class="p-8 text-center">
                                                    <h3 class="text-xl font-semibold mb-4">Hapus Data Service</h3>
                                                    <p class="text-slate-500 mb-4">
                                                        Apakah Anda yakin ingin menghapus data service ini?
                                                    </p>
                                                    <div class="bg-slate-50 p-3 rounded mb-4">
                                                        <div class="text-sm text-slate-600">
                                                            <strong>Driver:</strong> {{ $item['driver']['name'] ?? '-' }}<br>
                                                            <strong>Kendaraan:</strong> {{ $item['vehicle']['name'] }}<br>
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
                                                    <form action="{{ route($route . '.destroy', $item->id) }}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <x-base.button type="submit" variant="danger">
                                                            Ya, Hapus
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
                                    <x-base.table.td colspan="7" class="py-16 text-center">
                                        <div>
                                            <h3 class="text-lg font-semibold mb-2">Belum Ada Data Service</h3>
                                            <p class="text-slate-500 mb-4">
                                                Belum ada data service kendaraan yang tercatat.
                                            </p>
                                            <a href="{{ route($route . '.create') }}">
                                                <x-base.button variant="primary">
                                                    Tambah Data Service Pertama
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
    });
</script>
@endpush
