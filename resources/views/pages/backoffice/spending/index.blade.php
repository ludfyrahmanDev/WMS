@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <h2 class="intro-y mt-10 text-lg font-medium">{{ $title }}</h2>
    @if (session('success'))
        <x-base.alert class="mb-2 mt-5 flex items-center" variant="outline-success">
            <x-base.lucide class="mr-2 h-6 w-6" icon="AlertOctagon" />
            {{ session('success') }}
            <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
    @if (session('failed'))
        <x-base.alert class="mb-2 flex items-center" variant="outline-danger">
            <x-base.lucide class="mr-2 h-6 w-6" icon="AlertOctagon" />
            {{ session('failed') }}
            <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 mt-2 flex flex-wrap items-center sm:flex-nowrap">
            <a href="{{ route($route . '.create') }}">
                <x-base.button class="mr-2 shadow-md" variant="primary">
                    Add Data
                </x-base.button>
            </a>
            <x-base.menu>
                <x-base.menu.button class="!box px-2" as="x-base.button">
                    <span class="flex h-5 w-5 items-center justify-center">
                        <x-base.lucide class="h-4 w-4" icon="file" />
                    </span>
                </x-base.menu.button>
                <x-base.menu.items class="w-40">
                    <x-base.menu.item href="{{ route($route . '.export', $request) }}" target="_blank">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="sheet" /> Export to Excel
                    </x-base.menu.item>
                    <x-base.menu.item href="{{ route($route . '.export-pdf', $request) }}">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" /> Export to PDF
                    </x-base.menu.item>
                </x-base.menu.items>
            </x-base.menu>
            <div class="mx-auto hidden text-slate-500 md:block">
                Showing 1 to {{ $data->total() < 10 ? $data->total() : 10 }} of {{ $data->total() }} entries
            </div>
            <div class="mt-3 w-full flex sm:mt-0 sm:ml-auto sm:w-auto md:ml-0">
                <div class=" flex w-72">
                    <x-base.form-input  class="datepicker !box mr-4 sm:w-56" id="start_date" type="date"
                        value="{{ $request['start_date'] ?? old('start_date') }}" required placeholder="Tanggal Mulai" />
                    <x-base.form-input  class="datepicker !box mr-4 sm:w-56" id="end_date" type="date"
                        value="{{ $request['end_date'] ?? old('end_date') }}" required placeholder="Tanggal Mulai" />
                </div>
                {{-- make live search --}}
                <div class="relative w-56 text-slate-500">
                    <x-base.form-input class="!box w-56 pr-10" type="text" id="search"
                        value="{{ request()->get('search') }}" placeholder="Search..." />
                    <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4" icon="Search" />
                </div>
            </div>
        </div>


        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            
            <!-- BEGIN: Neraca -->
            <div class="mt-8">
                <div class="text-xl text-primary font-bold mb-5">
                    <h3>NERACA</h3>
                    <p class="text-sm text-slate-500 font-normal">Per {{ date('d F Y') }}</p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- AKTIVA -->
                    <div class="intro-y">
                        <x-base.table class="border-separate border-spacing-y-[2px]">
                            <x-base.table.thead>
                                <x-base.table.tr>
                                    <x-base.table.th class="bg-primary text-white text-center font-bold text-lg" colspan="2">
                                        AKTIVA
                                    </x-base.table.th>
                                </x-base.table.tr>
                            </x-base.table.thead>
                            <x-base.table.tbody>
                                <!-- Aktiva Lancar -->
                                <x-base.table.tr>
                                    <x-base.table.td class="bg-slate-100 font-bold text-center" colspan="2">
                                        AKTIVA LANCAR
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Kas & Bank
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand($saldo ?? 0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Piutang Dagang
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand($sellingInCompleted ?? 0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Persediaan Barang
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand($inventoryValue ?? 0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Piutang Ongkos Kirim
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand($transportRevenue ?? 0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr class="border-t-2 border-primary">
                                    <x-base.table.td class="bg-slate-50 font-bold">
                                        Total Aktiva Lancar
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-slate-50 text-right font-bold">
                                        {{ toThousand(($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0) + ($transportRevenue ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                
                                <!-- Aktiva Tetap -->
                                <x-base.table.tr>
                                    <x-base.table.td class="bg-slate-100 font-bold text-center" colspan="2">
                                        AKTIVA TETAP
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Kendaraan & Peralatan
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand(0) }} {{-- Nilai aset tetap perlu dihitung --}}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr class="border-t-2 border-primary">
                                    <x-base.table.td class="bg-slate-50 font-bold">
                                        Total Aktiva Tetap
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-slate-50 text-right font-bold">
                                        {{ toThousand(0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                
                                <!-- Total Aktiva -->
                                <x-base.table.tr class="border-t-4 border-primary">
                                    <x-base.table.td class="bg-primary text-white font-bold text-lg">
                                        TOTAL AKTIVA
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-primary text-white text-right font-bold text-lg">
                                        {{ toThousand(($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0) + ($transportRevenue ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                            </x-base.table.tbody>
                        </x-base.table>
                    </div>
                    
                    <!-- PASSIVA -->
                    <div class="intro-y">
                        <x-base.table class="border-separate border-spacing-y-[2px]">
                            <x-base.table.thead>
                                <x-base.table.tr>
                                    <x-base.table.th class="bg-danger text-white text-center font-bold text-lg" colspan="2">
                                        PASSIVA
                                    </x-base.table.th>
                                </x-base.table.tr>
                            </x-base.table.thead>
                            <x-base.table.tbody>
                                <!-- Kewajiban -->
                                <x-base.table.tr>
                                    <x-base.table.td class="bg-slate-100 font-bold text-center" colspan="2">
                                        KEWAJIBAN
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Hutang Dagang
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand(abs($purchaseInCompleted ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Biaya Servis Kendaraan
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand($vehicleServiceExpense ?? 0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Biaya Saku Sopir
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand($driversPocketMoney ?? 0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Hutang Lain-lain
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand(0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr class="border-t-2 border-danger">
                                    <x-base.table.td class="bg-slate-50 font-bold">
                                        Total Kewajiban
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-slate-50 text-right font-bold">
                                        {{ toThousand(abs($purchaseInCompleted ?? 0) + ($vehicleServiceExpense ?? 0) + ($driversPocketMoney ?? 0)) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                
                                <!-- Modal -->
                                <x-base.table.tr>
                                    <x-base.table.td class="bg-slate-100 font-bold text-center" colspan="2">
                                        MODAL
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Modal Pemilik
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand((($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0) + ($transportRevenue ?? 0)) - (abs($purchaseInCompleted ?? 0) + ($vehicleServiceExpense ?? 0) + ($driversPocketMoney ?? 0))) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr>
                                    <x-base.table.td class="border-b bg-white pl-6">
                                        Laba Ditahan
                                    </x-base.table.td>
                                    <x-base.table.td class="border-b bg-white text-right font-medium">
                                        {{ toThousand(0) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                <x-base.table.tr class="border-t-2 border-danger">
                                    <x-base.table.td class="bg-slate-50 font-bold">
                                        Total Modal
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-slate-50 text-right font-bold">
                                        {{ toThousand((($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0) + ($transportRevenue ?? 0)) - (abs($purchaseInCompleted ?? 0) + ($vehicleServiceExpense ?? 0) + ($driversPocketMoney ?? 0))) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                                
                                <!-- Total Passiva -->
                                <x-base.table.tr class="border-t-4 border-danger">
                                    <x-base.table.td class="bg-danger text-white font-bold text-lg">
                                        TOTAL PASSIVA
                                    </x-base.table.td>
                                    <x-base.table.td class="bg-danger text-white text-right font-bold text-lg">
                                        {{ toThousand((abs($purchaseInCompleted ?? 0) + ($vehicleServiceExpense ?? 0) + ($driversPocketMoney ?? 0)) + ((($saldo ?? 0) + ($sellingInCompleted ?? 0) + ($inventoryValue ?? 0) + ($transportRevenue ?? 0)) - (abs($purchaseInCompleted ?? 0) + ($vehicleServiceExpense ?? 0) + ($driversPocketMoney ?? 0)))) }}
                                    </x-base.table.td>
                                </x-base.table.tr>
                            </x-base.table.tbody>
                        </x-base.table>
                    </div>
                </div>
            </div>
            <!-- END: Neraca -->
            
            <div class="mt-8">
                <div class="text-xl text-primary font-bold mb-2">
                    <h3>Laporan Kas/ Bank Harian</h3>
                </div>
                <div class="bg-slate-50 rounded-lg p-4 mb-6">
                    <p class="text-slate-700 font-medium mb-3">Keterangan Warna Laporan Kas:</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <!-- Debit -->
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-600 rounded-full mr-3"></div>
                            <div>
                                <span class="font-semibold text-green-700">DEBIT (Pemasukan)</span>
                                <p class="text-xs text-slate-500">Semua jenis pemasukan</p>
                            </div>
                        </div>
                        
                        <!-- Kredit -->
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-600 rounded-full mr-3"></div>
                            <div>
                                <span class="font-semibold text-red-700">KREDIT (Pengeluaran)</span>
                                <p class="text-xs text-slate-500">Semua jenis pengeluaran</p>
                            </div>
                        </div>
                        
                        <!-- Saldo -->
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-blue-600 rounded-full mr-3"></div>
                            <div>
                                <span class="font-semibold text-blue-700">SALDO BERJALAN</span>
                                <p class="text-xs text-slate-500">Saldo setelah setiap transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Card Pemasukan -->
                    <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-xl">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white bg-opacity-10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="relative p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                    <x-base.lucide class="h-8 w-8 text-white" icon="TrendingUp" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-white text-lg font-bold">Total Pemasukan</h3>
                                    <p class="text-green-100 text-sm">Debet</p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-3xl font-bold text-white mb-2">
                                    {{ toThousand(($income ?? 0) + ($sellingCompleted ?? 0) + ($transportRevenue ?? 0)) }}
                                </p>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-green-100">
                                    <span>• Penjualan & Lainnya</span>
                                    <span class="font-medium">{{ toThousand(($income ?? 0) + ($sellingCompleted ?? 0)) }}</span>
                                </div>
                                <div class="flex justify-between text-green-100">
                                    <span>• Ongkos Kirim</span>
                                    <span class="font-medium">{{ toThousand($transportRevenue ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Pengeluaran -->
                    <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl shadow-xl">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white bg-opacity-10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="relative p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                    <x-base.lucide class="h-8 w-8 text-white" icon="TrendingDown" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-white text-lg font-bold">Total Pengeluaran</h3>
                                    <p class="text-red-100 text-sm">Kredit</p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-3xl font-bold text-white mb-2">
                                    {{ toThousand(($outcome ?? 0) + ($purchaseCompleted ?? 0) + ($vehicleServiceExpense ?? 0) + ($driversPocketMoney ?? 0)) }}
                                </p>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-red-100">
                                    <span>• Operasional & Pembelian</span>
                                    <span class="font-medium">{{ toThousand(($outcome ?? 0) + ($purchaseCompleted ?? 0)) }}</span>
                                </div>
                                <div class="flex justify-between text-red-100">
                                    <span>• Servis & Saku Sopir</span>
                                    <span class="font-medium">{{ toThousand(($vehicleServiceExpense ?? 0) + ($driversPocketMoney ?? 0)) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Card Saldo Kas -->
                    <div class="relative overflow-hidden bg-gradient-to-br {{ ($saldo ?? 0) >= 0 ? 'from-blue-500 to-cyan-600' : 'from-orange-500 to-red-600' }} rounded-2xl shadow-xl">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white bg-opacity-10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="relative p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                    <x-base.lucide class="h-8 w-8 text-white" icon="Wallet" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-white text-lg font-bold">Saldo Kas</h3>
                                    <p class="{{ ($saldo ?? 0) >= 0 ? 'text-blue-100' : 'text-orange-100' }} text-sm">
                                        {{ ($saldo ?? 0) >= 0 ? 'Kondisi Sehat' : 'Perlu Perhatian' }}
                                    </p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-3xl font-bold text-white mb-2">
                                    {{ toThousand($saldo ?? 0) }}
                                </p>
                            </div>
                            <div class="text-sm {{ ($saldo ?? 0) >= 0 ? 'text-blue-100' : 'text-orange-100' }}">
                                <div class="flex justify-between">
                                    <span>Status:</span>
                                    <span class="font-medium">{{ ($saldo ?? 0) >= 0 ? '✓ Positif' : '⚠ Negatif' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                Debet (Masuk)
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Kredit (Keluar)
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Saldo
                            </x-base.table.th>
                            <x-base.table.th class="text-center border-b border-slate-200 py-3 px-4 font-semibold">
                                Aksi
                            </x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        @php $runningBalance = 0; @endphp
                        @foreach ($data as $index=> $item)
                            @php 
                                if(is_object($item)) {
                                    // check item has toArray method
                                    if(method_exists($item, 'toArray')) {
                                        $item = $item->toArray();
                                    } else {
                                        $item = (array) $item;
                                    }
                                }
                                
                                if($item['mutation'] == 'Uang Masuk') {
                                    $runningBalance += $item['nominal'];
                                } else {
                                    $runningBalance -= $item['nominal'];
                                }
                            @endphp
                            <x-base.table.tr class="hover:bg-slate-50">
                                <x-base.table.td class="text-center border-b border-slate-100 py-3 px-4">
                                    {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                                </x-base.table.td>
                                <x-base.table.td class="text-center border-b border-slate-100 py-3 px-4">
                                    {{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}
                                </x-base.table.td>
                                <x-base.table.td class="border-b border-slate-100 py-3 px-4">
                                    <div class="font-medium">{{ $item['description'] }}</div>
                                    <div class="text-sm text-slate-500">
                                        @if(isset($item['spendingCategory']) && is_array($item['spendingCategory']))
                                            {{ $item['spendingCategory']['spending_category'] }}
                                        @elseif(isset($item['spendingCategory']) && is_object($item['spendingCategory']))
                                            {{ $item['spendingCategory']->spending_category }}
                                        @else
                                            {{ $item['spendingCategory']['spending_category'] ?? 'N/A' }}
                                        @endif
                                        @if(isset($item['payment_method']))
                                         | {{ $item['payment_method'] }}
                                        @endif
                                    </div>
                                </x-base.table.td>
                                <x-base.table.td class="text-right border-b border-slate-100 py-3 px-4">
                                    @if($item['mutation'] == 'Uang Masuk')
                                        <span class="font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                                            {{ toThousand($item['nominal']) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </x-base.table.td>
                                <x-base.table.td class="text-right border-b border-slate-100 py-3 px-4">
                                    @if($item['mutation'] == 'Uang Keluar')
                                        <span class="font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full">
                                            {{ toThousand($item['nominal']) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </x-base.table.td>
                                <x-base.table.td class="text-right border-b border-slate-100 py-3 px-4">
                                    <span class="font-bold {{ $runningBalance >= 0 ? 'text-blue-600 bg-blue-50' : 'text-red-600 bg-red-50' }} px-3 py-1 rounded-full">
                                        {{ toThousand($runningBalance) }}
                                    </span>
                                </x-base.table.td>
                                <x-base.table.td class="text-center border-b border-slate-100 py-3 px-4">
                                    @if (
                                        isset($item['type']) && in_array($item['type'], ['vehicle_service', 'transport_income', 'drivers_pocket'])
                                    )
                                        <span class="text-slate-400 text-sm">Auto</span>
                                    @elseif (
                                        isset($item['spendingCategory']) &&
                                        (
                                            (is_array($item['spendingCategory']) && $item['spendingCategory']['spending_category'] != 'Saldo Utama' && $item['spendingCategory']['spending_category'] != 'Saldo Kendaraan') ||
                                            (is_object($item['spendingCategory']) && $item['spendingCategory']->spending_category != 'Saldo Utama' && $item['spendingCategory']->spending_category != 'Saldo Kendaraan')
                                        )
                                    )
                                        <div class="flex items-center justify-center space-x-2">
                                            <a class="text-blue-600 hover:text-blue-800 text-sm" href="{{ route('spending.edit', $item['id']) }}">
                                                <x-base.lucide class="h-4 w-4" icon="Edit" />
                                            </a>
                                            <a class="text-red-600 hover:text-red-800 text-sm" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal-{{ $item['id'] }}" href="#">
                                                <x-base.lucide class="h-4 w-4" icon="Trash2" />
                                            </a>
                                        </div>
                                        <x-base.dialog id="delete-confirmation-modal-{{ $item['id'] }}">
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
                                                    <form action="{{ route('spending.destroy', $item['id']) }}" method="post"
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
                                    @else
                                        <span class="text-slate-400 text-sm">-</span>
                                    @endif
                                </x-base.table.td>
                            </x-base.table.tr>
                        @endforeach
                        
                        <!-- Total Row -->
                        @if($data->isNotEmpty()):
                            <x-base.table.tr class="bg-slate-100 font-bold ">
                                <x-base.table.td class="text-center border-t-2 border-slate-300 py-4 px-4" colspan="3">
                                    <strong>TOTAL</strong>
                                </x-base.table.td>
                                <x-base.table.td class="text-right border-t-2 border-slate-300 py-4 px-4">
                                    @php
                                        $totalIncome = $data->filter(function($item) { 
                                            return isset($item->mutation) && $item->mutation == 'Uang Masuk'; 
                                        })->sum(function($item) {
                                            return isset($item->nominal) ? $item->nominal : 0;
                                        });
                                    @endphp
                                    <strong class="text-green-600 bg-green-50 px-3 py-1 rounded-full">{{ toThousand($totalIncome) }}</strong>
                                </x-base.table.td>
                                <x-base.table.td class="text-right border-t-2 border-slate-300 py-4 px-4">
                                    @php
                                        $totalOutcome = $data->filter(function($item) { 
                                            return isset($item->mutation) && $item->mutation == 'Uang Keluar'; 
                                        })->sum(function($item) {
                                            return isset($item->nominal) ? $item->nominal : 0;
                                        });
                                    @endphp
                                    <strong class="text-red-600 bg-red-50 px-3 py-1 rounded-full">{{ toThousand($totalOutcome) }}</strong>
                                </x-base.table.td>
                                <x-base.table.td class="text-right border-t-2 border-slate-300 py-4 px-4">
                                    @php
                                        $finalBalance = $totalIncome - $totalOutcome;
                                    @endphp
                                    <strong class="{{ $finalBalance >= 0 ? 'text-blue-600 bg-blue-50' : 'text-red-600 bg-red-50' }} px-3 py-1 rounded-full">
                                        {{ toThousand($finalBalance) }}
                                    </strong>
                                </x-base.table.td>
                                <x-base.table.td class="border-t-2 border-slate-300 py-4 px-4"></x-base.table.td>
                            </x-base.table.tr>
                        @endif
                    </x-base.table.tbody>
                    @if ($data->isEmpty())
                        <x-base.table.tbody>
                            <x-base.table.tr>
                                <x-base.table.td class="text-center py-8 border-b border-slate-100" colspan="7">
                                    <div class="flex flex-col justify-center items-center">
                                        <x-base.lucide class="h-16 w-16 text-slate-400 mb-3" icon="Inbox" />
                                        <div class="text-slate-500 text-lg font-medium">
                                            Tidak ada data transaksi
                                        </div>
                                        <div class="text-slate-400 text-sm mt-1">
                                            Silakan tambah transaksi baru untuk melihat laporan kas
                                        </div>
                                    </div>
                                </x-base.table.td>
                            </x-base.table.tr>
                        </x-base.table.tbody>
                    @endif
                </x-base.table>
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
