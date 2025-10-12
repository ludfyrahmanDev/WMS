<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Cv;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasController extends Controller
{
    /**
     * Display kas report/listing
     */
    public function index(Request $request)
    {
        $cv_id = session('cv_id');
        
        $query = Kas::with(['deliveryOrder.supplier', 'selling.customer', 'cv'])
            ->when($cv_id, function ($q) use ($cv_id) {
                $q->where('cv_id', $cv_id);
            })
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'));

        // Date filter
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        // Transaction type filter
        if ($request->has('transaction_type') && $request->transaction_type != '') {
            $query->where('transaction_type', $request->transaction_type);
        }

        $data = $query->paginate($request->get('per_page', 15));

        // Calculate totals for current CV
        $totals = $this->calculateTotals($cv_id, $request);

        $title = 'Laporan Kas';
        $cvs = auth()->user()->getAccessibleCvs();
        
        return view('pages.backoffice.kas.index', compact(
            'data', 
            'title', 
            'totals', 
            'cvs',
            'request'
        ));
    }

    /**
     * Show the form for creating a new kas entry (modal)
     */
    public function create()
    {
        $cvs = auth()->user()->getAccessibleCvs();
        return view('pages.backoffice.kas.modal.create', compact('cvs'));
    }

    /**
     * Store a new kas entry (modal creation)
     */
    public function store(Request $request)
    {
        $request->validate([
            'transaction_type' => 'required|in:debit,kredit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:500',
            'cv_id' => 'nullable|exists:cv,id'
        ]);

        try {
            Kas::create([
                'transaction_type' => $request->transaction_type,
                'amount' => $request->amount,
                'description' => $request->description,
                'cv_id' => $request->cv_id ?? session('cv_id'),
                'who_create' => Auth::user()->name,
                'who_update' => Auth::user()->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kas entry berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kas entry: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing kas entry
     */
    public function edit(Kas $kas)
    {
        $cvs = auth()->user()->getAccessibleCvs();
        return view('pages.backoffice.kas.modal.edit', compact('kas', 'cvs'));
    }

    /**
     * Update kas entry
     */
    public function update(Request $request, Kas $kas)
    {
        $request->validate([
            'transaction_type' => 'required|in:debit,kredit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:500',
            'cv_id' => 'nullable|exists:cv,id'
        ]);

        try {
            $kas->update([
                'transaction_type' => $request->transaction_type,
                'amount' => $request->amount,
                'description' => $request->description,
                'cv_id' => $request->cv_id ?? session('cv_id'),
                'who_update' => Auth::user()->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kas entry berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate kas entry: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove kas entry
     */
    public function destroy(Kas $kas)
    {
        try {
            $kas->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Kas entry berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kas entry: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get kas summary/balance
     */
    public function getSummary(Request $request)
    {
        $cv_id = $request->cv_id ?? session('cv_id');
        $totals = $this->calculateTotals($cv_id, $request);

        return response()->json([
            'success' => true,
            'data' => $totals
        ]);
    }

    /**
     * Add modal (additional capital)
     */
    public function addModal(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:500'
        ]);

        try {
            Kas::create([
                'transaction_type' => 'debit',
                'amount' => $request->amount,
                'description' => 'Penambahan Modal: ' . $request->description,
                'cv_id' => session('cv_id'),
                'who_create' => Auth::user()->name,
                'who_update' => Auth::user()->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Modal berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan modal: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Calculate totals for kas
     */
    private function calculateTotals($cv_id = null, $request = null)
    {
        $query = Kas::query();
        
        if ($cv_id) {
            $query->where('cv_id', $cv_id);
        }

        // Apply date filter if provided
        if ($request && $request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $debit = (clone $query)->where('transaction_type', 'debit')->sum('amount');
        $kredit = (clone $query)->where('transaction_type', 'kredit')->sum('amount');
        $balance = $debit - $kredit;

        return [
            'debit' => $debit,
            'kredit' => $kredit,
            'balance' => $balance
        ];
    }
}
