<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions (you can adjust these as per your needs)
        $permissions = ['view dashboard', 'manage users', 'manage sales', 'manage operations'];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        $sales = Role::create(['name' => 'sales', 'guard_name' => 'admin']);
        $operation = Role::create(['name' => 'operations', 'guard_name' => 'admin']);

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());
        $sales->givePermissionTo(['view dashboard', 'manage sales']);
        $operation->givePermissionTo(['view dashboard', 'manage operations']);
    }
}
