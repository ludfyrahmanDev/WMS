<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CV;

class CVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = CV::filterResource($request, [
            'name',
            'npwp',
            'address',
            'description',
        ], [])
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));
        $title = 'Data CV';
        $route = 'cv';
        return view('pages.backoffice.cv.index', compact('data', 'title', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Data CV';
        $data = (object)[
            'name'        => '',
            'npwp'        => '',
            'address'     => '',
            'description' => '',
        ];
        $route = route('cv.store');
        $type = 'create';
        return view('pages.backoffice.cv._form', compact('title', 'data', 'route', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {
            $cv = new CV();
            $cv->name = $request->name;
            $cv->npwp = $request->npwp;
            $cv->address = $request->address;
            $cv->description = $request->description;
            $cv->who_create = auth()->user()->name ?? 'System';
            $cv->who_update = auth()->user()->name ?? 'System';
            $cv->save();

            return redirect('cv')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data! ' . $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CV $cv)
    {
        $data = $cv;
        $title = 'Data CV';
        $route = route('cv.update', $cv->id);
        $type = 'edit';
        return view('pages.backoffice.cv._form', compact('title', 'data', 'route', 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CV $cv)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        try {
            $cv->name = $request->name;
            $cv->npwp = $request->npwp;
            $cv->address = $request->address;
            $cv->description = $request->description;
            $cv->who_update = auth()->user()->name ?? 'System';
            $cv->save();

            return redirect('cv')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data! ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CV $cv)
    {
        try {
            $cv->delete();
            return redirect('cv')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data! ' . $th->getMessage());
        }
    }
}
