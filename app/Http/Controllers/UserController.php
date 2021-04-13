<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'permissions')->paginate(10);
        // echo json_encode($users);
        // die;
        return view('user.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::with('roles', 'permissions')->findOrFail($id);

        $permissions_id = [];
        foreach ($user->permissions as $permission) {
            $permissions_id[] = $permission->id;
        }

        $roles = Role::get();

        $not_user_permissions = Permission::whereNotIn('id', $permissions_id)->get();

        return view('user.edit', compact('user', 'roles', 'not_user_permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|min:4,max:25',
            'email'       => 'required|email|unique:users,email,' . $id,
            'roles'       => 'required',
            'permissions' => 'required|array',
        ]);

        $user = User::with('roles', 'permissions')->findOrFail($id);

        $old_role  = $user->roles[0]['name'];
        $old_permission = $user->permissions;

        // remove old role and permission
        $user->removeRole($old_role);
        $user->revokePermissionTo($old_permission);

        // assign new role and permissions
        $user->assignRole($request->roles);
        $user->givePermissionTo($request->permissions);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }
}
