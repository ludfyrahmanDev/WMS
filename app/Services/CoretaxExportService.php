<?php

namespace App\Services;

use App\Models\Selling;
use App\Models\SellingDetail;
use Carbon\Carbon;

class CoretaxExportService
{
    /**
     * Generate Coretax export data format
     * Format: CSV with specific columns required by Coretax
     */
    public function generateExportData($sellingId)
    {
        $selling = Selling::with(['customer', 'details.product', 'cv'])
            ->findOrFail($sellingId);

        $exportData = [];
        
        foreach ($selling->details as $index => $detail) {
            // PPN include dalam subtotal
            // DPP = subtotal / 1.11
            // PPN = DPP * 0.11
            $hargaTotal = $detail->subtotal;
            $dpp = $hargaTotal / 1.11;
            $ppn = $dpp * 0.11;
            $hargaSatuan = $detail->price_sell / 1.11;
            
            $exportData[] = [
                'Nama Barang/Jasa' => htmlspecialchars($detail->product->product ?? ''),
                'Nomor Transaksi' => 'INV-' . str_pad($selling->id, 8, '0', STR_PAD_LEFT),
                'Tanggal Transaksi' => Carbon::parse($selling->date)->format('d/m/Y'),
                'NPWP Pembeli' => $this->formatNPWP($selling->customer->npwp ?? ''),
                'Nama Pembeli' => $selling->customer->name ?? '',
                'Alamat Pembeli' => $selling->customer->address ?? '',
                'Nomor Item' => $index + 1,
                'Nama Barang/Jasa' => $detail->product->product ?? '',
                'Harga Satuan' => number_format($hargaSatuan, 2, '.', ''),
                'Jumlah Barang' => $detail->total_qty,
                'Harga Total' => number_format($hargaTotal, 2, '.', ''),
                'Diskon' => '0.00',
                'DPP (Dasar Pengenaan Pajak)' => number_format($dpp, 2, '.', ''),
                'PPN' => number_format($ppn, 2, '.', ''), // PPN 11%
                'Tarif PPN' => '11',
                'PPnBM' => '0.00',
                'Tarif PPnBM' => '0',
                'Keterangan' => $selling->notes ?? '',
                'Referensi' => 'WMS-' . $selling->id,
            ];
        }

        return $exportData;
    }

    /**
     * Generate CSV file
     */
    public function generateCSV($sellingId)
    {
        $data = $this->generateExportData($sellingId);
        
        if (empty($data)) {
            return null;
        }

        $filename = 'coretax_export_' . $sellingId . '_' . date('YmdHis') . '.csv';
        $filepath = storage_path('app/exports/' . $filename);

        // Ensure directory exists
        if (!file_exists(storage_path('app/exports'))) {
            mkdir(storage_path('app/exports'), 0755, true);
        }

        $file = fopen($filepath, 'w');
        
        // Add BOM for Excel UTF-8 compatibility
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Write header
        fputcsv($file, array_keys($data[0]), ';');
        
        // Write data
        foreach ($data as $row) {
            fputcsv($file, $row, ';');
        }
        
        fclose($file);

        return [
            'filename' => $filename,
            'filepath' => $filepath,
            'url' => asset('storage/exports/' . $filename)
        ];
    }

