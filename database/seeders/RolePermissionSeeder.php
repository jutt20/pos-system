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
        // Create permissions
        $permissions = [
            'manage employees',
            'manage customers',
            'manage billing',
            'manage invoices',
            'manage activations',
            'manage orders',
            'view reports',
            'manage documents',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'employee']);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'employee']);
        $managerRole = Role::create(['name' => 'Manager', 'guard_name' => 'employee']);
        $accountantRole = Role::create(['name' => 'Accountant', 'guard_name' => 'employee']);
        $salesRole = Role::create(['name' => 'Sales Agent', 'guard_name' => 'employee']);
        $supportRole = Role::create(['name' => 'Technical Support', 'guard_name' => 'employee']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        
        $managerRole->givePermissionTo([
            'manage customers',
            'manage billing',
            'manage invoices',
            'manage activations',
            'manage orders',
            'view reports',
            'manage documents',
        ]);

        $accountantRole->givePermissionTo([
            'manage billing',
            'manage invoices',
            'view reports',
        ]);

        $salesRole->givePermissionTo([
            'manage customers',
            'manage activations',
            'manage documents',
        ]);

        $supportRole->givePermissionTo([
            'manage customers',
            'manage activations',
            'manage documents',
        ]);

        // Create default admin user
        $admin = Employee::create([
            'name' => 'System Administrator',
            'email' => 'admin@nexitel.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
        ]);

        $admin->assignRole('Admin');
    }
}
