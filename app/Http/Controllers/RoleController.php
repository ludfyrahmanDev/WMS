<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\User\RoleStoreRequest;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Role::with(['permissions', 'users'])
            ->filterResource($request, [
                'name', 'display_name', 'description'
            ], [])
            ->orderBy($request->get('sort_by', 'created_at'), $request->get('order', 'desc'))
            ->paginate($request->get('per_page', 10));
            
        $title = 'Role Management';
        $route = 'role';
        return view('pages.backoffice.role.index', compact('data', 'title','route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create New Role';
        $data = (object)[
            'name' => '',
            'display_name' => '',
            'description' => '',
            'is_active' => true,
            'permissions' => collect()
        ];
        
        // Get all permissions grouped by module
        $permissions = Permission::orderBy('group')->orderBy('display_name')->get()->groupBy('group');
        
        $route = route('role.store');
        $type = 'create';
        return view('pages.backoffice.role._form', compact('title', 'data', 'route', 'type', 'permissions'));
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
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            $role = new Role();
            $role->name = Str::slug($request->display_name, '_');
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->is_active = $request->has('is_active');
            $role->save();

            // Assign permissions
            if ($request->has('permissions')) {
                $role->permissions()->attach($request->permissions);
            }

            return redirect('role')->with('success', 'Role berhasil dibuat!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal membuat role! ' . $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        $title = 'Role Details';
        return view('pages.backoffice.role.show', compact('role', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $data = $role->load('permissions');
        $title = 'Edit Role';
        
        // Get all permissions grouped by module
        $permissions = Permission::orderBy('group')->orderBy('display_name')->get()->groupBy('group');
        
        $route = route('role.update', $role->id);
        $type = 'edit';
        return view('pages.backoffice.role._form', compact('title', 'data', 'route', 'type', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        try {
            $role->name = Str::slug($request->display_name, '_');
            $role->display_name = $request->display_name;
            $role->description = $request->description;
            $role->is_active = $request->has('is_active');
            $role->save();

            // Sync permissions
            $role->permissions()->sync($request->permissions ?? []);

            return redirect('role')->with('success', 'Role berhasil diupdate!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengupdate role! ' . $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try {
            // Check if role has users
            if ($role->users()->count() > 0) {
                return back()->with('failed', 'Tidak dapat menghapus role yang masih digunakan oleh user!');
            }

            // Check if it's a system role
            if (in_array($role->name, ['super_admin', 'admin'])) {
                return back()->with('failed', 'Tidak dapat menghapus system role!');
            }

            $role->delete();
            return redirect('role')->with('success', 'Role berhasil dihapus!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menghapus role! ' . $th->getMessage());
        }
    }
}
