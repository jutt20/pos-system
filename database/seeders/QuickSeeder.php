<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Hash;

class QuickSeeder extends Seeder
{
    public function run()
    {
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
        Employee::create([
            'name' => 'John Manager',
            'email' => 'manager@nexitel.com',
            'username' => 'manager',
            'password' => Hash::make('password'),
            'phone' => '+1234567891',
            'role' => 'Manager',
        ]);

        Employee::create([
            'name' => 'Jane Sales',
            'email' => 'sales@nexitel.com',
            'username' => 'sales',
            'password' => Hash::make('password'),
            'phone' => '+1234567892',
            'role' => 'Sales Agent',
        ]);

        // Create sample customers
        $customer1 = Customer::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed@example.com',
            'phone' => '+92300123456',
            'address' => '123 Main Street, Karachi',
            'cnic' => '42101-1234567-1',
        ]);

        $customer2 = Customer::create([
            'name' => 'Sara Khan',
            'email' => 'sara@example.com',
            'phone' => '+92301234567',
            'address' => '456 Park Avenue, Lahore',
            'cnic' => '35202-2345678-2',
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
            'employee_id' => $admin->id,
            'invoice_number' => 'INV-002',
            'billing_date' => now(),
            'total_amount' => 3500.00,
            'status' => 'pending',
            'due_date' => now()->addDays(15),
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

        echo "Sample data created successfully!\n";
        echo "Admin Login: admin / password\n";
        echo "Manager Login: manager / password\n";
        echo "Sales Login: sales / password\n";
    }
}
