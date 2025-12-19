<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Transport;
use App\Exports\TransportExport;
use App\Http\Requests\Transaksi\TransportStoreRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Dompdf\Dompdf;
use Dompdf\Options;

class TransportController extends Controller
{
    public function index(Request $request)
    {
        $cv_id = session('cv_id');
        $all = Transport::with('vehicle', 'driver')
            ->where('cv_id', $cv_id)
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));

        // Filter nopol
        if ($request->filled('nopol')) {
            $all = $all->where('vehicle_id', $request->nopol);
        }

        // Filter tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('date', [$start_date, $end_date]);
        }

        // Pencarian umum (search)
        if ($request->filled('search')) {
            $search = $request->search;
            $all = $all->where(function($q) use ($search) {
                $q->whereHas('vehicle', function($v) use ($search) {
                    $v->where('license_plate', 'like', "%$search%")
                      ->orWhere('name', 'like', "%$search%");
                })
                ->orWhereHas('driver', function($d) use ($search) {
                    $d->where('name', 'like', "%$search%");
                })
                ->orWhere('customer', 'like', "%$search%")
                ->orWhere('product', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%")
                ->orWhere('ongkosan', 'like', "%$search%")
                ->orWhere('setoran', 'like', "%$search%");
            });
        }

        $data = $all->paginate($request->get('per_page', 10));
        $title = 'Laporan Angkutan';
        $route = 'transport';
        $request = $request->toArray();
        return view('pages.backoffice.transport.index', compact('data', 'request', 'title', 'route', 'request'));
    }

    public function create(Transport $transport)
    {
        $selectedCvId = session('cv_id');
        $cvs = auth()->user()->getAccessibleCvs();

        $data['invoices']   = $transport->invoices();
        $data['vehicle']    = $transport->getVehicle();
        $data['driver']     = $transport->getDriver();
        $data['cvs']        = $cvs;
        $data['header'] = (object)[
            'cv_id'                 => $selectedCvId,
            'date'                  => null,
            'vehicle_id'            => null,
            'driver_id'             => null,
            'product'           => null,
            'customer'           => null,
            'weight'           => null,
            'ongkosan'            => null,
            'driver_pocket_money'   => null,
            'setoran'     => null
        ];

        $title  = 'Tambah Angkutan Transaksi';
        $route  = route('transport.store');
        $type   = 'create';

        return view('pages.backoffice.transport._form', compact('data', 'title', 'route', 'type'));
    }

    public function getInvoice(Request $request)
    {
        $id = $request->post('id');

        $transport = new Transport();
        $invoices = $transport->getDataSellingByInvoice($id);

        return response()->json($invoices);
    }

    public function store(TransportStoreRequest $request)
    {

        $user = auth()->user();
        try {

            // insert Table Selling
            $transport                        = new Transport();
            $transport->cv_id                  = $request->cv_id ?? session('cv_id');
            $transport->date                  = $request->tgl_jual;
            $transport->vehicle_id            = $request->vehicle;
            $transport->driver_id             = $request->driver;
            $transport->product               = $request->product;
            $transport->customer              = $request->customer;
            $transport->weight                = $request->weight;
            $transport->ongkosan              = curencyToInteger($request->ongkosan);
            $transport->drivers_pocket_money  = curencyToInteger($request->drivers_pocket_money);
            $transport->setoran               = curencyToInteger($request->setoran);
            $transport->type                  = $request->type ?? 'cash';
            $transport->status                = 'In Progress';
            $transport->created_by            = $user['name'];
            $transport->updated_by            = $user['name'];
            $transport->save();

            return redirect(route('transport.index'))->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            // $errorMessage = $th->getMessage() . " at line " . $th->getLine();
            // // var_dump($errorMessage);
            // // die;
            // return back()->with('failed', $errorMessage);
            return back()->with('failed', 'Gagal menambah data!' . $th->getMessage());
        }
    }

    public function edit(Transport $Transport)
    {
        $transport = new Transport;
        $cvs = auth()->user()->getAccessibleCvs();

        $data['invoices']   = $transport->invoices();
        $data['vehicle']    = $transport->getVehicle();
        $data['driver']     = $transport->getDriver();
        $data['cvs']        = $cvs;
        $data['header']     = $Transport;

        // echo json_encode($data['detail']); die;

        $title = 'Edit Angkutan';
        $route = route('transport.update', $Transport);
        $type = 'edit';

        return view('pages.backoffice.transport._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(TransportStoreRequest $request, Transport $transport)
    {
        $user = auth()->user();
        try {
            if ($request->mode == 'Konfirmasi') {
                $transport->status = 'Completed';
                $transport->updated_by            = $user['name'];
                $transport->save();

                return redirect('transport')->with('success', 'Berhasil mengubah data!');
            } else {
                $transport->cv_id                  = $request->cv_id ?? session('cv_id');
                $transport->date                  = $request->tgl_jual;
                $transport->vehicle_id            = $request->vehicle;
                $transport->driver_id             = $request->driver;
                $transport->product               = $request->product;
                $transport->customer              = $request->customer;
                $transport->weight                = $request->weight;
                $transport->ongkosan              = curencyToInteger($request->ongkosan);
                $transport->drivers_pocket_money  = curencyToInteger($request->drivers_pocket_money);
                $transport->setoran               = curencyToInteger($request->setoran);
                $transport->type                  = $request->type ?? 'cash';
                $transport->status                = 'In Progress';
                $transport->created_by            = $user['name'];
                $transport->updated_by            = $user['name'];
                $transport->save();

                return redirect('transport')->with('success', 'Berhasil mengubah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!' . $th->getMessage());
        }
    }

     public function show(Transport $Transport)
    {
        $transport = new Transport;
        $cvs = auth()->user()->getAccessibleCvs();

        // $selling->load('selling_detail.product');

        $data['invoices']   = $transport->invoices();
        $data['vehicle']    = $transport->getVehicle();
        $data['driver']     = $transport->getDriver();
        $data['cvs']        = $cvs;
        $data['header']     = $Transport;

        // echo json_encode($data['product']); die;

        $title = 'Data Angkutan';
        $route = route('transport.update', $Transport);
        $type = 'show';

        return view('pages.backoffice.transport._view', compact('data', 'title', 'route', 'type'));
    }

     public function destroy(Transport $transport)
    {
        try {
            $transport->delete();
            return  redirect('transport')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            // $errorMessage = $th->getMessage() . " at line " . $th->getLine();
            // return back()->with('failed', 'Gagal menghapus data, karena : ' . $errorMessage);
            return back()->with('failed', 'Gagal menghapus data!' . $th->getMessage());
        }
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
        $all = Transport::with('driver');
        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('date', [$start_date, $end_date]);
        }
        $all = $all->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
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
