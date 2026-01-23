@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-slate-900">Form Penjualan</h2>
                <p class="mt-1 text-slate-600">{{ $type == 'create' ? 'Buat penjualan baru' : 'Edit penjualan' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <x-base.button class="px-3" variant="outline-secondary">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft"/>
                    <a href="{{ route('selling.index') }}">Kembali</a>
                </x-base.button>
            </div>
        </div>

        @if (session('success'))
            <x-base.alert class="flex items-center" variant="outline-success">
                <x-base.lucide class="mr-2 h-5 w-5" icon="CheckCircle" />
                {{ session('success') }}
                <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                    <x-base.lucide class="h-4 w-4" icon="X" />
                </x-base.alert.dismiss-button>
            </x-base.alert>
        @endif
        
        @if (session('failed'))
            <x-base.alert class="flex items-center" variant="outline-danger">
                <x-base.lucide class="mr-2 h-5 w-5" icon="AlertCircle" />
                {{ session('failed') }}
                <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                    <x-base.lucide class="h-4 w-4" icon="X" />
                </x-base.alert.dismiss-button>
            </x-base.alert>
        @endif
    </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <form action="{{ $route }}" method="post" enctype="multipart/form-data" id="sellingForm">
                @csrf
                @if ($type != 'create')
                    @method('PUT')
                @endif
                
                <!-- Main Form Layout -->
                <div class="intro-y rounded-lg border border-slate-200 bg-white">
                    <!-- Transaction Info Section -->
                    <div class="p-5">
                        <h3 class="mb-3 text-base font-medium">Informasi Transaksi</h3>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 lg:col-span-4">
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <div class="mb-3">
                                        <x-base.form-label for="tgl_jual">Tanggal Penjualan</x-base.form-label>
                                        <x-base.form-input 
                                            class="w-full" 
                                            id="tgl_jual" 
                                            type="date" 
                                            name="tgl_jual"
                                            value="{{ $data['header']->date ?? date('Y-m-d') }}"
                                        />
                                        @error('tgl_jual')
                                            <div class="mt-2 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    @if (count($data['cvs']) > 1)
                                        <div class="mb-3 hidden">
                                            <x-base.form-label for="cv_id">Perusahaan</x-base.form-label>
                                            <x-base.tom-select 
                                                name="cv_id" 
                                                id="cv_id" 
                                                class="w-full"
                                                data-placeholder="Pilih Perusahaan" 
                                                required
                                            >
                                                <option value="">Pilih Perusahaan</option>
                                                @foreach ($data['cvs'] as $cv)
                                                    <option value="{{ $cv->id }}"
                                                        {{ ($data['header']->cv_id ?? session('cv_id')) == $cv->id ? 'selected' : '' }}>
                                                        {{ $cv->name }}
                                                    </option>
                                                @endforeach
                                            </x-base.tom-select>
                                            @error('cv_id')
                                                <div class="mt-2 text-danger text-sm">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @else
                                        <input type="hidden" name="cv_id" value="{{ $data['cvs']->first()->id ?? session('cv_id') }}">
                                    @endif
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-4">
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <div class="mb-3">
                                        <x-base.form-label for="customer">Pelanggan</x-base.form-label>
                                        <x-base.tom-select 
                                            name="customer" 
                                            id="customer" 
                                            class="w-full" 
                                            data-placeholder="Pilih Pelanggan"
                                        >
                                            <option value="">Pilih Pelanggan</option>
                                            @foreach ($data['customer'] as $row)
                                                <option value="{{ $row->id }}"
                                                    {{ $data['header']->customer_id == $row->id ? 'selected' : '' }}>
                                                    {{ $row->name }}
                                                </option>
                                            @endforeach
                                        </x-base.tom-select>
                                        @error('customer')
                                            <div class="mt-2 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-4">
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <div class="mb-3">
                                        <x-base.form-label>Status Transaksi</x-base.form-label>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium
                                                {{ $type == 'create' ? 'bg-primary/20 text-primary' : 
                                                ($data['header']->status == 'completed' ? 'bg-success/20 text-success' : 'bg-warning/20 text-warning') }}">
                                                <x-base.lucide 
                                                    class="mr-1 h-4 w-4" 
                                                    icon="{{ $type == 'create' ? 'FileEdit' : 
                                                        ($data['header']->status == 'completed' ? 'CheckCircle' : 'Clock') }}" 
                                                />
                                                {{ $type == 'create' ? 'Draft Baru' : 
                                                    ($data['header']->status == 'completed' ? 'Selesai' : 'Dalam Proses') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payment Info Section -->
                    <div class="border-t border-slate-200 p-5">
                        <h3 class="mb-3 text-base font-medium">Informasi Pembayaran</h3>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 lg:col-span-6">
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <div>
                                        <x-base.form-label for="tipe_pembelian">Tipe Pembelian</x-base.form-label>
                                        <x-base.tom-select 
                                            name="tipe_pembelian" 
                                            id="tipe_pembelian" 
                                            class="w-full"
                                            data-placeholder="Pilih Tipe Pembelian" 
                                            required
                                        >
                                            <option value="tempo"
                                                {{ $data['header']->purchasing_method == 'tempo' ? 'selected' : '' }}>
                                                Tempo Panjang
                                            </option>
                                            <option value="titipan"
                                                {{ $data['header']->purchasing_method == 'titipan' ? 'selected' : '' }}>
                                                Titipan
                                            </option>
                                            <option value="kontan"
                                                {{ $data['header']->purchasing_method == 'kontan' ? 'selected' : '' }}>
                                                Kontan
                                            </option>
                                        </x-base.tom-select>
                                        @error('tipe_pembelian')
                                            <div class="mt-2 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-6">
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <div>
                                        <x-base.form-label for="tipe_pembayaran">Tipe Pembayaran</x-base.form-label>
                                        <x-base.tom-select 
                                            name="tipe_pembayaran" 
                                            id="tipe_pembayaran" 
                                            class="w-full"
                                            data-placeholder="Pilih Tipe Pembayaran" 
                                            required
                                        >
                                            <option value="cash" 
                                                {{ $data['header']->payment_type == 'cash' ? 'selected' : '' }}>
                                                Cash
                                            </option>
                                            <option value="transfer"
                                                {{ $data['header']->payment_type == 'transfer' ? 'selected' : '' }}>
                                                Transfer
                                            </option>
                                        </x-base.tom-select>
                                        @error('tipe_pembayaran')
                                            <div class="mt-2 text-danger text-sm">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-12">
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <x-base.form-label for="catatan">Catatan</x-base.form-label>
                                    <x-base.form-textarea 
                                        class="form-control" 
                                        id="catatan" 
                                        name="catatan"
                                        rows="3"
                                        placeholder="Masukkan catatan (Optional)..."
                                    >{{ $data['header']->notes ?? old('catatan') }}</x-base.form-textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Products Section -->
                    <div class="border-t border-slate-200 p-5">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-base font-medium">Daftar Produk</h3>
                        </div>

                        <div class="rounded-lg bg-slate-50 p-4">
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 lg:col-span-6">
                                    <x-base.form-label for="produk">Produk</x-base.form-label>
                                    <x-base.tom-select 
                                        name="produk" 
                                        id="produk" 
                                        class="w-full"
                                        data-placeholder="Pilih Produk"
                                    >
                                        <option value="">Pilih Produk</option>
                                        @foreach ($data['product'] as $row)
                                            <option value="{{ $row->id }}_{{ $row->product }}_{{ $row->last_stock }}">
                                                <div class="flex items-center justify-between">
                                                    <span>{{ $row->product }}</span>
                                                    <span class="text-slate-500">(Stok: {{ $row->last_stock }})</span>
                                                </div>
                                            </option>
                                        @endforeach
                                    </x-base.tom-select>
                                </div>

                                <div class="col-span-12 lg:col-span-3">
                                    <x-base.form-label for="qty_jual">Jumlah (QTY)</x-base.form-label>
                                    <x-base.input-group>
                                        <x-base.form-input 
                                            class="w-full" 
                                            type="text" 
                                            name="qty_jual" 
                                            id="qty_jual"
                                            placeholder="Jumlah"
                                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46"
                                            onChange="getHargaStock(this.value)" 
                                        />
                                        <x-base.input-group.text>
                                            <x-base.button 
                                                type="button" 
                                                onclick="showSjFakturModal()"
                                                variant="primary" 
                                            >
                                                <x-base.lucide class="h-4 w-4" icon="Eye" />
                                            </x-base.button>
                                        </x-base.input-group.text>
                                    </x-base.input-group>
                                </div>

                                <div class="col-span-12 lg:col-span-3">
                                    <x-base.form-label for="harga_jual">Harga Jual</x-base.form-label>
                                    <div class="relative">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-slate-500">Rp</span>
                                        </div>
                                        <x-base.form-input 
                                            class="w-full pl-10" 
                                            type="text" 
                                            name="harga_jual" 
                                            id="harga_jual"
                                            placeholder="Harga jual per unit" 
                                            price="true"
                                        />
                                    </div>
                                </div>
                            </div>
                            <x-base.button 
                                type="button" 
                                variant="primary" 
                                onclick="tambahProduk()"
                            >
                                <x-base.lucide class="mr-2 h-4 w-4" icon="Plus"/>
                                Tambah Produk
                            </x-base.button>
                        </div>
                    </div>
                    <!-- Products Table -->
                    <div class="border-t border-slate-200 p-5">
                        <div class="rounded-lg border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200" id="transDetail">
                                <thead>
                                    <tr class="bg-slate-50">
                                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">Produk</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-slate-600">Qty</th>
                                        <th class="px-4 py-3 text-right text-sm font-medium text-slate-600">Harga Jual</th>
                                        <th class="px-4 py-3 text-right text-sm font-medium text-slate-600">Subtotal</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-slate-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200" id="transDetail">
                                    @if (isset($data['detail']) && count($data['detail']) > 0)
                                        @foreach ($data['detail'] as $item)
                                            <tr class="row-data">
                                                <td class="produk_id" hidden>
                                                    {{ $item['id'] }}
                                                    <input type="hidden" name="produk_id[]" value="{{ $item['id'] }}" />
                                                </td>
                                                <td class="profit_peritem" hidden>
                                                    <input type="hidden" name="profit_peritem[]" class="column_profit_peritem" 
                                                        value="{{ $item['labaPerItem'] }}" />
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="font-medium">{{ $item['product'] }}</div>
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    {{ $item['total_qty'] }}
                                                    <input type="hidden" name="jumlah_qty[]" value="{{ $item['total_qty'] }}" />
                                                </td>
                                                <td class="px-4 py-3 text-right font-medium">
                                                    {{ toThousand($item['price_sell']) }}
                                                    <input type="hidden" name="harga_jual[]" value="{{ $item['price_sell'] }}" />
                                                </td>
                                                <td class="px-4 py-3 text-right font-medium">
                                                    {{ toThousand($item['subtotal']) }}
                                                    <input type="hidden" class="column_subtotal" name="subtotal_produk[]" 
                                                        value="{{ $item['subtotal'] }}" />
                                                </td>
                                                <td class="px-4 py-3 text-center">
                                                    <button type="button" onclick="hapusRow(this)" 
                                                        class="inline-flex items-center text-danger hover:text-danger/70">
                                                        <x-base.lucide class="h-4 w-4" icon="Trash2" />
                                                        <span class="ml-2">Hapus</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="emptyData">
                                            <td colspan="5" class="px-4 py-3 text-center text-slate-500">
                                                <div class="flex items-center justify-center">
                                                    <x-base.lucide class="mr-2 h-4 w-4" icon="Package" />
                                                    Belum ada produk ditambahkan
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Card -->
                        <div class="mt-4 grid grid-cols-12 gap-4">
                            <div class="col-span-12 lg:col-span-4">
                                <div class="rounded-lg bg-success/20 p-4">
                                    <div class="text-sm font-medium text-success">Laba Bersih</div>
                                    <div class="mt-1 text-2xl font-bold text-success">
                                        {{ toThousand($data['header']->net_profit) ?? 0 }}
                                    </div>
                                    <input type="hidden" id="laba_bersih" name="laba_bersih"
                                        value="{{ $data['header']->net_profit ?? 0 }}" />
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-4">
                                <div class="rounded-lg bg-primary/20 p-4">
                                    <div class="text-sm font-medium text-primary">Grand Total</div>
                                    <div class="mt-1 text-2xl font-bold text-primary grand_total">
                                        {{ toThousand($data['header']->grand_total) ?? 0 }}
                                    </div>
                                    <input type="hidden" id="grand_total" name="grand_total"
                                        value="{{ $data['header']->grand_total ?? 0 }}" />
                                </div>
                            </div>

                            <div class="col-span-12 lg:col-span-4">
                                <div class="rounded-lg bg-warning/20 p-4">
                                    <div class="text-sm font-medium text-warning">Total Bayar</div>
                                    <div class="mt-1">
                                        <x-base.form-input 
                                            class="text-lg font-bold" 
                                            type="text"
                                            id="total_bayar" 
                                            name="total_bayar" 
                                            value="{{ $data['header']->total_payment ?? 0 }}"
                                            placeholder="Masukkan total pembayaran" 
                                            required 
                                            price="true"
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="mode" id="mode" value="" />

                        <!-- Action Buttons -->
                        <div class="mt-5 flex items-center justify-end gap-2">
                            <x-base.button type="button" variant="outline-secondary">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="X" />
                                <a href="{{ route('selling.index') }}">
                                    Batal
                                </a>
                            </x-base.button>
                            
                            <x-base.button type="submit" variant="primary">
                                <x-base.lucide class="mr-2 h-4 w-4" icon="Save" />
                                Simpan
                            </x-base.button>

                            @if ($type != 'create')
                                <x-base.button type="submit" variant="success" onclick="closingSelling()">
                                    <x-base.lucide class="mr-2 h-4 w-4" icon="CheckCircle" />
                                    Konfirmasi
                                </x-base.button>
                            @endif
                        </div>
                    </div>

                    <!-- Stock Price Details Modal -->
                    <x-base.dialog id="detailStockHarga">
                        <x-base.dialog.panel>
                            <div class="p-5">
                                <div class="mb-5 flex items-center justify-between">
                                    <h3 class="text-lg font-medium">Detail Harga Stok</h3>
                                    <x-base.button 
                                        class="h-8 w-8" 
                                        data-tw-dismiss="modal" 
                                        variant="outline-secondary"
                                    >
                                        <x-base.lucide class="h-4 w-4" icon="X" />
                                    </x-base.button>
                                </div>

                                <div class="rounded-lg border border-slate-200">
                                    <table class="min-w-full divide-y divide-slate-200">
                                        <thead>
                                            <tr class="bg-slate-50">
                                                <td class="px-4 py-3 text-start text-sm font-medium text-slate-600">No</td>
                                                <td class="px-4 py-3 text-start text-sm font-medium text-slate-600">Stok</td>
                                                <td class="px-4 py-3 text-start text-sm font-medium text-slate-600">Harga/Kg</td>
                                            </tr>
                                        </thead>
                                        <tbody id="tableDetailStockHarga" class="divide-y divide-slate-200">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </x-base.dialog.panel>
                    </x-base.dialog>

                    <!-- Price Method Selection Modal -->
                    <x-base.dialog id="priceMethodModal" size="lg">
                        <x-base.dialog.panel>
                            <div class="p-5">
                                <div class="mb-5">
                                    <h3 class="text-lg font-medium mb-2">Pilih Metode Harga Pembelian</h3>
                                    <p class="text-slate-600 text-sm">Qty yang diinputkan: <strong id="qtyDisplay"></strong>. Stok tersedia: <strong id="stockDisplay"></strong>. Pilih metode penentuan harga pembelian:</p>
                                </div>

                                <div class="space-y-4">
                                    <!-- Option 1: Use Old Price (FIFO) -->
                                    <div class="border border-slate-200 rounded-lg p-4 hover:border-primary cursor-pointer" onclick="selectPriceMethod('old')">
                                        <div class="flex items-start">
                                            <input type="radio" name="price_method" value="old" id="method_old" class="mt-1">
                                            <label for="method_old" class="ml-3 cursor-pointer flex-1">
                                                <div class="font-medium text-base mb-1">Gunakan Harga Lama (FIFO)</div>
                                                <p class="text-sm text-slate-600">Menggunakan harga dari stok yang paling lama terlebih dahulu. System akan mengecek stock_in_use, jika sudah mencapai first_stock maka stok tersebut tidak dapat digunakan lagi.</p>
                                                <div class="mt-3 bg-slate-50 p-3 rounded">
                                                    <div class="text-xs font-medium text-slate-600 mb-2">Contoh Alokasi:</div>
                                                    <div class="text-sm space-y-1" id="oldPriceExample">
                                                        <!-- Will be populated by JavaScript -->
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Option 2: Use Latest Available Price -->
                                    <div class="border border-slate-200 rounded-lg p-4 hover:border-primary cursor-pointer" onclick="selectPriceMethod('latest')">
                                        <div class="flex items-start">
                                            <input type="radio" name="price_method" value="latest" id="method_latest" class="mt-1">
                                            <label for="method_latest" class="ml-3 cursor-pointer flex-1">
                                                <div class="font-medium text-base mb-1">Gunakan Harga Terbaru</div>
                                                <p class="text-sm text-slate-600">Menggunakan harga sesuai dengan stok yang tersedia saat ini (last_stock). Hanya stok yang tersedia yang akan digunakan.</p>
                                                <div class="mt-3 bg-slate-50 p-3 rounded">
                                                    <div class="text-xs font-medium text-slate-600 mb-2">Contoh Alokasi:</div>
                                                    <div class="text-sm space-y-1" id="latestPriceExample">
                                                        <!-- Will be populated by JavaScript -->
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Stock Table -->
                                <div class="mt-5">
                                    <h4 class="font-medium mb-3">Detail Stok Tersedia:</h4>
                                    <div class="rounded-lg border border-slate-200">
                                        <table class="min-w-full divide-y divide-slate-200">
                                            <thead>
                                                <tr class="bg-slate-50">
                                                    <td class="px-4 py-3 text-start text-sm font-medium text-slate-600">Stock ID</td>
                                                    <td class="px-4 py-3 text-center text-sm font-medium text-slate-600">First Stock</td>
                                                    <td class="px-4 py-3 text-center text-sm font-medium text-slate-600">In Use</td>
                                                    <td class="px-4 py-3 text-center text-sm font-medium text-slate-600">Available</td>
                                                    <td class="px-4 py-3 text-right text-sm font-medium text-slate-600">Harga/Kg</td>
                                                </tr>
                                            </thead>
                                            <tbody id="modalStockDetail" class="divide-y divide-slate-200">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="mt-5 flex justify-end gap-2">
                                    <x-base.button type="button" variant="outline-secondary" data-tw-dismiss="modal">
                                        Batal
                                    </x-base.button>
                                    <x-base.button type="button" variant="primary" onclick="confirmPriceMethod()">
                                        Konfirmasi
                                    </x-base.button>
                                </div>
                            </div>
                        </x-base.dialog.panel>
                    </x-base.dialog>

                    <!-- Nomor SJ dan Faktur Modal -->
                    <x-base.dialog id="nomorSjFakturModal" size="lg">
                        <x-base.dialog.panel>
                            <div class="p-5">
                                <div class="mb-5 flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium">Input Nomor SJ & Faktur</h3>
                                        <p class="text-slate-600 text-sm mt-1">Masukkan nomor SJ dan nomor faktur untuk setiap alokasi stok</p>
                                    </div>
                                    <x-base.button 
                                        class="h-8 w-8" 
                                        type="button"
                                        variant="outline-secondary"
                                        onclick="closeSjFakturModal()"
                                    >
                                        <x-base.lucide class="h-4 w-4" icon="X" />
                                    </x-base.button>
                                </div>

                                <div id="sjFakturInputContainer" class="space-y-4">
                                    <!-- Will be populated by JavaScript -->
                                </div>

                                <div class="mt-5 flex justify-end gap-2">
                                    <x-base.button type="button" variant="outline-secondary" onclick="closeSjFakturModal()">
                                        Batal
                                    </x-base.button>
                                    <x-base.button type="button" variant="primary" onclick="confirmSjFaktur()">
                                        Konfirmasi & Tambah Produk
                                    </x-base.button>
                                </div>
                            </div>
                        </x-base.dialog.panel>
                    </x-base.dialog>
                </div>
                <!-- END: Form Layout -->
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            var arrLaba = [];
            var tempStockData = [];
            var selectedPriceMethod = null;
            var currentQty = 0;
            var currentProduk = null;

            document.getElementById('produk').addEventListener('change', function() {
                $('#qty_jual').removeAttr('disabled');
            });

            function selectPriceMethod(method) {
                selectedPriceMethod = method;
                $('input[name="price_method"][value="' + method + '"]').prop('checked', true);
            }

            function confirmPriceMethod() {
                if (!selectedPriceMethod) {
                    alert('Harap pilih metode harga terlebih dahulu!');
                    return false;
                }

                // Process stock allocation based on selected method
                arrLaba = [];
                let remainingQty = currentQty;
                let stockList = [...tempStockData];

                if (selectedPriceMethod === 'old') {
                    // FIFO: Use oldest stock first, check stock_in_use vs first_stock
                    stockList.sort((a, b) => a.stock_id - b.stock_id);
                    // only get first index array
                    // stockList = stockList.slice(0, 1);
                    // console.log('FIFO Stock List:', stockList);
                    for (let stock of stockList) {
                        if (remainingQty <= 0) break;
                        
                        // Calculate available capacity: first_stock - stock_in_use
                        let availableCapacity = stock.first_stock - stock.stock_in_use;
                        
                        if (availableCapacity <= 0) {
                            // This stock is fully used, skip it
                            continue;
                        }
                        
                        let qtyToUse = Math.min(remainingQty, availableCapacity);
                        arrLaba.push({
                            stock_id: stock.stock_id,
                            stock: qtyToUse,
                            price_kg: stock.price_kg,
                            available_capacity: availableCapacity
                        });
                        remainingQty -= qtyToUse;
                        break;
                    }
                    // if (remainingQty > 0) {
                    //     alert('Stok dengan harga lama tidak mencukupi! Sisa qty yang tidak dapat dialokasikan: ' + remainingQty);
                    //     arrLaba = [];
                    //     return false;
                    // }
                } else {
                    // Latest: Use based on available stock (last_stock)
                    for (let stock of stockList) {
                        if (remainingQty <= 0) break;
                        
                        if (stock.last_stock <= 0) {
                            continue;
                        }
                        
                        let qtyToUse = Math.min(remainingQty, stock.last_stock);
                        arrLaba.push({
                            stock_id: stock.stock_id,
                            stock: qtyToUse,
                            price_kg: stock.price_kg,
                            last_stock: stock.last_stock
                        });
                        remainingQty -= qtyToUse;
                    }
                    
                    // if (remainingQty > 0) {
                    //     alert('Stok yang tersedia tidak mencukupi! Sisa qty yang tidak dapat dialokasikan: ' + remainingQty);
                    //     arrLaba = [];
                    //     return false;
                    // }
                }

                // Enable add product button
                $('#modalDetailStockHarga').removeAttr('disabled');
                
                // Close modal
                const modal = tailwind.Modal.getInstance(document.querySelector('#priceMethodModal'));
                modal.hide();

                // Show SJ dan Faktur input modal
                showSjFakturModal();
            }

            function showSjFakturModal() {
                // Generate input fields based on arrLaba
                let inputHtml = '';
                
                for (let i = 0; i < arrLaba.length; i++) {
                    inputHtml += `
                        <div class="border border-slate-200 rounded-lg p-4">
                            <div class="mb-3 flex items-center justify-between">
                                <div>
                                    <span class="font-medium">Stock #${arrLaba[i].stock_id}</span>
                                    <span class="text-slate-600 text-sm ml-2">(${arrLaba[i].stock} pcs × ${toCurrency(arrLaba[i].price_kg)})</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label>Nomor SJ</label>
                                    <input 
                                        class="w-full border border-slate-300 rounded-md p-2" 
                                        type="text" 
                                        id="no_sj_${i}"
                                        placeholder="Masukkan nomor SJ"
                                    />
                                    
                                </div>
                                <div>
                                    <label>Nomor Faktur</label>
                                    <input 
                                        class="w-full border border-slate-300 rounded-md p-2" 
                                        type="text" 
                                        id="no_faktur_${i}"
                                        placeholder="Masukkan nomor faktur"
                                    />
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                $('#sjFakturInputContainer').html(inputHtml);
                
                // Show modal
                const sjFakturModal = tailwind.Modal.getOrCreateInstance(document.querySelector('#nomorSjFakturModal'));
                sjFakturModal.show();
            }

            function closeSjFakturModal() {
                const modal = tailwind.Modal.getInstance(document.querySelector('#nomorSjFakturModal'));
                if (modal) {
                    modal.hide();
                }
            }

            function confirmSjFaktur() {
                // Collect SJ and Faktur data
                for (let i = 0; i < arrLaba.length; i++) {
                    let noSj = document.getElementById(`no_sj_${i}`).value;
                    let noFaktur = document.getElementById(`no_faktur_${i}`).value;
                    
                    if (!noSj || !noFaktur) {
                        alert(`Harap isi nomor SJ dan faktur untuk Stock #${arrLaba[i].stock_id}`);
                        return false;
                    }
                    
                    arrLaba[i].no_sj = noSj;
                    arrLaba[i].no_faktur = noFaktur;
                }
                
                // Close modal
                closeSjFakturModal();
                
                // Show detail stock modal
                displayStockDetail();
            }

            function displayStockDetail() {
                $('#tableDetailStockHarga').html('');
                
                for (let i = 0; i < arrLaba.length; i++) {
                    var stockHarga = `
                        <tr class="row-data">
                            <td class="py-2 px-4 w-1/4">${i + 1}</td>
                            <td class="py-2 px-4 w-1/4">${arrLaba[i].stock}</td>
                            <td class="py-2 px-4 w-1/4">${toCurrency(arrLaba[i].price_kg)}</td>
                        </tr>
                    `;
                    $('#tableDetailStockHarga').html($('#tableDetailStockHarga').html() + stockHarga);
                }
            }

            function showPriceMethodModal(stockData, qty, produk) {
                tempStockData = stockData;
                currentQty = qty;
                currentProduk = produk;
                selectedPriceMethod = null;
                $('input[name="price_method"]').prop('checked', false);

                // Calculate total available stock
                let totalAvailableStock = stockData.reduce((sum, item) => sum + parseInt(item.last_stock), 0);
                
                // Display qty and available stock
                $('#qtyDisplay').text(qty);
                $('#stockDisplay').text(totalAvailableStock);

                // Populate stock detail table in modal
                $('#modalStockDetail').html('');
                for (let i = 0; i < stockData.length; i++) {
                    if(stockData[i].last_stock <= 0) continue; // Skip if no available stock
                    let row = `
                        <tr>
                            <td class="px-4 py-3">#${stockData[i].stock_id}</td>
                            <td class="px-4 py-3 text-center">${stockData[i].first_stock}</td>
                            <td class="px-4 py-3 text-center">${stockData[i].stock_in_use}</td>
                            <td class="px-4 py-3 text-center">${stockData[i].last_stock}</td>
                            <td class="px-4 py-3 text-right">${toCurrency(stockData[i].price_kg)}</td>
                        </tr>
                    `;
                    $('#modalStockDetail').html($('#modalStockDetail').html() + row);
                }

                // Generate examples
                generatePriceExamples(stockData, qty);

                // Show modal
                const modal = tailwind.Modal.getOrCreateInstance(document.querySelector('#priceMethodModal'));
                modal.show();
            }

            function generatePriceExamples(stockData, qty) {
                // Old Price (FIFO) Example - Check stock_in_use
                let oldExample = '';
                let remainingOld = qty;
                let sortedOld = [...stockData].sort((a, b) => a.stock_id - b.stock_id);
                
                for (let stock of sortedOld) {
                    if (remainingOld <= 0) break;
                    
                    let availableCapacity = stock.first_stock - stock.stock_in_use;
                    if (availableCapacity <= 0) continue;
                    
                    let qtyToUse = Math.min(remainingOld, availableCapacity);
                    oldExample += `<div>Stock #${stock.stock_id}: ${qtyToUse} pcs × ${toCurrency(stock.price_kg)} (Kapasitas: ${availableCapacity})</div>`;
                    remainingOld -= qtyToUse;
                }
                
                if (remainingOld > 0) {
                    oldExample += `<div class="text-danger mt-2">⚠️ Kekurangan: ${remainingOld} pcs (Stok tidak mencukupi)</div>`;
                }
                $('#oldPriceExample').html(oldExample || '<div class="text-slate-500">Tidak ada stok yang dapat digunakan</div>');

                // Latest Price Example - Show ALL available stocks with their quantities
                let latestExample = '';
                let latestExampleList = [];
                
                // Show all stocks that have last_stock > 0
                for (let stock of stockData) {
                    if (stock.last_stock > 0) {
                        latestExampleList.push({
                            stock_id: stock.stock_id,
                            last_stock: stock.last_stock,
                            price_kg: stock.price_kg
                        });
                    }
                }
                
                // Display all available stocks
                if (latestExampleList.length > 0) {
                    latestExample += '<div class="mb-2 text-xs font-semibold text-slate-600">Semua stok yang tersedia:</div>';
                    for (let item of latestExampleList) {
                        latestExample += `<div>Stock #${item.stock_id}: ${item.last_stock} pcs tersedia × ${toCurrency(item.price_kg)}</div>`;
                    }
                    
                    // Calculate if enough
                    let totalAvailable = latestExampleList.reduce((sum, item) => sum + item.last_stock, 0);
                    if (qty > totalAvailable) {
                        latestExample += `<div class="text-danger mt-2">⚠️ Kekurangan: ${qty - totalAvailable} pcs (Total tersedia: ${totalAvailable})</div>`;
                    } else {
                        latestExample += `<div class="text-success mt-2">✓ Stok mencukupi (Total tersedia: ${totalAvailable})</div>`;
                    }
                } else {
                    latestExample = '<div class="text-slate-500">Tidak ada stok yang tersedia</div>';
                }
                
                $('#latestPriceExample').html(latestExample);
            }

            function tambahProduk() {
                var produk = $('#produk').val().split('_');
                var qty = $('#qty_jual').val();
                var harga_jual = currencyToNumber($('#harga_jual').val());
                var profit = $('#laba_bersih').val();
                var subtotal = parseInt(harga_jual) * parseInt(qty);

                // Validation: product, qty, and price must not be empty
                if (produk == "" || produk[0] == "") {
                    alert("Harap pilih produk terlebih dahulu!");
                    return false;
                }

                if (qty == "" || qty == 0 || isNaN(qty)) {
                    alert("Harap masukkan jumlah qty yang valid!");
                    return false;
                }

                if (harga_jual == "" || harga_jual == 0 || isNaN(harga_jual)) {
                    alert("Harap masukkan harga jual yang valid!");
                    return false;
                }

                if (arrLaba.length === 0) {
                    alert("Harap tentukan metode harga terlebih dahulu!");
                    return false;
                }

                var boolean = true
                $('.produk_id').each(function() {
                    var produk_id = $(this).text();
                    if (produk_id == produk[0]) {
                        boolean = false;
                    }
                })

                if (boolean == false) {
                    alert('Produk ini sudah ada');
                    return false;
                }

                var totalLaba = parseInt(profit) == '' ? 0 : parseInt(profit);
                var labaPerItem = 0;

                for (let i = 0; i < arrLaba.length; i++) {
                    // check if no_sj_ and no_faktur exist is null
                    if (!arrLaba[i].no_sj || !arrLaba[i].no_faktur) {
                        alert('Nomor SJ dan Faktur untuk semua alokasi stok harus diisi!');
                        showSjFakturModal();
                        return false;
                    }
                    const price_kg = arrLaba[i].price_kg;
                    const stock = arrLaba[i].stock;

                    totalLaba += (parseInt(harga_jual) - parseInt(price_kg)) * parseInt(stock);
                    labaPerItem += (parseInt(harga_jual) - parseInt(price_kg)) * parseInt(stock);
                }

                // Prepare arrLaba data as JSON string to pass to backend
                var arrLabaJson = JSON.stringify(arrLaba);

                var products = `
                    <tr class="row-data">
                        <td class="py-2 px-4 produk_id" hidden>${produk[0]}<input type="hidden" name="produk_id[]" id="produk_id[]" value="${produk[0]}" /></td>
                        <td class="py-2 px-4 profit_peritem" hidden><input type="hidden" name="profit_peritem[]" id="profit_peritem[]" class="column_profit_peritem" value="${labaPerItem}" /></td>
                        <td class="py-2 px-4 arr_laba_data" hidden><input type="hidden" name="arr_laba_data[]" value='${arrLabaJson}' /></td>
                        <td class="px-4 py-3">
                            <div class="font-medium">${produk[1]}</div>
                        </td>
                        <td class="px-4 py-3 text-center">${qty}<input type="hidden" name="jumlah_qty[]" id="jumlah_qty[]" value="${qty}" /></td>
                        <td class="px-4 py-3 text-right font-medium">${toCurrency(harga_jual)}<input type="hidden" name="harga_jual[]" id="harga_jual[]" value="${harga_jual}" /></td>
                        <td class="px-4 py-3 text-right font-medium">${toCurrency(subtotal)}<input type="hidden" class="column_subtotal" name="subtotal_produk[]" id="subtotal_produk[]" value="${subtotal}" /></td>
                        <td class="px-4 py-3 text-center"> 
                            <button type="button" onclick="hapusRow(this)" class="inline-flex items-center text-danger hover:text-danger/70">
                                <x-base.lucide class="h-4 w-4" icon="Trash2" />
                                <span class="ml-2">Hapus</span>
                            </button>
                        </td>
                    </tr>
                `;
                $('#transDetail > tbody').html($('#transDetail > tbody').html() + products);

                var totalSubtotal = 0;
                $('.column_subtotal').each(function() {
                    var sub_sementara = $(this).val();
                    totalSubtotal += parseInt(currencyToNumber(sub_sementara));
                })
                $('.emptyData').remove();

                $('.laba_bersih').text(toCurrency(totalLaba));
                $('#laba_bersih').val(totalLaba);
                $('.grand_total').text(toCurrency(totalSubtotal));
                $('#grand_total').val(totalSubtotal);

                // Reset form
                document.getElementById('qty_jual').value = '';
                document.getElementById('qty_jual').disabled = true;
                document.getElementById('modalDetailStockHarga').disabled = true;
                document.getElementById('produk').value = '';
                document.getElementById('produk').dispatchEvent(new Event('change'));
                document.getElementById('harga_jual').value = '';
                arrLaba = [];
                tempStockData = [];
                selectedPriceMethod = null;
            }

            function hapusRow(event) {
                event.closest('tr').remove();

                var totalSubtotal = 0;
                $('.column_subtotal').each(function() {
                    var sub_sementara = $(this).val();
                    totalSubtotal += parseInt(currencyToNumber(sub_sementara));
                })

                var profitPerItem = 0;
                $('.column_profit_peritem').each(function() {
                    var profit_sementara = $(this).val();
                    profitPerItem += parseInt(currencyToNumber(profit_sementara));
                })

                var totalProfit = profitPerItem;

                $('.laba_bersih').text(toCurrency(totalProfit));
                $('#laba_bersih').val(totalProfit);

                $('.grand_total').text(toCurrency(totalSubtotal));
                $('#grand_total').val(totalSubtotal);
            }

            function closingSelling() {
                $('.mode').html('<input type="hidden" name="mode" id="mode" value="confirm"/>');
            }

            function getHargaStock(qty) {
                var produk = $('#produk').val().split('_');

                if (qty == "") {
                    document.getElementById('modalDetailStockHarga').disabled = true;
                    return false;
                }

                if (produk == "" || produk[0] == "") {
                    alert('Pilih produk terlebih dahulu!');
                    return false;
                }

                var xhr = new XMLHttpRequest();
                var url = "/getHargaStock?produk=" + produk[0] + "&qty=" + qty;

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            var response = JSON.parse(xhr.responseText);
                            console.log('response length:', response.length);
                            if (response.length > 0) {
                                // Calculate total capacity for old price (FIFO)
                                let totalOldCapacity = 0;
                                for (let stock of response) {
                                    let capacity = stock.first_stock - stock.stock_in_use;
                                    if (capacity > 0) {
                                        totalOldCapacity += capacity;
                                        break;
                                    }
                                }
                                
                                // If qty <= total old capacity, automatically use old price (FIFO)
                                if (parseInt(qty) <= totalOldCapacity) {
                                    selectPriceMethod('old');
                                    // Auto allocate using old price method
                                    arrLaba = [];
                                    let remainingQty = parseInt(qty);
                                    let sortedByOldest = [...response].sort((a, b) => a.stock_id - b.stock_id);
                                    
                                    for (let stock of sortedByOldest) {
                                        if (remainingQty <= 0) break;
                                        
                                        let availableCapacity = stock.first_stock - stock.stock_in_use;
                                        if (availableCapacity <= 0) continue;
                                        
                                        let qtyToUse = Math.min(remainingQty, availableCapacity);
                                        arrLaba.push({
                                            stock_id: stock.stock_id,
                                            stock: qtyToUse,
                                            price_kg: stock.price_kg,
                                            available_capacity: availableCapacity
                                        });
                                        remainingQty -= qtyToUse;
                                    }
                                    
                                    // Enable add product button and show SJ Faktur modal
                                    $('#modalDetailStockHarga').removeAttr('disabled');
                                    showSjFakturModal();
                                } else {
                                    // Show price method modal
                                    showPriceMethodModal(response, qty, produk);
                                }
                            } else {
                                document.getElementById('qty_jual').value = '';
                            }
                        } else {
                            console.log('Error:', xhr.status);
                        }
                    }
                };
                xhr.open("GET", url, true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send();
            }

            // Form validation - Check if at least 1 product is added
            document.getElementById('sellingForm').addEventListener('submit', function(e) {
                const transDetailBody = document.querySelector('#transDetail tbody');
                const productRows = transDetailBody.querySelectorAll('tr');
                
                // Check if there are any product rows (excluding empty state)
                const validRows = Array.from(productRows).filter(row => {
                    return !row.querySelector('td[colspan]'); // Exclude rows with colspan (empty state)
                });

                if (validRows.length === 0) {
                    e.preventDefault();
                    
                    // Show custom alert notification
                    showProductValidationAlert();

                    // Scroll to product section
                    const productInput = document.querySelector('#produk');
                    if (productInput) {
                        productInput.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'center' 
                        });
                        // Focus on product select
                        setTimeout(() => {
                            productInput.focus();
                        }, 500);
                    }
                    
                    return false;
                }

                // If validation passes, check the mode for closing
                const mode = document.getElementById('mode').value;
                if (mode === 'Konfirmasi Lunas') {
                    // Additional confirmation for closing
                    if (!confirm('Apakah Anda yakin ingin mengkonfirmasi penjualan ini sebagai lunas?')) {
                        e.preventDefault();
                        return false;
                    }
                }

                return true;
            });

            // Show custom alert notification
            function showProductValidationAlert() {
                // Remove existing alerts
                const existingAlert = document.getElementById('product-validation-alert');
                if (existingAlert) {
                    existingAlert.remove();
                }

                const alertDiv = document.createElement('div');
                alertDiv.id = 'product-validation-alert';
                alertDiv.className = 'fixed top-4 right-4 z-50 max-w-md animate-slide-in';
                alertDiv.innerHTML = `
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 p-5 rounded-lg shadow-2xl">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-7 w-7 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4 flex-1 ">
                                <h3 class="text-base font-bold text-yellow-900 mb-1">
                                    ⚠️ Peringatan!
                                </h3>
                                <div class="text-sm text-yellow-800 space-y-1">
                                    <p class="font-semibold">Minimal 1 produk harus ditambahkan!</p>
                                    <p class="text-xs text-yellow-700">Silakan tambahkan produk terlebih dahulu sebelum menyimpan transaksi penjualan.</p>
                                </div>
                            </div>
                            <div class="ml-4">
                                <button onclick="this.closest('#product-validation-alert').remove()" 
                                        class="text-yellow-500 hover:text-yellow-700 transition-colors duration-200 focus:outline-none">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button onclick="this.closest('#product-validation-alert').remove()" 
                                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-sm">
                                Mengerti
                            </button>
                        </div>
                    </div>
                `;
                document.body.appendChild(alertDiv);

                // Add slide-in animation
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes slide-in {
                        from {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                    .animate-slide-in {
                        animation: slide-in 0.3s ease-out;
                    }
                    @keyframes shake {
                        0%, 100% { transform: translateX(0); }
                        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                        20%, 40%, 60%, 80% { transform: translateX(5px); }
                    }
                    .animate-shake {
                        animation: shake 0.5s ease-in-out;
                    }
                `;
                if (!document.getElementById('validation-alert-styles')) {
                    style.id = 'validation-alert-styles';
                    document.head.appendChild(style);
                }

                // Add shake animation to product input
                const productInput = document.querySelector('#produk');
                if (productInput) {
                    productInput.parentElement.classList.add('animate-shake');
                    setTimeout(() => {
                        productInput.parentElement.classList.remove('animate-shake');
                    }, 500);
                }

                // Auto remove after 8 seconds
                setTimeout(() => {
                    if (alertDiv && alertDiv.parentElement) {
                        alertDiv.style.transition = 'transform 0.3s ease-in, opacity 0.3s ease-in';
                        alertDiv.style.transform = 'translateX(100%)';
                        alertDiv.style.opacity = '0';
                        setTimeout(() => {
                            if (alertDiv && alertDiv.parentElement) {
                                alertDiv.remove();
                            }
                        }, 300);
                    }
                }, 8000);

                // Play notification sound (optional)
                try {
                    const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIGWi777eeTRAMT6fk77RgGwY5kdfy0H4tBSR0yO/eizwKFWK56+mmUxIKRp/f8r1rIAUsgs/z2ogzBxppu+64n0wQC1Cn5O+zXxsGOpPY88+ALgUldsrv3og6ChViu+vqpVMSCkef4PK9aiAFK4LO89mIMQcaarvvuZ9MEAxPqOTwsl4bBjuU2fPPgC4FJHfK7+CIOQoVYrvr6qVTEgpHn+Dyv2sgBSuCzvPZhzEHGmq777meThAMT6jl8LJeGgY7lNnzz3"8uBSR3yu/ghzkKFWK76+qlUxIKR6Dh8sBqIAUrgs7z2YYwBxpqu++5nk4QDE+o5fCyXhoGPJTZ88+ALgUkd8rv4Ic5ChViu+vqpVMSCkeg4fLAaiAFK4PO89mGMAcaarwApe5PEDQAAAAABJRU5ErkJggg==');
                    audio.volume = 0.3;
                    audio.play().catch(() => {
                        // Ignore if audio play fails
                    });
                } catch (e) {
                    // Ignore audio errors
                }
            }

            // Prevent double submission
            let isSubmitting = false;
            document.getElementById('sellingForm').addEventListener('submit', function(e) {
                if (isSubmitting) {
                    e.preventDefault();
                    return false;
                }
                
                // Check validation first
                const transDetailBody = document.querySelector('#transDetail tbody');
                const productRows = transDetailBody.querySelectorAll('tr');
                const validRows = Array.from(productRows).filter(row => {
                    return !row.querySelector('td[colspan]');
                });

                if (validRows.length > 0) {
                    isSubmitting = true;
                    // Show loading on submit buttons
                    const submitButtons = this.querySelectorAll('button[type="submit"]');
                    submitButtons.forEach(btn => {
                        btn.disabled = true;
                        const originalText = btn.innerHTML;
                        btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Menyimpan...';
                    });
                }
            });
        </script>
    @endpush
@endsection
