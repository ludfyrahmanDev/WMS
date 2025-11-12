# Coretax Bulk Invoice Export - System Architecture

## 📊 Component Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                         USER INTERFACE                          │
├─────────────────────────────────────────────────────────────────┤
│  ┌──────────────────┐         ┌──────────────────┐            │
│  │   Web Form       │         │   JavaScript     │            │
│  │  (HTML/Blade)    │         │   (AJAX/Fetch)   │            │
│  └────────┬─────────┘         └────────┬─────────┘            │
└───────────┼────────────────────────────┼──────────────────────┘
            │                            │
            └──────────┬─────────────────┘
                       │
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                        ROUTING LAYER                            │
├─────────────────────────────────────────────────────────────────┤
│  POST /selling/coretax-bulk-invoice-export                     │
│  Middleware: auth, permission:selling.view                      │
└───────────┬─────────────────────────────────────────────────────┘
            │
            ▼
┌─────────────────────────────────────────────────────────────────┐
│                      CONTROLLER LAYER                           │
├─────────────────────────────────────────────────────────────────┤
│  SellingController::coretaxBulkInvoiceExportXML()              │
│  ├─ Validate Request                                           │
│  ├─ Extract Parameters                                         │
│  ├─ Call Service                                               │
│  └─ Return Download Response                                   │
└───────────┬─────────────────────────────────────────────────────┘
            │
            ▼
┌─────────────────────────────────────────────────────────────────┐
│                       SERVICE LAYER                             │
├─────────────────────────────────────────────────────────────────┤
│  CoretaxExportService::generateBulkInvoiceXML()                │
│  ├─ Query Database (Eloquent)                                  │
│  ├─ Create XML Structure (DOMDocument)                         │
│  ├─ Process Each Invoice                                       │
│  │   └─ createTaxInvoiceElement()                             │
│  │       └─ Process Each Product                              │
│  │           └─ createGoodServiceElement()                    │
│  ├─ Format Data (cleanTin, htmlspecialchars)                  │
│  ├─ Save XML File                                              │
│  └─ Return File Info                                           │
└───────────┬─────────────────────────────────────────────────────┘
            │
            ├────────────────┐
            ▼                ▼
┌──────────────────┐  ┌──────────────────┐
│  DATABASE LAYER  │  │  FILE SYSTEM     │
├──────────────────┤  ├──────────────────┤
│  ├─ sellings     │  │  storage/app/    │
│  ├─ customers    │  │    exports/      │
│  ├─ cvs          │  │  *.xml files     │
│  ├─ products     │  └──────────────────┘
│  └─ details      │
└──────────────────┘
```

## 🔄 Data Flow Sequence

```
1. USER INTERACTION
   ├─ User selects invoices (IDs: 1, 2, 3)
   ├─ User optionally enters Seller TIN
   └─ User clicks "Export" button

2. REQUEST PROCESSING
   ├─ POST request sent to /selling/coretax-bulk-invoice-export
   ├─ CSRF token validated
   ├─ Authentication checked
   └─ Permission verified (selling.view)

3. CONTROLLER VALIDATION
   ├─ Validate selling_ids (array, min:1, exists in DB)
   ├─ Validate seller_tin (optional, max:20)
   └─ Extract parameters

4. SERVICE INVOCATION
   ├─ CoretaxExportService instantiated
   └─ generateBulkInvoiceXML([1,2,3], '0830044103613000') called

5. DATA RETRIEVAL
   ├─ Query: Selling::with(['customer', 'details.product', 'cv'])
   │         ->whereIn('id', [1,2,3])
   │         ->get()
   └─ Returns collection of Selling models with relations

6. XML GENERATION
   ├─ Create DOMDocument with UTF-8 encoding
   ├─ Create root element: <TaxInvoiceBulk>
   ├─ Add namespace attributes
   ├─ Add <TIN>0830044103613000</TIN>
   ├─ Create <ListOfTaxInvoice>
   └─ For each selling:
       ├─ Create <TaxInvoice> element
       ├─ Add invoice metadata (date, buyer, seller)
       ├─ Create <ListOfGoodService>
       └─ For each product detail:
           ├─ Create <GoodService> element
           ├─ Calculate VAT (12%)
           ├─ Format prices (2 decimals)
           └─ Escape special characters

7. DATA FORMATTING
   ├─ cleanTin(): Format NPWP (remove dots, dashes, pad zeros)
   ├─ htmlspecialchars(): Escape XML entities
   ├─ Carbon::parse()->format('Y-m-d'): Format dates
   └─ number_format($value, 2, '.', ''): Format decimals

8. FILE OPERATIONS
   ├─ Generate filename: coretax_bulk_invoice_20251105120000.xml
   ├─ Check/create directory: storage/app/exports/
   ├─ Save XML: $xml->save($filepath)
   └─ Return file information

9. RESPONSE GENERATION
   ├─ Create download response
   ├─ Set Content-Disposition header (attachment)
   ├─ Set Content-Type: application/xml
   ├─ Enable deleteFileAfterSend(true)
   └─ Add flash message: "Berhasil export X invoice"

