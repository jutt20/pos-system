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
        // Create admin user
        $admin = Employee::create([
            'name' => 'System Administrator',
            'email' => 'admin@nexitel.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
        ]);

        // Create sample customers
        $customer1 = Customer::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567891',
            'address' => '123 Main St, City, State 12345',
            'id_number' => 'ID123456789',
        ]);

        $customer2 = Customer::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '+1234567892',
            'address' => '456 Oak Ave, City, State 12345',
            'id_number' => 'ID987654321',
        ]);

        // Create sample invoices
        $invoice1 = Invoice::create([
            'customer_id' => $customer1->id,
            'employee_id' => $admin->id,
            'invoice_number' => 'INV-001',
            'total_amount' => 150.00,
            'status' => 'paid',
            'due_date' => now()->addDays(30),
        ]);

        // Create invoice items
        InvoiceItem::create([
            'invoice_id' => $invoice1->id,
            'description' => 'SIM Card Activation',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_price' => 50.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice1->id,
            'description' => 'Monthly Service Plan',
            'quantity' => 1,
            'unit_price' => 100.00,
            'total_price' => 100.00,
        ]);

        echo "Sample data created successfully!\n";
        echo "Admin Login: admin / password\n";
    }
}
