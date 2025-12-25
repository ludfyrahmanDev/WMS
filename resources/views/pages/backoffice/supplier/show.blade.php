@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- Header Section -->
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-2xl font-bold text-slate-800 mr-auto">{{ $title }}</h2>
        <div class="flex items-center space-x-2">
            <a href="{{ route('supplier.index') }}">
                <x-base.button class="shadow-md" variant="outline-secondary">
                    <x-base.lucide class="w-4 h-4 mr-2" icon="ArrowLeft" />
                    Kembali
                </x-base.button>
            </a>
        </div>
    </div>

    <!-- Supplier Data Card -->
    <div class="intro-y mt-5">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center mb-6 pb-6 border-b border-slate-200">
                <div class="flex items-center justify-center w-16 h-16 bg-orange-100 text-orange-600 rounded-full mr-4">
                    <x-base.lucide class="w-8 h-8" icon="Building" />
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $supplier->name }}</h3>
                    <p class="text-slate-500 text-sm mt-1">Detail Informasi Supplier</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center justify-center w-10 h-10 bg-slate-100 rounded-lg mr-3">
                            <x-base.lucide class="w-5 h-5 text-slate-600" icon="FileText" />
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">NPWP</p>
                            <p class="text-slate-800 font-medium">{{ $supplier->npwp ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center justify-center w-10 h-10 bg-slate-100 rounded-lg mr-3">
                            <x-base.lucide class="w-5 h-5 text-slate-600" icon="Phone" />
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">No. Telepon</p>
                            <p class="text-slate-800 font-medium">{{ $supplier->phone ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center justify-center w-10 h-10 bg-slate-100 rounded-lg mr-3">
                            <x-base.lucide class="w-5 h-5 text-slate-600" icon="User" />
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">PIC (Person In Charge)</p>
                            <p class="text-slate-800 font-medium">{{ $supplier->pic ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center justify-center w-10 h-10 bg-slate-100 rounded-lg mr-3">
                            <x-base.lucide class="w-5 h-5 text-slate-600" icon="MapPin" />
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Alamat</p>
                            <p class="text-slate-800 font-medium">{{ $supplier->address ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center justify-center w-10 h-10 bg-orange-100 rounded-lg mr-3">
                            <x-base.lucide class="w-5 h-5 text-orange-600" icon="ShoppingCart" />
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Delivery Order</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $deliveryOrders->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery Orders Table -->
    <div class="intro-y mt-6">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="p-5 border-b border-slate-200">
                <div class="flex items-center">
                    <x-base.lucide class="w-5 h-5 mr-2 text-slate-600" icon="Package" />
                    <h3 class="text-lg font-semibold text-slate-800">Daftar Delivery Order</h3>
                </div>
                <p class="text-sm text-slate-500 mt-1">Riwayat pembelian dari supplier ini</p>
            </div>

            <div class="overflow-x-auto">
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
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Calendar" />
                                    <span>Tanggal Pembelian</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-right font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center justify-end">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Package" />
                                    <span>Jumlah Qty</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-right font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center justify-end">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="DollarSign" />
                                    <span>Total Harga</span>
                                </div>
                            </x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        @forelse ($deliveryOrders as $index => $item)
                            <x-base.table.tr class="intro-x hover:bg-slate-50 transition-colors duration-200">
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-slate-600 font-medium">
                                    <div class="flex items-center justify-center w-8 h-8 bg-slate-100 rounded-full text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-600 rounded-full mr-3">
                                            <x-base.lucide class="w-5 h-5" icon="Calendar" />
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800">
                                                {{ \Carbon\Carbon::parse($item['purchase_date'])->format('d F Y') }}
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                {{ \Carbon\Carbon::parse($item['purchase_date'])->format('l') }}
                                            </div>
                                        </div>
                                    </div>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-right">
                                    <div class="flex items-center justify-end">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                            {{ number_format($item['total_qty'], 0, ',', '.') }} Kg
                                        </span>
                                    </div>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-right">
                                    <div class="font-semibold text-slate-800 text-lg">
                                        Rp {{ number_format($item['total_price'], 0, ',', '.') }}
                                    </div>
                                </x-base.table.td>
                            </x-base.table.tr>
                        @empty
                            <x-base.table.tr>
                                <x-base.table.td colspan="4" class="py-12 text-center border-b border-slate-200">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-base.lucide class="w-16 h-16 text-slate-300 mb-4" icon="Package" />
                                        <h3 class="text-lg font-medium text-slate-600 mb-2">Tidak ada delivery order</h3>
                                        <p class="text-slate-500">Belum ada transaksi pembelian dari supplier ini</p>
                                    </div>
                                </x-base.table.td>
                            </x-base.table.tr>
                        @endforelse
                    </x-base.table.tbody>
                    @if($deliveryOrders->count() > 0)
                        <x-base.table.tfoot>
                            <x-base.table.tr class="bg-slate-50 font-bold">
                                <x-base.table.td colspan="2" class="py-4 px-6 border-t-2 border-slate-300 text-right text-slate-700">
                                    <span class="text-lg">TOTAL</span>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-t-2 border-slate-300 text-right">
                                    <span class="px-4 py-2 bg-green-200 text-green-800 rounded-full text-base font-bold">
                                        {{ number_format($deliveryOrders->sum('total_qty'), 0, ',', '.') }} Kg
                                    </span>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-t-2 border-slate-300 text-right">
                                    <span class="text-xl text-slate-800">
                                        Rp {{ number_format($deliveryOrders->sum('total_price'), 0, ',', '.') }}
                                    </span>
                                </x-base.table.td>
                            </x-base.table.tr>
                        </x-base.table.tfoot>
                    @endif
                </x-base.table>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="intro-y mt-6 flex justify-end space-x-3">
        <a href="{{ route('supplier.edit', $supplier->id) }}">
            <x-base.button class="shadow-md bg-primary hover:bg-primary/90" variant="primary">
                <x-base.lucide class="w-4 h-4 mr-2" icon="Edit" />
                Edit Supplier
            </x-base.button>
        </a>
    </div>
@endsection