10. FILE DELIVERY
    ├─ Browser receives XML file
    ├─ File downloaded to user's computer
    ├─ Server deletes temporary file
    └─ User redirected with success message
```

## 🗂️ File Structure Flow

```
Request → routes/web.php
            │
            ├─ Route: selling.coretax-bulk-invoice-export
            │
            ▼
        app/Http/Controllers/SellingController.php
            │
            ├─ Method: coretaxBulkInvoiceExportXML()
            ├─ Validates request
            │
            ▼
        app/Services/CoretaxExportService.php
            │
            ├─ Method: generateBulkInvoiceXML()
            ├─ Method: createTaxInvoiceElement()
            ├─ Method: createGoodServiceElement()
            ├─ Method: cleanTin()
            │
            ▼
        Database Models
            ├─ app/Models/Selling.php
            ├─ app/Models/Customer.php
            ├─ app/Models/CV.php
            ├─ app/Models/Product.php
            └─ app/Models/SellingDetail.php
            │
            ▼
        Storage
            └─ storage/app/exports/
                └─ coretax_bulk_invoice_YYYYMMDDHHMMSS.xml
            │
            ▼
        Download Response
            └─ Browser downloads file
```

## 📋 Database Relationships

```
┌────────────┐
│   CV       │ (Company)
│            │
│ - id       │──┐
│ - npwp     │  │
│ - name     │  │
└────────────┘  │
                │
                │  ┌────────────────┐
┌───────────┐   │  │    Selling     │
│ Customer  │   │  │                │
│           │   │  │ - id           │
│ - id      │──┼──│ - cv_id        │
│ - npwp    │   └──│ - customer_id  │
│ - name    │      │ - date         │
│ - address │      │ - grand_total  │
│ - email   │      └────────┬───────┘
└───────────┘               │
                            │
                ┌───────────┴────────────┐
                │                        │
        ┌───────▼────────┐      ┌───────▼────────┐
        │ SellingDetail  │      │    Product     │
        │                │      │                │
        │ - id           │──────│ - id           │
        │ - selling_id   │      │ - code         │
        │ - product_id   │      │ - product      │
        │ - price_sell   │      │ - unit         │
        │ - total_qty    │      └────────────────┘
        │ - subtotal     │
        └────────────────┘
```

## 🔍 XML Structure Tree

```
TaxInvoiceBulk (root)
│
├── TIN (15 digits)
│   └── Value: "0830044103613000"
│
└── ListOfTaxInvoice
    │
    ├── TaxInvoice [1]
    │   ├── TaxInvoiceDate (YYYY-MM-DD)
    │   ├── TaxInvoiceOpt ("Normal")
    │   ├── TrxCode ("04")
    │   ├── AddInfo (empty)
    │   ├── CustomDoc (empty)
    │   ├── CustomDocMonthYear (empty)
    │   ├── RefDesc (INVxxxxxxxx)
    │   ├── FacilityStamp (empty)
    │   ├── SellerIDTKU (22 digits)
    │   ├── BuyerTin (15 digits)
    │   ├── BuyerDocument ("TIN")
    │   ├── BuyerCountry ("IND")
    │   ├── BuyerDocumentNumber (empty)
    │   ├── BuyerName (string)
    │   ├── BuyerAdress (string)
    │   ├── BuyerEmail (string)
    │   ├── BuyerIDTKU (22 digits)
    │   │
    │   └── ListOfGoodService
    │       │
    │       ├── GoodService [1]
    │       │   ├── Opt ("A" or "B")
    │       │   ├── Code (classification)
    │       │   ├── Name (product name)
    │       │   ├── Unit (UM code)
    │       │   ├── Price (decimal)
    │       │   ├── Qty (integer)
    │       │   ├── TotalDiscount (decimal)
    │       │   ├── TaxBase (decimal)
    │       │   ├── OtherTaxBase (decimal)
    │       │   ├── VATRate (percentage)
    │       │   ├── VAT (decimal)
    │       │   ├── STLGRate (percentage)
    │       │   └── STLG (decimal)
    │       │
    │       ├── GoodService [2]
    │       └── GoodService [...]
    │
    ├── TaxInvoice [2]
    └── TaxInvoice [...]
```

## 🧮 Calculation Flow

```
Product Detail Data
├── price_sell = 25540.54
├── total_qty = 500
└── subtotal = 12770270

                ↓

Tax Base Calculation
├── TaxBase = subtotal
│   └── 12770270
│
└── OtherTaxBase = TaxBase / 1.09
    └── 11706080.83

                ↓

VAT Calculation
├── VATRate = 12 (%)
├── VAT = TaxBase × (VATRate / 100)
│   └── 12770270 × 0.12 = 1532432.40
│
└── Total = TaxBase + VAT
    └── 12770270 + 1532432.40 = 14302702.40

                ↓

