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
            'export data',
            'system settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'employee']);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::create(['name' => 'Super Admin', 'guard_name' => 'employee']);
        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'employee']);
        $managerRole = Role::create(['name' => 'Manager', 'guard_name' => 'employee']);
        $accountantRole = Role::create(['name' => 'Accountant', 'guard_name' => 'employee']);
        $salesRole = Role::create(['name' => 'Sales Agent', 'guard_name' => 'employee']);
        $supportRole = Role::create(['name' => 'Technical Support', 'guard_name' => 'employee']);

        // Super Admin gets all permissions
        $superAdminRole->givePermissionTo(Permission::all());
        
        // Admin gets most permissions except system settings
        $adminRole->givePermissionTo([
            'manage employees',
            'manage customers',
            'manage billing',
            'manage invoices',
            'manage activations',
            'manage orders',
            'view reports',
            'manage documents',
            'export data',
        ]);

        // Manager gets operational permissions
        $managerRole->givePermissionTo([
            'manage customers',
            'manage billing',
            'manage invoices',
            'manage activations',
            'manage orders',
            'view reports',
            'manage documents',
            'export data',
        ]);

        // Accountant gets billing and reporting permissions
        $accountantRole->givePermissionTo([
            'manage billing',
            'manage invoices',
            'view reports',
            'export data',
        ]);

        // Sales Agent gets customer and activation permissions
        $salesRole->givePermissionTo([
            'manage customers',
            'manage activations',
            'manage documents',
            'manage invoices',
        ]);

        // Technical Support gets customer support permissions
        $supportRole->givePermissionTo([
            'manage customers',
            'manage activations',
            'manage documents',
        ]);

        // Create Super Admin user
        // $superAdmin = Employee::create([
        //     'name' => 'Super Administrator',
        //     'email' => 'superadmin@nexitel.com',
        //     'username' => 'superadmin',
        //     'password' => Hash::make('superadmin123'),
        //     'phone' => '+1234567888',
        // ]);
        // $superAdmin->assignRole('Super Admin');

        // Create default admin user
        // $admin = Employee::create([
        //     'name' => 'System Administrator',
        //     'email' => 'admin@nexitel.com',
        //     'username' => 'admin',
        //     'password' => Hash::make('password'),
        //     'phone' => '+1234567890',
        // ]);
        // $admin->assignRole('Admin');

        // Create sample employees
        // $manager = Employee::create([
        //     'name' => 'John Manager',
        //     'email' => 'manager@nexitel.com',
        //     'username' => 'manager',
        //     'password' => Hash::make('password'),
        //     'phone' => '+1234567891',
        // ]);
        // $manager->assignRole('Manager');

        $accountant = Employee::create([
            'name' => 'Sarah Accountant',
            'email' => 'accountant@nexitel.com',
            'username' => 'accountant',
            'password' => Hash::make('password'),
            'phone' => '+1234567892',
        ]);
        $accountant->assignRole('Accountant');

        // $sales = Employee::create([
        //     'name' => 'Mike Sales',
        //     'email' => 'sales@nexitel.com',
        //     'username' => 'sales',
        //     'password' => Hash::make('password'),
        //     'phone' => '+1234567893',
        // ]);
        // $sales->assignRole('Sales Agent');

        $support = Employee::create([
            'name' => 'Lisa Support',
            'email' => 'support@nexitel.com',
            'username' => 'support',
            'password' => Hash::make('password'),
            'phone' => '+1234567894',
        ]);
        $support->assignRole('Technical Support');

        echo "Roles and permissions created successfully!\n";
        echo "Super Admin: superadmin / superadmin123\n";
        echo "Admin: admin / password\n";
        echo "Manager: manager / password\n";
        echo "Accountant: accountant / password\n";
        echo "Sales: sales / password\n";
        echo "Support: support / password\n";
    }
}
