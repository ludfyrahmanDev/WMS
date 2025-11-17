# 🧾 Coretax Bulk Invoice Export

Export multiple invoices to Coretax XML format in a single file.

## 🚀 Quick Start

### Option 1: Use Test Interface
Visit the test page:
```
http://your-domain.com/selling/coretax-bulk-export-page
```

### Option 2: Use PHP Service
```php
use App\Services\CoretaxExportService;

$service = new CoretaxExportService();
$result = $service->generateBulkInvoiceXML([1, 2, 3], '0830044103613000');

// Download the file
return response()->download($result['filepath'], $result['filename'])
    ->deleteFileAfterSend(true);
```

### Option 3: POST to API Endpoint
```bash
curl -X POST "http://your-domain.com/selling/coretax-bulk-invoice-export" \
  -F "selling_ids[]=1" \
  -F "selling_ids[]=2" \
  -F "selling_ids[]=3" \
  -F "seller_tin=0830044103613000" \
  -F "_token=your-csrf-token"
```

## 📋 Requirements

- Laravel 10+
- PHP 8.1+
- DOMDocument extension enabled
- Permission: `selling.view`

## 📦 What's Included

- ✅ Service class with XML generation
- ✅ Controller endpoint
- ✅ Test interface page
- ✅ Complete documentation
- ✅ Feature tests
- ✅ Example usage code

## 📚 Documentation

| Document | Description |
|----------|-------------|
| [Complete Guide](docs/CORETAX_BULK_INVOICE_EXPORT.md) | Full documentation with all details |
| [Quick Reference](docs/CORETAX_BULK_INVOICE_EXPORT_QUICK_REF.md) | Quick reference card |
| [Implementation Summary](IMPLEMENTATION_SUMMARY.md) | Technical implementation details |

## 🎯 Features

- Export multiple invoices in one XML file
- Coretax TaxInvoiceBulk format compliance
- Automatic NPWP/TIN formatting
- VAT calculation (12%)
- UTF-8 encoding
- Special character escaping
- Request validation
- Error handling

## 📝 Example XML Output

```xml
<?xml version="1.0" encoding="UTF-8"?>
<TaxInvoiceBulk xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                xsi:noNamespaceSchemaLocation="TaxInvoice.xsd">
    <TIN>0830044103613000</TIN>
    <ListOfTaxInvoice>
        <TaxInvoice>
            <TaxInvoiceDate>2025-11-01</TaxInvoiceDate>
            <RefDesc>INV00000001</RefDesc>
            <BuyerName>PT. CUSTOMER NAME</BuyerName>
            <ListOfGoodService>
                <GoodService>
                    <Name>Product Name</Name>
                    <Price>25540.54</Price>
                    <Qty>500</Qty>
                    <VAT>1532432.40</VAT>
                </GoodService>
            </ListOfGoodService>
        </TaxInvoice>
    </ListOfTaxInvoice>
</TaxInvoiceBulk>
```

## 🧪 Testing

### Run Tests
```bash
php artisan test --filter CoretaxBulkInvoiceExportTest
```

### Manual Testing
1. Visit: `/selling/coretax-bulk-export-page`
2. Select invoices or enter IDs manually
3. Click "Export"
4. Verify downloaded XML file

## 🔗 Routes

| Method | URL | Name | Description |
|--------|-----|------|-------------|
| GET | `/selling/coretax-bulk-export-page` | `selling.coretax-bulk-export-page` | Test interface |
| POST | `/selling/coretax-bulk-invoice-export` | `selling.coretax-bulk-invoice-export` | Export API |

## ⚙️ Configuration

### Change VAT Rate
Edit in `app/Services/CoretaxExportService.php`:
```php
$vatRate = 12; // Change to 11 or as needed
```

### Change Default Seller TIN
Edit in `app/Http/Controllers/SellingController.php`:
```php
$sellerTin = $request->input('seller_tin', '0830044103613000');
```

## 🐛 Troubleshooting

### Issue: "selling_ids is required"
**Fix**: Send as array `selling_ids[]` not `selling_ids`

### Issue: XML import fails in Coretax
**Fix**: 
- Check TIN is 15 digits numeric
- Verify date format is YYYY-MM-DD
- Validate product codes

### Issue: Special characters corrupted
**Fix**: Ensure database and file are UTF-8 encoded

## 📞 Support

- Check logs: `storage/logs/laravel.log`
- View docs: `docs/CORETAX_BULK_INVOICE_EXPORT.md`
- Run tests: `php artisan test --filter CoretaxBulkInvoice`

## 📄 License

Internal use for WMS project.

---

**Version**: 1.0.0  
**Date**: November 5, 2025  
**Status**: ✅ Production Ready
