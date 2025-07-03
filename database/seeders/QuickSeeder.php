<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Activation;
use App\Models\SimOrder;
use Illuminate\Support\Facades\Hash;

class QuickSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin
        $superAdmin = Employee::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@nexitel.com',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin123'),
            'phone' => '+1234567888',
            'role' => 'Super Admin',
        ]);

        // Create admin employee
        $admin = Employee::create([
            'name' => 'System Administrator',
            'email' => 'admin@nexitel.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'role' => 'Admin',
        ]);

        // Create sample employees
        $manager = Employee::create([
            'name' => 'John Manager',
            'email' => 'manager@nexitel.com',
            'username' => 'manager',
            'password' => Hash::make('password'),
            'phone' => '+1234567891',
            'role' => 'Manager',
        ]);

        $sales = Employee::create([
            'name' => 'Jane Sales',
            'email' => 'sales@nexitel.com',
            'username' => 'sales',
            'password' => Hash::make('password'),
            'phone' => '+1234567892',
            'role' => 'Sales Agent',
        ]);

        $cashier = Employee::create([
            'name' => 'Mike Cashier',
            'email' => 'cashier@nexitel.com',
            'username' => 'cashier',
            'password' => Hash::make('password'),
            'phone' => '+1234567893',
            'role' => 'Cashier',
        ]);

        // Create sample customers
        $customer1 = Customer::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed@example.com',
            'phone' => '+92300123456',
            'address' => '123 Main Street, Karachi',
            'cnic' => '42101-1234567-1',
            'assigned_employee_id' => $admin->id,
        ]);

        $customer2 = Customer::create([
            'name' => 'Sara Khan',
            'email' => 'sara@example.com',
            'phone' => '+92301234567',
            'address' => '456 Park Avenue, Lahore',
            'cnic' => '35202-2345678-2',
            'assigned_employee_id' => $sales->id,
        ]);

        $customer3 = Customer::create([
            'name' => 'Hassan Sheikh',
            'email' => 'hassan@example.com',
            'phone' => '+92302345678',
            'address' => '789 Garden Road, Islamabad',
            'cnic' => '61101-3456789-3',
            'assigned_employee_id' => $manager->id,
        ]);

        // Create sample invoices
        $invoice1 = Invoice::create([
            'customer_id' => $customer1->id,
            'employee_id' => $admin->id,
            'invoice_number' => 'INV-001',
            'billing_date' => now(),
            'total_amount' => 5000.00,
            'status' => 'paid',
            'due_date' => now()->addDays(30),
        ]);

        $invoice2 = Invoice::create([
            'customer_id' => $customer2->id,
            'employee_id' => $sales->id,
            'invoice_number' => 'INV-002',
            'billing_date' => now(),
            'total_amount' => 3500.00,
            'status' => 'sent',
            'due_date' => now()->addDays(15),
        ]);

        $invoice3 = Invoice::create([
            'customer_id' => $customer3->id,
            'employee_id' => $manager->id,
            'invoice_number' => 'INV-003',
            'billing_date' => now(),
            'total_amount' => 7500.00,
            'status' => 'draft',
            'due_date' => now()->addDays(20),
        ]);

        // Create invoice items
        InvoiceItem::create([
            'invoice_id' => $invoice1->id,
            'description' => 'SIM Card Activation',
            'quantity' => 1,
            'unit_price' => 2000.00,
            'total_price' => 2000.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice1->id,
            'description' => 'Monthly Package',
            'quantity' => 1,
            'unit_price' => 3000.00,
            'total_price' => 3000.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice2->id,
            'description' => 'Device Setup',
            'quantity' => 1,
            'unit_price' => 1500.00,
            'total_price' => 1500.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice2->id,
            'description' => 'Service Fee',
            'quantity' => 1,
            'unit_price' => 2000.00,
            'total_price' => 2000.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice3->id,
            'description' => 'Premium Package Setup',
            'quantity' => 1,
            'unit_price' => 5000.00,
            'total_price' => 5000.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice3->id,
            'description' => 'Installation Fee',
            'quantity' => 1,
            'unit_price' => 2500.00,
            'total_price' => 2500.00,
        ]);

        // Create sample activations
        Activation::create([
            'customer_id' => $customer1->id,
            'employee_id' => $admin->id,
            'sim_number' => '8923400000000001',
            'phone_number' => '+923001234567',
            'package_type' => 'Monthly Unlimited',
            'activation_fee' => 500.00,
            'monthly_fee' => 1500.00,
            'status' => 'active',
            'activation_date' => now(),
            'expiry_date' => now()->addMonth(),
        ]);

        Activation::create([
            'customer_id' => $customer2->id,
            'employee_id' => $sales->id,
            'sim_number' => '8923400000000002',
            'phone_number' => '+923012345678',
            'package_type' => 'Weekly Basic',
            'activation_fee' => 200.00,
            'monthly_fee' => 800.00,
            'status' => 'active',
            'activation_date' => now()->subDays(5),
            'expiry_date' => now()->addWeeks(3),
        ]);

        Activation::create([
            'customer_id' => $customer3->id,
            'employee_id' => $manager->id,
            'sim_number' => '8923400000000003',
            'phone_number' => '+923023456789',
            'package_type' => 'Premium Business',
            'activation_fee' => 1000.00,
            'monthly_fee' => 3000.00,
            'status' => 'pending',
            'activation_date' => now()->addDays(2),
            'expiry_date' => now()->addMonths(3),
        ]);

        // Create sample SIM orders
        SimOrder::create([
            'customer_id' => $customer1->id,
            'employee_id' => $admin->id,
            'order_number' => 'ORD-001',
            'sim_type' => 'Nano SIM',
            'quantity' => 5,
            'unit_price' => 100.00,
            'total_amount' => 500.00,
            'status' => 'delivered',
            'order_date' => now()->subDays(10),
            'expected_delivery' => now()->subDays(5),
        ]);

        SimOrder::create([
            'customer_id' => $customer2->id,
            'employee_id' => $sales->id,
            'order_number' => 'ORD-002',
            'sim_type' => 'Micro SIM',
            'quantity' => 3,
            'unit_price' => 100.00,
            'total_amount' => 300.00,
            'status' => 'shipped',
            'order_date' => now()->subDays(3),
            'expected_delivery' => now()->addDays(2),
        ]);

        SimOrder::create([
            'customer_id' => $customer3->id,
            'employee_id' => $manager->id,
            'order_number' => 'ORD-003',
            'sim_type' => 'eSIM',
            'quantity' => 10,
            'unit_price' => 150.00,
            'total_amount' => 1500.00,
            'status' => 'processing',
            'order_date' => now()->subDays(1),
            'expected_delivery' => now()->addDays(7),
        ]);

        echo "Sample data created successfully!\n";
        echo "=== LOGIN CREDENTIALS ===\n";
        echo "Super Admin: superadmin / superadmin123\n";
        echo "Admin: admin / password\n";
        echo "Manager: manager / password\n";
        echo "Sales: sales / password\n";
        echo "Cashier: cashier / password\n";
        echo "\n=== SAMPLE DATA CREATED ===\n";
        echo "- 5 Employees with different roles\n";
        echo "- 3 Customers with assignments\n";
        echo "- 3 Invoices with items\n";
        echo "- 3 Activations with different statuses\n";
        echo "- 3 SIM Orders with different statuses\n";
    }
}
