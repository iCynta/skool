<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('_', $item->name)[0];
        });

        $selectedRole = null;
        if ($request->has('role')) {
            $selectedRole = Role::findById($request->role);
        }

        return view('permissions.index', compact('roles', 'permissions', 'selectedRole'));
    }

    public function update(Request $request, Role $role)
    {
        $roleId = $request->get('role_id'); // Find role by ID
    
        // Convert permission IDs from strings to integers
        $permissions = array_map('intval', $request->permissions);
    
        // Update permissions without removing existing ones
        $role->syncPermissions($permissions);
    
        return redirect()->route('roles-permissions.index')
            ->with('success', 'Permissions updated successfully.');
    }
    
}
