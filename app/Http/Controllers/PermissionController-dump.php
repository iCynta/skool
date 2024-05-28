<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('_', $item->name)[0];
        });

        return view('permissions.index', compact('roles', 'permissions'));
    }

    public function update(Request $request)
    {
        $role = Role::findById($request->role_id);
        $role->syncPermissions($request->permissions);

        return redirect()->route('permissions.index')
            ->with('success', 'Permissions updated successfully.');
    }
}
