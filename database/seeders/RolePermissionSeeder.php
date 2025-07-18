<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions if they don't exist
        $permissions = [
            'manage employees',
            'manage customers',
            'manage invoices',
            'manage activations',
            'manage sim orders',
            'manage sim stocks',
            'view reports',
            'manage roles',
            'export data',
            'import data',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'employee'
            ]);
        }

        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'employee'
        ]);

        $managerRole = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'employee'
        ]);

        $retailerRole = Role::firstOrCreate([
            'name' => 'retailer',
            'guard_name' => 'employee'
        ]);

        $staffRole = Role::firstOrCreate([
            'name' => 'staff',
            'guard_name' => 'employee'
        ]);

        // Assign permissions to roles
        $adminRole->syncPermissions($permissions);
        
        $managerRole->syncPermissions([
            'manage customers',
            'manage invoices',
            'manage activations',
            'manage sim orders',
            'view reports',
            'export data',
        ]);

        $retailerRole->syncPermissions([
            'manage customers',
            'manage invoices',
            'manage activations',
            'view reports',
        ]);

        $staffRole->syncPermissions([
            'manage customers',
            'manage invoices',
            'manage activations',
        ]);

        // Create default admin user if doesn't exist
        $admin = Employee::firstOrCreate([
            'username' => 'admin'
        ], [
            'name' => 'System Administrator',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'status' => 'active',
        ]);

        $admin->assignRole('admin');

        // Create default retailer user if doesn't exist
        $retailer = Employee::firstOrCreate([
            'username' => 'retailer'
        ], [
            'name' => 'Default Retailer',
            'email' => 'retailer@pos.com',
            'password' => Hash::make('password'),
            'phone' => '1234567891',
            'status' => 'active',
        ]);

        $retailer->assignRole('retailer');

        // Create default staff user if doesn't exist
        $staff = Employee::firstOrCreate([
            'username' => 'staff'
        ], [
            'name' => 'Default Staff',
            'email' => 'staff@pos.com',
            'password' => Hash::make('password'),
            'phone' => '1234567892',
            'status' => 'active',
        ]);

        $staff->assignRole('staff');
    }
}