    /**
     * Generate XML format (alternative format)
     */
    public function generateXML($sellingId)
    {
        $selling = Selling::with(['customer', 'details.product', 'cv'])
            ->findOrFail($sellingId);

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><FakturPajak></FakturPajak>');
        
        // Header
        $header = $xml->addChild('Header');
        $header->addChild('NomorFaktur', 'INV-' . str_pad($selling->id, 8, '0', STR_PAD_LEFT));
        $header->addChild('TanggalFaktur', Carbon::parse($selling->date)->format('d/m/Y'));
        $header->addChild('MasaPajak', Carbon::parse($selling->date)->format('m'));
        $header->addChild('TahunPajak', Carbon::parse($selling->date)->format('Y'));
        
        // Penjual
        $penjual = $xml->addChild('Penjual');
        $penjual->addChild('NPWP', $this->formatNPWP($selling->cv->npwp ?? ''));
        $penjual->addChild('Nama', $selling->cv->name ?? '');
        $penjual->addChild('Alamat', $selling->cv->address ?? '');
        
        // Pembeli
        $pembeli = $xml->addChild('Pembeli');
        $pembeli->addChild('NPWP', $this->formatNPWP($selling->customer->npwp ?? ''));
        $pembeli->addChild('Nama', $selling->customer->name ?? '');
        $pembeli->addChild('Alamat', $selling->customer->address ?? '');
        
        // Detail
        $details = $xml->addChild('Details');
        foreach ($selling->details as $index => $detail) {
            // PPN include dalam subtotal
            $hargaTotal = $detail->subtotal;
            $dpp = $hargaTotal / 1.11;
            $ppn = $dpp * 0.11;
            $hargaSatuan = $detail->price_sell / 1.11;
            
            $item = $details->addChild('Item');
            $item->addChild('NomorUrut', $index + 1);
            $item->addChild('NamaBarang', htmlspecialchars($detail->product->product ?? ''));
            $item->addChild('HargaSatuan', number_format($hargaSatuan, 2, '.', ''));
            $item->addChild('Jumlah', $detail->total_qty);
            $item->addChild('HargaTotal', number_format($hargaTotal, 2, '.', ''));
            $item->addChild('DPP', number_format($dpp, 2, '.', ''));
            $item->addChild('PPN', number_format($ppn, 2, '.', ''));
        }
        
        // Summary - PPN include dalam grand_total
        $totalNilai = $selling->grand_total;
        $totalDPP = $totalNilai / 1.11;
        $totalPPN = $totalDPP * 0.11;
        
        $summary = $xml->addChild('Summary');
        $summary->addChild('TotalDPP', number_format($totalDPP, 2, '.', ''));
        $summary->addChild('TotalPPN', number_format($totalPPN, 2, '.', ''));
        $summary->addChild('TotalPPnBM', '0.00');
        $summary->addChild('TotalNilai', number_format($totalNilai, 2, '.', ''));
        
        $filename = 'coretax_export_' . $sellingId . '_' . date('YmdHis') . '.xml';
        $filepath = storage_path('app/exports/' . $filename);
        
        // Ensure directory exists
        if (!file_exists(storage_path('app/exports'))) {
            mkdir(storage_path('app/exports'), 0755, true);
        }
        
        $xml->asXML($filepath);
        
        return [
            'filename' => $filename,
            'filepath' => $filepath,
            'url' => asset('storage/exports/' . $filename)
        ];
    }

    /**
     * Format NPWP to standard format
     */
    private function formatNPWP($npwp)
    {
        // Remove all non-numeric characters
        $npwp = preg_replace('/[^0-9]/', '', $npwp);
        
        // If empty, return default
        if (empty($npwp)) {
            return '00.000.000.0-000.000';
        }
        
        // Pad with zeros if needed
        $npwp = str_pad($npwp, 15, '0', STR_PAD_LEFT);
        
        // Format: XX.XXX.XXX.X-XXX.XXX
        return substr($npwp, 0, 2) . '.' . 
               substr($npwp, 2, 3) . '.' . 
               substr($npwp, 5, 3) . '.' . 
               substr($npwp, 8, 1) . '-' . 
               substr($npwp, 9, 3) . '.' . 
               substr($npwp, 12, 3);
    }

    /**
     * Get export data for preview
     */
    public function getPreviewData($sellingId)
    {
        $selling = Selling::with(['customer', 'details.product', 'cv'])
            ->findOrFail($sellingId);

        // PPN include dalam grand_total
        $totalNilai = $selling->grand_total;
        $totalDPP = $totalNilai / 1.11;
        $totalPPN = $totalDPP * 0.11;

        return [
            'selling' => $selling,
            'invoice_number' => 'INV-' . str_pad($selling->id, 8, '0', STR_PAD_LEFT),
            'formatted_date' => Carbon::parse($selling->date)->format('d/m/Y'),
            'total_dpp' => $totalDPP,
            'total_ppn' => $totalPPN,
            'total_nilai' => $totalNilai,
            'items' => $this->generateExportData($sellingId)
        ];
    }

