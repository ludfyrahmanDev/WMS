<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

//import driver store
use App\Http\Requests\User\DriverStoreRequest;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $data = Driver::filterResource($request, [
            'name',
            'address',
            'phone'
        ], [])
        ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
        ->paginate($request->get('per_page', 10));

        $title = 'Data Driver';
        $route = 'driver';

        return view('pages.backoffice.driver.index', compact('data', 'title', 'route'));
    }

    public function create()
    {
        $data = (object)[
            'name' => '',
            'address' => '',
            'phone' => ''
        ];

        $title = 'Data Driver';
        $route = route('driver.store');
        $type = 'create';

        return view('pages.backoffice.driver._form', compact('data', 'title', 'route', 'type'));
    }

    public function store(DriverStoreRequest $request)
    {
        try {
            $driver = new Driver();
            $driver->name = $request->name;
            $driver->address = $request->address;
            $driver->phone = $request->phone;
            $driver->save();

            return redirect('driver')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
        //    return back()->with('failed', 'Gagal menambah data!');
        return back()->withErrors($request->getValidator())->with('failed', 'Gagal menambah data!');
        }
    }

    public function edit(Driver $driver)
    {
        $data = $driver;
        $title = 'Data Driver';
        $route = route('driver.update', $driver);
        $type = 'edit';
        return view('pages.backoffice.driver._form', compact('data', 'title', 'route', 'type'));
    }

    public function update(DriverStoreRequest $request, Driver $driver)
    {
        try {
            $driver->name = $request->name;
            $driver->address = $request->address;
            $driver->phone = $request->phone;
            $driver->save();

            return redirect('driver')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }

    public function destroy(Driver $driver)
    {
        try {
            $driver->delete();

            return redirect('driver')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }
}
