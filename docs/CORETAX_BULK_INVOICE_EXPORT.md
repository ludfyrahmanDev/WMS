# Coretax Bulk Invoice Export

## Overview
Feature untuk export multiple invoice ke format XML Coretax dalam satu file. Format XML mengikuti standar TaxInvoiceBulk dari Coretax.

## Format XML
```xml
<?xml version="1.0" encoding="UTF-8"?>
<TaxInvoiceBulk xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="TaxInvoice.xsd">
    <TIN>0830044103613000</TIN>
    <ListOfTaxInvoice>
        <TaxInvoice>
            <!-- Multiple invoice records -->
        </TaxInvoice>
    </ListOfTaxInvoice>
</TaxInvoiceBulk>
```

## Endpoint

### POST: `/selling/coretax-bulk-invoice-export`

**Route Name:** `selling.coretax-bulk-invoice-export`

**Middleware:** `permission:selling.view`

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `selling_ids` | array | Yes | Array of selling IDs to export |
| `selling_ids.*` | integer | Yes | Each selling ID must exist in database |
| `seller_tin` | string | No | Seller's Tax Identification Number (default: 0830044103613000) |

## Example Usage

### Using AJAX (JavaScript)
```javascript
// Select multiple invoices
const selectedInvoices = [1, 2, 3, 4, 5];

// Create form data
const formData = new FormData();
selectedInvoices.forEach(id => {
    formData.append('selling_ids[]', id);
});
formData.append('seller_tin', '0830044103613000'); // Optional

// Send request
fetch('/selling/coretax-bulk-invoice-export', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: formData
})
.then(response => response.blob())
.then(blob => {
    // Download file
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'coretax_bulk_invoice_' + Date.now() + '.xml';
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
});
```

### Using HTML Form
```html
<form action="{{ route('selling.coretax-bulk-invoice-export') }}" method="POST">
    @csrf
    
    <!-- Hidden inputs for selected selling IDs -->
    <input type="hidden" name="selling_ids[]" value="1">
    <input type="hidden" name="selling_ids[]" value="2">
    <input type="hidden" name="selling_ids[]" value="3">
    
    <!-- Optional: Custom seller TIN -->
    <input type="text" name="seller_tin" value="0830044103613000" placeholder="Seller TIN">
    
    <button type="submit" class="btn btn-primary">
        Export Bulk Invoice XML
    </button>
</form>
```

### Using cURL
```bash
curl -X POST "http://your-domain.com/selling/coretax-bulk-invoice-export" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d "selling_ids[]=1" \
  -d "selling_ids[]=2" \
  -d "selling_ids[]=3" \
  -d "seller_tin=0830044103613000" \
  --output coretax_bulk_invoice.xml
```

## PHP Service Method

```php
use App\Services\CoretaxExportService;

// Initialize service
$coretaxService = new CoretaxExportService();

// Generate bulk invoice XML
$result = $coretaxService->generateBulkInvoiceXML(
    $sellingIds = [1, 2, 3, 4, 5],
    $sellerTin = '0830044103613000'
);

// Result contains:
// [
//     'filename' => 'coretax_bulk_invoice_20251105120000.xml',
//     'filepath' => '/path/to/storage/app/exports/coretax_bulk_invoice_20251105120000.xml',
//     'url' => 'http://your-domain.com/storage/exports/coretax_bulk_invoice_20251105120000.xml',
//     'total_invoices' => 5
// ]
```

## XML Structure Details

### TaxInvoice Element
Setiap invoice dalam bulk export mengandung:

- **TaxInvoiceDate**: Tanggal invoice (format: YYYY-MM-DD)
- **TaxInvoiceOpt**: Tipe invoice (Normal, Replacement, dll)
- **TrxCode**: Kode transaksi (04 = Penyerahan yang PPN-nya harus dipungut sendiri)
- **RefDesc**: Nomor referensi invoice (INV00000001)
- **SellerIDTKU**: ID seller 22 digit (TIN + 000000)
- **BuyerTin**: NPWP pembeli (15 digit)
- **BuyerDocument**: Tipe dokumen pembeli (TIN/NIK)
- **BuyerCountry**: Kode negara (IND untuk Indonesia)
- **BuyerName**: Nama pembeli
- **BuyerAdress**: Alamat pembeli
- **BuyerEmail**: Email pembeli
- **BuyerIDTKU**: ID pembeli 22 digit
- **ListOfGoodService**: Daftar barang/jasa

### GoodService Element
Setiap produk dalam invoice mengandung:

- **Opt**: Jenis item (A = Barang, B = Jasa)
- **Code**: Kode klasifikasi barang/jasa
- **Name**: Nama barang/jasa
- **Unit**: Satuan (kode unit measurement)
- **Price**: Harga per unit
- **Qty**: Jumlah
- **TotalDiscount**: Total diskon
- **TaxBase**: Dasar Pengenaan Pajak (DPP)
- **OtherTaxBase**: DPP lainnya
- **VATRate**: Tarif PPN (%)
- **VAT**: Nilai PPN
- **STLGRate**: Tarif PPnBM (%)
- **STLG**: Nilai PPnBM

## Data Mapping

### From Database to XML

| Database Field | XML Field | Notes |
|---------------|-----------|-------|
| `selling.date` | TaxInvoiceDate | Format: YYYY-MM-DD |
| `selling.id` | RefDesc | Format: INV00000001 |
| `cv.npwp` | SellerIDTKU | 22 digit (NPWP + 000000) |
| `customer.npwp` | BuyerTin | 15 digit |
| `customer.name` | BuyerName | HTML escaped |
| `customer.address` | BuyerAdress | HTML escaped |
| `customer.email` | BuyerEmail | HTML escaped |
| `product.code` | Code | Default: 761000 |
| `product.product` | Name | HTML escaped |
| `detail.price_sell` | Price | 2 decimal places |
| `detail.total_qty` | Qty | Integer |
| `detail.subtotal` | TaxBase | 2 decimal places |

