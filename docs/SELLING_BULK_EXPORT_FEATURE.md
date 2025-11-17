# 🆕 Fitur Bulk Export Coretax & Filter Date Range - Selling Index

## 📋 Overview
Fitur baru yang ditambahkan pada halaman index selling untuk memudahkan export multiple invoice ke Coretax XML dan filter data berdasarkan tanggal.

---

## ✨ Fitur yang Ditambahkan

### 1. **Filter Date Range**
- Input tanggal mulai (start_date)
- Input tanggal akhir (end_date)
- Auto-submit saat tanggal dipilih
- Tombol "Clear" untuk reset filter
- Icon calendar pada input field

### 2. **Bulk Export Coretax**
- Checkbox pada setiap baris untuk select invoice
- Checkbox "Select All" di header tabel
- Counter jumlah data yang dipilih
- Tombol export yang muncul otomatis saat ada data terpilih
- Konfirmasi sebelum export
- Loading state saat proses export
- Keyboard shortcut: `Ctrl/Cmd + E`

### 3. **Enhanced Search**
- Pencarian berdasarkan nama customer
- Pencarian berdasarkan ID invoice
- Pencarian berdasarkan notes
- Debounced search (500ms delay)

---

## 🎯 Cara Penggunaan

### Filter Date Range

#### Via UI
1. Buka halaman `/selling`
2. Klik input "Dari Tanggal" dan pilih tanggal mulai
3. Klik input "Sampai Tanggal" dan pilih tanggal akhir
4. Data akan otomatis ter-filter
5. Klik tombol "Clear" untuk reset filter

#### Via URL
```
/selling?start_date=2025-11-01&end_date=2025-11-05
```

#### Kombinasi dengan Search
```
/selling?search=customer&start_date=2025-11-01&end_date=2025-11-05
```

---

### Bulk Export Coretax

#### Langkah-langkah:
1. **Pilih Invoice**
   - Klik checkbox pada invoice yang ingin di-export
   - Atau klik "Pilih Semua" untuk select semua invoice di halaman

2. **Lihat Counter**
   - Counter akan menampilkan jumlah invoice terpilih
   - Contoh: "5 data dipilih"

3. **Export**
   - Tombol "Export ke Coretax XML" akan muncul
   - Klik tombol tersebut
   - Akan muncul konfirmasi dengan detail invoice
   - Klik OK untuk lanjutkan
   - File XML akan otomatis ter-download

4. **Keyboard Shortcut**
   - Tekan `Ctrl + E` (Windows/Linux)
   - Tekan `Cmd + E` (Mac)
   - Export akan langsung dimulai untuk invoice yang terpilih

---

## 🔧 Technical Details

### Frontend Changes

**File Modified**: `resources/views/pages/backoffice/selling/index.blade.php`

#### 1. Added Date Range Inputs
```blade
<x-base.form-input
    id="start_date"
    name="start_date"
    type="date"
    value="{{ request()->get('start_date') }}"
/>

<x-base.form-input
    id="end_date"
    name="end_date"
    type="date"
    value="{{ request()->get('end_date') }}"
/>
```

#### 2. Added Checkbox Column
```blade
<x-base.table.th>
    <input 
        type="checkbox" 
        id="select-all-checkbox" 
        onchange="toggleSelectAll()"
    />
</x-base.table.th>
```

#### 3. Added Bulk Export Button
```blade
<x-base.button 
    id="bulk-export-btn" 
    onclick="exportBulkCoretax()">
    Export <span id="export-count">0</span> ke Coretax XML
</x-base.button>
```

#### 4. JavaScript Functions
- `updateSelectedCount()` - Update counter dan visibility tombol
- `toggleSelectAll()` - Toggle semua checkbox
- `exportBulkCoretax()` - Submit form export
- `clearFilters()` - Reset semua filter

### Backend Changes

**File Modified**: `app/Http/Controllers/SellingController.php`

