# Fitur Export Coretax - Delivery Order

## Deskripsi
Fitur ini memungkinkan export data transaksi pembelian (Delivery Order) ke format yang kompatibel dengan sistem Coretax DJP untuk keperluan pelaporan Faktur Pajak Masukan.

## Perbedaan dengan Export Penjualan

### Faktur Pajak Masukan (Delivery Order/Pembelian)
- **Jenis:** Pajak yang dibayar saat pembelian dari supplier
- **Posisi:** Pembeli adalah perusahaan (CV), Penjual adalah supplier
- **Tujuan:** Input tax credit, mengurangi kewajiban pajak
- **Data Utama:** NPWP Supplier (Penjual), Data Perusahaan (Pembeli)

### Faktur Pajak Keluaran (Selling/Penjualan)
- **Jenis:** Pajak yang dipungut saat penjualan ke customer
- **Posisi:** Penjual adalah perusahaan (CV), Pembeli adalah customer
- **Tujuan:** Output tax, kewajiban pajak yang harus disetor
- **Data Utama:** Data Perusahaan (Penjual), NPWP Customer (Pembeli)

## Fitur Utama

### 1. Preview Data Export
- Menampilkan preview Faktur Pajak Masukan
- Informasi lengkap supplier (penjual) dan perusahaan (pembeli)
- Detail item pembelian dengan perhitungan PPN
- Summary total DPP, PPN, dan nilai transaksi
- Nomor Faktur dan Surat Jalan dari supplier

### 2. Format Export yang Didukung

#### CSV (Comma Separated Values)
- Format standard untuk import ke Coretax
- Dapat dibuka dengan Microsoft Excel
- Delimiter: semicolon (;)
- Encoding: UTF-8 with BOM

**Kolom CSV:**
- Nomor Transaksi
- Tanggal Transaksi
- NPWP Penjual (Supplier)
- Nama Penjual
- Alamat Penjual
- NPWP Pembeli (Perusahaan/CV)
- Nama Pembeli
- Alamat Pembeli
- Nomor Item
- Nama Barang/Jasa
- Harga Satuan
- Jumlah Barang
- Harga Total
- Diskon
- DPP (Dasar Pengenaan Pajak)
- PPN (11%)
- Tarif PPN
- PPnBM
- Tarif PPnBM
- Keterangan
- Referensi
- Nomor Faktur
- Nomor SJ (Surat Jalan)

#### XML (Extensible Markup Language)
- Format terstruktur untuk integrasi sistem
- Dapat diimport langsung ke Coretax
- Struktur: Header, Penjual (Supplier), Pembeli (CV), Details, Summary
- Include Nomor Faktur dan Surat Jalan

## Cara Penggunaan

### 1. Dari Halaman Detail Delivery Order
1. Buka detail transaksi Delivery Order
2. Klik tombol "Export to Coretax"
3. Akan diarahkan ke halaman preview
4. Verifikasi data Nomor Faktur dan Surat Jalan
5. Pilih format export (CSV atau XML)
6. File akan terdownload otomatis

### 2. Preview Export
**URL:** `/delivery_order/{id}/coretax-preview`

Halaman preview menampilkan:
- Informasi faktur (Nomor, Surat Jalan, Tanggal)
- Data supplier/penjual (Nama, Alamat, NPWP)
- Data perusahaan/pembeli (Nama, Alamat, NPWP)
- Detail item dengan perhitungan pajak
- Total DPP, PPN 11%, dan nilai keseluruhan

### 3. Download Export
**CSV:** `/delivery_order/{id}/coretax-export-csv`
**XML:** `/delivery_order/{id}/coretax-export-xml`

## Perhitungan Pajak

### PPN (Pajak Pertambahan Nilai)
- Tarif: **11%** (sesuai peraturan terbaru)
- Perhitungan: DPP × 11%
- DPP = Harga Total Item (Subtotal)

### Input Tax Credit
- PPN Masukan dapat dikreditkan untuk mengurangi PPN Keluaran
- Total PPN Masukan = Σ (PPN per item)
- Dapat mengurangi kewajiban pajak perusahaan

## Persyaratan Data

### Data yang Harus Lengkap:
1. **Supplier (Penjual):**
   - Nama (wajib)
   - NPWP (wajib untuk credit pajak)
   - Alamat (recommended)

2. **CV/Perusahaan (Pembeli):**
   - Nama (wajib)
   - NPWP (wajib untuk laporan pajak)
   - Alamat (recommended)

3. **Transaksi:**
   - Tanggal pembelian
   - Nomor Faktur dari supplier (penting)
   - Nomor Surat Jalan (penting)
   - Detail produk yang dibeli
   - Harga dan quantity
   - Total transaksi

## Penting untuk Diperhatikan

