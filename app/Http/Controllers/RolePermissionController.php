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
        $roleId = intval($request->input('role_id')); // Find role by ID
    
        // Validate request (if applicable)
        // $this->validate($request, [
        //     'role_id' => 'required|integer|exists:roles,id',
        //     'permissions' => 'required|array',
        // ]);
    
        // Check if role exists
        if (!$role = Role::find($roleId)) {
            return redirect()->back()->withErrors(['error' => 'Role not found']);
        }
    
        // Convert permission IDs if necessary
        if (is_array($request->permissions)) {
            $permissions = array_map('intval', $request->permissions);
        } else {
            // Handle case where permissions is not an array
            return redirect()->back()->withErrors(['error' => 'Invalid permissions format']);
        }
    
        // Update permissions without removing existing ones (modify as needed)
        $role->syncPermissions($permissions); // Replace with attach/detach if needed
    
        return redirect()->route('roles-permissions.index')
            ->with('success', 'Permissions updated successfully.');
    }
    
    
}
