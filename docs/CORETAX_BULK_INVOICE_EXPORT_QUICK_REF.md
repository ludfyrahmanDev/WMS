# Coretax Bulk Invoice Export - Quick Reference

## 🚀 Quick Start

### 1. Service Method
```php
use App\Services\CoretaxExportService;

$service = new CoretaxExportService();
$result = $service->generateBulkInvoiceXML([1, 2, 3, 4, 5], '0830044103613000');
```

### 2. Controller Endpoint
```
POST /selling/coretax-bulk-invoice-export
```

### 3. Web Interface
```
GET /selling/coretax-bulk-export-page
```

---

## 📂 Files Created/Modified

### ✅ Modified Files
1. **app/Services/CoretaxExportService.php**
   - Added: `generateBulkInvoiceXML()` - Main export method
   - Added: `createTaxInvoiceElement()` - Create single invoice XML
   - Added: `createGoodServiceElement()` - Create product XML
   - Added: `cleanTin()` - Format TIN/NPWP

2. **app/Http/Controllers/SellingController.php**
   - Added: `coretaxBulkInvoiceExportXML()` - HTTP endpoint handler

3. **routes/web.php**
   - Added: POST route for bulk export
   - Added: GET route for test page

### ✅ New Files Created
1. **docs/CORETAX_BULK_INVOICE_EXPORT.md**
   - Complete documentation
   - Usage examples
   - API reference

2. **resources/views/pages/backoffice/selling/coretax-bulk-export.blade.php**
   - Test/demo page
   - Interactive UI for testing
   - JavaScript examples

---

## 🔧 Implementation Details

### XML Structure
```xml
TaxInvoiceBulk
├── TIN (Seller's Tax ID)
└── ListOfTaxInvoice
    └── TaxInvoice (multiple)
        ├── TaxInvoiceDate
        ├── TaxInvoiceOpt
        ├── TrxCode
        ├── RefDesc
        ├── SellerIDTKU
        ├── BuyerTin
        ├── BuyerName
        ├── BuyerAdress
        └── ListOfGoodService
            └── GoodService (multiple)
                ├── Opt
                ├── Code
                ├── Name
                ├── Unit
                ├── Price
                ├── Qty
                ├── TaxBase
                ├── VATRate
                └── VAT
```

### Key Features
- ✅ Multiple invoices in single XML file
- ✅ Follows Coretax TaxInvoiceBulk schema
- ✅ Automatic TIN/NPWP formatting
- ✅ HTML entity escaping for special characters
- ✅ UTF-8 encoding
- ✅ Validation for required fields
- ✅ Error handling
- ✅ Auto-delete file after download

---

## 📝 Request Parameters

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `selling_ids` | array | ✅ Yes | - | Array of selling IDs |
| `selling_ids.*` | integer | ✅ Yes | - | Each ID must exist |
| `seller_tin` | string | ❌ No | 0830044103613000 | Seller's TIN (15-16 digits) |

---

## 🌐 API Endpoints

### Bulk Export (POST)
```
POST /selling/coretax-bulk-invoice-export
Content-Type: application/x-www-form-urlencoded

selling_ids[]=1&selling_ids[]=2&selling_ids[]=3&seller_tin=0830044103613000
```

### Test Page (GET)
```
GET /selling/coretax-bulk-export-page
```

---

## 💻 Usage Examples

### HTML Form
```html
<form action="{{ route('selling.coretax-bulk-invoice-export') }}" method="POST">
    @csrf
    <input type="hidden" name="selling_ids[]" value="1">
    <input type="hidden" name="selling_ids[]" value="2">
    <input type="hidden" name="selling_ids[]" value="3">
    <input type="text" name="seller_tin" value="0830044103613000">
    <button type="submit">Export</button>
</form>
```

### JavaScript/Fetch
```javascript
const formData = new FormData();
[1, 2, 3].forEach(id => formData.append('selling_ids[]', id));
formData.append('seller_tin', '0830044103613000');

fetch('/selling/coretax-bulk-invoice-export', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: formData
})
.then(response => response.blob())
.then(blob => {
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'coretax_bulk_invoice.xml';
    document.body.appendChild(a);
    a.click();
});
```

### PHP Controller
```php
$request->validate([
    'selling_ids' => 'required|array|min:1',
    'selling_ids.*' => 'required|integer|exists:sellings,id'
]);

$coretaxService = new CoretaxExportService();
$result = $coretaxService->generateBulkInvoiceXML(
    $request->input('selling_ids'),
    $request->input('seller_tin', '0830044103613000')
);

return response()->download($result['filepath'], $result['filename'])
    ->deleteFileAfterSend(true);
```

---

## 🎯 Tax Calculations

### PPN (Value Added Tax)
- **Rate**: 12% (update as per regulation)
- **Formula**: `VAT = TaxBase × (VATRate / 100)`
- **TaxBase**: Subtotal before VAT

### PPnBM (Luxury Sales Tax)
- **Rate**: 0% (default for regular goods)
- **Formula**: `STLG = TaxBase × (STLGRate / 100)`