    /**
     * Generate Bulk Invoice XML for Coretax
     * Format: XML with TaxInvoiceBulk structure
     * 
     * @param array $sellingIds Array of selling IDs to include in bulk export
     * @param string $sellerTin Seller's Tax Identification Number (20 digits)
     * @return array Contains filename, filepath, and url
     */
    public function generateBulkInvoiceXML($sellingIds, $sellerTin = '0830044103613000')
    {
        // Fetch all sellings with related data
        $sellings = Selling::with(['customer', 'details.product', 'cv'])
            ->whereIn('id', $sellingIds)
            ->get();

        // Create XML structure
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        // Root element with namespace
        $root = $xml->createElement('TaxInvoiceBulk');
        $root->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $root->setAttribute('xsi:noNamespaceSchemaLocation', 'TaxInvoice.xsd');
        $xml->appendChild($root);

        // Add TIN (Seller's Tax Identification Number)
        $tin = $xml->createElement('TIN', $this->cleanTin($sellerTin));
        $root->appendChild($tin);

        // List of Tax Invoices
        $listOfTaxInvoice = $xml->createElement('ListOfTaxInvoice');
        $root->appendChild($listOfTaxInvoice);

        // Process each selling
        foreach ($sellings as $selling) {
            $taxInvoice = $this->createTaxInvoiceElement($xml, $selling);
            $listOfTaxInvoice->appendChild($taxInvoice);
        }

        // Save XML file
        $filename = 'coretax_bulk_invoice_' . date('YmdHis') . '.xml';
        $filepath = storage_path('app/exports/' . $filename);

        // Ensure directory exists
        if (!file_exists(storage_path('app/exports'))) {
            mkdir(storage_path('app/exports'), 0755, true);
        }

        $xml->save($filepath);

        return [
            'filename' => $filename,
            'filepath' => $filepath,
            'url' => asset('storage/exports/' . $filename),
            'total_invoices' => $sellings->count()
        ];
    }

    /**
     * Create TaxInvoice element for a single selling
     */
    private function createTaxInvoiceElement($xml, $selling)
    {
        $taxInvoice = $xml->createElement('TaxInvoice');

        // Tax Invoice Date (format: YYYY-MM-DD)
        $taxInvoiceDate = $xml->createElement('TaxInvoiceDate', Carbon::parse($selling->date)->format('Y-m-d'));
        $taxInvoice->appendChild($taxInvoiceDate);

        // Tax Invoice Option (Normal, Replacement, etc.)
        $taxInvoiceOpt = $xml->createElement('TaxInvoiceOpt', 'Normal');
        $taxInvoice->appendChild($taxInvoiceOpt);

        // Transaction Code (04 = Penyerahan yang PPN-nya harus dipungut sendiri)
        $trxCode = $xml->createElement('TrxCode', '04');
        $taxInvoice->appendChild($trxCode);

        // Additional Info (optional)
        $addInfo = $xml->createElement('AddInfo');
        $taxInvoice->appendChild($addInfo);

        // Custom Document (optional)
        $customDoc = $xml->createElement('CustomDoc');
        $taxInvoice->appendChild($customDoc);

        // Custom Document Month Year (optional)
        $customDocMonthYear = $xml->createElement('CustomDocMonthYear');
        $taxInvoice->appendChild($customDocMonthYear);

        // Reference Description (Invoice Number)
        $refNumber = 'INV' . str_pad($selling->id, 8, '0', STR_PAD_LEFT);
        $refDesc = $xml->createElement('RefDesc', $refNumber);
        $taxInvoice->appendChild($refDesc);

        // Facility Stamp (optional)
        $facilityStamp = $xml->createElement('FacilityStamp');
        $taxInvoice->appendChild($facilityStamp);

        // Seller ID TKU (22 digits: TIN + 6 additional digits)
        $sellerIdTku = $xml->createElement('SellerIDTKU', $this->cleanTin($selling->cv->npwp ?? '0830044103613000') . '000000');
        $taxInvoice->appendChild($sellerIdTku);

        // Buyer TIN (15 digits)
        $buyerTin = $xml->createElement('BuyerTin', $this->cleanTin($selling->customer->npwp ?? ''));
        $taxInvoice->appendChild($buyerTin);

        // Buyer Document Type
        $buyerDocument = $xml->createElement('BuyerDocument', 'TIN');
        $taxInvoice->appendChild($buyerDocument);

        // Buyer Country Code (ISO 3166-1 alpha-3)
        $buyerCountry = $xml->createElement('BuyerCountry', 'IND');
        $taxInvoice->appendChild($buyerCountry);

        // Buyer Document Number (optional, for foreign buyers)
        $buyerDocumentNumber = $xml->createElement('BuyerDocumentNumber');
        $taxInvoice->appendChild($buyerDocumentNumber);

        // Buyer Name
        $buyerName = $xml->createElement('BuyerName', htmlspecialchars($selling->customer->name ?? '', ENT_XML1, 'UTF-8'));
        $taxInvoice->appendChild($buyerName);

        // Buyer Address
        $buyerAddress = $xml->createElement('BuyerAdress', htmlspecialchars($selling->customer->address ?? '', ENT_XML1, 'UTF-8'));
        $taxInvoice->appendChild($buyerAddress);

        // Buyer Email (optional)
        $buyerEmail = $xml->createElement('BuyerEmail', htmlspecialchars($selling->customer->email ?? '', ENT_XML1, 'UTF-8'));
        $taxInvoice->appendChild($buyerEmail);

        // Buyer ID TKU (22 digits)
        $buyerIdTku = $xml->createElement('BuyerIDTKU', $this->cleanTin($selling->customer->npwp ?? '') . '000000');
        $taxInvoice->appendChild($buyerIdTku);

        // List of Goods/Services
        $listOfGoodService = $xml->createElement('ListOfGoodService');
        $taxInvoice->appendChild($listOfGoodService);

        // Add each product detail
        foreach ($selling->details as $detail) {
            $goodService = $this->createGoodServiceElement($xml, $detail);
            $listOfGoodService->appendChild($goodService);
        }

        return $taxInvoice;
    }

