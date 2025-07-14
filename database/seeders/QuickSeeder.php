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
use Carbon\Carbon;

class QuickSeeder extends Seeder
{
    public function run()
    {
        // Create employees
        $superAdmin = Employee::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@nexitel.com',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin123'),
            'phone' => '+1234567888',
        ]);
        $superAdmin->assignRole('Super Admin');

        $admin = Employee::create([
            'name' => 'System Administrator',
            'email' => 'admin@nexitel.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
        ]);
        $admin->assignRole('Admin');

        $manager = Employee::create([
            'name' => 'John Manager',
            'email' => 'manager@nexitel.com',
            'username' => 'manager',
            'password' => Hash::make('password'),
            'phone' => '+1234567891',
        ]);
        $manager->assignRole('Manager');

        $sales = Employee::create([
            'name' => 'Mike Sales',
            'email' => 'sales@nexitel.com',
            'username' => 'sales',
            'password' => Hash::make('password'),
            'phone' => '+1234567893',
        ]);
        $sales->assignRole('Sales Agent');

        $cashier = Employee::create([
            'name' => 'Mike Cashier',
            'email' => 'cashier@nexitel.com',
            'username' => 'cashier',
            'password' => Hash::make('password'),
            'phone' => '+1234567893',
            'role' => 'Cashier',
        ]);

        // Create customers
        $customer1 = Customer::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed@example.com',
            'password' => Hash::make('password'),
            'phone' => '+92300123456',
            'address' => '123 Main Street, Karachi',
            'assigned_employee_id' => $admin->id,
            'status' => 'active',
        ]);

        $customer2 = Customer::create([
            'name' => 'Sara Khan',
            'email' => 'sara@example.com',
            'password' => Hash::make('password'),
            'phone' => '+92301234567',
            'address' => '456 Park Avenue, Lahore',
            'assigned_employee_id' => $sales->id,
            'status' => 'active',
        ]);

        $customer3 = Customer::create([
            'name' => 'Hassan Sheikh',
            'email' => 'hassan@example.com',
            'password' => Hash::make('password'),
            'phone' => '+92302345678',
            'address' => '789 Garden Road, Islamabad',
            'assigned_employee_id' => $manager->id,
            'status' => 'active',
        ]);

        // Sample invoice data
        $invoiceData = [
            [
                'customer' => $customer1,
                'employee' => $admin,
                'status' => 'paid',
                'due' => 30,
                'items' => [
                    ['desc' => 'SIM Card Activation', 'qty' => 1, 'price' => 2000],
                    ['desc' => 'Monthly Package', 'qty' => 1, 'price' => 3000],
                ],
            ],
            [
                'customer' => $customer2,
                'employee' => $sales,
                'status' => 'sent',
                'due' => 15,
                'items' => [
                    ['desc' => 'Device Setup', 'qty' => 1, 'price' => 1500],
                    ['desc' => 'Service Fee', 'qty' => 1, 'price' => 2000],
                ],
            ],
            [
                'customer' => $customer3,
                'employee' => $manager,
                'status' => 'draft',
                'due' => 20,
                'items' => [
                    ['desc' => 'Premium Package Setup', 'qty' => 1, 'price' => 5000],
                    ['desc' => 'Installation Fee', 'qty' => 1, 'price' => 2500],
                ],
            ],
        ];

        foreach ($invoiceData as $data) {
            $subtotal = collect($data['items'])->sum(fn($item) => $item['qty'] * $item['price']);
            $tax = $subtotal * 0.08;
            $total = $subtotal + $tax;

            $invoice = Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'customer_id' => $data['customer']->id,
                'employee_id' => $data['employee']->id,
                'invoice_date' => now(),
                'due_date' => now()->addDays($data['due']),
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'total_amount' => $total,
                'status' => $data['status'],
                'notes' => 'Auto-generated invoice from QuickSeeder',
            ]);

            foreach ($data['items'] as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['desc'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['qty'] * $item['price'],
                ]);
            }
        }

        // Activations (unchanged)
        Activation::create([
            'customer_id' => $customer1->id,
            'employee_id' => $admin->id,
            'brand' => 'Jazz',
            'plan' => 'Monthly Unlimited',
            'sku' => 'JAZZ-MU-001',
            'quantity' => 1,
            'price' => 1500.00,
            'cost' => 1000.00,
            'profit' => 500.00, // You may also compute: price - cost
            'activation_date' => now(),
            'status' => 'active',
            'notes' => 'Activated by admin on initial setup.'
        ]);


        Activation::create([
            'customer_id' => $customer2->id,
            'employee_id' => $sales->id,
            'brand' => 'Telenor',
            'plan' => 'Weekly Basic',
            'sku' => 'TEL-WB-001',
            'quantity' => 1,
            'price' => 800.00,
            'cost' => 600.00,
            'profit' => 200.00,
            'activation_date' => now()->subDays(5),
            'status' => 'active',
            'notes' => 'Weekly basic plan activated.'
        ]);

        Activation::create([
            'customer_id' => $customer3->id,
            'employee_id' => $manager->id,
            'brand' => 'Zong',
            'plan' => 'Premium Business',
            'sku' => 'ZONG-PB-001',
            'quantity' => 1,
            'price' => 3000.00,
            'cost' => 2000.00,
            'profit' => 1000.00,
            'activation_date' => now()->addDays(2),
            'status' => 'pending',
            'notes' => 'Pending activation for Premium Business plan.'
        ]);

        // SIM Orders (unchanged)
        SimOrder::create([
            'customer_id' => $customer1->id,
            'employee_id' => $admin->id,
            'vendor' => 'Telenor Vendor',
            'brand' => 'Telenor',
            'sim_type' => 'Nano SIM',
            'quantity' => 5,
            'unit_cost' => 100.00,
            'total_cost' => 500.00,
            'status' => 'delivered',
            'notes' => 'Invoice attached. Shipped with DHL tracking #DHL12345',
            'order_date' => now()->subDays(10),
        ]);

        SimOrder::create([
            'customer_id' => $customer2->id,
            'employee_id' => $sales->id,
            'vendor' => 'Jazz Supplier Co.',
            'brand' => 'Jazz',
            'sim_type' => 'Micro SIM',
            'quantity' => 3,
            'unit_cost' => 90.00,
            'total_cost' => 270.00,
            'status' => 'shipped',
            'notes' => 'Shipped. Tracking URL: https://courier.example.com/track/JZ98765',
            'order_date' => now()->subDays(3),
        ]);

        SimOrder::create([
            'customer_id' => $customer3->id,
            'employee_id' => $manager->id,
            'vendor' => 'Zong Distribution',
            'brand' => 'Zong',
            'sim_type' => 'eSIM',
            'quantity' => 10,
            'unit_cost' => 120.00,
            'total_cost' => 1200.00,
            'status' => 'processing',
            'notes' => 'Waiting on delivery confirmation.',
            'order_date' => now()->subDay(),
        ]);

        echo "QuickSeeder executed successfully!\n";
    }
}
