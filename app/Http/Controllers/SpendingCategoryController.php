<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpendingCategory;
use App\Http\Requests\Master\SpendingCategoryStoreRequest;

class SpendingCategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = SpendingCategory::filterResource($request, [
            'spending_category',
            'spending_types'
        ], [])
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));
        $title = 'Data Kategori Pengeluaran';
        $route = 'spendingCategory';
        return view('pages.backoffice.spendingCategory.index', compact('data', 'title','route'));
    }

    public function create()
    {
        $title = 'Data Kategori Pengeluaran';
        $data = (object)[
            'spending_category' => '',
            'spending_types' => ''
        ];
        $route = route('spendingCategory.store');
        $type = 'create';
        return view('pages.backoffice.spendingCategory._form', compact('title', 'data', 'route','type'));
    }
    
    public function store(SpendingCategoryStoreRequest $request)
    {
        try {
            $spendingCategory = new SpendingCategory();
            $spendingCategory->spending_category = $request->spending_category;
            $spendingCategory->spending_types = $request->spending_types;
            $spendingCategory->save();

            if ($spendingCategory) {
                return redirect('spendingCategory')->with('success', 'Berhasil menambah data!');
            } else {
                return back()->with('failed', 'Gagal menambah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!');
        }
    }

    public function edit(SpendingCategory $spendingCategory)
    {
        $data = $spendingCategory;
        $title = 'Data Kategori Pengeluaran';
        $route = route('spendingCategory.update', $spendingCategory->id);
        $type = 'edit';
        return view('pages.backoffice.spendingCategory._form', compact('title', 'data', 'route','type'));
    }

    public function update(SpendingCategoryStoreRequest $request, SpendingCategory $spendingCategory)
    {
        try {
            $spendingCategory->spending_category = $request->spending_category;
            $spendingCategory->spending_types = $request->spending_types;
            $spendingCategory->save();

            if ($spendingCategory) {
                return redirect('spendingCategory')->with('success', 'Berhasil mengubah data!');
            } else {
                return back()->with('failed', 'Gagal mengubah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    public function destroy(SpendingCategory $spendingCategory)
    {
        try {
            $spendingCategory->delete();

            return redirect('spendingCategory')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }
}
