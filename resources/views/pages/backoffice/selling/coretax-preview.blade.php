@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex flex-col gap-3">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Preview Export Coretax</h2>
                <p class="mt-1 text-slate-500">Preview data sebelum export ke format Coretax</p>
            </div>
            <div class="flex items-center gap-2">
                <x-base.button variant="outline-secondary" onclick="window.history.back()">
                    <x-base.lucide class="mr-2 h-4 w-4" icon="ArrowLeft" />
                    Kembali
                </x-base.button>
            </div>
        </div>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <!-- Header Information -->
            <div class="mb-5 rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 bg-gradient-to-r from-primary/5 to-primary/10 p-5">
                    <h3 class="flex items-center text-lg font-bold text-primary">
                        <x-base.lucide class="mr-2 h-6 w-6" icon="FileText" />
                        Informasi Faktur Pajak
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 lg:col-span-6">
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                                        <x-base.lucide class="h-5 w-5 text-primary" icon="Hash" />
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium text-slate-500">Nomor Faktur</div>
                                        <div class="mt-1 text-lg font-bold text-slate-900">{{ $previewData['invoice_number'] }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10">
                                        <x-base.lucide class="h-5 w-5 text-primary" icon="Calendar" />
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium text-slate-500">Tanggal Transaksi</div>
                                        <div class="mt-1 text-lg font-bold text-slate-900">{{ $previewData['formatted_date'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 lg:col-span-6">
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-success/10">
                                        <x-base.lucide class="h-5 w-5 text-success" icon="Building2" />
                                    </div>
                                    <div>
                                        <div class="text-xs font-medium text-slate-500">Pembeli</div>
                                        <div class="mt-1 text-lg font-bold text-slate-900">{{ $previewData['selling']->customer->name }}</div>
                                        <div class="mt-1 text-sm text-slate-600">{{ $previewData['selling']->customer->address ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Preview Table -->
            <div class="mb-5 rounded-lg border border-slate-200 bg-white">
                <div class="border-b border-slate-200 p-5">
                    <h3 class="flex items-center text-base font-medium">
                        <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="Package" />
                        Detail Item Transaksi
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Nama Barang</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-600">Harga Satuan</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-600">Jumlah</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-600">Harga Total</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-600">DPP</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-600">PPN (11%)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach ($previewData['items'] as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 text-sm">{{ $item['Nomor Item'] }}</td>
                                    <td class="px-4 py-3 text-sm font-medium">{{ $item['Nama Barang/Jasa'] }}</td>
                                    <td class="px-4 py-3 text-right text-sm">Rp {{ number_format($item['Harga Satuan'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-center text-sm">{{ $item['Jumlah Barang'] }}</td>
                                    <td class="px-4 py-3 text-right text-sm font-medium">Rp {{ number_format($item['Harga Total'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-sm">Rp {{ number_format($item['DPP (Dasar Pengenaan Pajak)'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-sm text-success">Rp {{ number_format($item['PPN'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50">
                            <tr class="font-bold">
                                <td colspan="5" class="px-4 py-4 text-right">Total DPP:</td>
                                <td colspan="2" class="px-4 py-4 text-right text-primary">Rp {{ number_format($previewData['total_dpp'], 0, ',', '.') }}</td>
                            </tr>
                            <tr class="font-bold">
                                <td colspan="5" class="px-4 py-4 text-right">Total PPN (11%):</td>
                                <td colspan="2" class="px-4 py-4 text-right text-success">Rp {{ number_format($previewData['total_ppn'], 0, ',', '.') }}</td>
                            </tr>
                            <tr class="bg-primary/10 font-bold">
                                <td colspan="5" class="px-4 py-4 text-right text-lg">TOTAL NILAI:</td>
                                <td colspan="2" class="px-4 py-4 text-right text-lg text-primary">Rp {{ number_format($previewData['total_nilai'], 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Export Options -->
            <div class="rounded-lg border border-slate-200 bg-white p-6">
                <h3 class="mb-4 flex items-center text-base font-medium">
                    <x-base.lucide class="mr-2 h-5 w-5 text-primary" icon="Download" />
                    Pilih Format Export
                </h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <a href="{{ route('selling.coretax-export-csv', $previewData['selling']->id) }}" 
                       class="group block rounded-lg border-2 border-success/20 bg-gradient-to-br from-success/5 to-success/10 p-6 transition-all hover:border-success hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-success/20 transition-all group-hover:scale-110">
                                <x-base.lucide class="h-7 w-7 text-success" icon="FileSpreadsheet" />
                            </div>
                            <div class="flex-1">
                                <div class="text-lg font-bold text-slate-900">Export CSV</div>
                                <div class="mt-1 text-sm text-slate-600">Format CSV untuk import ke Coretax</div>
                            </div>
                            <x-base.lucide class="h-5 w-5 text-success transition-transform group-hover:translate-x-1" icon="ArrowRight" />
                        </div>
                    </a>

                    <a href="{{ route('selling.coretax-export-xml', $previewData['selling']->id) }}" 
                       class="group block rounded-lg border-2 border-primary/20 bg-gradient-to-br from-primary/5 to-primary/10 p-6 transition-all hover:border-primary hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-primary/20 transition-all group-hover:scale-110">
                                <x-base.lucide class="h-7 w-7 text-primary" icon="FileCode" />
                            </div>
                            <div class="flex-1">
                                <div class="text-lg font-bold text-slate-900">Export XML</div>
                                <div class="mt-1 text-sm text-slate-600">Format XML untuk import ke Coretax</div>
                            </div>
                            <x-base.lucide class="h-5 w-5 text-primary transition-transform group-hover:translate-x-1" icon="ArrowRight" />
                        </div>
                    </a>
                </div>

                <div class="mt-6 rounded-lg bg-info/10 p-4">
                    <div class="flex items-start gap-3">
                        <x-base.lucide class="mt-0.5 h-5 w-5 text-info" icon="Info" />
                        <div class="flex-1 text-sm text-slate-700">
                            <p class="font-medium text-info">Catatan Penting:</p>
                            <ul class="mt-2 list-inside list-disc space-y-1">
                                <li>File CSV dapat dibuka dengan Microsoft Excel atau aplikasi spreadsheet lainnya</li>
                                <li>File XML dapat diimport langsung ke sistem Coretax</li>
                                <li>Pastikan data NPWP pelanggan sudah benar sebelum export</li>
                                <li>Tarif PPN yang digunakan adalah 11% sesuai peraturan terbaru</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