#### Enhanced index() Method
```php
// Added search functionality
->when($request->has('search'), function ($query) use ($request) {
    $search = $request->search;
    $query->where(function ($q) use ($search) {
        $q->whereHas('customer', function ($customerQuery) use ($search) {
            $customerQuery->where('name', 'like', '%' . $search . '%');
        })
        ->orWhere('notes', 'like', '%' . $search . '%')
        ->orWhere('id', 'like', '%' . $search . '%');
    });
})

// Date range filter (sudah ada, tidak diubah)
if ($request->has('start_date') && $request->has('end_date')) {
    $all = $all->whereBetween('date', [$start_date, $end_date]);
}
```

---

## 📊 UI Components

### Filter Bar
```
┌─────────────────────────────────────────────────────────┐
│ [Search Input]  [Start Date]  [End Date]  [Clear Btn]  │
└─────────────────────────────────────────────────────────┘
```

### Table Header
```
┌──────────────────────────────────────────────────────────────┐
│ Daftar Penjualan                    [Export N] [Pilih Semua] │
│ N data dipilih                                                │
└──────────────────────────────────────────────────────────────┘
```

### Table Row
```
┌──────────────────────────────────────────────────────────┐
│ [✓] 1  05 Nov 2025  PT. Customer  Kontan  Rp 1,000,000  │
└──────────────────────────────────────────────────────────┘
```

---

## 🎨 Visual States

### Default State
- Bulk export button: **Hidden**
- Select all checkbox: **Unchecked**
- Counter: "0 data dipilih"

### Selected State (1+ items)
- Bulk export button: **Visible**
- Export count badge: Shows number
- Counter: "N data dipilih"

### Select All State
- All checkboxes: **Checked**
- Select all checkbox: **Checked**
- Bulk export button: **Visible**

### Indeterminate State (Some selected)
- Select all checkbox: **Indeterminate** (dash icon)
- Some checkboxes: **Checked**

### Loading State
- Export button: **Disabled**
- Button text: "Exporting..."
- Spinner icon visible

---

## 💡 Features & Enhancements

### Smart Counter
- Real-time update
- Shows in 2 places: header subtitle & export button
- Auto-hide export button when count = 0

### Keyboard Navigation
- `Ctrl/Cmd + E`: Quick export
- `Space`: Toggle checkbox when focused
- `Tab`: Navigate between checkboxes

### Responsive Design
- Mobile: Stack filters vertically
- Tablet: 2 columns layout
- Desktop: Full horizontal layout

### User Feedback
- Confirmation dialog before export
- Shows selected invoice details
- Loading spinner during export
- Success message after export

---

## 🔒 Security Features

### CSRF Protection
```javascript
const csrfToken = document.createElement('input');
csrfToken.name = '_token';
csrfToken.value = '{{ csrf_token() }}';
```

### Validation
- Minimum 1 invoice must be selected
- Valid date range (start <= end)
- Search query sanitization

### Permission Check
- Route protected by `permission:selling.view`
- User authentication required

---

## 📱 Responsive Behavior

### Mobile (< 640px)
```
┌─────────────────┐
│ [Search]        │
│ [Start Date]    │
│ [End Date]      │
│ [Clear]         │
└─────────────────┘
```

### Tablet (640px - 1024px)
```
┌──────────────────────────────┐
│ [Search]  [Start]  [End]     │
└──────────────────────────────┘
```

### Desktop (> 1024px)
```
┌─────────────────────────────────────────────────┐
│ [Search Input]  [Start Date]  [End Date]  [Clear] │
└─────────────────────────────────────────────────┘
```

---

## 🐛 Known Issues & Solutions

### Issue 1: Export button not showing
**Cause**: JavaScript not loaded
**Solution**: Clear browser cache and reload

### Issue 2: Date filter not working
**Cause**: Invalid date format
**Solution**: Ensure date format is YYYY-MM-DD

### Issue 3: Checkbox not updating
**Cause**: JavaScript error
**Solution**: Check browser console for errors

---

## 🎓 Best Practices

### For Users
1. **Select Specific Range**: Pilih date range yang spesifik untuk performa lebih baik
2. **Export in Batches**: Export maksimal 100 invoice per batch
3. **Verify Selection**: Selalu cek konfirmasi dialog sebelum export
4. **Use Keyboard**: Gunakan Ctrl+E untuk export lebih cepat

