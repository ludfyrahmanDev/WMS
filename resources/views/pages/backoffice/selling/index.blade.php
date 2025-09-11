@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="mt-8">
        <h2 class="text-2xl font-bold">Data Penjualan</h2>
        <p class="text-slate-500 mt-1">Kelola data transaksi penjualan</p>
    </div>
    
    @if (session('success'))
        <x-base.alert class="mb-2 mt-5" variant="outline-success">
            {{ session('success') }}
        </x-base.alert>
    @endif
    @if (session('failed'))
        <x-base.alert class="mb-2 mt-5" variant="outline-danger">
            {{ session('failed') }}
        </x-base.alert>
    @endif
    <!-- Statistics Cards -->
    <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="intro-y box p-5">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <x-base.lucide class="h-5 w-5 text-blue-600" icon="ShoppingCart" />
                </div>
                <div>
                    <div class="text-slate-500 text-sm">Total Penjualan</div>
                    <div class="text-xl font-semibold">{{ toThousand($total ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="intro-y box p-5">
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
                    <div class="text-slate-500 text-sm">Total Piutang</div>
                    <div class="text-xl font-semibold">{{ toThousand($inCompleted ?? 0) }}</div>
                </div>
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
                                Buat Transaksi Baru
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
                                <x-base.menu.item href="{{ route($route . '.export-coretax', $request) }}">
                                    Export ke Coretax
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
                            placeholder="Cari penjualan..." 
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
                    Menampilkan data transaksi penjualan
                </div>
            </div>
        </div>
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
                                    Supir
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
                                        {{ $item['driver']['name'] }}
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