    /**
     * Create GoodService element for a product detail
     */
    private function createGoodServiceElement($xml, $detail)
    {
        $goodService = $xml->createElement('GoodService');

        // Option (A = Barang, B = Jasa)
        $opt = $xml->createElement('Opt', 'A');
        $goodService->appendChild($opt);

        // Product Code (Kode Klasifikasi Barang/Jasa)
        $code = $xml->createElement('Code', htmlspecialchars($detail->product->id ?? '761000', ENT_XML1, 'UTF-8'));
        $goodService->appendChild($code);

        // Product Name
        $name = $xml->createElement('Name', htmlspecialchars($detail->product->product ?? '-', ENT_XML1, 'UTF-8'));
        $goodService->appendChild($name);

        // Unit of Measurement (Kode Satuan)
        $unit = $xml->createElement('Unit', 'UM.0020');
        $goodService->appendChild($unit);

        // Calculate prices and tax - PPN include dalam subtotal
        $hargaTotal = $detail->subtotal;
        $qty = $detail->total_qty;
        $totalDiscount = 0;
        
        // Tax Base (DPP) = Harga Total / 1.11 (PPN 11% include)
        $taxBase = $hargaTotal / 1.11;
        
        // Price per unit (exclude PPN)
        $pricePerUnit = $detail->price_sell / 1.11;
        
        // Other Tax Base (for calculation purposes)
        $otherTaxBase = $taxBase;
        
        // VAT Rate (11%)
        $vatRate = 11;
        
        // VAT Amount
        $vat = $taxBase * 0.11;
        
        // Luxury Sales Tax (PPnBM) - usually 0 for regular goods
        $stlgRate = 0;
        $stlg = 0;

        // Price per unit
        $price = $xml->createElement('Price', number_format($pricePerUnit, 2, '.', ''));
        $goodService->appendChild($price);

        // Quantity
        $qtyElement = $xml->createElement('Qty', $qty);
        $goodService->appendChild($qtyElement);

        // Total Discount
        $totalDiscountElement = $xml->createElement('TotalDiscount', number_format($totalDiscount, 2, '.', ''));
        $goodService->appendChild($totalDiscountElement);

        // Tax Base (DPP)
        $taxBaseElement = $xml->createElement('TaxBase', number_format($taxBase, 2, '.', ''));
        $goodService->appendChild($taxBaseElement);

        // Other Tax Base
        $otherTaxBaseElement = $xml->createElement('OtherTaxBase', number_format($otherTaxBase, 2, '.', ''));
        $goodService->appendChild($otherTaxBaseElement);

        // VAT Rate
        $vatRateElement = $xml->createElement('VATRate', $vatRate);
        $goodService->appendChild($vatRateElement);

        // VAT Amount
        $vatElement = $xml->createElement('VAT', number_format($vat, 2, '.', ''));
        $goodService->appendChild($vatElement);

        // STLG Rate (Luxury Sales Tax Rate)
        $stlgRateElement = $xml->createElement('STLGRate', $stlgRate);
        $goodService->appendChild($stlgRateElement);

        // STLG Amount
        $stlgElement = $xml->createElement('STLG', number_format($stlg, 2, '.', ''));
        $goodService->appendChild($stlgElement);

        return $goodService;
    }

    /**
     * Clean and format TIN/NPWP to numeric only
     * Returns 15 or 16 digit numeric string
     */
    private function cleanTin($tin)
    {
        // Remove all non-numeric characters
        $cleaned = preg_replace('/[^0-9]/', '', $tin);
        
        // Pad with zeros if needed (standard is 15 digits for NPWP, 16 for NIK)
        if (strlen($cleaned) < 15) {
            $cleaned = str_pad($cleaned, 15, '0', STR_PAD_LEFT);
        }
        
        return $cleaned;
    }
}
