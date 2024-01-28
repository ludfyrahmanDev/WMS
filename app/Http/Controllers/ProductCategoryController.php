<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Requests\Master\ProductCategoryStoreRequest;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ProductCategory::filterResource($request, [
            'name',
        ], [])->with('product')
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
        ->paginate($request->get('per_page', 10));
        $title = 'Data Kategori Produk';
        $route = 'category';
        return view('pages.backoffice.category.index', compact('data', 'title','route'));
    }

    public function create()
    {

        $data = (object)[
            'name' => '',
        ];

        $title = 'Data Kategori Produk';
        $route = route('category.store');
        $type = 'create';

        return view('pages.backoffice.category._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(ProductCategoryStoreRequest $request)
    {
        try {
            $product = new ProductCategory();
            $product->name = $request->name;
            $product->save();

            if ($product) {
                return redirect('category')->with('success', 'Berhasil menambah data!');
            } else {
                return back()->with('failed', 'Gagal menambah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
        }
    }

    public function edit(ProductCategory $category)
    {

        $data = $category;
        $title = 'Data Kategori Produk';
        $route = route('category.update', $category);
        $type = 'edit';

        return view('pages.backoffice.category._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(ProductCategoryStoreRequest $request, ProductCategory $category)
    {
        try {
            $category->name = $request->name;
            $category->save();

            if ($category) {
                return redirect('category')->with('success', 'Berhasil mengubah data!');
            } else {
                return back()->with('failed', 'Gagal mengubah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    public function destroy(ProductCategory $category)
    {
        try {
            $category->delete();

            return redirect('category')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!'.$th->getMessage());
        }
    }
}
