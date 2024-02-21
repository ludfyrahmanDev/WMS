<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Transport;
use App\Exports\TransportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Dompdf\Dompdf;
use Dompdf\Options;

class TransportController extends Controller
{
    public function index(Request $request)
    {
        $all = Transport::with('customer', 'driver')
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('created_at', [$start_date, $end_date]);
        }
        $data = $all->paginate($request->get('per_page', 10));
        $title = 'Laporan Angkutan';
        $route = 'transport';
        $request = $request->toArray();
        return view('pages.backoffice.transport.index', compact('data', 'request', 'title', 'route', 'request'));
    }

    public function export(Request $request)
    {
        $name = 'Data Angkutan - ' . date('Y-m-d');
        $fileName = $name . '.xlsx';
        Excel::store(new TransportExport($request), 'public/excel/' . $fileName);
        return Excel::download(new TransportExport($request), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $all = Transport::with('customer', 'driver')
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('created_at', [$start_date, $end_date]);
        }

        $data = $all->get();
        $title = 'Data Angkutan';

        // Inisialisasi opsi Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);

        // Inisialisasi Dompdf dengan opsi yang telah disetel
        $dompdf = new Dompdf($options);
        // Memuat tampilan HTML sebagai string
        $html = view('pages.backoffice.transport.export', compact('data', 'title'))->render();

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Set paper size (jika diperlukan)
        $dompdf->setPaper('a4', 'landscape');

        // Render PDF (output ke browser atau simpan ke file)
        $dompdf->render();

        // Nama file untuk diunduh
        $name = 'laporan_angkatan_' . date('d-m-Y');

        // Unduh file PDF
        return $dompdf->stream("$name.pdf");
    }
}
