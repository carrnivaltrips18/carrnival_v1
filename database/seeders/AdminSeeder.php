<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin; // Use your Admin model
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a superadmin
        $superAdmin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole('superadmin'); // Assign the role to the superadmin

        // Create a sales admin
        $salesAdmin = Admin::create([
            'name' => 'Sales Admin',
            'email' => 'salesadmin@example.com',
            'password' => Hash::make('password'),
        ]);
        $salesAdmin->assignRole('sales'); // Assign the sales role

        // Create an operations admin
        $operationsAdmin = Admin::create([
            'name' => 'Operations Admin',
            'email' => 'operationsadmin@example.com',
            'password' => Hash::make('password'),
        ]);
        $operationsAdmin->assignRole('operations'); // Assign the operations role
    }
}
