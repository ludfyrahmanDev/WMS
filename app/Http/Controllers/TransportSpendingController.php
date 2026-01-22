<?php

namespace App\Http\Controllers;

use App\Models\Selling;
use App\Models\TransportSpending;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\CV;
use App\Http\Requests\Transaksi\TransportSpendingStoreRequest;

class TransportSpendingController extends Controller
{
    public function index(Request $request)
    {
        $selectedCvId = session('cv_id');
        
        $all = TransportSpending::filterResource($request, [
            'date',
            'spendingCategory.spending_category',
            'mutation',
            'payment_method',
            'who_update',
        ], [])
        ->when($request->has('search'), function ($query) use ($request) {
            $query->where('description', 'like', '%' . $request->search . '%');
        })
        ->when($selectedCvId && auth()->user()->hasCompanyAccess(), function ($query) use ($selectedCvId) {
            $query->where('cv_id', $selectedCvId);
        })
        ->with(['spendingCategory', 'cv'])
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));
        
        if($request->has('start_date') && $request->has('end_date')){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $all = $all->whereBetween('date', [$start_date, $end_date]);
        }
        
        $income = $all->get()->where('mutation', 'Uang Masuk')->sum('nominal');
        $outcome = $all->get()->where('mutation', 'Uang Keluar')->sum('nominal');
        
        // Pagination
        $perPage = $request->get('per_page', 10);
        $currentPage = request()->get('page', 1);
        $data = $all->paginate($perPage, ['*'], 'page', $currentPage);
        
        $title = 'Data Transaksi Lain Lain - Khusus Angkutan';
        $route = 'transportSpending';
        $request = $request->toArray();
        $totalSpending = $outcome;

        return view('pages.backoffice.transport_spending.index', compact('data', 'request','title', 'route', 'income', 'outcome', 'totalSpending'));
    }

    public function create()
    {
        $spending = new TransportSpending;

        $kategori = $spending->getSpendingCategory();
        $enum = PaymentMethod::asOptions();

        $data = (object)[
            'date' => null,
            'mutation' => null,
            'description' => null,
            'spending_category_id' => null,
            'payment_method' => null,
            'nominal' => null
        ];

        $selectedCvId = session('cv_id');
        $cvs = auth()->user()->getAccessibleCvs();
        $selectedCv = $selectedCvId ? CV::find($selectedCvId) : null;
        
        $title = 'Tambah Transaksi Angkutan' . ($selectedCv ? ' (' . $selectedCv->name . ')' : '');
        $route = route('transportSpending.store');
        $type = 'create';

        return view('pages.backoffice.transport_spending._form', compact('data', 'title', 'route', 'type', 'kategori', 'enum', 'cvs', 'selectedCvId'));
    }

    public function store(TransportSpendingStoreRequest $request)
    {
        $user = auth()->user();

        try {
            $spending = new TransportSpending();
            $spending->date = $request->tanggal;
            $spending->mutation = $request->mutasi;
            $spending->spending_category_id = $request->spending_category;
            $spending->cv_id = $request->cv_id ?? session('cv_id');
            $spending->who_create = $user['name'];
            $spending->who_update = $user['name'];
            $spending->description = $request->description;
            $spending->payment_method = $request->payment_method;
            $spending->nominal = curencyToInteger($request->nominal);
            $spending->save();

            return redirect('transportSpending')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
        }
    }

    public function edit(TransportSpending $transportSpending)
    {
        $kategori = $transportSpending->getSpendingCategory();
        $enum = PaymentMethod::asOptions();
        $cvs = auth()->user()->getAccessibleCvs();
        $selectedCvId = $transportSpending->cv_id;
        
        $data = $transportSpending;
        $title = 'Edit Transaksi Angkutan';
        $route = route('transportSpending.update', $transportSpending);
        $type = 'edit';

        return view('pages.backoffice.transport_spending._form', compact('kategori', 'enum', 'data', 'title', 'route', 'type', 'cvs', 'selectedCvId'));
    }

    public function update(TransportSpendingStoreRequest $request, TransportSpending $transportSpending)
    {
        $user = auth()->user();

        try {
            $description = str_replace('&quot;', '"', $request->description);
            $transportSpending->date = $request->tanggal;
            $transportSpending->mutation = $request->mutasi;
            $transportSpending->spending_category_id = $request->spending_category;
            $transportSpending->cv_id = $request->cv_id;
            $transportSpending->who_update = $user['name'];
            $transportSpending->description = $description;
            $transportSpending->payment_method = $request->payment_method;
            $transportSpending->nominal = curencyToInteger($request->nominal);
            $transportSpending->save();

            return redirect('transportSpending')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    public function destroy(TransportSpending $transportSpending)
    {
        try {
            $transportSpending->delete();

            return redirect('transportSpending')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!'.$th->getMessage());
        }
    }
}
