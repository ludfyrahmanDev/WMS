@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- Modern Header -->
    <div class="flex items-center justify-between mb-8 pt-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ $title }}</h1>
            <p class="text-slate-600 mt-2">Kelola pengeluaran perusahaan dengan sistem keuangan terintegrasi</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-3 rounded-lg text-white shadow-lg">
                <x-base.lucide class="w-6 h-6" icon="TrendingDown" />
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-red-500 to-red-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm">Total Pengeluaran</p>
                    <p class="text-2xl font-bold">{{ toThousand($totalSpending ?? 0) }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-red-200" icon="TrendingDown" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Transaksi Bulan Ini</p>
                    <p class="text-2xl font-bold">{{ $data->where('created_at', '>=', now()->startOfMonth())->count() ?? 0 }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-orange-200" icon="Calendar" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Rata-rata Harian</p>
                    <p class="text-2xl font-bold">{{ toThousand(($totalSpending ?? 0) / 30) }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-purple-200" icon="BarChart3" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Kategori</p>
                    <p class="text-2xl font-bold">{{ $data->unique('spending_category_id')->count() ?? 0 }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-blue-200" icon="Layers" />
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
                                Tambah Data Pengeluaran
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
                    Menampilkan 1 hingga {{ $data->total() < 10 ? $data->total() : 10 }} dari {{ $data->total() }} data
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
                                        {{ toThousand(abs($payables ?? 0)) }}
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
                                            {{ $item['spending_category']['spending_category'] ?? 'N/A' }}
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
                                        isset($item['type']) && in_array($item['type'], ['vehicle_service', 'transport_income', 'drivers_pocket', 'profit_summary', 'receivables_summary', 'payables_summary'])
                                    )
                                        <span class="text-slate-400 text-sm">
                                            @if($item['type'] == 'profit_summary')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <x-base.lucide class="h-3 w-3 mr-1" icon="TrendingUp" />
                                                    Summary
                                                </span>
                                            @elseif($item['type'] == 'receivables_summary')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <x-base.lucide class="h-3 w-3 mr-1" icon="Clock" />
                                                    Summary
                                                </span>
                                            @elseif($item['type'] == 'payables_summary')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <x-base.lucide class="h-3 w-3 mr-1" icon="AlertCircle" />
                                                    Summary
                                                </span>
                                            @else
                                                Auto
                                            @endif
                                        </span>
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
                this.style.transition = 'all 0.2s ease';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
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

        // Financial data enhancements for Neraca section
        const neracaTables = document.querySelectorAll('table');
        neracaTables.forEach(table => {
            if (table.querySelector('th[class*="bg-primary"]')) {
                // Add subtle animations to financial data
                const cells = table.querySelectorAll('td');
                cells.forEach((cell, index) => {
                    cell.style.animation = `fadeInUp 0.5s ease-in-out ${index * 0.1}s both`;
                });
            }
        });
    });

    // Add CSS animations for financial data
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
