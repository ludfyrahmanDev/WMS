@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Detail Penjualan</h2>
                <p class="mt-1 text-slate-500">Informasi lengkap transaksi penjualan</p>
            </div>
            <div class="flex items-center gap-2">
                <x-base.button variant="outline-secondary" onclick="window.history.back()">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" />
                    Kembali
                </x-base.button>
                <x-base.button variant="primary" onclick="window.location.href='{{ route('selling.coretax-preview', $data['header']->id) }}'">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" />
                    Export to Coretax
                </x-base.button>
            </div>
        </div>

        @if (session('failed'))
            <x-base.alert class="flex items-center" variant="outline-danger">
                <x-base.lucide class="mr-2 h-5 w-5" icon="AlertCircle" />
                {{ session('failed') }}
                <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                    <x-base.lucide class="h-4 w-4" icon="X" />
                </x-base.alert.dismiss-button>
            </x-base.alert>
        @endif

        @if (session('success'))
            <x-base.alert class="flex items-center" variant="outline-success">
                <x-base.lucide class="mr-2 h-5 w-5" icon="CheckCircle" />
                {{ session('success') }}
                <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                    <x-base.lucide class="h-4 w-4" icon="X" />
                </x-base.alert.dismiss-button>
            </x-base.alert>
        @endif
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">

        <div class="intro-y col-span-12 lg:col-span-12">
            <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($type != 'create')
                    @method('PUT')
                @endif
                
                <!-- Status Card -->
                <div class="intro-y mb-5 rounded-lg border border-slate-200 bg-white p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full {{ $data['header']->status == 'completed' ? 'bg-success/20' : 'bg-warning/20' }}">
                                <x-base.lucide 
                                    class="h-6 w-6 {{ $data['header']->status == 'completed' ? 'text-success' : 'text-warning' }}" 
                                    icon="{{ $data['header']->status == 'completed' ? 'CheckCircle' : 'Clock' }}" 
                                />
                            </div>
                            <div>
                                <div class="text-xs font-medium text-slate-500">STATUS TRANSAKSI</div>
                                <div class="mt-1 text-xl font-bold {{ $data['header']->status == 'completed' ? 'text-success' : 'text-warning' }}">
                                    {{ $data['header']->status == 'completed' ? 'Selesai' : 'Dalam Proses' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-medium text-slate-500">NO. TRANSAKSI</div>
                            <div class="mt-1 text-lg font-bold text-slate-700">#{{ $data['header']->id }}</div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Info -->
                <div class="intro-y mb-5 rounded-lg border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 p-5">
                        <h3 class="flex items-center text-base font-medium">
                            <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="FileText" />
                            Informasi Transaksi
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 lg:col-span-4">
                                <div class="rounded-lg bg-slate-50 p-4 transition-all hover:shadow-md">
                                    <div class="mb-2 flex items-center text-xs font-medium text-slate-500">
                                        <x-base.lucide class="mr-1 h-3 w-3" icon="Calendar" />
                                        TANGGAL PENJUALAN
                                    </div>
                                    <div class="text-base font-semibold text-slate-700">
                                        {{ \Carbon\Carbon::parse($data['header']->date)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-4">
                                <div class="rounded-lg bg-slate-50 p-4 transition-all hover:shadow-md">
                                    <div class="mb-2 flex items-center text-xs font-medium text-slate-500">
                                        <x-base.lucide class="mr-1 h-3 w-3" icon="User" />
                                        PELANGGAN
                                    </div>
                                    <div class="text-base font-semibold text-slate-700">
                                        {{ $data['customer']->where('id', $data['header']->customer_id)->first()->name ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-4">
                                <div class="rounded-lg bg-slate-50 p-4 transition-all hover:shadow-md">
                                    <div class="mb-2 flex items-center text-xs font-medium text-slate-500">
                                        <x-base.lucide class="mr-1 h-3 w-3" icon="Building2" />
                                        PERUSAHAAN
                                    </div>
                                    <div class="text-base font-semibold text-slate-700">
                                        {{ session('cv_name') ?? 'CV Default' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="intro-y mb-5 rounded-lg border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 p-5">
                        <h3 class="flex items-center text-base font-medium">
                            <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="CreditCard" />
                            Informasi Pembayaran
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 lg:col-span-6">
                                <div class="rounded-lg bg-primary/10 p-4">
                                    <div class="mb-2 flex items-center text-xs font-medium text-primary">
                                        <x-base.lucide class="mr-1 h-3 w-3" icon="ShoppingCart" />
                                        TIPE PEMBELIAN
                                    </div>
                                    <div class="text-base font-semibold text-slate-700">
                                        @if($data['header']->purchasing_method == 'tempo')
                                            <span class="inline-flex items-center rounded-full bg-warning/20 px-3 py-1 text-warning">
                                                <x-base.lucide class="mr-1 h-3 w-3" icon="Clock" />
                                                Tempo Panjang
                                            </span>
                                        @elseif($data['header']->purchasing_method == 'titipan')
                                            <span class="inline-flex items-center rounded-full bg-info/20 px-3 py-1 text-info">
                                                <x-base.lucide class="mr-1 h-3 w-3" icon="Package" />
                                                Titipan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-success/20 px-3 py-1 text-success">
                                                <x-base.lucide class="mr-1 h-3 w-3" icon="CheckCircle" />
                                                Kontan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-6">
                                <div class="rounded-lg bg-primary/10 p-4">
                                    <div class="mb-2 flex items-center text-xs font-medium text-primary">
                                        <x-base.lucide class="mr-1 h-3 w-3" icon="Wallet" />
                                        METODE PEMBAYARAN
                                    </div>
                                    <div class="text-base font-semibold text-slate-700">
                                        @if($data['header']->payment_type == 'cash')
                                            <span class="inline-flex items-center rounded-full bg-success/20 px-3 py-1 text-success">
                                                <x-base.lucide class="mr-1 h-3 w-3" icon="Banknote" />
                                                Cash
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-primary/20 px-3 py-1 text-primary">
                                                <x-base.lucide class="mr-1 h-3 w-3" icon="CreditCard" />
                                                Transfer
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($data['header']->notes)
                            <div class="col-span-12">
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <div class="mb-2 flex items-center text-xs font-medium text-slate-500">
                                        <x-base.lucide class="mr-1 h-3 w-3" icon="FileText" />
                                        CATATAN
                                    </div>
                                    <div class="text-sm text-slate-600">
                                        {{ $data['header']->notes }}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <!-- Products Table -->
                <div class="intro-y mb-5 rounded-lg border border-slate-200 bg-white">
                    <div class="border-b border-slate-200 p-5">
                        <h3 class="flex items-center text-base font-medium">
                            <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="Package" />
                            Daftar Produk
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                                        <div class="flex items-center">
                                            <x-base.lucide class="mr-2 h-4 w-4" icon="Box" />
                                            Produk
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-600">
                                        <div class="flex items-center justify-center">
                                            <x-base.lucide class="mr-2 h-4 w-4" icon="Hash" />
                                            Qty
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">
                                        <div class="flex items-center justify-end">
                                            <x-base.lucide class="mr-2 h-4 w-4" icon="DollarSign" />
                                            Harga Jual
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">
                                        <div class="flex items-center justify-end">
                                            <x-base.lucide class="mr-2 h-4 w-4" icon="Calculator" />
                                            Subtotal
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @if (isset($data['detail']) && count($data['detail']) > 0)
                                    @foreach ($data['detail'] as $index => $item)
                                        <tr class="transition-colors hover:bg-slate-50">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                                        <span class="font-bold">{{ $index + 1 }}</span>
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="font-medium text-slate-900">{{ $item['product'] }}</div>
                                                        <div class="text-xs text-slate-500">ID: #{{ $item['id'] }}</div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="produk_id[]" value="{{ $item['id'] }}" />
                                                <input type="hidden" name="profit_peritem[]" class="column_profit_peritem" value="{{ $item['labaPerItem'] }}" />
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 font-semibold text-primary">
                                                    {{ $item['total_qty'] }}
                                                </span>
                                                <input type="hidden" name="jumlah_qty[]" value="{{ $item['total_qty'] }}" />
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="font-semibold text-slate-900">Rp {{ toThousand($item['price_sell']) }}</div>
                                                <input type="hidden" name="harga_jual[]" value="{{ $item['price_sell'] }}" />
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="font-bold text-primary">Rp {{ toThousand($item['subtotal']) }}</div>
                                                <input type="hidden" class="column_subtotal" name="subtotal_produk[]" value="{{ $item['subtotal'] }}" />
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <x-base.lucide class="mb-2 h-12 w-12" icon="Package" />
                                                <p class="text-sm">Tidak ada produk</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="intro-y mb-5 grid grid-cols-12 gap-4">
                    <div class="col-span-12 lg:col-span-4">
                        <div class="rounded-lg border border-success/20 bg-gradient-to-br from-success/5 to-success/10 p-5 transition-all hover:shadow-lg">
                            <div class="mb-2 flex items-center text-xs font-medium text-success">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="TrendingUp" />
                                LABA BERSIH
                            </div>
                            <div class="text-3xl font-bold text-success">
                                Rp {{ toThousand($data['header']->net_profit ?? 0) }}
                            </div>
                            <div class="mt-2 text-xs text-success/70">
                                Profit dari transaksi ini
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-4">
                        <div class="rounded-lg border border-primary/20 bg-gradient-to-br from-primary/5 to-primary/10 p-5 transition-all hover:shadow-lg">
                            <div class="mb-2 flex items-center text-xs font-medium text-primary">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="ShoppingCart" />
                                GRAND TOTAL
                            </div>
                            <div class="text-3xl font-bold text-primary">
                                Rp {{ toThousand($data['header']->grand_total ?? 0) }}
                            </div>
                            <input type="hidden" id="grand_total" name="grand_total" value="{{ $data['header']->grand_total ?? 0 }}" />
                            <div class="mt-2 text-xs text-primary/70">
                                Total nilai transaksi
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-4">
                        <div class="rounded-lg border border-warning/20 bg-gradient-to-br from-warning/5 to-warning/10 p-5 transition-all hover:shadow-lg">
                            <div class="mb-2 flex items-center text-xs font-medium text-warning">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="Wallet" />
                                TOTAL BAYAR
                            </div>
                            <div class="text-3xl font-bold text-warning">
                                Rp {{ toThousand($data['header']->total_payment ?? 0) }}
                            </div>
                            <div class="mt-2 text-xs text-warning/70">
                                Jumlah yang sudah dibayar
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Installment Section (if On Progress) -->
                @if ($data['header']->status == 'On Progress')
                    <div class="intro-y mb-5 rounded-lg border border-info/20 bg-gradient-to-br from-info/5 to-info/10">
                        <div class="border-b border-info/20 p-5">
                            <h3 class="flex items-center text-base font-medium text-info">
                                <x-base.lucide class="mr-2 h-5 w-5" icon="CreditCard" />
                                Tambah Angsuran
                            </h3>
                        </div>
                        <div class="p-5">
                            <div class="flex items-end gap-4">
                                <div class="flex-1">
                                    <x-base.form-label for="angsuran" class="text-slate-700">
                                        <span class="flex items-center">
                                            <x-base.lucide class="mr-2 h-4 w-4" icon="Banknote" />
                                            Jumlah Angsuran
                                        </span>
                                    </x-base.form-label>
                                    <x-base.form-input 
                                        class="mt-2 text-lg font-semibold" 
                                        id="angsuran" 
                                        type="text"
                                        name="angsuran" 
                                        value="" 
                                        price="true" 
                                        placeholder="Masukkan jumlah angsuran" 
                                        required
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
                                    />
                                    @error('angsuran')
                                        <div class="mt-2 text-sm text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-4 rounded-lg bg-info/10 p-3">
                                <div class="flex items-center text-sm text-info">
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="Info" />
                                    <span>Masukkan jumlah pembayaran angsuran untuk melanjutkan transaksi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <input type="hidden" name="mode" id="mode" value="angsuran" />

                <!-- Action Buttons -->
                <div class="intro-y flex items-center justify-end gap-3 rounded-lg border border-slate-200 bg-white p-5">
                    <x-base.button type="button" variant="outline-secondary" onclick="window.location.href='{{ route('selling.index') }}'">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="X" />
                        Batal
                    </x-base.button>
                    
                    @if ($data['header']->status == 'On Progress')
                        <x-base.button type="submit" variant="primary">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="Save" />
                            Simpan Angsuran
                        </x-base.button>
                    @endif
                </div>
            </form>
        </div>
    </div>

@endsection
