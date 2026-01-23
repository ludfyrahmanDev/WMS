@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
    <style>
        .form-section {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .form-section.active {
            border-left-color: #3b82f6;
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.05) 0%, transparent 100%);
        }
        .form-step {
            opacity: 0.6;
            transition: all 0.3s ease;
        }
        .form-step.active {
            opacity: 1;
            transform: scale(1.05);
        }
        .form-step.completed {
            opacity: 1;
        }
        .interactive-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .interactive-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #3b82f6;
        }
        .product-item {
            transition: all 0.3s ease;
            border-left: 4px solid #e5e7eb;
        }
        .product-item:hover {
            border-left-color: #10b981;
            background-color: #f0fdf4;
            transform: translateX(4px);
        }
        .form-input-enhanced {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }
        .form-input-enhanced:focus {
            border-color: #3b82f6;
            transform: scale(1.02);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn-interactive {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-interactive:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .btn-interactive:active {
            transform: translateY(0);
        }
        .progress-bar {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #10b981);
            border-radius: 2px;
            transition: width 0.5s ease;
        }
        .floating-total {
            position: sticky;
            top: 20px;
            z-index: 10;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .slide-in {
            animation: slideIn 0.5s ease;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection

{{-- <?php echo $data['detail'];
die(); ?> --}}

@section('subcontent')
    <!-- Progress Bar -->
    <div class="intro-y mt-8">
        <div class="progress-bar mb-4">
            <div class="progress-fill" id="formProgress" style="width: 25%"></div>
        </div>
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium">{{$title}}</h2>
            <div class="flex space-x-2">
                <div class="form-step active flex items-center space-x-2 px-3 py-1 bg-blue-100 rounded-full">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    <span class="text-sm font-medium text-blue-700">Info Dasar</span>
                </div>
                <div class="form-step flex items-center space-x-2 px-3 py-1 bg-gray-100 rounded-full">
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    <span class="text-sm font-medium text-gray-600">Produk</span>
                </div>
                <div class="form-step flex items-center space-x-2 px-3 py-1 bg-gray-100 rounded-full">
                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                    <span class="text-sm font-medium text-gray-600">Konfirmasi</span>
                </div>
            </div>
        </div>
    </div>
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

        <div class="intro-y col-span-12 lg:col-span-12">

            <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                @csrf
                @if ($type != 'create')
                    @method('PUT')
                @endif
                <!-- BEGIN: Form Layout -->
                <div class="intro-y interactive-card box p-6 slide-in" id="myForm">
                    <!-- Section 1: Basic Information -->
                    <div class="form-section active mb-6 p-4 rounded-lg" id="section1">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center mr-3 text-sm font-bold">1</span>
                            Informasi Pembelian
                        </h3>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="input-form col-span-6">
                            <x-base.form-label for="crud-form-1" class="flex items-center">
                                <x-base.lucide class="w-4 h-4 mr-2 text-blue-500" icon="Calendar" />
                                Tanggal Pembelian
                            </x-base.form-label>
                            <x-base.form-input class="w-full form-input-enhanced" id="tanggal_pembelian" type="date" name="tanggal_pembelian"
                                value="{{ $data['header']->purchase_date ?? date('Y-m-d') }}" required
                                placeholder="Pilih Tanggal Pembelian" />
                            @error('tanggal_pembelian')
                                <div class="pristine-error text-danger mt-2 flex items-center">
                                    <x-base.lucide class="w-4 h-4 mr-1" icon="AlertCircle" />
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-4 hidden">
                            <x-base.form-label for="crud-form-1">Tanggal Pengambilan</x-base.form-label>
                            <x-base.form-input class="w-full" id="tanggal_pengambilan" type="date"
                                name="tanggal_pengambilan" value="{{ $data['header']->pick_up_date ?? date('Y-m-d') }}"
                                placeholder="Pilih Tanggal Pengambilan"  />
                            @error('tanggal_pengambilan')
                                <div class="pristine-error text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-form col-span-6">
                            <x-base.form-label for="supplier" class="flex items-center">
                                <x-base.lucide class="w-4 h-4 mr-2 text-green-500" icon="Truck" />
                                Supplier
                            </x-base.form-label>
                            <x-base.tom-select name="supplier" id="supplier" class="w-full form-input-enhanced"
                                data-placeholder="Pilih Supplier" required>
                                <option value="">Pilih Supplier</option>
                                @foreach ($data['supplier'] as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ $data['header']->supplier_id == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                            @error('supplier')
                                <div class="pristine-error text-danger mt-2 flex items-center">
                                    <x-base.lucide class="w-4 h-4 mr-1" icon="AlertCircle" />
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-12 gap-4">
                        <div class="input-form col-span-6">
                            <x-base.form-label for="tipe_pembelian" class="flex items-center">
                                <x-base.lucide class="w-4 h-4 mr-2 text-red-500" icon="CreditCard" />
                                Tipe Pembelian
                            </x-base.form-label>
                            <x-base.tom-select name="tipe_pembelian" id="tipe_pembelian" class="w-full form-input-enhanced"
                                data-placeholder="Pilih Tipe Pembelian" required>
                                <option value="">Pilih Tipe Pembelian</option>
                                <option value="Tempo Panjang"
                                    {{ $data['header']->transaction_type == 'Tempo Panjang' ? 'selected' : '' }}>Tempo
                                    Panjang</option>
                                <option value="Kontan"
                                    {{ $data['header']->transaction_type == 'Kontan' ? 'selected' : '' }}>Kontan</option>
                            </x-base.tom-select>
                            @error('tipe_pembelian')
                                <div class="pristine-error text-danger mt-2 flex items-center">
                                    <x-base.lucide class="w-4 h-4 mr-1" icon="AlertCircle" />
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-12 gap-4">
                        <div class="input-form col-span-12">
                            <x-base.form-label for="catatan" class="flex items-center">
                                <x-base.lucide class="w-4 h-4 mr-2 text-gray-500" icon="FileText" />
                                Catatan
                            </x-base.form-label>
                            <x-base.form-textarea class="form-control form-input-enhanced" id="catatan" name="catatan"
                                placeholder="Masukkan catatan (Optional)..."
                                value="{{ $data['header']->notes ?? old('catatan') }}"></x-base.form-textarea>
                        </div>
                    </div>
                    </div>

                    <!-- Section Divider -->
                    <div class="my-8 relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t-2 border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">Detail Produk</span>
                        </div>
                    </div>

                    <!-- Section 2: Product Entry -->
                    <div class="form-section mb-6 p-4 rounded-lg" id="section2">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <span class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center mr-3 text-sm font-bold">2</span>
                            Tambah Produk
                        </h3>
                        <div class="bg-gradient-to-r from-blue-50 to-green-50 p-4 rounded-lg border border-blue-200">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="input-form col-span-3">
                            <x-base.form-label for="produk" class="flex items-center">
                                <x-base.lucide class="w-4 h-4 mr-2 text-blue-500" icon="Package" />
                                Produk
                            </x-base.form-label>
                            <x-base.tom-select name="produk" id="produk" class="w-full form-input-enhanced" data-placeholder="Pilih Produk">
                                <option value="">Pilih Produk</option>
                                @foreach ($data['product'] as $product)
                                    <option value="{{ $product->id }}_{{ $product->product }}">{{ $product->product }}
                                    </option>
                                @endforeach
                            </x-base.tom-select>
                        </div>
                        <div class="input-form col-span-3">
                            <x-base.form-label for="qty" class="flex items-center">
                                <x-base.lucide class="w-4 h-4 mr-2 text-orange-500" icon="Hash" />
                                Qty
                            </x-base.form-label>
                            <x-base.form-input class="w-full form-input-enhanced" type="text" name="qty"
                                id="qty" value="" placeholder="Input Qty Produk"
                                onkeyup="changeSubtotal()"
                                onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46" />
                        </div>
                        <div class="input-form col-span-3">
                            <x-base.form-label for="harga_kg" class="flex items-center">
                                <x-base.lucide class="w-4 h-4 mr-2 text-green-500" icon="DollarSign" />
                                Harga/Kg
                            </x-base.form-label>
                            <x-base.form-input class="w-full form-input-enhanced" type="text" name="harga_kg"
                                onkeyup="changeSubtotal()" price="true"
                                id="harga_kg" value="" placeholder="Input Harga/Kg"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        </div>
                        <div class="input-form col-span-3">
                            <x-base.form-label for="subtotal" class="flex items-center">
                                <x-base.lucide class="w-4 h-4 mr-2 text-purple-500" icon="Calculator" />
                                Subtotal
                            </x-base.form-label>
                            <x-base.form-input class="w-full form-input-enhanced bg-gray-50" type="text" name="subtotal" id="subtotal"
                                value="" placeholder="0" price="true"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" disabled />
                        </div>
                    </div>
                        </div>

                    <div class="mt-4 flex justify-end">
                            <x-base.button onclick="tambahProduk()" type="button" 
                                class="btn-interactive bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600 text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                                <x-base.lucide class="w-4 h-4" icon="Plus" />
                                <span>Tambah Produk</span>
                            </x-base.button>
                        </div>
                    </div>
                    <!-- Floating Total -->
                    <div class="floating-total rounded-lg p-4 mb-4" id="totalSummary">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-700">Grand Total:</span>
                            <span class="text-2xl font-bold text-blue-600" id="displayGrandTotal">Rp 0</span>
                        </div>
                    </div>

                    @error('produk_id')
                        <div class="pristine-error text-danger mt-2 flex items-center bg-red-50 p-3 rounded-lg">
                            <x-base.lucide class="w-4 h-4 mr-2" icon="AlertCircle" />
                            {{ $message }}
                        </div>
                    @enderror
                    @error('total_bayar')
                        <div class="pristine-error text-danger mt-2 flex items-center bg-red-50 p-3 rounded-lg">
                            <x-base.lucide class="w-4 h-4 mr-2" icon="AlertCircle" />
                            {{ $message }}
                        </div>
                    @enderror
                    <!-- Section 3: Product Table -->
                    <div class="form-section mb-6 p-4 rounded-lg" id="section3">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <span class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center mr-3 text-sm font-bold">3</span>
                            Daftar Produk
                        </h3>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <table class="min-w-full bg-white" id="table_product">
                        <thead>
                            <tr class="bg-gradient-to-r from-gray-800 to-gray-700 text-white">
                                <th class="py-3 px-4 border-b text-left w-1/4 flex items-center">
                                    <x-base.lucide class="w-4 h-4 mr-2" icon="Package" />
                                    Produk
                                </th>
                                <th class="py-3 px-4 border-b text-left w-1/4">
                                    <div class="flex items-center">
                                        <x-base.lucide class="w-4 h-4 mr-2" icon="Hash" />
                                        Qty
                                    </div>
                                </th>
                                <th class="py-3 px-4 border-b text-left w-1/4">
                                    <div class="flex items-center">
                                        <x-base.lucide class="w-4 h-4 mr-2" icon="DollarSign" />
                                        Harga/Kg
                                    </div>
                                </th>
                                <th class="py-3 px-4 border-b text-left w-1/4">
                                    <div class="flex items-center">
                                        <x-base.lucide class="w-4 h-4 mr-2" icon="Calculator" />
                                        Subtotal
                                    </div>
                                </th>
                                <th class="py-3 px-4 border-b text-left w-1/4">
                                    <div class="flex items-center">
                                        <x-base.lucide class="w-4 h-4 mr-2" icon="Settings" />
                                        Action
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="products">
                            @if (isset($data['detail']))
                                @foreach ($data['detail'] as $item)
                                    <tr class="product-item row-data hover:bg-gray-50 transition-all duration-200">
                                        <td class="py-3 px-4 produk_id" hidden>{{ $item['product_id'] }}<input
                                                type="hidden" name="produk_id[]" id="produk_id[]"
                                                value="{{ $item['product_id'] }}" /></td>
                                        <td class="py-3 px-4 w-1/4 font-medium text-gray-800">{{ $item['product']['product'] }}</td>
                                        <td class="py-3 px-4 jumlah_qty w-1/4 text-center">
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">{{ $item['purchase_amount'] }}</span>
                                            <input type="hidden" name="jumlah_qty[]" id="jumlah_qty[]" value="{{ $item['purchase_amount'] }}" />
                                        </td>
                                        <td class="py-3 px-4 hargaKG w-1/4 text-green-600 font-semibold">{{ toThousand($item['price_kg']) }}<input
                                                type="hidden" class="column_hargaKG" name="hargaKG[]" id="hargaKG[]"
                                                value="{{ $item['price_kg'] }}" /></td>
                                        <td class="py-3 px-4 subtotal w-1/4 text-purple-600 font-bold">{{ toThousand($item['subtotal']) }}<input type="hidden"
                                                class="column_subtotal" name="subtotal_produk[]" id="subtotal_produk[]"
                                                value="{{ $item['subtotal'] }}" /></td>
                                        <td class="py-3 px-4 w-1/4">
                                            <button onclick="hapusRow(this)" class="btn-interactive bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg flex items-center space-x-1 transition-all duration-200">
                                                <x-base.lucide class="w-4 h-4" icon="Trash2" />
                                                <span class="text-sm">Hapus</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-gradient-to-r from-gray-700 to-gray-800 text-white">
                                <th class="py-4 px-4 border-t text-center font-bold text-lg" colspan="4">
                                    <div class="flex items-center justify-center">
                                        <x-base.lucide class="w-5 h-5 mr-2" icon="Calculator" />
                                        Grand Total
                                    </div>
                                </th>
                                <th class="py-4 px-4 border-t text-center grand_total text-xl font-bold text-green-300">
                                    {{ toThousand($data['header']->grand_total ?? 0) }}
                                </th>
                                <th class="py-2 px-4 border-b text-center" hidden><x-base.form-input
                                        class="w-3/3 text-center" id="grand_total" type="text" name="grand_total"
                                        value="{{ $data['header']->grand_total ?? 0 }}" /></th>
                            </tr>
                            <tr class="bg-gradient-to-r from-gray-600 to-gray-700 text-white hidden">
                                <th class="py-3 px-4 border-b text-center text-white" colspan="4">
                                    <div class="flex items-center justify-center">
                                        <x-base.lucide class="w-4 h-4 mr-2" icon="CreditCard" />
                                        Total Bayar
                                    </div>
                                </th>
                                <th class="py-3 px-4 border-b text-center">
                                    <x-base.form-input class="w-3/3 text-center form-input-enhanced" id="total_bayar" type="text"
                                        name="total_bayar" value="{{ $data['header']->total_payment ?? 0 }}"
                                        placeholder="Input Total Bayar" required price="true"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    </div>

                    <div class="mode"></div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <x-base.button class="btn-interactive px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg" type="button">
                            <a href="{{ route('delivery_order.index') }}" class="flex items-center space-x-2">
                                <x-base.lucide class="w-4 h-4" icon="ArrowLeft" />
                                <span>{{ $type != 'detail' ? 'Batal' : 'Kembali' }}</span>
                            </a>
                        </x-base.button>
                        <x-base.button class="btn-interactive px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg" type="submit">
                            <div class="flex items-center space-x-2">
                                <x-base.lucide class="w-4 h-4" icon="Save" />
                                <span>Simpan</span>
                            </div>
                        </x-base.button>
                        @if ($type != 'create')
                            <x-base.button class="btn-interactive px-6 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg" onclick="confirmDeliveryOrder()" type="submit">
                                <div class="flex items-center space-x-2">
                                    <x-base.lucide class="w-4 h-4" icon="CheckCircle" />
                                    <span>Konfirmasi</span>
                                </div>
                            </x-base.button>
                        @endif
                    </div>
                </div>
                <!-- END: Form Layout -->
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize form interactivity
                initializeFormInteractivity();
                updateFormProgress();
                updateFloatingTotal();
                
                // Add real-time validation
                $('.form-input-enhanced').on('input focus', function() {
                    $(this).removeClass('border-red-500').addClass('border-blue-500');
                });
                
                // Smooth scrolling for form sections
                $('.form-step').on('click', function() {
                    var targetSection = '#section' + ($(this).index() + 1);
                    $('html, body').animate({
                        scrollTop: $(targetSection).offset().top - 100
                    }, 500);
                });
            });

            function initializeFormInteractivity() {
                // Add focus effects to form inputs
                $('.form-input-enhanced').on('focus', function() {
                    $(this).closest('.form-section').addClass('active');
                });
                
                $('.form-input-enhanced').on('blur', function() {
                    $(this).closest('.form-section').removeClass('active');
                });
                
                // Add hover effects to cards
                $('.interactive-card').hover(
                    function() { $(this).addClass('shadow-lg'); },
                    function() { $(this).removeClass('shadow-lg'); }
                );
            }

            function updateFormProgress() {
                var progress = 25;
                var filledInputs = 0;
                var totalInputs = $('.form-input-enhanced').length;
                
                $('.form-input-enhanced').each(function() {
                    if ($(this).val() !== '') {
                        filledInputs++;
                    }
                });
                
                if ($('#products tr').length > 0) {
                    progress = 75;
                }
                
                if (filledInputs > 0) {
                    progress = Math.max(50, (filledInputs / totalInputs) * 100);
                }
                
                $('#formProgress').css('width', progress + '%');
                
                // Update form steps
                $('.form-step').removeClass('active completed');
                if (progress >= 25) $('.form-step').eq(0).addClass('completed');
                if (progress >= 50) $('.form-step').eq(1).addClass('active');
                if (progress >= 75) $('.form-step').eq(1).addClass('completed').removeClass('active');
                if (progress >= 75) $('.form-step').eq(2).addClass('active');
            }

            function updateFloatingTotal() {
                var totalSubtotal = 0;
                $('.column_subtotal').each(function() {
                    var sub_sementara = $(this).val();
                    totalSubtotal += parseInt(currencyToNumber(sub_sementara));
                });
                
                $('#displayGrandTotal').text(toCurrency(totalSubtotal));
                
                // Add pulse animation when total changes
                $('#totalSummary').addClass('pulse-animation');
                setTimeout(function() {
                    $('#totalSummary').removeClass('pulse-animation');
                }, 2000);
            }

            function changeSubtotal(){
                var qty = $('#qty').val();
                var hargaKG = $('#harga_kg').val();
                var hargaFix = isNaN(currencyToNumber(hargaKG)) ? 0 : currencyToNumber(hargaKG);
                var sub = qty * hargaFix;
                $('#subtotal').val(toCurrency(sub));
                
                // Add visual feedback
                if (sub > 0) {
                    $('#subtotal').removeClass('bg-gray-50').addClass('bg-green-50 border-green-300');
                } else {
                    $('#subtotal').removeClass('bg-green-50 border-green-300').addClass('bg-gray-50');
                }
                
                updateFormProgress();
            }

            function tambahProduk() {
                var produk = $('#produk').val().split('_');
                var qty = $('#qty').val();
                var subtotal = $('#subtotal').val();
                var hargaKG = $('#harga_kg').val();
                if (produk.length == 1 || qty == "" || subtotal == "" || hargaKG == "") {
                    showNotification('Harap mengisi form produk, qty, harga/Kg, subtotal', 'error');
                    
                    // Highlight empty fields
                    if (produk.length == 1) $('#produk').addClass('border-red-500');
                    if (qty == "") $('#qty').addClass('border-red-500');
                    if (hargaKG == "") $('#harga_kg').addClass('border-red-500');
                    
                    return false;
                }

                console.log(subtotal);

                var boolean = true
                $('.produk_id').each(function() {
                    var produk_id = $(this).text();
                    if (produk_id == produk[0]) {
                        boolean = false;
                    }
                })

                if (boolean == false) {
                    showNotification('Produk ini sudah ada dalam daftar', 'warning');
                    $('#produk').addClass('border-orange-500');
                    return false;
                }

                var products = `
                    <tr class="product-item row-data hover:bg-gray-50 transition-all duration-200 slide-in">
                            <td class="py-3 px-4 produk_id" hidden>${produk[0]}<input type="hidden" name="produk_id[]" id="produk_id[]" value="${produk[0]}" /></td>
                            <td class="py-3 px-4 w-1/4 font-medium text-gray-800">${produk[1]}</td>
                            <td class="py-3 px-4 jumlah_qty w-1/4 text-center">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">${qty}</span>
                                <input type="hidden" name="jumlah_qty[]" id="jumlah_qty[]" value="${qty}" />
                            </td>
                            <td class="py-3 px-4 hargaKG w-1/4 text-green-600 font-semibold">${hargaKG}<input type="hidden" class="column_hargaKG" name="hargaKG[]" id="hargaKG[]" value="${hargaKG}" /></td>
                            <td class="py-3 px-4 subtotal w-1/4 text-purple-600 font-bold">${subtotal}<input type="hidden" class="column_subtotal" name="subtotal_produk[]" id="subtotal_produk[]" value="${currencyToNumber(subtotal)}" /></td>
                            <td class="py-3 px-4 w-1/4"> 
                                <button onclick="hapusRow(this)" class="btn-interactive bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg flex items-center space-x-1 transition-all duration-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    <span class="text-sm">Hapus</span>
                                </button>
                            </td>
                    </tr>
                `;
                $('#products').html($('#products').html() + products);

                // Calculate totals and update display
                var totalSubtotal = 0;
                $('.column_subtotal').each(function() {
                    var sub_sementara = $(this).val();
                    totalSubtotal += parseInt(currencyToNumber(sub_sementara));
                })

                $('.grand_total').text(toCurrency(totalSubtotal));
                $('#grand_total').val(totalSubtotal);

                if ($('#tipe_pembelian').val() == 'Kontan') {
                    $('#total_bayar').val(toCurrency(totalSubtotal));
                }
                
                // Reset form fields
                $('#produk').val('').trigger('change');
                $('#qty').val('');
                $('#harga_kg').val('');
                $('#subtotal').val('').removeClass('bg-green-50 border-green-300').addClass('bg-gray-50');
                
                // Remove error states
                $('.form-input-enhanced').removeClass('border-red-500 border-orange-500');
                
                // Show success notification
                showNotification('Produk berhasil ditambahkan', 'success');
                
                // Update progress
                updateFormProgress();
                updateFloatingTotal();
            }

            function hapusRow(event) {
                event.closest('tr').remove();

                var totalSubtotal = 0;
                $('.column_subtotal').each(function() {
                    var sub_sementara = $(this).val();
                    totalSubtotal += parseInt(currencyToNumber(sub_sementara));
                })

                $('.grand_total').text(toCurrency(totalSubtotal));
                $('#grand_total').val(totalSubtotal);

                if ($('#tipe_pembelian').val() == 'Kontan') {
                    $('#total_bayar').val(toCurrency(totalSubtotal));
                }
            }

            // function saveDeliveryOrder() {
            //     // Header
            //     var tanggal_pembelian = $('#tanggal_pembelian').val();
            //     var tanggal_pengambilan = $('#tanggal_pengambilan').val();
            //     var supplier = $('#supplier').val();
            //     var driver = $('#driver').val();
            //     var kendaraan = $('#kendaraan').val();

            //     var arr = [];
            //     // getProdukID
            //     $('.produk_id').each(function() {
            //         var produk_id = $(this).text();

            //         arr.push({
            //             produk_id: produk_id,
            //             qty: 0,
            //             subtotal: 0,
            //         })
            //     })

            //     $('.jumlah_qty').each(function(i, v) {
            //         var qty = $(this).text();

            //         arr[i].qty = qty
            //     })

            //     $('.subtotal').each(function(i, v) {
            //         var subtotal = $(this).text();

            //         arr[i].subtotal = subtotal
            //     })

            //     // $.ajax({
            //     //     type: "POST",
            //     //     url: "{{ route('delivery_order.store') }}",
            //     //     data: {
            //     //         tanggal_pembelian: tanggal_pembelian,
            //     //         tanggal_pengambilan: tanggal_pengambilan,
            //     //         supplier: supplier,
            //     //         driver: driver,
            //     //         kendaraan: kendaraan,
            //     //         detail: arr
            //     //     },
            //     //     dataType: "JSON",
            //     //     success: function(response) {

            //     //     }
            //     // })
            // }

            function confirmDeliveryOrder() {
                $('.mode').html('<input type="hidden" name="mode" id="mode" value="konfirmasi stok aktif"/>');
                showNotification('Form akan dikonfirmasi', 'info');
            }

            // Enhanced notification system
            function showNotification(message, type = 'info') {
                var bgColor = 'bg-blue-500';
                var icon = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>';
                
                switch(type) {
                    case 'success':
                        bgColor = 'bg-green-500';
                        icon = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
                        break;
                    case 'error':
                        bgColor = 'bg-red-500';
                        icon = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
                        break;
                    case 'warning':
                        bgColor = 'bg-orange-500';
                        icon = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
                        break;
                }
                
                var notification = `
                    <div class="fixed top-4 right-4 ${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 z-50 slide-in" id="notification">
                        ${icon}
                        <span>${message}</span>
                    </div>
                `;
                
                // Remove existing notification
                $('#notification').remove();
                
                // Add new notification
                $('body').append(notification);
                
                // Auto remove after 3 seconds
                setTimeout(function() {
                    $('#notification').fadeOut(function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            // Enhanced delete function with animation
            function hapusRow(event) {
                // Add animation before removal
                $(event).closest('tr').addClass('opacity-50 scale-95');
                
                setTimeout(function() {
                    $(event).closest('tr').remove();
                    
                    var totalSubtotal = 0;
                    $('.column_subtotal').each(function() {
                        var sub_sementara = $(this).val();
                        totalSubtotal += parseInt(currencyToNumber(sub_sementara));
                    });

                    $('.grand_total').text(toCurrency(totalSubtotal));
                    $('#grand_total').val(totalSubtotal);

                    if ($('#tipe_pembelian').val() == 'Kontan') {
                        $('#total_bayar').val(toCurrency(totalSubtotal));
                    }
                    
                    updateFormProgress();
                    updateFloatingTotal();
                    showNotification('Produk berhasil dihapus', 'success');
                }, 300);
            }

            // Add keyboard shortcuts
            $(document).keydown(function(e) {
                // Ctrl + S to save
                if (e.ctrlKey && e.keyCode == 83) {
                    e.preventDefault();
                    $('form').submit();
                    return false;
                }
                
                // Ctrl + Enter to add product
                if (e.ctrlKey && e.keyCode == 13) {
                    e.preventDefault();
                    tambahProduk();
                    return false;
                }
            });

            // Add tooltip for keyboard shortcuts
            $('<div class="fixed bottom-4 right-4 bg-gray-800 text-white text-xs px-3 py-2 rounded-lg opacity-75 z-40">' +
              'Shortcuts: Ctrl+S (Save), Ctrl+Enter (Add Product)' +
              '</div>').appendTo('body').delay(5000).fadeOut();
        </script>
    @endpush
@endsection