### Nomor Faktur & Surat Jalan
⚠️ **SANGAT PENTING:**
- Nomor Faktur harus sesuai dengan faktur fisik dari supplier
- Nomor Surat Jalan harus sesuai dengan dokumen pengiriman
- Kedua nomor ini harus diinput dengan benar untuk validitas pajak
- Tidak boleh ada duplikasi nomor faktur

### NPWP Supplier
- NPWP supplier harus valid dan terdaftar
- Format: XX.XXX.XXX.X-XXX.XXX (15 digit)
- Pastikan NPWP supplier sudah PKP (Pengusaha Kena Pajak)

## File yang Tergenerate

### Lokasi Penyimpanan
`storage/app/exports/`

### Nama File
- CSV: `coretax_do_export_{id}_{timestamp}.csv`
- XML: `coretax_do_export_{id}_{timestamp}.xml`

### Cleanup
File akan otomatis dihapus setelah didownload untuk menghemat storage.

## Troubleshooting

### Error: "Tidak ada data untuk diekspor"
**Solusi:** Pastikan Delivery Order memiliki detail produk

### Error: "Gagal export"
**Solusi:** 
1. Cek permission folder `storage/app/exports/`
2. Pastikan folder exists (otomatis dibuat jika tidak ada)
3. Cek log error di `storage/logs/laravel.log`

### Data NPWP Tidak Valid
**Solusi:**
1. Update NPWP supplier di master data
2. Update NPWP CV/Perusahaan
3. Format NPWP: 15 digit angka
4. Akan otomatis diformat ke `XX.XXX.XXX.X-XXX.XXX`

### Nomor Faktur/SJ Kosong
**Solusi:**
1. Update data Delivery Order
2. Input Nomor Faktur dari supplier
3. Input Nomor Surat Jalan dari supplier
4. Kedua data ini penting untuk validitas pajak

## Struktur Code

### Service
`app/Services/CoretaxDeliveryOrderService.php`
- `generateExportData()` - Generate data export
- `generateCSV()` - Generate file CSV
- `generateXML()` - Generate file XML
- `getPreviewData()` - Data untuk preview
- `formatNPWP()` - Format NPWP ke standard

### Controller
`app/Http/Controllers/DeliveryOrderController.php`
- `coretaxPreview()` - Halaman preview
- `coretaxExportCSV()` - Download CSV
- `coretaxExportXML()` - Download XML

### Routes
```php
Route::get('delivery_order/{id}/coretax-preview', [DeliveryOrderController::class, 'coretaxPreview'])
    ->name('delivery_order.coretax-preview');
    
Route::get('delivery_order/{id}/coretax-export-csv', [DeliveryOrderController::class, 'coretaxExportCSV'])
    ->name('delivery_order.coretax-export-csv');
    
Route::get('delivery_order/{id}/coretax-export-xml', [DeliveryOrderController::class, 'coretaxExportXML'])
    ->name('delivery_order.coretax-export-xml');
```

### Views
`resources/views/pages/backoffice/delivery_order/coretax-preview.blade.php`

## Best Practices

1. **Validasi Data Sebelum Export**
   - Pastikan Nomor Faktur dan SJ sudah diisi
   - Cek NPWP supplier valid
   - Verifikasi perhitungan pajak

2. **Dokumentasi**
   - Simpan copy faktur fisik dari supplier
   - Archive file export untuk audit
   - Catat tanggal dan nomor faktur

3. **Rekonsiliasi**
   - Cocokkan dengan faktur fisik supplier
   - Verifikasi total DPP dan PPN
   - Pastikan tidak ada duplikasi entry

4. **Pelaporan Pajak**
   - Export dilakukan setiap bulan untuk pelaporan
   - Compile semua Faktur Pajak Masukan per periode
   - Credit PPN Masukan di SPT Masa PPN

## Workflow Pajak

### Input Tax (Pajak Masukan)
1. Terima faktur pajak dari supplier
2. Input Nomor Faktur & SJ ke sistem
3. Export data ke Coretax
4. Submit ke DJP untuk credit pajak
5. Gunakan untuk offset PPN Keluaran

### Manfaat Credit Pajak
- Mengurangi kewajiban PPN yang harus dibayar
- PPN Masukan dikreditkan dengan PPN Keluaran
- Selisih dibayar/direstitusi ke DJP

## Update Log

### Version 1.0.0 (2025-10-23)
- Initial release
- Support CSV export
- Support XML export
- Preview feature dengan data supplier dan CV
- PPN 11% calculation
- NPWP formatting
- Include Nomor Faktur dan Surat Jalan
- Faktur Pajak Masukan untuk pembelian

## Support

Untuk pertanyaan atau issue terkait fitur export Coretax Delivery Order, silakan hubungi tim development atau buat ticket di sistem internal.

## Referensi
- Peraturan Menteri Keuangan tentang PPN
- Panduan Penggunaan Coretax DJP
- UU No. 7 Tahun 2021 tentang Harmonisasi Peraturan Perpajakan
