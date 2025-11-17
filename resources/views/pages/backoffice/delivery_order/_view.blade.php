@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">{{$title}}</h2>
                <p class="mt-1 text-slate-600">Detail pesanan delivery #{{ $data['header']->id }}</p>
            </div>
            <div class="flex items-center gap-2">
                <x-base.button variant="outline-secondary" onclick="window.history.back()">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" />
                    Kembali
                </x-base.button>
                <x-base.button variant="primary" onclick="window.location.href='{{ route('delivery_order.coretax-preview', $data['header']->id) }}'">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="FileText" />
                    Export to Coretax
                </x-base.button>
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    {{ $data['header']->status == 'Completed' ? 'bg-success/20 text-success' : 
                       ($data['header']->status == 'On Progress' ? 'bg-warning/20 text-warning' : 
                       'bg-slate-100 text-slate-500') }}">
                    {{ $data['header']->status }}
                </span>
            </div>
        </div>

        <!-- Status Alert -->
        @if (session('failed'))
            <x-base.alert class="mb-4 mt-5 flex items-center" variant="outline-danger">
                <x-base.lucide class="mr-2 h-6 w-6" icon="AlertOctagon" />
                {{ session('failed') }}
                <x-base.alert.dismiss-button class="btn-close" type="button" aria-label="Close">
                    <x-base.lucide class="h-4 w-4" icon="X" />
                </x-base.alert.dismiss-button>
            </x-base.alert>
        @endif

        <!-- Summary Cards -->
        <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex items-center">
                    <div class="mr-4 rounded-full bg-primary/10 p-3">
                        <x-base.lucide class="h-6 w-6 text-primary" icon="Calendar" />
                    </div>
                    <div>
                        <div class="text-sm text-slate-500">Tanggal Pembelian</div>
                        <div class="text-lg font-medium">{{ \Carbon\Carbon::parse($data['header']->purchase_date)->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex items-center">
                    <div class="mr-4 rounded-full bg-warning/10 p-3">
                        <x-base.lucide class="h-6 w-6 text-warning" icon="Truck" />
                    </div>
                    <div>
                        <div class="text-sm text-slate-500">Tanggal Pengambilan</div>
                        <div class="text-lg font-medium">{{ \Carbon\Carbon::parse($data['header']->pick_up_date)->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-5">
                <div class="flex items-center">
                    <div class="mr-4 rounded-full {{ $data['header']->transaction_type == 'Kontan' ? 'bg-success/10' : 'bg-danger/10' }} p-3">
                        <x-base.lucide class="h-6 w-6 {{ $data['header']->transaction_type == 'Kontan' ? 'text-success' : 'text-danger' }}" 
                            icon="Wallet" />
                    </div>
                    <div>
                        <div class="text-sm text-slate-500">Tipe Pembayaran</div>
                        <div class="text-lg font-medium">{{ $data['header']->transaction_type }}</div>
                    </div>
                </div>
            </div>
        </div>
    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-12">
            <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($type != 'create')
                    @method('PUT')
                @endif
                <!-- BEGIN: Form Layout -->
                <div class="intro-y rounded-lg border border-slate-200 bg-white" id="myForm">
                    <div class="p-5">
                        <h3 class="mb-4 text-lg font-medium">Detail Pesanan</h3>
                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                            <div class="space-y-4">
                                <div>
                                    <x-base.form-label for="tanggal_pembelian">Tanggal Pembelian</x-base.form-label>
                                    <x-base.form-input 
                                        class="w-full" 
                                        id="tanggal_pembelian" 
                                        type="date" 
                                        name="tanggal_pembelian"
                                        value="{{ $data['header']->purchase_date ?? date('Y-m-d') }}" 
                                        required 
                                        disabled
                                        placeholder="Pilih Tanggal Pembelian" 
                                    />
                                    @error('tanggal_pembelian')
                                        <div class="mt-2 text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                    <div class="mt-2 grid grid-cols-12 gap-2">
                        <div class="input-form col-span-6">
                            <x-base.form-label for="tipe_pembelian">Tipe Pembelian</x-base.form-label>
                            <x-base.tom-select name="tipe_pembelian" id="tipe_pembelian" class="w-full"
                                data-placeholder="Pilih Tipe Pembelian" required disabled>
                                <option value="">Pilih Tipe Pembelian</option>
                                <option value="Tempo Panjang"
                                    {{ $data['header']->transaction_type == 'Tempo Panjang' ? 'selected' : '' }}>Tempo
                                    Panjang</option>
                                <option value="Kontan"
                                    {{ $data['header']->transaction_type == 'Kontan' ? 'selected' : '' }}>Kontan</option>
                            </x-base.tom-select>
                            @error('tipe_pembelian')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-6">
                            <x-base.form-label for="supplier">Supplier</x-base.form-label>
                            <x-base.tom-select name="supplier" id="supplier" class="w-full"
                                data-placeholder="Pilih Supplier" required disabled>
                                <option value="">Pilih Supplier</option>
                                @foreach ($data['supplier'] as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ $data['header']->supplier_id == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                            @error('supplier')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2 grid grid-cols-12 gap-2">
                        @if ($data['header']->status != 'On Progress')
                            <div class="input-form col-span-12">
                                <x-base.form-label for="catatan">Catatan</x-base.form-label>
                                <x-base.form-textarea class="form-control" id="catatan" name="catatan"
                                    placeholder="Masukkan catatan (Optional)..."
                                    value="{{ $data['header']->notes ?? old('catatan') }}" disabled></x-base.form-textarea>
                            </div>
                        @else
                            <div class="input-form col-span-12">
                                <x-base.form-label for="catatan">Catatan</x-base.form-label>
                                <x-base.form-textarea class="form-control" id="catatan" name="catatan"
                                    placeholder="Masukkan catatan (Optional)..."
                                    value="{{ $data['header']->notes ?? old('catatan') }}"></x-base.form-textarea>
                            </div>
                        @endif
                    </div>
                    <br>
                    <hr style="border: 1px solid black;">
                    <br>
                    @error('produk_id')
                        <div class="pristine-error text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('total_bayar')
                        <div class="pristine-error text-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                    <table class="min-w-full bg-white border-gray-300" id="table_product">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-left w-1/4">Produk</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Qty</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Harga/Kg</th>
                                <th class="py-2 px-4 border-b text-left w-1/4">Subtotal</th>
                                <!-- Tambahkan header lainnya sesuai kebutuhan -->
                            </tr>
                        </thead>
                        <tbody >
                            @if (isset($data['detail']))
                                @foreach ($data['detail'] as $item)
                                    <tr class="row-data">
                                        <td class="py-2 px-4" hidden>{{ $item['product_id'] }}</td>
                                        <td class="py-2 px-4 w-1/4">{{ $item['product']['product'] }}</td>
                                        <td class="py-2 px-4 jumlah_qty w-1/4">{{ $item['purchase_amount'] }}<input
                                                type="hidden" name="jumlah_qty[]" id="jumlah_qty[]"
                                                value="{{ $item['purchase_amount'] }}" /></td>
                                        <td class="py-2 px-4 hargaKG w-1/4">{{ toThousand($item['price_kg']) }}<input
                                                type="hidden" class="column_hargaKG" name="hargaKG[]" id="hargaKG[]"
                                                value="{{ $item['price_kg'] }}" /></td>
                                        <td class="py-2 px-4 subtotal w-1/4">{{ toThousand($item['subtotal']) }}<input type="hidden"
                                                class="column_subtotal" name="subtotal_produk[]" id="subtotal_produk[]"
                                                value="{{ $item['subtotal'] }}" /></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-dark text-white">
                                <th class="py-2 px-4 border-b text-center" colspan="3">Grand Total</th>
                                <th class="py-2 px-4 border-b text-center grand_total">
                                    {{ toThousand($data['header']->grand_total ?? 0) }}</th>
                            </tr>
                            @if ($data['header']->status == 'On Progress')
                                <tr class="bg-dark hidden">
                                    <th class="py-2 px-4 border-b text-center text-white" colspan="3">Total Bayar</th>
                                    <th class="py-2 px-4 border-b text-center text-white">
                                        {{ toThousand($data['header']->total_payment ?? 0) }}
                                    </th>
                                </tr>
                                @if($data['header']['transaction_type'] == 'Kontan')
                                <tr class="bg-dark ">
                                    <th class="py-2 px-4 border-b text-center text-white" colspan="3">Angsuran</th>
                                    <th class="py-2 px-4 border-b text-center">
                                        <x-base.form-input class="w-3/5 text-center" price="true" id="angsuran" type="text"
                                            name="angsuran" value="" placeholder="Input Angsuran" required
                                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                    </th>
                                </tr>
                                @endif
                            @else
                                <tr class="bg-dark ">
                                    <th class="py-2 px-4 border-b text-center text-white" colspan="3">Total Bayar</th>
                                    <th class="py-2 px-4 border-b text-center text-white">
                                        {{ toThousand($data['payment'] ?? 0) }}
                                    </th>
                                </tr>
                            @endif
                        </tfoot>
                    </table>

                    <input type="hidden" name="mode" id="mode" value="angsuran" />

                    <div class="mt-5 text-right">
                        <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">
                            <a href="{{ route('delivery_order.index') }}" variant="outline-secondary">
                                Kembali
                            </a>
                        </x-base.button>
                        @if ($data['header']->status == 'On Progress')
                            <x-base.button class="w-50 hidden" type="submit" variant="primary">
                                Tambah Produk
                            </x-base.button>
                        @endif
                    </div>
                </div>
                <!-- END: Form Layout -->
            </form>
        </div>
    </div>
    @if($data['header']['status'] == 'Completed'  )
    <!-- Add Product Form -->
    @if($data['payment_detail']->sum('subtotal') < $data['header']->grand_total )
    <div class="mt-6">
        <div class="intro-y rounded-lg border border-slate-200 bg-white hidden">
            <div class="p-5">
                <h3 class="mb-4 text-lg font-medium">Tambah Produk</h3>
                <form action="{{ $routeQuota }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                         <div>
                            <x-base.form-label for="qty">No SJ</x-base.form-label>
                            <x-base.form-input 
                                class="w-full" 
                                id="sj" 
                                type="text" 
                                name="sj"
                                value="" 
                                placeholder="Input No SJ"
                            />
                            @error('sj')
                                <div class="mt-2 text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                         <div>
                            <x-base.form-label for="faktur">No Faktur</x-base.form-label>
                            <x-base.form-input 
                                class="w-full" 
                                id="faktur" 
                                type="text" 
                                name="faktur"
                                value="" 
                                placeholder="Input No Faktur"
                            />
                            @error('faktur')
                                <div class="mt-2 text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <x-base.form-label for="produk">Produk</x-base.form-label>
                            <x-base.tom-select name="produk" id="produk" class="w-full" data-placeholder="Pilih Produk">
                                <option value="">Pilih Produk</option>
                                @foreach ($data['detail'] as $product)
                                    <option value="{{ $product->product->id }}_{{ $product->product->product ?? '-' }}_{{$product->price_kg}}_{{ $product->purchase_amount }}">
                                        {{ $product->product->product ?? '-' }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                        </div>
                        <div>
                            <x-base.form-label for="qty">Jumlah (QTY)</x-base.form-label>
                            <x-base.form-input 
                                class="w-full" 
                                id="qty" 
                                type="text" 
                                name="qty"
                                value="" 
                                placeholder="Input Qty Produk"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
                            />
                            @error('qty')
                                <div class="mt-2 text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <x-base.button type="button" variant="primary" onclick="tambahProduk()">
                            <x-base.lucide class="mr-2 h-4 w-4" icon="Plus" />
                            Tambah Produk
                        </x-base.button>
                    </div>

                    <div class="mt-6">
                        @error('produk_id')
                            <div class="mb-2 text-danger">{{ $message }}</div>
                        @enderror
                        @error('total_bayar')
                            <div class="mb-2 text-danger">{{ $message }}</div>
                        @enderror

                        <div class="rounded-lg border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead>
                                    <tr class="bg-slate-50">
                                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">No. SJ</th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">No. Faktur</th>
                                        <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">Produk</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-slate-600">Qty</th>
                                        <th class="px-4 py-3 text-right text-sm font-medium text-slate-600">Subtotal</th>
                                        <th class="px-4 py-3 text-center text-sm font-medium text-slate-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="products" class="divide-y divide-slate-200"></tbody>
                                <tfoot>
                                    <tr class="bg-slate-50">
                                        <td class="px-4 py-3 text-right font-medium text-slate-600" colspan="5">
                                            Tanggal Pengambilan
                                        </td>
                                        <td class="px-4 py-3">
                                            <x-base.form-input 
                                                class="w-full" 
                                                id="tanggal_pengambilan" 
                                                type="date"
                                                name="tanggal_pengambilan" 
                                                value="{{ $data['header']->pick_up_date ?? date('Y-m-d') }}"
                                            />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-4 flex justify-end gap-2">
                            <x-base.button class="w-24" type="button" variant="outline-secondary">
                                <a href="{{ route('delivery_order.index') }}">
                                    {{ $type != 'detail' ? 'Batal' : 'Kembali' }}
                                </a>
                            </x-base.button>
                            <x-base.button class="w-24" type="submit" variant="primary">
                                Simpan
                            </x-base.button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Transaction History -->
    <div class="mt-6">
        <div class="intro-y rounded-lg border border-slate-200 bg-white">
            <div class="p-5">
                <h3 class="mb-4 text-lg font-medium">Riwayat Transaksi</h3>
                <div class="rounded-lg border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">No. SJ</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">No. Faktur</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">Tanggal Pengambilan</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-slate-600">Produk</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-slate-600">Qty</th>
                                <th class="px-4 py-3 text-right text-sm font-medium text-slate-600">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($data['payment_detail'] as $item)
                                <tr>
                                    <td class="px-4 py-3 text-slate-600">{{ $item->no_sj }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $item->no_faktur }}</td>
                                    <td class="px-4 py-3 text-slate-600">
                                        {{ $item->stock->purchase_date->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">{{ $item->stock->product->product }}</td>
                                    <td class="px-4 py-3 text-center text-slate-600">{{ $item->purchase_amount }}</td>
                                    <td class="px-4 py-3 text-right font-medium text-slate-600">
                                        {{ toThousand($item->subtotal) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-3 text-center text-slate-500" colspan="6">
                                        <i>Belum ada data transaksi</i>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
        <script>
            function tambahProduk() {
                const produk = $('#produk').val()?.split('_');
                const qty = $('#qty').val();
                const purchase_amount = parseInt({{$data['payment_detail']->sum('purchase_amount')}});
                if(parseInt(qty) > (parseInt(produk[3] - purchase_amount))) {
                    const alert = `
                        <div class="">
                            <div class="rounded-md border border-danger bg-danger/20 px-4 py-3 text-danger">
                                <div class="flex items-center">
                                    <x-base.lucide class="mr-2 h-5 w-5" icon="AlertOctagon" />
                                    <span>Jumlah (QTY) melebihi sisa kuota produk</span>
                                </div>
                            </div>
                        </div>
                    `;
                    $(alert).insertBefore('#qty').fadeIn();
                    
                    // Remove alert after 3 seconds
                    setTimeout(() => {
                        $('.bg-danger\\\/20').fadeOut(function() {
                            $(this).remove();
                        });
                    }, 3000);
                    
                    return false;
                }
                if (!produk?.length || !qty) {
                    // Show error alert
                    const alert = `
                        <div class="mb-4">
                            <div class="rounded-md border border-danger bg-danger/20 px-4 py-3 text-danger">
                                <div class="flex items-center">
                                    <x-base.lucide class="mr-2 h-5 w-5" icon="AlertOctagon" />
                                    <span>Harap mengisi form produk dan jumlah</span>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Insert alert before the form
                    $(alert).insertBefore('#produk').fadeIn();
                    
                    // Remove alert after 3 seconds
                    setTimeout(() => {
                        $('.bg-danger\\\/20').fadeOut(function() {
                            $(this).remove();
                        });
                    }, 3000);
                    
                    return false;
                }

                // Check if product already exists
                if ($('.produk_id').toArray().some(el => $(el).text() === produk[0])) {
                    const alert = `
                        <div class="mb-4">
                            <div class="rounded-md border border-warning bg-warning/20 px-4 py-3 text-warning">
                                <div class="flex items-center">
                                    <x-base.lucide class="mr-2 h-5 w-5" icon="AlertTriangle" />
                                    <span>Produk ini sudah ada dalam daftar</span>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $(alert).insertBefore('#produk').fadeIn();
                    
                    setTimeout(() => {
                        $('.bg-warning\\\/20').fadeOut(function() {
                            $(this).remove();
                        });
                    }, 3000);
                    
                    return false;
                }

                const products = `
                    <tr class="row-data">
                        <td class="produk_id" hidden>
                            ${produk[0]}
                            <input type="hidden" name="produk_id[]" value="${produk[0]}" />
                        </td>
                        <td class="px-4 py-3">
                            ${$('#sj').val()}
                            <input type="hidden" name="no_sj[]" value="${$('#sj').val()}" />
                        </td>
                        <td class="px-4 py-3">
                            ${$('#faktur').val()}
                            <input type="hidden" name="no_faktur[]" value="${$('#faktur').val()}" />
                        </td>
                        <td class="px-4 py-3">
                            ${produk[1]}
                        </td>
                        <td class="px-4 py-3 text-center">
                            ${qty}
                            <input type="hidden" name="jumlah_qty[]" value="${qty}" />
                        </td>
                        <td class="px-4 py-3 text-right">
                            Rp ${toCurrency(qty * produk[2])}
                            <input type="hidden" class="subtotal" name="subtotal[]" value="${qty * produk[2]}" />
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button type="button" onclick="hapusRow(this)" class="inline-flex items-center text-danger hover:text-danger/70">
                                <x-base.lucide class="h-4 w-4" icon="Trash2" />
                                <span class="ml-2">Hapus</span>
                            </button>
                        </td>
                    </tr>
                `;
                
                $('#products').append(products);

                // Reset form
                $('#produk').val('').trigger('change');
                $('#qty').val('');
                // set form clear
                $('#sj').val('');
                $('#faktur').val('');

            }

            function hapusRow(button) {
                // Remove row with fade animation
                $(button).closest('tr').fadeOut(300, function() {
                    $(this).remove();
                    
                    // Update totals
                    let totalSubtotal = 0;
                    $('.subtotal').each(function() {
                        totalSubtotal += parseInt($(this).val()) || 0;
                    });

                    // Update display with animation
                    $('.grand_total')
                        .fadeOut(200)
                        .text(toCurrency(totalSubtotal))
                        .fadeIn(200);
                        
                    $('#grand_total').val(totalSubtotal);
                });
            }

            function confirmDeliveryOrder() {
                $('.mode').html('<input type="hidden" name="mode" value="konfirmasi"/>');
            }
        </script>
    @endpush
@endsection
