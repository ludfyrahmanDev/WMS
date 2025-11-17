<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Penjualan - {{ $selling->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11pt;
            line-height: 1.3;
            padding: 20px;
            max-width: 210mm;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .company-name {
            font-weight: bold;
            font-size: 13pt;
            margin-bottom: 3px;
        }
        
        .company-address {
            font-size: 9pt;
            margin-bottom: 2px;
        }
        
        .nota-section {
            text-align: right;
            margin-bottom: 15px;
            font-size: 11pt;
        }
        
        .nota-number {
            font-weight: bold;
            font-size: 12pt;
        }
        
        .customer-info {
            margin-bottom: 15px;
            font-size: 10pt;
        }
        
        .customer-info div {
            margin-bottom: 2px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        table th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
            font-size: 10pt;
        }
        
        table td {
            padding: 6px 5px;
            border-bottom: 1px solid #ccc;
            font-size: 10pt;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .totals {
            margin-top: 10px;
            text-align: right;
            font-size: 11pt;
        }
        
        .totals div {
            margin-bottom: 5px;
            padding: 3px 0;
        }
        
        .grand-total {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            font-weight: bold;
            font-size: 12pt;
            padding: 8px 0 !important;
            margin-top: 5px;
        }
        
        .notes {
            margin-top: 15px;
            font-size: 9pt;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        
        .payment-info {
            margin-top: 15px;
            font-size: 10pt;
            border: 1px solid #000;
            padding: 10px;
        }
        
        .payment-info div {
            margin-bottom: 5px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10pt;
        }
        
        .signature {
            margin-top: 60px;
            text-align: center;
        }
        
        @media print {
            body {
                padding: 10px;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
        
        .print-button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Print Nota</button>
    
    <div class="header">
        <div class="company-name">{{ strtoupper($selling->cv->name ?? 'PT. SINAR JAYA MAKMUR BERSAUDARA SEJAHTERA') }}</div>
        <div class="company-address">{{ $selling->cv->address ?? 'JL. RAYA KRIKILAN KM 26, TANJUNGAN, DRIYOREJO' }}</div>
        <div class="company-address">{{ $selling->cv->description ?? 'GRESIK, JAWA TIMUR, 61177' }}</div>
        @if($selling->cv->npwp)
        <div class="company-address">(031) {{ $selling->cv->npwp }}</div>
        @endif
    </div>
    
    <div class="nota-section">
        <div style="text-align: left; float: left;">
            Gresik, {{ \Carbon\Carbon::parse($selling->date)->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
        </div>
        <div style="text-align: right;">
            Yth : {{ strtoupper($selling->customer->name ?? '-') }}
        </div>
        <div style="clear: both;"></div>
    </div>
    
    <div style="text-align: center; margin-bottom: 20px;">
        <div style="font-weight: bold; font-size: 11pt; margin-bottom: 5px;">NOTA</div>
        <div class="nota-number">No : N{{ str_pad($selling->id, 8, '0', STR_PAD_LEFT) }}</div>
        <div style="font-size: 10pt; margin-top: 5px;">PO : </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 15%;">KODE BARANG</th>
                <th style="width: 40%;">JENIS BARANG</th>
                <th class="text-center" style="width: 10%;">JUMLAH</th>
                <th class="text-right" style="width: 15%;">HARGA</th>
                <th class="text-right" style="width: 20%;">TOTAL HARGA</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalItems = 0;
            @endphp
            @foreach($selling->details as $detail)
            <tr>
                <td>ATPO{{ str_pad($detail->stock->product_id ?? '0', 4, '0', STR_PAD_LEFT) }}</td>
                <td>{{ strtoupper($detail->stock->product->product ?? '-') }}</td>
                <td class="text-center">{{ number_format($detail->qty, 0, ',', '.') }} LBR</td>
                <td class="text-right">Rp {{ number_format($detail->price_sell, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @php
                $totalItems += $detail->qty;
            @endphp
            @endforeach
        </tbody>
    </table>
    
    <div style="border-top: 1px solid #ccc; padding-top: 10px; margin-bottom: 10px;">
        <div style="font-style: italic; font-size: 9pt;">
            TERBILANG : {{ ucwords(terbilang($selling->grand_total ?? 0)) }} rupiah
        </div>
    </div>
    
    <div class="totals">
        <div style="display: flex; justify-content: flex-end;">
            <div style="width: 300px; text-align: right;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span>DDP :</span>
                    <span>Rp. {{ number_format($selling->grand_total - ($selling->grand_total * 0.11), 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span>DISC :</span>
                    <span>Rp. 0</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span>PPN :</span>
                    <span>Rp. {{ number_format($selling->grand_total * 0.11, 0, ',', '.') }}</span>
                </div>
                <div class="grand-total" style="display: flex; justify-content: space-between;">
                    <span>TOTAL HARGA :</span>
                    <span>Rp. {{ number_format($selling->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="payment-info">
        <div><strong>SYARAT PEMBAYARAN :</strong></div>
        <div>TGL. JATUH TEMPO : {{ $selling->purchasing_method == 'tempo' ? \Carbon\Carbon::parse($selling->date)->addDays(30)->locale('id')->isoFormat('DD/MM/YYYY') : '-' }}</div>
        <div><strong>PEMBAYARAN HARAP DITRANSFER KE REKENING</strong></div>
        <div>BCA : 468.388.6833</div>
        <div>A/N : {{ strtoupper($selling->cv->name ?? 'PT. SINAR JAYA MAKMUR BERSAUDARA SEJAHTERA (IDR)') }}</div>
    </div>
    
    @if($selling->notes)
    <div class="notes">
        <strong>Catatan:</strong> {{ $selling->notes }}
    </div>
    @endif
    
    <div class="footer">
        <div style="margin-bottom: 80px; display: inline-block; text-align: center;">
            <div>{{ strtoupper($selling->cv->name ?? 'PT. SINAR JAYA MAKMUR BERSAUDARA SEJAHTERA') }}</div>
            <div style="margin-top: 60px; border-top: 1px solid #000; padding-top: 5px;">
                <strong>(________________)</strong>
            </div>
        </div>
    </div>
    
    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
