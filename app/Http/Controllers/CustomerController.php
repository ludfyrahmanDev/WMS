<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
// import user store
use App\Http\Requests\Master\CustomerStoreRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Customer::filterResource($request, [
            'name',
            'phone',
            'ongkosan',
            'borongan',
            'alamat',
        ], [])
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));
        $title = 'Data Customer';
        $route = 'customer';
        return view('pages.backoffice.customer.index', compact('data', 'title','route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Data Customer';
        $data = (object)[
            'name' => '',
            'nohp' => '',
            'ongkosan' => '',
            'borongan' => '',
            'alamat' => '',
        ];
        $route = route('customer.store');
        $type = 'create';
        return view('pages.backoffice.customer._form', compact('title', 'data', 'route','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {
        try {
            $cust = new Customer();
            $cust->name = $request->name;
            $cust->phone = $request->phone;
            $cust->ongkosan = $request->ongkosan;
            $cust->borongan = $request->borongan;
            $cust->address = $request->address;
            $cust->save();

            if ($cust) {
                return redirect('customer')->with('success', 'Berhasil menambah data!');
            } else {
                return back()->with('failed', 'Gagal menambah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $data = $customer;
        $title = 'Data Customer';
        $route = route('customer.update', $customer->id);
        $type = 'edit';
        return view('pages.backoffice.customer._form', compact('title', 'data', 'route','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerStoreRequest $request, Customer $customer)
    {
        try {
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->ongkosan = $request->ongkosan;
            $customer->borongan = $request->borongan;
            $customer->address = $request->address;
            $customer->save();
            
            if ($customer) {
                return redirect('customer')->with('success', 'Berhasil mengubah data!');
            } else {
                return back()->with('failed', 'Gagal menambah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect('customer')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }
}
