<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerAlias;
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
            ->withCount('selling')
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));
        $title = 'Data Customer';
        $route = 'customer';
        return view('pages.backoffice.customer.index', compact('data', 'title', 'route'));
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
            'name'      => '',
            'npwp'      => '',
            'nik'       => '',
            'nohp'      => '',
            'ongkosan'  => '',
            'borongan'  => '',
            'alamat'    => '',
        ];
        $route = route('customer.store');
        $type = 'create';
        return view('pages.backoffice.customer._form', compact('title', 'data', 'route', 'type'));
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
            //Insert data customer
            $cust = new Customer();
            $cust->name     = $request->name;
            $cust->npwp     = $request->npwp;
            $cust->nik      = $request->nik;
            $cust->phone    = $request->phone;
            $cust->ongkosan = curencyToInteger($request->ongkosan);
            $cust->borongan = curencyToInteger($request->borongan);
            $cust->address  = $request->address;
            $cust->save();

            //Insert data customer alias
            $totalAlias = COUNT($request->alias);

            for ($i = 0; $i < $totalAlias; $i++) {
                $custAlias              = new CustomerAlias();
                $custAlias->customer_id = $cust->id;
                $custAlias->name        = $request->alias[$i];
                $custAlias->npwp        = $request->npwp_alias[$i];
                $custAlias->nik         = $request->nik_alias[$i];
                $custAlias->phone       = $request->phone_alias[$i];
                $custAlias->ongkosan    = curencyToInteger($request->ongkosan_alias[$i]);
                $custAlias->borongan    = curencyToInteger($request->borongan_alias[$i]);
                $custAlias->address     = $request->address_alias[$i];
                $custAlias->save();
            }

            if ($cust) {
                return redirect('customer')->with('success', 'Berhasil menambah data!');
            } else {
                return back()->with('failed', 'Gagal menambah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!' . $th->getMessage());
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
        $data           = $customer;
        $data['alias']  = $customer->getAliasByID($customer->id);
        $title          = 'Data Customer';
        $route          = route('customer.update', $customer->id);
        $type           = 'edit';
        return view('pages.backoffice.customer._form', compact('title', 'data', 'route', 'type'));
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
            $customer->name     = $request->name;
            $customer->npwp     = $request->npwp;
            $customer->nik      = $request->nik;
            $customer->phone    = $request->phone;
            $customer->ongkosan = curencyToInteger($request->ongkosan);
            $customer->borongan = curencyToInteger($request->borongan);
            $customer->address  = $request->address;
            $customer->save();

            $customer->alias()->delete();

            $totalAlias = COUNT($request->alias);
            for ($i = 0; $i < $totalAlias; $i++) {
                $custAlias              = new CustomerAlias();
                $custAlias->customer_id = $customer->id;
                $custAlias->name        = $request->alias[$i];
                $custAlias->npwp        = $request->npwp_alias[$i];
                $custAlias->nik         = $request->nik_alias[$i];
                $custAlias->phone       = $request->phone_alias[$i];
                $custAlias->ongkosan    = curencyToInteger($request->ongkosan_alias[$i]);
                $custAlias->borongan    = curencyToInteger($request->borongan_alias[$i]);
                $custAlias->address     = $request->address_alias[$i];
                $custAlias->save();
            }

            if ($customer) {
                return redirect('customer')->with('success', 'Berhasil mengubah data!');
            } else {
                return back()->with('failed', 'Gagal menambah data!');
            }
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!' . $th->getMessage());
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
            $customer->alias()->delete();
            return redirect('customer')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!' . $th->getMessage());
        }
    }
}
