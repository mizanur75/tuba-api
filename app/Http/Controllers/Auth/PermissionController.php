<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Permission::all();
        return view('auth.permissions.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);

        Permission::create($data);

        return redirect()->back()->with('success', 'Permission created success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = Permission::findOrFail($id);
        $data = Permission::all();
        return view('auth.permissions.edit', compact('data', 'permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        $data = Permission::all();
        return view('auth.permissions.edit', compact('data', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:permissions,name,'.$id
        ]);

        Permission::where('id',$id)->update($data);

        return redirect()->route('permissions.index')->with('success', 'Permission Updated success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission Deleted Success');
    }

    public function add_permissions_to_role($roleId){
        $role = Role::FindOrFail($roleId);
        $permissions = Permission::all();
        $role_permission = DB::table('role_has_permissions')->where('role_id', $roleId)->pluck('permission_id')->all();

        return view('auth.roles.add_permissions', compact('role','permissions','role_permission'));
    }

    public function give_permissions_to_role(Request $request, $roleId){
        $request->validate([
            'permissions' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permissions);

        return back()->with('success','Give permissions success');
    }
}
