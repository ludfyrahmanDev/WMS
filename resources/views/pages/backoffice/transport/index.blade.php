@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    @php
        // Pisahkan data cash dan transfer
        $cash = $data->filter(fn($item) => ($item['type'] ?? 'cash') == 'cash');
        $transfer = $data->filter(fn($item) => ($item['type'] ?? '') == 'transfer');

        $totalOngkosCash = $cash->sum('ongkosan');
        $totalSakuSopirCash = $cash->sum('drivers_pocket_money');
        $totalSetoranCash = $totalOngkosCash - $totalSakuSopirCash;

        $totalOngkosTransfer = $transfer->sum('ongkosan');
        $totalSakuSopirTransfer = $transfer->sum('drivers_pocket_money');
        $totalSetoranTransfer = $totalOngkosTransfer - $totalSakuSopirTransfer;
    @endphp

    <div class="mt-8">
        <h2 class="text-2xl font-bold">Data Transport</h2>
        <p class="text-slate-500 mt-1">Kelola data transport dan pengiriman</p>
    </div>

    <!-- Statistics Cards -->
    <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="intro-y box p-5">
            <h4 class="text-lg font-bold mb-2 text-green-700">Statistik Cash</h4>
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span>Total Transport Cash</span>
                    <span class="font-semibold">{{ $cash->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Total Ongkos Cash</span>
                    <span class="font-semibold text-green-600">{{ toThousand($totalOngkosCash) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Total Saku Sopir Cash</span>
                    <span class="font-semibold text-orange-600">{{ toThousand($totalSakuSopirCash) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Total Setoran Cash</span>
                    <span class="font-semibold text-purple-600">{{ toThousand($totalSetoranCash) }}</span>
                </div>
            </div>
        </div>
        <div class="intro-y box p-5">
            <h4 class="text-lg font-bold mb-2 text-blue-700">Statistik Transfer</h4>
            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span>Total Transport Transfer</span>
                    <span class="font-semibold">{{ $transfer->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Total Ongkos Transfer</span>
                    <span class="font-semibold text-green-600">{{ toThousand($totalOngkosTransfer) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Total Saku Sopir Transfer</span>
                    <span class="font-semibold text-orange-600">{{ toThousand($totalSakuSopirTransfer) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Total Setoran Transfer</span>
                    <span class="font-semibold text-purple-600">{{ toThousand($totalSetoranTransfer) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Neraca Angkutan -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold mb-4">Neraca Angkutan Cash & Transfer</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Neraca Cash -->
            <div class="intro-y box p-5 bg-gradient-to-br from-green-50 to-green-100 border-green-200">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-green-900">Neraca Cash</h4>
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                        <x-base.lucide class="h-6 w-6 text-white" icon="Landmark" />
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <span class="text-sm text-slate-600">Ongkosan Cash</span>
                        <span class="font-semibold text-green-700">{{ toThousand($totalOngkosCash) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <span class="text-sm text-slate-600">Saku Sopir Cash</span>
                        <span class="font-semibold text-orange-700">{{ toThousand($totalSakuSopirCash) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <span class="font-bold text-green-900">Total Setoran Cash</span>
                        <span class="text-xl font-bold text-green-900">{{ toThousand($totalSetoranCash) }}</span>
                    </div>
                </div>
            </div>
            <!-- Neraca Transfer -->
            <div class="intro-y box p-5 bg-gradient-to-br from-blue-50 to-blue-100 border-blue-200">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-lg font-semibold text-blue-900">Neraca Transfer</h4>
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                        <x-base.lucide class="h-6 w-6 text-white" icon="FileText" />
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <span class="text-sm text-slate-600">Ongkosan Transfer</span>
                        <span class="font-semibold text-green-700">{{ toThousand($totalOngkosTransfer) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <span class="text-sm text-slate-600">Saku Sopir Transfer</span>
                        <span class="font-semibold text-orange-700">{{ toThousand($totalSakuSopirTransfer) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                        <span class="font-bold text-blue-900">Total Setoran Transfer</span>
                        <span class="text-xl font-bold text-blue-900">{{ toThousand($totalSetoranTransfer) }}</span>
                    </div>
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
                            <x-base.button class="mr-2 shadow-md" variant="primary">
                                Tambah Transport
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
                    <form method="GET" action="" class="flex flex-col sm:flex-row gap-3 lg:w-auto w-full">
                        <x-base.form-input class="!box w-full sm:w-56" type="text" name="search" id="search"
                            value="{{ request()->get('search') }}" placeholder="Cari transport..." />
                        <select name="nopol" class="!box w-full sm:w-40">
                            <option value="">- Semua Nopol -</option>
                            @foreach(\App\Models\Vehicle::all() as $v)
                                <option value="{{ $v->id }}" @if(request('nopol') == $v->id) selected @endif>{{ $v->license_plate }}</option>
                            @endforeach
                        </select>
                        <x-base.form-input class="!box" name="start_date" id="start_date" type="date"
                            value="{{ $request['start_date'] ?? old('start_date') }}" />
                        <x-base.form-input class="!box" name="end_date" id="end_date" type="date"
                            value="{{ $request['end_date'] ?? old('end_date') }}" />
                        <x-base.button class="mr-2 shadow-md" variant="primary">
                            Filter
                        </x-base.button>
                    </form>
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
                    <h3 class="text-lg font-semibold">Daftar Transport</h3>
                </div>

                <!-- Table Content -->
                <div class="">
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
                                    Nopol
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Pengemudi
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Penerima
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Ongkosan
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Saku Sopir
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Setoran
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
                                    <x-base.table.td class="text-center py-4">
                                        {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        {{ date('d M Y', strtotime($item['date'])) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4 font-semibold">
                                        {{ $item['vehicle']['license_plate'] }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        {{ $item['driver']['name'] ?? '-' }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        {{ $item['customer'] }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4 font-semibold text-green-600">
                                        {{ toThousand($item['ongkosan']) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4 font-semibold text-orange-600">
                                        {{ toThousand($item['drivers_pocket_money']) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4 font-semibold text-blue-600">
                                        {{ toThousand($item['setoran']) }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        @php
                                            $statusColor = match ($item['status']) {
                                                'Pending' => 'text-yellow-600',
                                                'On Progress' => 'text-blue-600',
                                                'Completed' => 'text-green-600',
                                                default => 'text-gray-600',
                                            };
                                        @endphp
                                        <span class="{{ $statusColor }} font-medium">{{ $item['status'] }}</span>
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            @if ($item['status'] == 'In Progress')
                                                <x-base.button size="sm" variant="success" data-tw-toggle="modal"
                                                    data-tw-target="#status-confirmation-modal-{{ $item->id }}">
                                                    Konfirmasi
                                                </x-base.button>
                                                <x-base.button size="sm" variant="outline-warning" as="a"
                                                    href="{{ route('transport.edit', $item->id) }}">
                                                    Edit
                                                </x-base.button>
                                                <x-base.button size="sm" variant="outline-danger"
                                                    data-tw-toggle="modal"
                                                    data-tw-target="#delete-confirmation-modal-{{ $item->id }}">
                                                    Hapus
                                                </x-base.button>
                                            @elseif ($item['status'] == 'Completed')
                                                <x-base.button size="sm" variant="outline-primary" as="a"
                                                    href="{{ route($route . '.show', $item->id) }}">
                                                    Detail
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
                                                            <strong>Customer:</strong> {{ $item['customer'] }}<br>
                                                            <strong>Tanggal:</strong>
                                                            {{ date('d M Y', strtotime($item['date'])) }}
                                                        </div>
                                                    </div>
                                                    <p class="text-xs text-red-600">
                                                        Tindakan ini tidak dapat dibatalkan
                                                    </p>
                                                </div>
                                                <div class="px-8 pb-8 flex justify-center gap-3">
                                                    <x-base.button data-tw-dismiss="modal" type="button"
                                                        variant="outline-secondary">
                                                        Batal
                                                    </x-base.button>
                                                    <form action="{{ route('transport.destroy', $item->id) }}"
                                                        method="post">
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
                                                        Apakah Anda yakin ingin mengkonfirmasi pembayaran untuk penjualan
                                                        ini?
                                                    </p>
                                                    <div class="bg-slate-50 p-3 rounded mb-4">
                                                        <div class="text-sm text-slate-600">
                                                            <strong>Customer:</strong> {{ $item['customer'] }}<br>
                                                            <strong>Tanggal:</strong>
                                                            {{ date('d M Y', strtotime($item['date'])) }}<br>
                                                            <strong>Status akan berubah menjadi:</strong> <span
                                                                class="text-green-600 font-semibold">Completed</span>
                                                        </div>
                                                    </div>
                                                    {{-- <p class="text-xs text-blue-600">
                                                        Pastikan pembayaran sudah diterima sebelum konfirmasi
                                                    </p> --}}
                                                </div>
                                                <div class="px-8 pb-8 flex justify-center gap-3">
                                                    <x-base.button data-tw-dismiss="modal" type="button"
                                                        variant="outline-secondary">
                                                        Batal
                                                    </x-base.button>
                                                    <form action="{{ route($route . '.update', $item->id) }}"
                                                        method="post">
                                                        @method('PUT')
                                                        @csrf
                                                        <input type="hidden" name="mode" value="Konfirmasi">
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
                                    <x-base.table.td colspan="10" class="py-16 text-center">
                                        <div>
                                            <h3 class="text-lg font-semibold mb-2">Belum Ada Data Transport</h3>
                                            <p class="text-slate-500 mb-4">
                                                Belum ada data transport yang tercatat.
                                            </p>
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
@endsection
