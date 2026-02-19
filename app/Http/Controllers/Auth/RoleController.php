<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::all();
        return view('auth.roles.index', compact('data'));
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
            'name' => 'required|string|unique:roles,name'
        ]);

        Role::create($data);

        return redirect()->back()->with('success', 'Role created success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $data = Role::all();
        return view('auth.roles.edit', compact('data', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,'.$id
        ]);

        Role::where('id',$id)->update($data);

        return redirect()->route('roles.index')->with('success', 'Role Updated success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role Deleted Success');
    }

    public function add_role_to_user($roleId){
        $user = User::FindOrFail($roleId);
        $roles = Role::all();
        $role_permission = DB::table('role_has_permissions')->where('role_id', $roleId)->pluck('permission_id')->all();

        return view('auth.users.add_roles', compact('role','roles','user_role'));
    }

    public function asign_role_to_user(Request $request, $roleId){
        $request->validate([
            'roles' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permissions);

        return back()->with('success','Give permissions success');
    }
}
