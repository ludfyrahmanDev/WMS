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
                @if ($type != 'create')
                    <x-base.button class="px-3" variant="outline-danger">
                        <x-base.lucide class="mr-2 h-4 w-4" icon="FileX"/>
                        Batalkan
                    </x-base.button>
                @endif
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
            <form action="{{ $route }}" method="post" enctype="multipart/form-data">
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
                                        <div class="mb-3">
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
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                            onKeyUp="getHargaStock(this.value)" 
                                        />
                                        <x-base.input-group.text>
                                            <x-base.button 
                                                type="button" 
                                                id="modalDetailStockHarga" 
                                                data-tw-toggle="modal"
                                                data-tw-target="#detailStockHarga" 
                                                variant="primary" 
                                                disabled
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
                                                    Rp {{ toThousand($item['price_sell']) }}
                                                    <input type="hidden" name="harga_jual[]" value="{{ $item['price_sell'] }}" />
                                                </td>
                                                <td class="px-4 py-3 text-right font-medium">
                                                    Rp {{ toThousand($item['subtotal']) }}
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
                                        Rp {{ toThousand($data['header']->grand_total) ?? 0 }}
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
                    }
                    
                    if (remainingQty > 0) {
                        alert('Stok dengan harga lama tidak mencukupi! Sisa qty yang tidak dapat dialokasikan: ' + remainingQty);
                        arrLaba = [];
                        return false;
                    }
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
                    // oldExample += `<div class="text-danger mt-2">⚠️ Kekurangan: ${remainingOld} pcs (Stok tidak mencukupi)</div>`;
                }
                $('#oldPriceExample').html(oldExample || '<div class="text-slate-500">Tidak ada stok yang dapat digunakan</div>');

                // Latest Price Example - Based on last_stock
                let latestExample = '';
                let remainingLatest = qty;
                
                for (let stock of stockData) {
                    if (remainingLatest <= 0) break;
                    
                    if (stock.last_stock <= 0) continue;
                    
                    let qtyToUse = Math.min(remainingLatest, stock.last_stock);
                    latestExample += `<div>Stock #${stock.stock_id}: ${qtyToUse} pcs × harga stok tersedia (Tersedia: ${stock.last_stock})</div>`;
                    remainingLatest -= qtyToUse;
                }
                
                if (remainingLatest > 0) {
                    // latestExample += `<div class="text-danger mt-2">⚠️ Kekurangan: ${remainingLatest} pcs (Stok tidak mencukupi)</div>`;
                }
                $('#latestPriceExample').html(latestExample || '<div class="text-slate-500">Tidak ada stok yang tersedia</div>');
            }

            function tambahProduk() {
                var produk = $('#produk').val().split('_');
                var qty = $('#qty_jual').val();
                var harga_jual = currencyToNumber($('#harga_jual').val());
                var profit = $('#laba_bersih').val();
                var subtotal = parseInt(harga_jual) * parseInt(qty);

                if (produk == "" || qty == "" || harga_jual == "") {
                    alert("Harap pilih produk, qty, harga terjual terlebih dahulu!");
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
                    const price_kg = arrLaba[i].price_kg;
                    const stock = arrLaba[i].stock;

                    totalLaba += (parseInt(harga_jual) - parseInt(price_kg)) * parseInt(stock);
                    labaPerItem += (parseInt(harga_jual) - parseInt(price_kg)) * parseInt(stock);
                }

                var products = `
                    <tr class="row-data">
                        <td class="py-2 px-4 produk_id" hidden>${produk[0]}<input type="hidden" name="produk_id[]" id="produk_id[]" value="${produk[0]}" /></td>
                        <td class="py-2 px-4 profit_peritem" hidden><input type="hidden" name="profit_peritem[]" id="profit_peritem[]" class="column_profit_peritem" value="${labaPerItem}" /></td>
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
                            
                            if (response.length > 0) {
                                // Show price method modal regardless of qty vs stock
                                showPriceMethodModal(response, qty, produk);
                            } else {
                                alert('Stok tidak tersedia!');
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
        </script>
    @endpush
@endsection
