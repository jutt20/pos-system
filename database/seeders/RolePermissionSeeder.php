<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Employee;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage employees',
            'manage customers',
            'manage invoices',
            'manage activations',
            'manage sim orders',
            'manage sim stocks',
            'view reports',
            'manage roles',
            'manage system settings',
            'manage billing',
            'manage documents',
            'export data',
            'import data',
            'view dashboard',
            'manage retailer sales',
            'track commissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'employee']);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'employee']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'employee']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'employee']);
        $billingRole = Role::firstOrCreate(['name' => 'Billing Agent', 'guard_name' => 'employee']);
        $salesRole = Role::firstOrCreate(['name' => 'Sales Agent', 'guard_name' => 'employee']);
        $retailerRole = Role::firstOrCreate(['name' => 'Retailer', 'guard_name' => 'employee']);

        // Assign permissions to roles
        $superAdminRole->givePermissionTo(Permission::all());
        
        $adminRole->givePermissionTo([
            'manage employees',
            'manage customers',
            'manage invoices',
            'manage activations',
            'manage sim orders',
            'manage sim stocks',
            'view reports',
            'manage billing',
            'manage documents',
            'export data',
            'import data',
            'view dashboard',
        ]);

        $managerRole->givePermissionTo([
            'manage customers',
            'manage invoices',
            'manage activations',
            'manage sim orders',
            'view reports',
            'manage billing',
            'view dashboard',
        ]);

        $billingRole->givePermissionTo([
            'manage invoices',
            'manage billing',
            'view reports',
            'export data',
            'view dashboard',
        ]);

        $salesRole->givePermissionTo([
            'manage customers',
            'manage activations',
            'manage sim orders',
            'view dashboard',
        ]);

        $retailerRole->givePermissionTo([
            'manage customers',
            'manage activations',
            'manage retailer sales',
            'track commissions',
            'view dashboard',
        ]);

        // Create default employees
        $superAdmin = Employee::firstOrCreate(
            ['email' => 'admin@nexitel.com'],
            [
                'name' => 'System Administrator',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
                'status' => 'active',
                'position' => 'System Administrator',
                'hire_date' => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        $manager = Employee::firstOrCreate(
            ['email' => 'manager@nexitel.com'],
            [
                'name' => 'John Manager',
                'username' => 'manager',
                'password' => Hash::make('password'),
                'phone' => '+1234567891',
                'status' => 'active',
                'position' => 'Operations Manager',
                'hire_date' => now()->subMonths(3),
            ]
        );
        $manager->assignRole($managerRole);

        $billing = Employee::firstOrCreate(
            ['email' => 'billing@nexitel.com'],
            [
                'name' => 'Sarah Billing',
                'username' => 'billing',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
                'status' => 'active',
                'position' => 'Billing Agent',
                'hire_date' => now()->subMonths(2),
            ]
        );
        $billing->assignRole($billingRole);

        $sales = Employee::firstOrCreate(
            ['email' => 'sales@nexitel.com'],
            [
                'name' => 'Mike Sales',
                'username' => 'sales',
                'password' => Hash::make('password'),
                'phone' => '+1234567893',
                'status' => 'active',
                'position' => 'Sales Agent',
                'hire_date' => now()->subMonths(1),
            ]
        );
        $sales->assignRole($salesRole);

        $retailer = Employee::firstOrCreate(
            ['email' => 'retailer@nexitel.com'],
            [
                'name' => 'David Retailer',
                'username' => 'retailer',
                'password' => Hash::make('password'),
                'phone' => '+1234567894',
                'status' => 'active',
                'position' => 'Retailer',
                'hire_date' => now()->subWeeks(2),
            ]
        );
        $retailer->assignRole($retailerRole);

        // Create sample customers
        $customer1 = Customer::firstOrCreate(
            ['email' => 'customer1@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0101',
                'company' => 'ABC Corporation',
                'address' => '123 Main St',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10001',
                'balance' => 250.00,
                'prepaid_status' => 'postpaid',
                'status' => 'active',
                'created_by' => $superAdmin->id,
                'assigned_employee_id' => $sales->id,
            ]
        );

        $customer2 = Customer::firstOrCreate(
            ['email' => 'customer2@example.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0102',
                'company' => 'XYZ Inc',
                'address' => '456 Oak Ave',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'zip_code' => '90001',
                'balance' => -50.00,
                'prepaid_status' => 'prepaid',
                'status' => 'active',
                'created_by' => $sales->id,
                'assigned_employee_id' => $sales->id,
            ]
        );

        $customer3 = Customer::firstOrCreate(
            ['email' => 'customer3@example.com'],
            [
                'name' => 'Robert Johnson',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0103',
                'company' => 'Johnson Enterprises',
                'address' => '789 Pine St',
                'city' => 'Chicago',
                'state' => 'IL',
                'zip_code' => '60601',
                'balance' => 0.00,
                'prepaid_status' => 'postpaid',
                'status' => 'active',
                'created_by' => $manager->id,
                'assigned_employee_id' => $manager->id,
            ]
        );

        $this->command->info('Roles, permissions, employees, and customers created successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin - Username: admin, Password: password');
        $this->command->info('Manager - Username: manager, Password: password');
        $this->command->info('Billing - Username: billing, Password: password');
        $this->command->info('Sales - Username: sales, Password: password');
        $this->command->info('Retailer - Username: retailer, Password: password');
    }
}
