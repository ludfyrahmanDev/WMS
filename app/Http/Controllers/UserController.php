<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
// import gender
use App\Enums\Gender;
use App\Enums\RoleType;
// import user store
use App\Http\Requests\User\UserStoreRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = User::filterResource($request, [
            'name',
            'email',
        ], [])
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));
        $title = "Data User Akun";
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
        $gender = Gender::asOptions();
        $role = RoleType::asOptions();
        $data = (object)[
            'name' => '',
            'email' => '',
            'role' => '',
            'password' => '',
            'gender' => '',
            'active' => '',
            'photo' => '',
        ];
        $route = route('users.store');
        $type = 'create';
        return view('pages.backoffice.user._form', compact('title', 'gender', 'role', 'data', 'route','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = 'admin';
            $user->gender = $request->gender;
            $user->password = bcrypt($request->password);
            $user->photo = $request->hasFile('file') ?
            $request->file->store('file', 'public') :
            '';
            $user->active = 1;
            $user->save();
            return redirect('users')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data! '.$th->getMessage());
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
    public function edit(User $user)
    {
        $data = $user;
        $title = 'Data User Akun';
        $gender = Gender::asOptions();
        $role = RoleType::asOptions();
        $route = route('users.update', $user->id);
        $type = 'edit';
        return view('pages.backoffice.user._form', compact('title', 'gender', 'role', 'data', 'route','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = 'admin';
            $user->gender = $request->gender;
            $user->password = $request->password ? bcrypt($request->password) : $user->password;
            $user->photo = $request->hasFile('file') ?
            $request->file->store('file', 'public') :
            $user->photo;
            $user->save();
            return redirect('users')->with('success', 'Berhasil mengubah data!');
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
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect('users')->with('success', 'Berhasil menghapus data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus data!'.$th->getMessage());
        }
    }


    public function profile(){
        $data = auth()->user();
        $title = 'Profile';
        return view('pages.auth.profile', compact('data','title'));
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
            return back()->with('failed', 'Gagal mengubah data!'.$th->getMessage());
        }
    }
}
