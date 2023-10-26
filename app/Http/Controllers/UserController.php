<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = User::get();
        $title = 'Data User Akun';
        $route = 'users';
        return view('pages.backoffice.user.index', compact('data', 'title','route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Data User Akun';
        return view('pages.backoffice.user._form', compact('title'));
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
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        try {
            User::create([
                'username' => $request->username,
                'role' => $request->role,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            return redirect('user')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::where('id', $id)->first();

        return view('pages.backoffice.user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'role' => 'required',
        ]);
        try {
            $user = ([
                'username' => $request->username,
                'role' => $request->role,
                'email' => $request->email,

            ]);
            if ($request->password) {
                $user['password'] = bcrypt($request->password);
            }

            User::where('id', $id)->update($user);
            return redirect('user')->with('success', 'Berhasil mengubah data!');
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
    public function destroy($id)
    {
        try {
            User::where('id', $id)->update(['status' => 'Nonaktif']);
            return redirect('user')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!');
        }
    }


    public function profile(){
        $data = auth()->user();
        return view('auth.profile', compact('data'));
    }


    public function updateProfile(Request $request){
        $id = auth()->user()->id;
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:6|confirmed|unique:users,email,'.$id,
        ]);
        try {
            $user = ([
                'username' => $request->username,
                'email' => $request->email,
            ]);
            if ($request->password) {
                $user['password'] = bcrypt($request->password);
            }

            User::where('id', $id)->update($user);
            return back()->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!');
        }
    }
}
