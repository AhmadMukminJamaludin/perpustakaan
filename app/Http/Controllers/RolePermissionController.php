<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        
        return view('role-permission.index', compact('roles', 'permissions'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'role_id' => 'required|array',
            'permissions' => 'nullable|array',
        ]);
    
        foreach ($request->role_id as $index => $roleId) {
            $role = Role::findOrFail($roleId);
    
            // Jika permissions untuk role ini ada, gunakan, jika tidak kosongkan
            $permissions = $request->permissions[$index] ?? [];
            $role->syncPermissions($permissions);
        }    

        return redirect()->route('role-permission.index')->with('success', 'Permissions updated successfully.');
    }
}