Luxury Tax (PPnBM)
├── STLGRate = 0 (%)
└── STLG = 0
```

## 🔐 Security Flow

```
HTTP Request
    ↓
┌───────────────────────┐
│ Middleware Stack      │
├───────────────────────┤
│ 1. CSRF Verification  │ ✓ Token validated
│ 2. Authentication     │ ✓ User logged in
│ 3. Authorization      │ ✓ Has permission:selling.view
└───────────┬───────────┘
            ↓
┌───────────────────────┐
│ Request Validation    │
├───────────────────────┤
│ 1. Array validation   │ ✓ selling_ids is array
│ 2. Existence check    │ ✓ IDs exist in database
│ 3. Type validation    │ ✓ seller_tin is string
└───────────┬───────────┘
            ↓
┌───────────────────────┐
│ Data Processing       │
├───────────────────────┤
│ 1. Eloquent ORM       │ ✓ SQL injection prevented
│ 2. HTML escaping      │ ✓ XSS prevented
│ 3. Path sanitization  │ ✓ Directory traversal prevented
└───────────┬───────────┘
            ↓
┌───────────────────────┐
│ File Operations       │
├───────────────────────┤
│ 1. Secure directory   │ ✓ storage/app/exports/
│ 2. Unique filename    │ ✓ Timestamp-based
│ 3. Auto-delete        │ ✓ After download
└───────────────────────┘
```

## 📊 Performance Metrics

```
Operation                    Time (approx)
─────────────────────────────────────────
Database Query               10-50ms
XML Generation (10 invoices) 50-200ms
File Write                   10-50ms
Total (10 invoices)          ~100-300ms

Memory Usage
─────────────────────────────────────────
Base Laravel                 ~30MB
10 invoices                  +5-10MB
100 invoices                 +20-50MB
500 invoices                 +100-200MB

File Size
─────────────────────────────────────────
Single invoice               ~2-5KB
10 invoices                  ~20-50KB
100 invoices                 ~200-500KB
```

## 🎯 Error Handling Flow

```
Request Received
    ↓
Try Block
    ├─ Validation
    │   ├─ Success → Continue
    │   └─ Fail → ValidationException
    │       └─ Return with errors
    │
    ├─ Database Query
    │   ├─ Success → Continue
    │   └─ Fail → QueryException
    │       └─ Log error & return failed message
    │
    ├─ XML Generation
    │   ├─ Success → Continue
    │   └─ Fail → DOMException
    │       └─ Log error & return failed message
    │
    └─ File Operations
        ├─ Success → Return download
        └─ Fail → IOException
            └─ Log error & return failed message

Catch Block
    ├─ Log exception
    ├─ Generate user-friendly message
    └─ Redirect back with error flash
```

## 🧪 Test Coverage Map

```
CoretaxBulkInvoiceExportTest
│
├─ Unit Tests
│   ├─ test_clean_tin_formats_correctly
│   │   ├─ Formatted NPWP
│   │   ├─ Unformatted NPWP
│   │   ├─ Short NPWP (padding)
│   │   └─ Special characters
│   │
│   └─ test_vat_calculation_is_correct
│       └─ 12% VAT calculation
│
├─ Integration Tests
│   ├─ test_can_generate_bulk_invoice_xml
│   │   ├─ Create test data
│   │   ├─ Generate XML
│   │   ├─ Verify file exists
│   │   └─ Validate XML structure
│   │
│   ├─ test_can_export_bulk_invoice_via_endpoint
│   │   ├─ Authenticate user
│   │   ├─ POST request
│   │   └─ Assert download response
│   │
│   └─ test_can_access_bulk_export_test_page
│       └─ Assert view rendered
│
├─ Validation Tests
│   ├─ test_validation_fails_without_selling_ids
│   └─ test_validation_fails_with_invalid_selling_ids
│
└─ Data Quality Tests
    ├─ test_xml_contains_correct_tin_format
    ├─ test_xml_escapes_special_characters
    └─ test_xml_date_format_is_correct
```

## 📚 Documentation Hierarchy

```
CORETAX_BULK_INVOICE_README.md
    ├─ Quick start guide
    ├─ Basic examples
    └─ Links to detailed docs
        │
        ├─── CORETAX_BULK_INVOICE_EXPORT_QUICK_REF.md
        │       ├─ API reference
        │       ├─ Code snippets
        │       └─ Troubleshooting
        │
        ├─── CORETAX_BULK_INVOICE_EXPORT.md
        │       ├─ Complete documentation
        │       ├─ Detailed examples
        │       ├─ Configuration guide
        │       └─ Integration guide
        │
        └─── IMPLEMENTATION_SUMMARY.md
                ├─ Technical details
                ├─ Architecture overview
                └─ Development notes
```

---

**Legend:**
- ┌─┐ │ └─┘ : Box drawing characters
- ─── : Connection lines
- ▼ ▲ : Direction indicators
- ✓ : Success/Completed
- ✗ : Failure/Error
- → : Flow direction
