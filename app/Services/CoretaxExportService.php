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
            $exportData[] = [
                'Nomor Transaksi' => 'INV-' . str_pad($selling->id, 8, '0', STR_PAD_LEFT),
                'Tanggal Transaksi' => Carbon::parse($selling->date)->format('d/m/Y'),
                'NPWP Pembeli' => $this->formatNPWP($selling->customer->npwp ?? ''),
                'Nama Pembeli' => $selling->customer->name ?? '',
                'Alamat Pembeli' => $selling->customer->address ?? '',
                'Nomor Item' => $index + 1,
                'Nama Barang/Jasa' => $detail->product->product ?? '',
                'Harga Satuan' => number_format($detail->price_sell, 2, '.', ''),
                'Jumlah Barang' => $detail->total_qty,
                'Harga Total' => number_format($detail->subtotal, 2, '.', ''),
                'Diskon' => '0.00',
                'DPP (Dasar Pengenaan Pajak)' => number_format($detail->subtotal, 2, '.', ''),
                'PPN' => number_format($detail->subtotal * 0.11, 2, '.', ''), // PPN 11%
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
            $item = $details->addChild('Item');
            $item->addChild('NomorUrut', $index + 1);
            $item->addChild('NamaBarang', htmlspecialchars($detail->product->product ?? ''));
            $item->addChild('HargaSatuan', number_format($detail->price_sell, 2, '.', ''));
            $item->addChild('Jumlah', $detail->total_qty);
            $item->addChild('HargaTotal', number_format($detail->subtotal, 2, '.', ''));
            $item->addChild('DPP', number_format($detail->subtotal, 2, '.', ''));
            $item->addChild('PPN', number_format($detail->subtotal * 0.11, 2, '.', ''));
        }
        
        // Summary
        $summary = $xml->addChild('Summary');
        $summary->addChild('TotalDPP', number_format($selling->grand_total, 2, '.', ''));
        $summary->addChild('TotalPPN', number_format($selling->grand_total * 0.11, 2, '.', ''));
        $summary->addChild('TotalPPnBM', '0.00');
        $summary->addChild('TotalNilai', number_format($selling->grand_total * 1.11, 2, '.', ''));
        
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

        $totalDPP = $selling->grand_total;
        $totalPPN = $totalDPP * 0.11;
        $totalNilai = $totalDPP + $totalPPN;

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
}
