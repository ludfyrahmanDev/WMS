<?php

namespace App\Services;

use App\Models\DeliveryOrder;
use Carbon\Carbon;

class CoretaxDeliveryOrderService
{
    /**
     * Generate Coretax export data format for Delivery Order
     */
    public function generateExportData($deliveryOrderId)
    {
        $deliveryOrder = DeliveryOrder::with(['supplier', 'details.stock.product', 'cv'])
            ->findOrFail($deliveryOrderId);

        $exportData = [];
        
        foreach ($deliveryOrder->details as $index => $detail) {
            $exportData[] = [
                'Nomor Transaksi' => 'DO-' . str_pad($deliveryOrder->id, 8, '0', STR_PAD_LEFT),
                'Tanggal Transaksi' => Carbon::parse($deliveryOrder->pickup_date)->format('d/m/Y'),
                'NPWP Penjual' => $this->formatNPWP($deliveryOrder->supplier->npwp ?? ''),
                'Nama Penjual' => $deliveryOrder->supplier->name ?? '',
                'Alamat Penjual' => $deliveryOrder->supplier->address ?? '',
                'NPWP Pembeli' => $this->formatNPWP($deliveryOrder->cv->npwp ?? ''),
                'Nama Pembeli' => $deliveryOrder->cv->name ?? '',
                'Alamat Pembeli' => $deliveryOrder->cv->address ?? '',
                'Nomor Item' => $index + 1,
                'Nama Barang/Jasa' => $detail->stock->product->product ?? '',
                'Harga Satuan' => number_format($detail->price, 2, '.', ''),
                'Jumlah Barang' => $detail->qty,
                'Harga Total' => number_format($detail->subtotal, 2, '.', ''),
                'Diskon' => '0.00',
                'DPP (Dasar Pengenaan Pajak)' => number_format($detail->subtotal, 2, '.', ''),
                'PPN' => number_format($detail->subtotal * 0.11, 2, '.', ''),
                'Tarif PPN' => '11',
                'PPnBM' => '0.00',
                'Tarif PPnBM' => '0',
                'Keterangan' => $deliveryOrder->notes ?? '',
                'Referensi' => 'WMS-DO-' . $deliveryOrder->id,
                'Nomor Faktur' => $deliveryOrder->no_faktur ?? '',
                'Nomor SJ' => $deliveryOrder->no_sj ?? '',
            ];
        }

        return $exportData;
    }

    /**
     * Generate CSV file
     */
    public function generateCSV($deliveryOrderId)
    {
        $data = $this->generateExportData($deliveryOrderId);
        
        if (empty($data)) {
            return null;
        }

        $filename = 'coretax_do_export_' . $deliveryOrderId . '_' . date('YmdHis') . '.csv';
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
     * Generate XML format
     */
    public function generateXML($deliveryOrderId)
    {
        $deliveryOrder = DeliveryOrder::with(['supplier', 'details.product', 'cv'])
            ->findOrFail($deliveryOrderId);

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><FakturPajakMasukan></FakturPajakMasukan>');
        
        // Header
        $header = $xml->addChild('Header');
        $header->addChild('NomorFaktur', $deliveryOrder->no_faktur ?? 'DO-' . str_pad($deliveryOrder->id, 8, '0', STR_PAD_LEFT));
        $header->addChild('NomorSuratJalan', $deliveryOrder->no_sj ?? '');
        $header->addChild('TanggalFaktur', Carbon::parse($deliveryOrder->pickup_date)->format('d/m/Y'));
        $header->addChild('MasaPajak', Carbon::parse($deliveryOrder->pickup_date)->format('m'));
        $header->addChild('TahunPajak', Carbon::parse($deliveryOrder->pickup_date)->format('Y'));
        
        // Penjual (Supplier)
        $penjual = $xml->addChild('Penjual');
        $penjual->addChild('NPWP', $this->formatNPWP($deliveryOrder->supplier->npwp ?? ''));
        $penjual->addChild('Nama', htmlspecialchars($deliveryOrder->supplier->name ?? ''));
        $penjual->addChild('Alamat', htmlspecialchars($deliveryOrder->supplier->address ?? ''));
        
        // Pembeli (CV/Perusahaan)
        $pembeli = $xml->addChild('Pembeli');
        $pembeli->addChild('NPWP', $this->formatNPWP($deliveryOrder->cv->npwp ?? ''));
        $pembeli->addChild('Nama', htmlspecialchars($deliveryOrder->cv->name ?? ''));
        $pembeli->addChild('Alamat', htmlspecialchars($deliveryOrder->cv->address ?? ''));
        
        // Detail
        $details = $xml->addChild('Details');
        $totalDPP = 0;
        $totalPPN = 0;
        
        foreach ($deliveryOrder->details as $index => $detail) {
            $item = $details->addChild('Item');
            $item->addChild('NomorUrut', $index + 1);
            $item->addChild('NamaBarang', htmlspecialchars($detail->product->product ?? ''));
            $item->addChild('HargaSatuan', number_format($detail->price, 2, '.', ''));
            $item->addChild('Jumlah', $detail->qty);
            $item->addChild('HargaTotal', number_format($detail->subtotal, 2, '.', ''));
            $item->addChild('DPP', number_format($detail->subtotal, 2, '.', ''));
            $item->addChild('PPN', number_format($detail->subtotal * 0.11, 2, '.', ''));
            
            $totalDPP += $detail->subtotal;
            $totalPPN += $detail->subtotal * 0.11;
        }
        
        // Summary
        $summary = $xml->addChild('Summary');
        $summary->addChild('TotalDPP', number_format($totalDPP, 2, '.', ''));
        $summary->addChild('TotalPPN', number_format($totalPPN, 2, '.', ''));
        $summary->addChild('TotalPPnBM', '0.00');
        $summary->addChild('TotalNilai', number_format($totalDPP + $totalPPN, 2, '.', ''));
        
        $filename = 'coretax_do_export_' . $deliveryOrderId . '_' . date('YmdHis') . '.xml';
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
    public function getPreviewData($deliveryOrderId)
    {
        $deliveryOrder = DeliveryOrder::with(['supplier', 'details', 'cv'])
            ->findOrFail($deliveryOrderId);

        $totalDPP = 0;
        foreach ($deliveryOrder->details as $detail) {
            $totalDPP += $detail->subtotal;
        }
        
        $totalPPN = $totalDPP * 0.11;
        $totalNilai = $totalDPP + $totalPPN;

        return [
            'delivery_order' => $deliveryOrder,
            'invoice_number' => $deliveryOrder->no_faktur ?? 'DO-' . str_pad($deliveryOrder->id, 8, '0', STR_PAD_LEFT),
            'surat_jalan' => $deliveryOrder->no_sj ?? '-',
            'formatted_date' => Carbon::parse($deliveryOrder->pickup_date)->format('d/m/Y'),
            'total_dpp' => $totalDPP,
            'total_ppn' => $totalPPN,
            'total_nilai' => $totalNilai,
            'items' => $this->generateExportData($deliveryOrderId)
        ];
    }
}
