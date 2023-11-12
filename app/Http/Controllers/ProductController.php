<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\Master\ProductStoreRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Product::with('productCategory')
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
        ->paginate($request->get('per_page', 10));

        $title = 'Data Produk';
        $route = 'product';
        return view('pages.backoffice.product.index', compact('data', 'title','route'));
    }

    public function create()
    {
        $kategori = DB::table('table_product_category')->get();

        $data = (object)[
            'product_category_id' => '',
            'product' => '',
            'stock' => '',
            'price' => '',
            'price_sell' => ''
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
            $product->stock = $request->stock;
            $product->price = $request->price;
            $product->price_sell = $request->price_sell;
            $product->save();

            if ($product) {
                return redirect('product')->with('success', 'Berhasil menambah data!');
            } else {
                return back()->with('failed', 'Gagal menambah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!');
        }
    }

    public function edit(Product $product)
    {
        $kategori = DB::table('product_category')->get();

        $data = $product;
        $title = 'Data Produk';
        $route = route('product.update', $product);
        $type = 'edit';

        return view('pages.backoffice.spending._form', compact('kategori', 'data', 'title', 'route', 'type'));
    }

    public function update(ProductStoreRequest $request, Product $product)
    {
        try {
            $product->product_category_id = $request->product_category;
            $product->product = $request->product;
            $product->stock = $request->stock;
            $product->price = $request->price;
            $product->price_sell = $request->price_sell;
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
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }
}
