# Fitur Export Coretax

## Deskripsi
Fitur ini memungkinkan export data transaksi penjualan ke format yang kompatibel dengan sistem Coretax DJP (Direktorat Jenderal Pajak) untuk keperluan pelaporan pajak.

## Fitur Utama

### 1. Preview Data Export
- Menampilkan preview data sebelum export
- Informasi faktur pajak lengkap
- Detail item transaksi dengan perhitungan PPN
- Summary total DPP, PPN, dan nilai transaksi

### 2. Format Export yang Didukung

#### CSV (Comma Separated Values)
- Format standard untuk import ke Coretax
- Dapat dibuka dengan Microsoft Excel
- Delimiter: semicolon (;)
- Encoding: UTF-8 with BOM

**Kolom CSV:**
- Nomor Transaksi
- Tanggal Transaksi
- NPWP Pembeli
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

#### XML (Extensible Markup Language)
- Format terstruktur untuk integrasi sistem
- Dapat diimport langsung ke Coretax
- Struktur: Header, Penjual, Pembeli, Details, Summary

## Cara Penggunaan

### 1. Dari Halaman Detail Penjualan
1. Buka detail transaksi penjualan
2. Klik tombol "Export to Coretax"
3. Akan diarahkan ke halaman preview
4. Pilih format export (CSV atau XML)
5. File akan terdownload otomatis

### 2. Preview Export
**URL:** `/selling/{id}/coretax-preview`

Halaman preview menampilkan:
- Informasi faktur (Nomor, Tanggal)
- Data pembeli (Nama, Alamat, NPWP)
- Detail item dengan perhitungan pajak
- Total DPP, PPN 11%, dan nilai keseluruhan

### 3. Download Export
**CSV:** `/selling/{id}/coretax-export-csv`
**XML:** `/selling/{id}/coretax-export-xml`

## Perhitungan Pajak

### PPN (Pajak Pertambahan Nilai)
- Tarif: **11%** (sesuai peraturan terbaru)
- Perhitungan: DPP × 11%
- DPP = Harga Total Item

### Format NPWP
Format standar: `XX.XXX.XXX.X-XXX.XXX`
- Otomatis diformat dari input
- Jika kosong, akan menggunakan format default

## Persyaratan Data

### Data yang Harus Lengkap:
1. **Customer:**
   - Nama (wajib)
   - NPWP (optional, tapi direkomendasikan)
   - Alamat (optional)

2. **CV/Perusahaan:**
   - Nama (wajib)
   - NPWP (optional, untuk keperluan pajak)
   - Alamat (optional)

3. **Transaksi:**
   - Tanggal transaksi
   - Detail produk
   - Harga dan quantity
   - Total transaksi

## File yang Tergenerate

### Lokasi Penyimpanan
`storage/app/exports/`

### Nama File
- CSV: `coretax_export_{id}_{timestamp}.csv`
- XML: `coretax_export_{id}_{timestamp}.xml`

### Cleanup
File akan otomatis dihapus setelah didownload untuk menghemat storage.

## Troubleshooting

### Error: "Tidak ada data untuk diekspor"
**Solusi:** Pastikan transaksi memiliki detail produk

### Error: "Gagal export"
**Solusi:** 
1. Cek permission folder `storage/app/exports/`
2. Pastikan folder exists (otomatis dibuat jika tidak ada)
3. Cek log error di `storage/logs/laravel.log`

### Data NPWP Tidak Valid
**Solusi:**
1. Update NPWP customer di master data
2. Format NPWP: 15 digit angka
3. Akan otomatis diformat ke `XX.XXX.XXX.X-XXX.XXX`

## Struktur Code

### Service
`app/Services/CoretaxExportService.php`
- `generateExportData()` - Generate data export
- `generateCSV()` - Generate file CSV
- `generateXML()` - Generate file XML
- `getPreviewData()` - Data untuk preview
- `formatNPWP()` - Format NPWP ke standard

### Controller
`app/Http/Controllers/SellingController.php`
- `coretaxPreview()` - Halaman preview
- `coretaxExportCSV()` - Download CSV
- `coretaxExportXML()` - Download XML

### Routes
```php
Route::get('selling/{id}/coretax-preview', [SellingController::class, 'coretaxPreview'])
    ->name('selling.coretax-preview');
    
Route::get('selling/{id}/coretax-export-csv', [SellingController::class, 'coretaxExportCSV'])
    ->name('selling.coretax-export-csv');
    
Route::get('selling/{id}/coretax-export-xml', [SellingController::class, 'coretaxExportXML'])
    ->name('selling.coretax-export-xml');
```

### Views
`resources/views/pages/backoffice/selling/coretax-preview.blade.php`

## Best Practices

1. **Validasi Data Sebelum Export**
   - Pastikan data customer lengkap
   - Cek NPWP valid (15 digit)
   - Verifikasi perhitungan pajak

2. **Backup Data**
   - Simpan data export untuk audit
   - Archive file export secara berkala

3. **Testing**
   - Test dengan data sample
   - Verifikasi perhitungan PPN
   - Cek format file sebelum submit ke Coretax

## Update Log

### Version 1.0.0 (2025-10-23)
- Initial release
- Support CSV export
- Support XML export
- Preview feature
- PPN 11% calculation
- NPWP formatting

## Support

Untuk pertanyaan atau issue terkait fitur export Coretax, silakan hubungi tim development atau buat ticket di sistem internal.
