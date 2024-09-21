<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = Admin::with('roles')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::all(); // Fetch all roles
        $permissions = Permission::all(); // Fetch all permissions
        return view('admin.admins.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:8',
            'role' => 'required', // Role selection is required
        ]);

        // Create new admin user
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role to the admin user
        $admin->assignRole($request->role);
       // dd($admin->assignRole($request->role));

        // Optionally, assign permissions to the admin user
        if ($request->has('permissions')) {
            $admin->givePermissionTo($request->permissions);
        }

        return redirect()->route('admin.admins.index')->with('success', 'Admin user created successfully.');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.admins.edit', compact('admin', 'roles', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'role' => 'required',
        ]);

        $admin = Admin::findOrFail($id);
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update role
        $admin->syncRoles($request->role);

        // Update permissions
        if ($request->has('permissions')) {
            $admin->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.admins.index')->with('success', 'Admin user updated successfully.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.admins.index')->with('success', 'Admin user deleted successfully.');
    }

}