### For Developers
1. **Optimize Queries**: Gunakan eager loading untuk relasi
2. **Add Pagination**: Jangan load semua data sekaligus
3. **Cache Results**: Cache hasil query untuk performa
4. **Error Handling**: Always handle edge cases

---

## 📈 Performance Considerations

### Query Optimization
```php
// Eager load relations
Selling::with('customer', 'cv')->get();

// Use whereBetween for date range
->whereBetween('date', [$start, $end]);

// Index on date column
$table->index('date');
```

### JavaScript Performance
```javascript
// Debounced search (500ms)
setTimeout(performSearch, 500);

// Use event delegation
document.addEventListener('change', handler);
```

---

## 🔄 Integration Flow

```
User Interface
    ↓
Select Invoices (Checkboxes)
    ↓
Click Export Button
    ↓
JavaScript: collectSelectedIds()
    ↓
Show Confirmation Dialog
    ↓
User Confirms
    ↓
Create POST Form
    ↓
Submit to: /selling/coretax-bulk-invoice-export
    ↓
SellingController::coretaxBulkInvoiceExportXML()
    ↓
CoretaxExportService::generateBulkInvoiceXML()
    ↓
Generate XML File
    ↓
Download Response
    ↓
Auto-delete File
```

---

## 📝 Configuration

### Default Values
```javascript
// Seller TIN (sesuaikan dengan perusahaan)
const DEFAULT_SELLER_TIN = '0830044103613000';

// Search debounce delay
const SEARCH_DELAY = 500; // ms

// Auto-dismiss alert timeout
const ALERT_TIMEOUT = 5000; // ms
```

### Customize in View
```blade
{{-- Change seller TIN --}}
sellerTinInput.value = 'YOUR_TIN_HERE';

{{-- Change search delay --}}
searchTimeout = setTimeout(performSearch, YOUR_DELAY);
```

---

## 🎯 Testing Checklist

### Manual Testing
- [ ] Date range filter works correctly
- [ ] Search works with customer name
- [ ] Search works with invoice ID
- [ ] Select all checkbox works
- [ ] Individual checkboxes work
- [ ] Counter updates correctly
- [ ] Export button shows/hides properly
- [ ] Confirmation dialog appears
- [ ] Export downloads XML file
- [ ] Clear button resets all filters
- [ ] Keyboard shortcut works (Ctrl+E)
- [ ] Responsive on mobile
- [ ] Loading state shows during export

### Edge Cases
- [ ] Select 0 invoices (should show alert)
- [ ] Select 1 invoice
- [ ] Select all invoices
- [ ] Invalid date range
- [ ] Empty search query
- [ ] Special characters in search
- [ ] Very large date range (>1 year)

---

## 📚 Related Documentation

- [Coretax Bulk Invoice Export](./CORETAX_BULK_INVOICE_EXPORT.md) - Main export documentation
- [Quick Reference](./CORETAX_BULK_INVOICE_EXPORT_QUICK_REF.md) - Quick reference guide
- [Architecture](./CORETAX_BULK_INVOICE_ARCHITECTURE.md) - System architecture

---

## 🆕 Version History

### v1.0.0 (November 5, 2025)
- ✅ Added date range filter
- ✅ Added bulk export functionality
- ✅ Enhanced search with customer name
- ✅ Added select all checkbox
- ✅ Added counter display
- ✅ Added keyboard shortcuts
- ✅ Added confirmation dialog
- ✅ Added loading states
- ✅ Responsive design improvements

---

## 🎉 Benefits

### For Users
- ⚡ **Faster**: Export multiple invoices at once
- 🎯 **Accurate**: Select specific invoices easily
- 📅 **Flexible**: Filter by date range
- 🔍 **Easy**: Search by customer or ID
- ⌨️ **Efficient**: Keyboard shortcuts available

### For Business
- 💰 **Cost Saving**: Less manual work
- ⏱️ **Time Saving**: Bulk operations
- 📊 **Better Reporting**: Easy data export
- ✅ **Compliance**: Coretax XML format
- 🔐 **Secure**: Built-in validation

---

**Status**: ✅ **COMPLETE**  
**Date**: November 5, 2025  
**Version**: 1.0.0  

---

*Happy Exporting! 🚀*
