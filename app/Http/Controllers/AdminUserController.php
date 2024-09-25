<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        //$admins = Admin::with('roles')->get();
       // $admins = Admin::with('roles')->paginate(10);
       $search = $request->input('search');
       $admins = Admin::with('roles')
                ->when($search, function($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%')
                                 ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->paginate(10); // Paginate results
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

    // Method to toggle admin status
    public function toggleStatus($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->status = !$admin->status; // Toggle status between 1 and 0
        $admin->save();

        return redirect()->route('admin.admins.index')->with('success', 'Admin status updated successfully.');
    }

    

public function exportCsv()
{
    $admins = Admin::with('roles')->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set header
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Email');
    $sheet->setCellValue('D1', 'Role');
    $sheet->setCellValue('E1', 'Status');
    $sheet->setCellValue('F1', 'Created At');
    $sheet->setCellValue('G1', 'StaUpdated At');

    //dd($admins);
    // Add data
    $row = 2;
    $serial = 1; 
    foreach ($admins as $user) {
        $roles = $user->roles->pluck('name')->implode(', ');
       

        $sheet->setCellValue('A' . $row, $serial);
        $sheet->setCellValue('B' . $row, $user->name);
        $sheet->setCellValue('C' . $row, $user->email);
        $sheet->setCellValue('D' . $row, $roles);
        $sheet->setCellValue('E' . $row, $user->status);
        $sheet->setCellValue('F' . $row, $user->created_at);
        $sheet->setCellValue('G' . $row, $user->updated_at);

        $serial++;
        $row++;
    }

    // Export as CSV
    $writer = new Csv($spreadsheet);
    $fileName = 'admin_users.csv';

    return new StreamedResponse(function () use ($writer) {
        $writer->save('php://output');
    }, 200, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
    ]);
}
}