## Kode Unit Measurement (UM)

Standar kode satuan yang digunakan:
- UM.0020 = Unit/Pcs
- UM.0001 = Kg (Kilogram)
- UM.0003 = Liter
- UM.0008 = M (Meter)
- UM.0013 = M2 (Meter Persegi)
- UM.0014 = M3 (Meter Kubik)

## Kode Klasifikasi Barang/Jasa

Contoh kode klasifikasi:
- 761000 = Logam mulia dan perhiasan
- 730000 = Besi dan baja
- 840000 = Mesin dan peralatan mekanik

*Sesuaikan dengan klasifikasi produk Anda*

## Perhitungan Pajak

### PPN (Pajak Pertambahan Nilai)
- Tarif: 12% (sesuaikan dengan regulasi terbaru)
- Formula: `VAT = TaxBase × (VATRate / 100)`

### PPnBM (Pajak Penjualan atas Barang Mewah)
- Hanya untuk barang mewah tertentu
- Default: 0%

## Response

### Success Response
- HTTP Status: 200
- Content-Type: application/xml
- File download dengan nama: `coretax_bulk_invoice_YYYYMMDDHHMMSS.xml`

### Error Response
```json
{
    "message": "Gagal export bulk invoice: Error message",
    "error": "detailed error message"
}
```

## Storage Location

File XML akan disimpan di:
```
storage/app/exports/coretax_bulk_invoice_YYYYMMDDHHMMSS.xml
```

File akan dihapus otomatis setelah download (deleteFileAfterSend).

## Validasi

### Pre-export Validation
1. Minimal 1 selling ID harus disediakan
2. Semua selling ID harus valid dan exist di database
3. Seller TIN harus format numerik (opsional, ada default value)
4. Setiap selling harus memiliki customer dengan NPWP
5. Setiap selling harus memiliki minimal 1 detail produk

### XML Validation
XML yang dihasilkan mengikuti schema `TaxInvoice.xsd` dari Coretax.

## Troubleshooting

### Problem: XML tidak bisa di-import ke Coretax
**Solution:** 
- Pastikan format TIN/NPWP sudah benar (15 digit numerik)
- Cek format tanggal (YYYY-MM-DD)
- Pastikan kode klasifikasi barang valid

### Problem: Error "selling_ids is required"
**Solution:**
- Pastikan mengirim array `selling_ids[]` bukan `selling_ids`
- Minimal 1 ID harus disediakan

### Problem: Special characters tidak tampil benar
**Solution:**
- File XML menggunakan encoding UTF-8
- Special characters sudah di-escape otomatis dengan `htmlspecialchars()`

## Integration with Frontend

### Example: Bulk Select & Export
```javascript
// Checkbox selection
let selectedIds = [];

document.querySelectorAll('.invoice-checkbox:checked').forEach(checkbox => {
    selectedIds.push(checkbox.value);
});

if (selectedIds.length === 0) {
    alert('Pilih minimal 1 invoice untuk di-export');
    return;
}

// Export
const form = document.createElement('form');
form.method = 'POST';
form.action = '/selling/coretax-bulk-invoice-export';

// CSRF token
const csrfInput = document.createElement('input');
csrfInput.type = 'hidden';
csrfInput.name = '_token';
csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
form.appendChild(csrfInput);

// Selling IDs
selectedIds.forEach(id => {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'selling_ids[]';
    input.value = id;
    form.appendChild(input);
});

document.body.appendChild(form);
form.submit();
```

## Customization

### Custom TIN Format
Untuk mengubah format TIN, edit method `cleanTin()` di `CoretaxExportService.php`:

```php
private function cleanTin($tin)
{
    $cleaned = preg_replace('/[^0-9]/', '', $tin);
    
    // Custom logic here
    if (strlen($cleaned) < 15) {
        $cleaned = str_pad($cleaned, 15, '0', STR_PAD_LEFT);
    }
    
    return $cleaned;
}
```

### Custom VAT Rate
Untuk mengubah tarif PPN, edit di method `createGoodServiceElement()`:

```php
// VAT Rate (11% or 12% depending on regulation)
$vatRate = 12; // Update this value
```

### Custom Product Classification
Set kode klasifikasi di database:
```sql
ALTER TABLE products ADD COLUMN classification_code VARCHAR(20) DEFAULT '761000';
```

Then update the service:
```php
$code = $xml->createElement('Code', htmlspecialchars($detail->product->classification_code ?? '761000', ENT_XML1, 'UTF-8'));
```

## Notes

1. **Performance**: Untuk export dengan jumlah invoice banyak (>100), pertimbangkan menggunakan queue jobs
2. **Memory**: PHP memory limit mungkin perlu ditingkatkan untuk bulk export besar
3. **Timeout**: Set timeout yang cukup untuk proses export
4. **Validation**: Selalu validasi data sebelum export ke Coretax

## Related Documentation

- [CORETAX_EXPORT.md](./CORETAX_EXPORT.md) - Single invoice export
- [CORETAX_DELIVERY_ORDER.md](./CORETAX_DELIVERY_ORDER.md) - Delivery order export

## Version History

- v1.0.0 (2025-11-05): Initial release dengan format TaxInvoiceBulk
