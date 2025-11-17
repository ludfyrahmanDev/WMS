@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- BEGIN: Page Header -->
    <div class="intro-y mt-8">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-200">{{ $title }}</h2>
        <div class="text-slate-500 mt-2">Kelola data pembelian dan supplier</div>
    </div>
    <!-- END: Page Header -->

    <!-- BEGIN: Alerts -->
    @if (session('success'))
        <x-base.alert class="mb-4 mt-5" variant="outline-success">
            <x-base.lucide class="mr-2 h-4 w-4" icon="CheckCircle" />
            {{ session('success') }}
        </x-base.alert>
    @endif
    @if (session('failed'))
        <x-base.alert class="mb-4 mt-5" variant="outline-danger">
            <x-base.lucide class="mr-2 h-4 w-4" icon="AlertTriangle" />
            {{ session('failed') }}
        </x-base.alert>
    @endif
    <!-- END: Alerts -->
    <!-- BEGIN: Statistics Cards -->
    <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="intro-y box p-5">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <x-base.lucide class="h-5 w-5 text-blue-600" icon="ShoppingCart" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">Total Pembelian</div>
                    <div class="text-xl font-semibold">{{ toThousand($total ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="intro-y box p-5 hidden">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <x-base.lucide class="h-5 w-5 text-green-600" icon="CheckCircle" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">Total Terbayar</div>
                    <div class="text-xl font-semibold">{{ toThousand($completed ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="intro-y box p-5">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                    <x-base.lucide class="h-5 w-5 text-orange-600" icon="Clock" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">Total Hutang</div>
                    <div class="text-xl font-semibold">{{ toThousand($inCompleted ?? 0) }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Statistics Cards -->
    <!-- BEGIN: Data Management Section -->
    <div class="mt-8 grid grid-cols-12 gap-6">
        <!-- BEGIN: Actions & Filters -->
        <div class="intro-y col-span-12">
            <div class="box p-5">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route($route . '.create') }}">
                            <x-base.button variant="primary">
                                Tambah Pembelian
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
                            placeholder="Cari pembelian..." 
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
                    Menampilkan {{ $data->firstItem() ?? 0 }}-{{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data
                </div>
            </div>
        </div>
        <!-- END: Actions & Filters -->
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12">
            <div class="box">
                <!-- Table Header -->
                <div class="p-5 border-b">
                    <h3 class="text-lg font-semibold">Daftar Pembelian</h3>
                </div>

                <!-- Table Content -->
                <div class="">
                    <x-base.table class="border-spacing-y-[10px] border-separate">
                        <x-base.table.thead>
                            <x-base.table.tr>
                                <x-base.table.th class="border-b-0 font-semibold">
                                    No
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold">
                                    Tanggal Pembelian
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center font-semibold">
                                    Jumlah
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center font-semibold">
                                    Supplier
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 text-center font-semibold">
                                    Tipe Transaksi
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
                                <x-base.table.tr class="intro-x hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    <x-base.table.td class="border-b-0 bg-white shadow-sm first:rounded-l-lg last:rounded-r-lg dark:bg-darkmode-600 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-primary/10 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-primary font-semibold text-sm">
                                                    {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                                                </span>
                                            </div>
                                        </div>
                                    </x-base.table.td>
                                    <x-base.table.td class="py-4">
                                        {{ date('d M Y', strtotime($item['purchase_date'])) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        {{ toThousand($item['grand_total']) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        {{ $item['supplier']['name'] }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        @php
                                            $typeColor = $item['transaction_type'] == 'Cash' ? 'text-green-600' : 'text-orange-600';
                                        @endphp
                                        <span class="{{ $typeColor }} font-medium">{{ $item['transaction_type'] }}</span>
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
                                            @else
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
                                            @endif
                                        </div>
                                        <!-- Delete Confirmation Modal -->
                                        <x-base.dialog id="delete-confirmation-modal-{{ $item->id }}">
                                            <x-base.dialog.panel>
                                                <div class="p-8 text-center">
                                                    <h3 class="text-xl font-semibold mb-4">Hapus Data Pembelian</h3>
                                                    <p class="text-slate-500 mb-4">
                                                        Apakah Anda yakin ingin menghapus data pembelian ini?
                                                    </p>
                                                    <div class="bg-slate-50 p-3 rounded mb-4">
                                                        <div class="text-sm text-slate-600">
                                                            <strong>Supplier:</strong> {{ $item['supplier']['name'] }}<br>
                                                            <strong>Tanggal:</strong> {{ date('d M Y', strtotime($item['purchase_date'])) }}
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

                                        <!-- Status Confirmation Modal -->
                                        <x-base.dialog id="status-confirmation-modal-{{ $item->id }}">
                                            <x-base.dialog.panel>
                                                <div class="p-8 text-center">
                                                    <h3 class="text-xl font-semibold mb-4">Konfirmasi Pembayaran</h3>
                                                    <p class="text-slate-500 mb-4">
                                                        Apakah Anda yakin ingin mengkonfirmasi pembayaran untuk pembelian ini?
                                                    </p>
                                                    <div class="bg-slate-50 p-3 rounded mb-4">
                                                        <div class="text-sm text-slate-600">
                                                            <strong>Supplier:</strong> {{ $item['supplier']['name'] }}<br>
                                                            <strong>Tanggal:</strong> {{ date('d M Y', strtotime($item['purchase_date'])) }}<br>
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
                                                        <input type="hidden" name="mode" value="konfirmasi lunas">
                                                        <x-base.button type="submit" variant="success">
                                                            Ya, Konfirmasi
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

                        <!-- Empty State -->
                        @if ($data->isEmpty())
                            <x-base.table.tbody>
                                <x-base.table.tr>
                                    <x-base.table.td colspan="7" class="py-16 text-center">
                                        <div>
                                            <h3 class="text-lg font-semibold mb-2">Belum Ada Data Pembelian</h3>
                                            <p class="text-slate-500 mb-4">
                                                Belum ada transaksi pembelian yang tercatat.
                                            </p>
                                            <a href="{{ route($route . '.create') }}">
                                                <x-base.button variant="primary">
                                                    Tambah Pembelian Pertama
                                                </x-base.button>
                                            </a>
                                        </div>
                                    </x-base.table.td>
                                </x-base.table.tr>
                            </x-base.table.tbody>
                        @endif
                    </x-base.table>
                </div>
            </div>
        </div>
        <!-- END: Data List -->
        
        <!-- BEGIN: Pagination -->
        @if ($data->hasPages())
            <div class="intro-y col-span-12">
                <div class="box p-5">
                    <div class="flex flex-col sm:flex-row items-center justify-between">
                        <div class="text-slate-500 text-sm mb-4 sm:mb-0">
                            Menampilkan {{ $data->firstItem() ?? 0 }} sampai {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data
                        </div>
                        <x-base.pagination.base :data="$data" class="flex-wrap"></x-base.pagination.base>
                    </div>
                </div>
            </div>
        @endif
        <!-- END: Pagination -->
    </div>
    <!-- END: Data Management Section -->
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
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Auto search functionality
                let searchTimeout;
                $('#search').on('input', function() {
                    clearTimeout(searchTimeout);
                    const searchValue = $(this).val();
                    
                    searchTimeout = setTimeout(function() {
                        const currentUrl = new URL(window.location.href);
                        if (searchValue.length > 0) {
                            currentUrl.searchParams.set('search', searchValue);
                        } else {
                            currentUrl.searchParams.delete('search');
                        }
                        currentUrl.searchParams.delete('page'); // Reset to first page
                        window.location.href = currentUrl.toString();
                    }, 800); // Wait 800ms after user stops typing
                });

                // Date filter functionality
                $('#start_date, #end_date').on('change', function() {
                    const startDate = $('#start_date').val();
                    const endDate = $('#end_date').val();
                    
                    if (startDate && endDate) {
                        const currentUrl = new URL(window.location.href);
                        currentUrl.searchParams.set('start_date', startDate);
                        currentUrl.searchParams.set('end_date', endDate);
                        currentUrl.searchParams.delete('page'); // Reset to first page
                        window.location.href = currentUrl.toString();
                    }
                });

                // Clear filters functionality
                function clearFilters() {
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.delete('search');
                    currentUrl.searchParams.delete('start_date');
                    currentUrl.searchParams.delete('end_date');
                    currentUrl.searchParams.delete('page');
                    window.location.href = currentUrl.toString();
                }

                // Add clear filters button if filters are active
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('search') || urlParams.has('start_date') || urlParams.has('end_date')) {
                    const clearButton = `
                        <button id="clear-filters" class="ml-2 px-3 py-2 text-sm bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors">
                            <i class="fas fa-times mr-1"></i> Clear Filters
                        </button>
                    `;
                    $('.flex.gap-2').after(clearButton);
                    
                    $('#clear-filters').on('click', clearFilters);
                }

                // Enhanced loading states for buttons
                $('form').on('submit', function() {
                    const submitBtn = $(this).find('button[type="submit"]');
                    const originalText = submitBtn.html();
                    
                    submitBtn.prop('disabled', true).html(`
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    `);
                    
                    // Restore button if form submission fails
                    setTimeout(() => {
                        submitBtn.prop('disabled', false).html(originalText);
                    }, 5000);
                });

                // Tooltip for truncated text
                $('[data-tooltip]').each(function() {
                    $(this).on('mouseenter', function() {
                        const tooltip = $('<div class="tooltip"></div>').text($(this).data('tooltip'));
                        $('body').append(tooltip);
                        
                        const offset = $(this).offset();
                        tooltip.css({
                            position: 'absolute',
                            top: offset.top - tooltip.outerHeight() - 5,
                            left: offset.left + ($(this).outerWidth() - tooltip.outerWidth()) / 2,
                            background: '#333',
                            color: '#fff',
                            padding: '5px 10px',
                            borderRadius: '4px',
                            fontSize: '12px',
                            zIndex: 1000
                        });
                    }).on('mouseleave', function() {
                        $('.tooltip').remove();
                    });
                });
            });
        </script>
    @endpush
@endsection
