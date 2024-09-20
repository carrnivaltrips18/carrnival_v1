<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Hash;

class AdminController extends Controller
{
    // Admin login form
    public function loginForm()
    {
        // Check if the admin is already authenticated
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard'); // Redirect to the dashboard if logged in
        }
        return view('admin.login');
    }

    // Handle admin login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('admin')->attempt($credentials)) {
            // Get the authenticated admin user
            $admin_user = Auth::guard('admin')->user();

            $super_admin_email = $admin_user['email'];  // Get the email of the authenticated admin user

            if (!$admin_user->hasRole('superadmin') && $super_admin_email == 'superadmin@example.com') {
                $admin_user->assignRole('superadmin'); // Assign the role to the user
            }
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Admin registration form
    public function registerForm()
    {
        return view('admin.register');
    }

    // Handle admin registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Admin registered successfully.');
    }

    // Admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Admin logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function salesDashboard()
    {
        return view('admin.sales_dashboard'); // Sales dashboard view
    }

    // Operations dashboard
    public function operationsDashboard()
    {
        return view('admin.operations_dashboard'); // Operations dashboard view
    }

     // Display the form to assign roles
     public function assignRoleForm()
     {
         $admins = Admin::all();
         $roles = Role::all();
         return view('admin.assign-role', compact('admins', 'roles'));
     }

      // Handle role assignment
    public function assignRole(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'role' => 'required|exists:roles,name',
        ]);

        $admin = Admin::find($request->admin_id);
        $admin->assignRole($request->role);

        return redirect()->back()->with('success', 'Role assigned successfully.');
    }

    // Display permissions
    public function assignPermissionForm()
    {
        $admins = Admin::all();
        $permissions = Permission::all();
        return view('admin.assign-permission', compact('admins', 'permissions'));
    }

      // Handle permission assignment
      public function assignPermission(Request $request)
      {
          $request->validate([
              'admin_id' => 'required|exists:admins,id',
              'permission' => 'required|exists:permissions,name',
          ]);
  
          $admin = Admin::find($request->admin_id);
          $admin->givePermissionTo($request->permission);
  
          return redirect()->back()->with('success', 'Permission assigned successfully.');
      }
}
