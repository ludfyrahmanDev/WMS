@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- Modern Header -->
    <div class="flex items-center justify-between mb-8 pt-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ $title }}</h1>
            <p class="text-slate-600 mt-2">Kelola pengeluaran khusus angkutan dengan sistem keuangan terintegrasi</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-3 rounded-lg text-white shadow-lg">
                <x-base.lucide class="w-6 h-6" icon="Truck" />
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <x-base.alert class="mb-6 flex items-center bg-green-50 border-green-200 text-green-800" variant="outline-success">
            <x-base.lucide class="mr-3 h-5 w-5 text-green-500" icon="CheckCircle" />
            <div class="flex-1">{{ session('success') }}</div>
            <x-base.alert.dismiss-button class="text-green-500 hover:text-green-700 ml-4">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
    @if (session('failed'))
        <x-base.alert class="mb-6 flex items-center bg-red-50 border-red-200 text-red-800" variant="outline-danger">
            <x-base.lucide class="mr-3 h-5 w-5 text-red-500" icon="AlertCircle" />
            <div class="flex-1">{{ session('failed') }}</div>
            <x-base.alert.dismiss-button class="text-red-500 hover:text-red-700 ml-4">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Total Pengeluaran</p>
                    <p class="text-2xl font-bold">{{ toThousand($totalSpending ?? 0) }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-orange-200" icon="TrendingDown" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Pemasukan</p>
                    <p class="text-2xl font-bold">{{ toThousand($income ?? 0) }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-green-200" icon="TrendingUp" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Transaksi Bulan Ini</p>
                    <p class="text-2xl font-bold">{{ $data->total() ?? 0 }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-blue-200" icon="Calendar" />
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
                                Tambah Data Pengeluaran Angkutan
                            </x-base.button>
                        </a>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:w-auto w-full">
                        <x-base.form-input 
                            class="!box w-full sm:w-56" 
                            type="text" 
                            id="search"
                            value="{{ request()->get('search') }}" 
                            placeholder="Cari pengeluaran..." 
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
                    Menampilkan 1 hingga {{ $data->count() < 10 ? $data->count() : 10 }} dari {{ $data->total() }} data
                </div>
            </div>
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <div class="overflow-x-auto overflow-y-hidden">
                <x-base.table class="border border-slate-200 bg-white rounded-lg shadow-sm mb-[190px]">
                    <x-base.table.thead>
                        <x-base.table.tr class="bg-slate-50">
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                No
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Tanggal
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Keterangan
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Kategori
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Masuk
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Keluar
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Metode Pembayaran
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Aksi
                            </x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        @forelse ($data as $index=> $item)
                            <x-base.table.tr class="hover:bg-slate-50">
                                <x-base.table.td class="text-center border-b border-slate-100 py-3 px-4">
                                    {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                                </x-base.table.td>
                                <x-base.table.td class="text-center border-b border-slate-100 py-3 px-4">
                                    {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                                </x-base.table.td>
                                <x-base.table.td class="border-b border-slate-100 py-3 px-4">
                                    <div class="font-medium">{{ $item->description ?? '-' }}</div>
                                </x-base.table.td>
                                <x-base.table.td class="border-b border-slate-100 py-3 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $item->spendingCategory->spending_category ?? '-' }}
                                    </span>
                                </x-base.table.td>
                                <x-base.table.td class="text-right border-b border-slate-100 py-3 px-4">
                                    @if($item->mutation == 'Uang Masuk')
                                        <span class="font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                                            {{ toThousand($item->nominal) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </x-base.table.td>
                                <x-base.table.td class="text-right border-b border-slate-100 py-3 px-4">
                                    @if($item->mutation == 'Uang Keluar')
                                        <span class="font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full">
                                            {{ toThousand($item->nominal) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </x-base.table.td>
                                <x-base.table.td class="border-b border-slate-100 py-3 px-4">
                                    <span class="text-sm text-slate-600">
                                        {{ $item->payment_method ?? '-' }}
                                    </span>
                                </x-base.table.td>
                                <x-base.table.td class="text-center border-b border-slate-100 py-3 px-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a class="text-blue-600 hover:text-blue-800 text-sm" href="{{ route('transportSpending.edit', $item->id) }}">
                                            <x-base.lucide class="h-4 w-4" icon="Edit" />
                                        </a>
                                        <a class="text-red-600 hover:text-red-800 text-sm" data-tw-toggle="modal"
                                            data-tw-target="#delete-confirmation-modal-{{ $item->id }}" href="#">
                                            <x-base.lucide class="h-4 w-4" icon="Trash2" />
                                        </a>
                                    </div>
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
                                                <form action="{{ route('transportSpending.destroy', $item->id) }}" method="post"
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
                                </x-base.table.td>
                            </x-base.table.tr>
                        @empty
                            <x-base.table.tr>
                                <x-base.table.td class="text-center py-8 border-b border-slate-100" colspan="8">
                                    <div class="flex flex-col justify-center items-center">
                                        <x-base.lucide class="h-16 w-16 text-slate-400 mb-3" icon="Inbox" />
                                        <div class="text-slate-500 text-lg font-medium">
                                            Tidak ada data transaksi angkutan
                                        </div>
                                        <div class="text-slate-400 text-sm mt-1">
                                            Silakan tambah transaksi baru untuk melihat data
                                        </div>
                                    </div>
                                </x-base.table.td>
                            </x-base.table.tr>
                        @endforelse
                    </x-base.table.tbody>
                </x-base.table>
            </div>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <x-base.pagination.base :data="$data"></x-base.pagination.base>
        <!-- END: Pagination -->
    </div>
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
</script>
@endpush
