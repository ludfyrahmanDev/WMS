<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Coretax Bulk Invoice Export - Test Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .checkbox-group {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 4px;
            background: #fafafa;
        }
        .checkbox-item {
            padding: 8px;
            margin-bottom: 5px;
            background: white;
            border-radius: 3px;
            border: 1px solid #eee;
        }
        .checkbox-item:hover {
            background: #f0f8ff;
        }
        .checkbox-item input[type="checkbox"] {
            margin-right: 10px;
        }
        button {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        button:hover {
            background: #0056b3;
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .btn-secondary {
            background: #6c757d;
            margin-left: 10px;
        }
        .btn-secondary:hover {
            background: #545b62;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .selected-count {
            margin: 15px 0;
            padding: 10px;
            background: #e7f3ff;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }
        .help-text {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .example-section {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #eee;
        }
        .example-section h3 {
            color: #007bff;
        }
        pre {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            overflow-x: auto;
        }
        code {
            color: #e83e8c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧾 Coretax Bulk Invoice Export</h1>
        
        <div class="alert alert-info">
            <strong>ℹ️ Info:</strong> Halaman ini untuk testing export bulk invoice ke format XML Coretax. 
            Pilih beberapa invoice dan klik tombol export untuk mengunduh file XML.
        </div>

        <form id="bulkExportForm" action="{{ route('selling.coretax-bulk-invoice-export') }}" method="POST">
            @csrf
            
            <!-- Seller TIN -->
            <div class="form-group">
                <label for="seller_tin">Seller TIN (Nomor Pokok Wajib Pajak Penjual)</label>
                <input 
                    type="text" 
                    id="seller_tin" 
                    name="seller_tin" 
                    value="0830044103613000"
                    placeholder="0830044103613000"
                    pattern="[0-9]{15,16}"
                    maxlength="16"
                >
                <div class="help-text">Format: 15-16 digit angka. Biarkan kosong untuk menggunakan nilai default.</div>
            </div>

            <!-- Invoice Selection -->
            <div class="form-group">
                <label>Pilih Invoice untuk Export</label>
                <div class="selected-count">
                    <strong>Terpilih: <span id="selectedCount">0</span> invoice</strong>
                </div>
                
                <div style="margin-bottom: 10px;">
                    <button type="button" class="btn-secondary" onclick="selectAll()">Pilih Semua</button>
                    <button type="button" class="btn-secondary" onclick="deselectAll()">Batal Pilih</button>
                </div>

                <div class="checkbox-group" id="invoiceList">
                    <!-- Invoice items will be loaded here -->
                    <div class="alert alert-warning">
                        <strong>⚠️ Demo Mode:</strong> Dalam production, daftar invoice akan dimuat dari database.
                        Untuk testing, masukkan ID invoice secara manual di bagian bawah.
                    </div>
                    
                    <!-- Sample invoices for demo -->
                    <div class="checkbox-item">
                        <input type="checkbox" name="selling_ids[]" value="1" class="invoice-checkbox">
                        <label style="display: inline;">Invoice #INV00000001 - PT. CUSTOMER A - Rp 10,000,000</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="selling_ids[]" value="2" class="invoice-checkbox">
                        <label style="display: inline;">Invoice #INV00000002 - PT. CUSTOMER B - Rp 15,500,000</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="selling_ids[]" value="3" class="invoice-checkbox">
                        <label style="display: inline;">Invoice #INV00000003 - PT. CUSTOMER C - Rp 8,750,000</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="selling_ids[]" value="4" class="invoice-checkbox">
                        <label style="display: inline;">Invoice #INV00000004 - PT. CUSTOMER D - Rp 22,300,000</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="selling_ids[]" value="5" class="invoice-checkbox">
                        <label style="display: inline;">Invoice #INV00000005 - PT. CUSTOMER E - Rp 12,000,000</label>
                    </div>
                </div>
            </div>

            <!-- Manual ID Input (for testing) -->
            <div class="form-group">
                <label for="manual_ids">Atau Masukkan ID Manual (pisahkan dengan koma)</label>
                <input 
                    type="text" 
                    id="manual_ids" 
                    placeholder="Contoh: 1,2,3,4,5"
                >
                <div class="help-text">Format: ID invoice dipisahkan dengan koma (1,2,3). Akan menambahkan ke pilihan yang sudah ada.</div>
                <button type="button" class="btn-secondary" onclick="addManualIds()" style="margin-top: 10px;">
                    Tambahkan ID
                </button>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" id="exportButton" disabled>
                    📥 Export ke XML Coretax
                </button>
                <button type="button" class="btn-secondary" onclick="previewSelection()">
                    👁️ Preview Selection
                </button>
            </div>
        </form>

        <!-- Example Section -->
        <div class="example-section">
            <h3>📚 Contoh Penggunaan</h3>
            
            <h4>1. Via JavaScript/AJAX</h4>
            <pre><code>const selectedIds = [1, 2, 3, 4, 5];
const formData = new FormData();

selectedIds.forEach(id => {
    formData.append('selling_ids[]', id);
});
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
});</code></pre>

            <h4>2. Via PHP Service</h4>
            <pre><code>use App\Services\CoretaxExportService;

$coretaxService = new CoretaxExportService();
$result = $coretaxService->generateBulkInvoiceXML(
    [1, 2, 3, 4, 5], 
    '0830044103613000'
);

// Result: ['filename', 'filepath', 'url', 'total_invoices']</code></pre>

            <h4>3. Format XML Output</h4>
            <pre><code>&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;TaxInvoiceBulk&gt;
    &lt;TIN&gt;0830044103613000&lt;/TIN&gt;
    &lt;ListOfTaxInvoice&gt;
        &lt;TaxInvoice&gt;
            &lt;TaxInvoiceDate&gt;2025-11-01&lt;/TaxInvoiceDate&gt;
            &lt;RefDesc&gt;INV00000001&lt;/RefDesc&gt;
            &lt;BuyerName&gt;PT. CUSTOMER NAME&lt;/BuyerName&gt;
            &lt;ListOfGoodService&gt;...&lt;/ListOfGoodService&gt;
        &lt;/TaxInvoice&gt;
    &lt;/ListOfTaxInvoice&gt;
&lt;/TaxInvoiceBulk&gt;</code></pre>
        </div>
    </div>

    <script>
        // Update selected count
        function updateSelectedCount() {
            const count = document.querySelectorAll('.invoice-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = count;
            document.getElementById('exportButton').disabled = count === 0;
        }

        // Listen to checkbox changes
        document.querySelectorAll('.invoice-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        // Select all checkboxes
        function selectAll() {
            document.querySelectorAll('.invoice-checkbox').forEach(checkbox => {
                checkbox.checked = true;
            });
            updateSelectedCount();
        }

        // Deselect all checkboxes
        function deselectAll() {
            document.querySelectorAll('.invoice-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectedCount();
        }

        // Add manual IDs
        function addManualIds() {
            const input = document.getElementById('manual_ids');
            const ids = input.value.split(',').map(id => id.trim()).filter(id => id);
            
            if (ids.length === 0) {
                alert('Masukkan minimal 1 ID');
                return;
            }

            const checkboxGroup = document.getElementById('invoiceList');
            
            ids.forEach(id => {
                // Check if already exists
                const existing = document.querySelector(`input[value="${id}"]`);
                if (!existing) {
                    const div = document.createElement('div');
                    div.className = 'checkbox-item';
                    div.innerHTML = `
                        <input type="checkbox" name="selling_ids[]" value="${id}" class="invoice-checkbox" checked>
                        <label style="display: inline;">Invoice ID #${id} (Manual Input)</label>
                    `;
                    checkboxGroup.appendChild(div);
                    
                    // Add event listener to new checkbox
                    div.querySelector('.invoice-checkbox').addEventListener('change', updateSelectedCount);
                }
            });
            
            input.value = '';
            updateSelectedCount();
            alert(`${ids.length} ID berhasil ditambahkan`);
        }

        // Preview selection
        function previewSelection() {
            const selectedIds = [];
            document.querySelectorAll('.invoice-checkbox:checked').forEach(checkbox => {
                selectedIds.push(checkbox.value);
            });
            
            if (selectedIds.length === 0) {
                alert('Pilih minimal 1 invoice untuk preview');
                return;
            }

            const sellerTin = document.getElementById('seller_tin').value || '0830044103613000';
            
            const message = `
📋 Preview Export:
━━━━━━━━━━━━━━━━━━━━━
Seller TIN: ${sellerTin}
Total Invoice: ${selectedIds.length}
Invoice IDs: ${selectedIds.join(', ')}
━━━━━━━━━━━━━━━━━━━━━

File yang akan dihasilkan:
coretax_bulk_invoice_YYYYMMDDHHMMSS.xml

Klik OK untuk melanjutkan export.
            `;
            
            alert(message);
        }

        // Form submit handler
        document.getElementById('bulkExportForm').addEventListener('submit', function(e) {
            const selectedIds = document.querySelectorAll('.invoice-checkbox:checked').length;
            
            if (selectedIds === 0) {
                e.preventDefault();
                alert('Pilih minimal 1 invoice untuk export!');
                return false;
            }

            // Show loading message
            const button = document.getElementById('exportButton');
            button.disabled = true;
            button.textContent = '⏳ Sedang export...';
            
            // Re-enable button after 3 seconds (in case of error)
            setTimeout(() => {
                button.disabled = false;
                button.textContent = '📥 Export ke XML Coretax';
            }, 3000);
        });

        // Initialize count
        updateSelectedCount();
    </script>
</body>
</html>