---

## 🔐 Validation Rules

### Pre-Export Checks
1. ✅ Minimum 1 selling ID required
2. ✅ All selling IDs must exist in database
3. ✅ Each selling must have a customer with NPWP
4. ✅ Each selling must have product details
5. ✅ Seller TIN must be 15-16 digits (if provided)

### XML Schema Validation
- Follows `TaxInvoice.xsd` schema
- UTF-8 encoding
- Date format: `YYYY-MM-DD`
- TIN format: 15 digits numeric
- ID TKU format: 22 digits (TIN + 000000)

---

## 📊 Response Format

### Success Response
```
HTTP/1.1 200 OK
Content-Type: application/xml
Content-Disposition: attachment; filename="coretax_bulk_invoice_20251105120000.xml"

<?xml version="1.0" encoding="UTF-8"?>
<TaxInvoiceBulk>
    ...
</TaxInvoiceBulk>
```

### Error Response (JSON)
```json
{
    "message": "Validation failed",
    "errors": {
        "selling_ids": ["The selling ids field is required."]
    }
}
```

### Error Response (HTML)
Redirects back with flash message:
```php
return back()->with('failed', 'Error message');
```

---

## 🗂️ Data Mapping

| Database | XML Field | Format | Notes |
|----------|-----------|--------|-------|
| `selling.date` | TaxInvoiceDate | YYYY-MM-DD | ISO date |
| `selling.id` | RefDesc | INVxxxxxxxx | 8-digit padded |
| `cv.npwp` | SellerIDTKU | 22 digits | TIN + 000000 |
| `customer.npwp` | BuyerTin | 15 digits | Numeric only |
| `customer.name` | BuyerName | String | HTML escaped |
| `customer.address` | BuyerAdress | String | HTML escaped |
| `product.code` | Code | String | Default: 761000 |
| `product.product` | Name | String | HTML escaped |
| `detail.price_sell` | Price | Decimal | 2 decimals |
| `detail.total_qty` | Qty | Integer | Quantity |
| `detail.subtotal` | TaxBase | Decimal | 2 decimals |

---

## ⚠️ Important Notes

1. **Memory Limit**: For large exports (>100 invoices), increase PHP memory limit
2. **Timeout**: Set appropriate execution timeout for large batches
3. **Queue**: Consider using Laravel Queue for large exports
4. **File Cleanup**: Files are auto-deleted after download
5. **Storage**: Temporary files stored in `storage/app/exports/`
6. **Validation**: Always validate NPWP format before export
7. **UTF-8**: Ensure database uses UTF-8 encoding
8. **Special Characters**: Automatically escaped with `htmlspecialchars()`

---

## 🐛 Troubleshooting

### Issue: "selling_ids is required"
**Solution**: Ensure array format `selling_ids[]` not `selling_ids`

### Issue: XML import fails in Coretax
**Solution**: 
- Check TIN format (15 digits numeric)
- Verify date format (YYYY-MM-DD)
- Validate product classification codes

### Issue: Special characters corrupted
**Solution**: 
- File uses UTF-8 encoding
- Characters automatically escaped
- Database should be UTF-8

### Issue: Empty XML generated
**Solution**:
- Check if selling IDs exist
- Verify selling has details
- Check customer has NPWP

---

## 🔄 Testing

### Access Test Page
```
http://your-domain.com/selling/coretax-bulk-export-page
```

### Manual Testing Steps
1. Open test page
2. Select invoices or enter IDs manually
3. Optionally change Seller TIN
4. Click "Export ke XML Coretax"
5. Verify downloaded XML file
6. Import to Coretax for validation

### Unit Test Example
```php
public function test_bulk_invoice_export()
{
    $response = $this->post('/selling/coretax-bulk-invoice-export', [
        'selling_ids' => [1, 2, 3],
        'seller_tin' => '0830044103613000'
    ]);

    $response->assertOk();
    $response->assertDownload();
}
```

---

## 📚 Related Documentation

- [Single Invoice Export](./CORETAX_EXPORT.md)
- [Delivery Order Export](./CORETAX_DELIVERY_ORDER.md)
- [Laravel Documentation](https://laravel.com/docs)
- [Coretax Official Docs](https://coretax.pajak.go.id)

---

## 📞 Support

For issues or questions:
1. Check documentation in `docs/CORETAX_BULK_INVOICE_EXPORT.md`
2. Review error messages in `storage/logs/laravel.log`
3. Test using the demo page at `/selling/coretax-bulk-export-page`

---

## ✨ Version

- **Version**: 1.0.0
- **Date**: November 5, 2025
- **Author**: Created for WMS Laravel Project
- **License**: Internal Use

---

## 🎉 Features Summary

✅ Bulk export multiple invoices  
✅ Coretax XML format compliance  
✅ Automatic NPWP formatting  
✅ VAT calculation (12%)  
✅ Product classification codes  
✅ UTF-8 encoding support  
✅ Error handling  
✅ Validation  
✅ Test interface  
✅ Complete documentation  

---

**Happy Exporting! 🚀**
