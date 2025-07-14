<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Employee;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Create sample customers and store them
        $customer1 = Customer::create([
            'name' => 'John Smith',
            'email' => 'john.smith@email.com',
            'password' => Hash::make('password'),
            'phone' => '+1-555-0101',
            'address' => '123 Main St, New York, NY 10001',
            'status' => 'active',
        ]);

        $customer2 = Customer::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.johnson@email.com',
            'password' => Hash::make('password'),
            'phone' => '+1-555-0102',
            'address' => '456 Oak Ave, Los Angeles, CA 90210',
            'status' => 'active',
        ]);

        $customer3 = Customer::create([
            'name' => 'Mike Davis',
            'email' => 'mike.davis@email.com',
            'password' => Hash::make('password'),
            'phone' => '+1-555-0103',
            'address' => '789 Pine St, Chicago, IL 60601',
            'status' => 'active',
        ]);

        $employee = Employee::first(); // Get Super Admin or first available employee

        if ($employee) {
            $invoices = [
                [
                    'customer' => $customer1,
                    'invoice_date' => Carbon::now()->subDays(10),
                    'due_date' => Carbon::now()->addDays(20),
                    'status' => 'paid',
                    'payment_method' => 'card',
                    'items' => [
                        ['description' => 'iPhone 14 Pro', 'quantity' => 1, 'unit_price' => 999.00],
                        ['description' => 'Phone Case', 'quantity' => 1, 'unit_price' => 29.99]
                    ]
                ],
                [
                    'customer' => $customer2,
                    'invoice_date' => Carbon::now()->subDays(5),
                    'due_date' => Carbon::now()->addDays(25),
                    'status' => 'sent',
                    'payment_method' => null,
                    'items' => [
                        ['description' => 'Samsung Galaxy S23', 'quantity' => 1, 'unit_price' => 799.00],
                        ['description' => 'Screen Protector', 'quantity' => 1, 'unit_price' => 19.99]
                    ]
                ],
                [
                    'customer' => $customer3,
                    'invoice_date' => Carbon::now()->subDays(2),
                    'due_date' => Carbon::now()->addDays(28),
                    'status' => 'draft',
                    'payment_method' => null,
                    'items' => [
                        ['description' => 'iPad Air', 'quantity' => 1, 'unit_price' => 599.00],
                        ['description' => 'Apple Pencil', 'quantity' => 1, 'unit_price' => 129.00]
                    ]
                ]
            ];

            foreach ($invoices as $invoiceData) {
                $items = $invoiceData['items'];
                unset($invoiceData['items']);

                $subtotal = 0;
                foreach ($items as $item) {
                    $subtotal += $item['quantity'] * $item['unit_price'];
                }

                $taxAmount = $subtotal * 0.08;
                $totalAmount = $subtotal + $taxAmount;

                $invoice = Invoice::create([
                    'invoice_number' => Invoice::generateInvoiceNumber(),
                    'customer_id' => $invoiceData['customer']->id,
                    'employee_id' => $employee->id,
                    'invoice_date' => $invoiceData['invoice_date'],
                    'due_date' => $invoiceData['due_date'],
                    'status' => $invoiceData['status'],
                    'payment_method' => $invoiceData['payment_method'],
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'total_amount' => $totalAmount,
                    'notes' => 'Sample invoice created during seeding',
                ]);

                foreach ($items as $item) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['quantity'] * $item['unit_price']
                    ]);
                }
            }
        }
    }
}
