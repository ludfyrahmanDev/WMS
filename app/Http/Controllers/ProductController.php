<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Master\ProductStoreRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::with('category')
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
        ->paginate($request->get('per_page', 10));
        $title = 'Data Produk';
        $route = 'product';
        return view('pages.backoffice.product.index', compact('data', 'title','route'));
    }

    public function create()
    {
        $kategori = ProductCategory::get();

        $data = (object)[
            'product_category_id' => '',
            'product' => ''
        ];

        $title = 'Data Produk';
        $route = route('product.store');
        $type = 'create';

        return view('pages.backoffice.product._form', compact('data', 'title', 'route', 'type', 'kategori'));
    }

    public function store(ProductStoreRequest $request)
    {
        try {
            $product = new Product();
            $product->product_category_id = $request->product_category;
            $product->product = $request->product;
            // $product->price = $request->price;
            // $product->price_sell = $request->price_sell;
            $product->save();

            if ($product) {
                return redirect('product')->with('success', 'Berhasil menambah data!');
            } else {
                return back()->with('failed', 'Gagal menambah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data! '.$th->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $kategori = ProductCategory::get();

        $data = $product;
        $title = 'Data Produk';
        $route = route('product.update', $product);
        $type = 'edit';

        return view('pages.backoffice.product._form', compact('kategori', 'data', 'title', 'route', 'type'));
    }

    public function update(ProductStoreRequest $request, Product $product)
    {
        try {
            $product->product_category_id = $request->product_category;
            $product->product = $request->product;
            // $product->price = $request->price;
            // $product->price_sell = $request->price_sell;
            $product->save();

            if ($product) {
                return redirect('product')->with('success', 'Berhasil mengubah data!');
            } else {
                return back()->with('failed', 'Gagal mengubah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect('product')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!'.$th->getMessage());
        }
    }

    public function getDataProduct($product)
    {
        try {
            $product = Product::findOrFail($product);
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}
