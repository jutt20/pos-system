<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Activation;
use App\Models\SimOrder;
use App\Models\Employee;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Get employees for assignments
        $admin = Employee::where('username', 'admin')->first();
        $manager = Employee::where('username', 'manager')->first();
        $sales = Employee::where('username', 'sales')->first();

        // Create sample customers
        $customer1 = Customer::create([
            'name' => 'Ahmed Ali',
            'email' => 'ahmed@example.com',
            'phone' => '+92300123456',
            'company' => 'Tech Solutions Ltd',
            'address' => '123 Main Street, Karachi',
            'balance' => 2500.00,
            'prepaid_status' => 'prepaid',
            'assigned_employee_id' => $admin->id,
        ]);

        $customer2 = Customer::create([
            'name' => 'Sara Khan',
            'email' => 'sara@example.com',
            'phone' => '+92301234567',
            'company' => 'Digital Marketing Co',
            'address' => '456 Park Avenue, Lahore',
            'balance' => -1200.00,
            'prepaid_status' => 'postpaid',
            'assigned_employee_id' => $sales->id,
        ]);

        $customer3 = Customer::create([
            'name' => 'Hassan Sheikh',
            'email' => 'hassan@example.com',
            'phone' => '+92302345678',
            'company' => 'Import Export Business',
            'address' => '789 Garden Road, Islamabad',
            'balance' => 5000.00,
            'prepaid_status' => 'prepaid',
            'assigned_employee_id' => $manager->id,
        ]);

        // Create sample invoices
        $invoice1 = Invoice::create([
            'customer_id' => $customer1->id,
            'employee_id' => $admin->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'billing_date' => now(),
            'due_date' => now()->addDays(30),
            'subtotal' => 4629.63,
            'tax_amount' => 370.37,
            'total_amount' => 5000.00,
            'status' => 'paid',
            'payment_method' => 'card',
        ]);

        $invoice2 = Invoice::create([
            'customer_id' => $customer2->id,
            'employee_id' => $sales->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'billing_date' => now(),
            'due_date' => now()->addDays(15),
            'subtotal' => 3240.74,
            'tax_amount' => 259.26,
            'total_amount' => 3500.00,
            'status' => 'sent',
        ]);

        $invoice3 = Invoice::create([
            'customer_id' => $customer3->id,
            'employee_id' => $manager->id,
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'billing_date' => now(),
            'due_date' => now()->addDays(20),
            'subtotal' => 6944.44,
            'tax_amount' => 555.56,
            'total_amount' => 7500.00,
            'status' => 'draft',
        ]);

        // Create invoice items
        InvoiceItem::create([
            'invoice_id' => $invoice1->id,
            'description' => 'SIM Card Activation - Premium',
            'plan' => 'Unlimited Talk & Data',
            'sku' => 'SKU-BLUE-001',
            'quantity' => 1,
            'unit_price' => 2000.00,
            'total_price' => 2000.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice1->id,
            'description' => 'Monthly Package - Business',
            'plan' => 'Business Pro',
            'sku' => 'SKU-PURPLE-002',
            'quantity' => 1,
            'unit_price' => 2629.63,
            'total_price' => 2629.63,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice2->id,
            'description' => 'Device Setup & Configuration',
            'quantity' => 1,
            'unit_price' => 1500.00,
            'total_price' => 1500.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice2->id,
            'description' => 'Service Fee & Installation',
            'quantity' => 1,
            'unit_price' => 1740.74,
            'total_price' => 1740.74,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice3->id,
            'description' => 'Premium Package Setup',
            'plan' => 'Enterprise',
            'sku' => 'SKU-ENTERPRISE-001',
            'quantity' => 1,
            'unit_price' => 5000.00,
            'total_price' => 5000.00,
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice3->id,
            'description' => 'Installation & Training',
            'quantity' => 1,
            'unit_price' => 1944.44,
            'total_price' => 1944.44,
        ]);

        // Create sample activations
        Activation::create([
            'customer_id' => $customer1->id,
            'employee_id' => $admin->id,
            'brand' => 'Nexitel Blue',
            'plan' => 'Unlimited Talk',
            'sku' => 'SKU-BLUE-001',
            'quantity' => 100,
            'price' => 15.00,
            'cost' => 10.00,
            'profit' => 500.00,
            'activation_date' => now(),
            'status' => 'active',
        ]);

        Activation::create([
            'customer_id' => $customer2->id,
            'employee_id' => $sales->id,
            'brand' => 'Nexitel Purple',
            'plan' => 'Premium Plan',
            'sku' => 'SKU-PURPLE-002',
            'quantity' => 40,
            'price' => 20.00,
            'cost' => 15.00,
            'profit' => 200.00,
            'activation_date' => now()->subDays(5),
            'status' => 'active',
        ]);

        Activation::create([
            'customer_id' => $customer3->id,
            'employee_id' => $manager->id,
            'brand' => 'AT&T',
            'plan' => 'Business Pro',
            'sku' => 'SKU-ATT-003',
            'quantity' => 75,
            'price' => 25.00,
            'cost' => 18.00,
            'profit' => 525.00,
            'activation_date' => now()->addDays(2),
            'status' => 'pending',
        ]);

        // Create sample SIM orders
        SimOrder::create([
            'order_number' => SimOrder::generateOrderNumber(),
            'vendor' => 'Nexitel Blue',
            'brand' => 'Nexitel Blue',
            'sim_type' => 'Standard SIM',
            'quantity' => 300,
            'order_date' => now()->subDays(10),
            'cost_per_sim' => 2.50,
            'total_cost' => 750.00,
            'status' => 'delivered',
            'tracking_number' => 'TRK001234567',
            'employee_id' => $admin->id,
        ]);

        SimOrder::create([
            'order_number' => SimOrder::generateOrderNumber(),
            'vendor' => 'Nexitel Purple',
            'brand' => 'Nexitel Purple',
            'sim_type' => 'eSIM',
            'quantity' => 150,
            'order_date' => now()->subDays(3),
            'cost_per_sim' => 3.00,
            'total_cost' => 450.00,
            'status' => 'shipped',
            'tracking_number' => 'TRK001234568',
            'employee_id' => $sales->id,
        ]);

        SimOrder::create([
            'order_number' => SimOrder::generateOrderNumber(),
            'vendor' => 'AT&T Wholesale',
            'brand' => 'AT&T',
            'sim_type' => 'Nano SIM',
            'quantity' => 500,
            'order_date' => now()->subDays(1),
            'cost_per_sim' => 2.75,
            'total_cost' => 1375.00,
            'status' => 'pending',
            'employee_id' => $manager->id,
        ]);

        echo "Sample data created successfully!\n";
        echo "- 3 Customers with different statuses\n";
        echo "- 3 Invoices with items\n";
        echo "- 3 Activations with profit calculations\n";
        echo "- 3 SIM Orders with different statuses\n";
    }
}
