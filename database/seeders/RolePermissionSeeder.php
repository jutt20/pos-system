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
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions only if they don't exist
        $permissions = [
            'manage employees',
            'manage customers',
            'manage billing',
            'manage invoices',
            'manage activations',
            'manage orders',
            'manage online orders',
            'manage delivery services',
            'view reports',
            'manage documents',
            'export data',
            'system settings',
            'manage sim stock',
            'view retailer dashboard',
            'manage retailer sales',
            'track commissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'employee']
            );
        }

        // Create roles only if they don't exist
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'employee']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'employee']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'employee']);
        $accountantRole = Role::firstOrCreate(['name' => 'Accountant', 'guard_name' => 'employee']);
        $salesRole = Role::firstOrCreate(['name' => 'Sales Agent', 'guard_name' => 'employee']);
        $supportRole = Role::firstOrCreate(['name' => 'Technical Support', 'guard_name' => 'employee']);
        $retailerRole = Role::firstOrCreate(['name' => 'Retailer', 'guard_name' => 'employee']);

        // Super Admin gets all permissions
        $superAdminRole->syncPermissions(Permission::all());
        
        // Admin gets most permissions except system settings
        $adminRole->syncPermissions([
            'manage employees',
            'manage customers',
            'manage billing',
            'manage invoices',
            'manage activations',
            'manage orders',
            'manage online orders',
            'manage delivery services',
            'view reports',
            'manage documents',
            'export data',
            'manage sim stock',
        ]);

        // Manager gets operational permissions
        $managerRole->syncPermissions([
            'manage customers',
            'manage billing',
            'manage invoices',
            'manage activations',
            'manage orders',
            'manage online orders',
            'view reports',
            'manage documents',
            'export data',
            'manage sim stock',
        ]);

        // Accountant gets billing and reporting permissions
        $accountantRole->syncPermissions([
            'manage billing',
            'manage invoices',
            'view reports',
            'export data',
        ]);

        // Sales Agent gets customer and activation permissions
        $salesRole->syncPermissions([
            'manage customers',
            'manage activations',
            'manage documents',
            'manage invoices',
            'manage sim stock',
        ]);

        // Technical Support gets customer support permissions
        $supportRole->syncPermissions([
            'manage customers',
            'manage activations',
            'manage documents',
            'manage sim stock',
        ]);

        // Retailer gets retailer-specific permissions
        $retailerRole->syncPermissions([
            'view retailer dashboard',
            'manage retailer sales',
            'track commissions',
            'manage customers',
            'manage activations',
            'manage invoices',
        ]);

        // Create Super Admin user only if doesn't exist
        $superAdmin = Employee::firstOrCreate(
            ['email' => 'superadmin@nexitel.com'],
            [
                'name' => 'Super Administrator',
                'username' => 'superadmin',
                'password' => Hash::make('superadmin123'),
                'phone' => '+1234567888',
                'is_active' => true,
            ]
        );
        $superAdmin->assignRole('Super Admin');

        // Create default admin user only if doesn't exist
        $admin = Employee::firstOrCreate(
            ['email' => 'admin@nexitel.com'],
            [
                'name' => 'System Administrator',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
                'is_active' => true,
            ]
        );
        $admin->assignRole('Admin');

        // Create sample employees only if they don't exist
        $manager = Employee::firstOrCreate(
            ['email' => 'manager@nexitel.com'],
            [
                'name' => 'John Manager',
                'username' => 'manager',
                'password' => Hash::make('password'),
                'phone' => '+1234567891',
                'is_active' => true,
            ]
        );
        $manager->assignRole('Manager');

        $accountant = Employee::firstOrCreate(
            ['email' => 'accountant@nexitel.com'],
            [
                'name' => 'Sarah Accountant',
                'username' => 'accountant',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
                'is_active' => true,
            ]
        );
        $accountant->assignRole('Accountant');

        $sales = Employee::firstOrCreate(
            ['email' => 'sales@nexitel.com'],
            [
                'name' => 'Mike Sales',
                'username' => 'sales',
                'password' => Hash::make('password'),
                'phone' => '+1234567893',
                'is_active' => true,
            ]
        );
        $sales->assignRole('Sales Agent');

        $support = Employee::firstOrCreate(
            ['email' => 'support@nexitel.com'],
            [
                'name' => 'Lisa Support',
                'username' => 'support',
                'password' => Hash::make('password'),
                'phone' => '+1234567894',
                'is_active' => true,
            ]
        );
        $support->assignRole('Technical Support');

        $retailer = Employee::firstOrCreate(
            ['email' => 'retailer@nexitel.com'],
            [
                'name' => 'David Retailer',
                'username' => 'retailer',
                'password' => Hash::make('password'),
                'phone' => '+1234567895',
                'is_active' => true,
            ]
        );
        $retailer->assignRole('Retailer');

        echo "Roles and permissions created successfully!\n";
        echo "Super Admin: superadmin / superadmin123\n";
        echo "Admin: admin / password\n";
        echo "Manager: manager / password\n";
        echo "Accountant: accountant / password\n";
        echo "Sales: sales / password\n";
        echo "Support: support / password\n";
        echo "Retailer: retailer / password\n";
    }
}
