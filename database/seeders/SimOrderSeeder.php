<?php

namespace Database\Seeders;

use App\Models\SimOrder;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\DeliveryService;
use Illuminate\Database\Seeder;

class SimOrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $employees = Employee::all();
        $deliveryServices = DeliveryService::all();

        if ($customers->isEmpty() || $employees->isEmpty() || $deliveryServices->isEmpty()) {
            return;
        }

        $employeeId = $employees->random()->id;

        $orders = [
            [
                'customer_id' => $customers->random()->id,
                'employee_id' => $employeeId,
                'vendor' => 'Telenor Vendor', // ✅ Added vendor
                'brand' => 'Nexitel Purple',
                'sim_type' => 'Physical',
                'quantity' => 2,
                'unit_cost' => 25.00,
                'total_cost' => 58.99,
                'order_type' => 'delivery',
                'delivery_service_id' => $deliveryServices->random()->id,
                'delivery_cost' => 8.99,
                'delivery_address' => '123 Main St',
                'delivery_city' => 'New York',
                'delivery_state' => 'NY',
                'delivery_zip' => '10001',
                'delivery_phone' => '+1234567890',
                'status' => 'pending',
                'notes' => 'Please deliver during business hours',
                'order_date' => now()->subDays(5),
            ],
            [
                'customer_id' => $customers->random()->id,
                'employee_id' => $employeeId,
                'vendor' => 'Jazz Supplier Co.', // ✅ Added vendor
                'brand' => 'Nexitel Blue',
                'sim_type' => 'eSIM',
                'quantity' => 1,
                'unit_cost' => 25.00,
                'total_cost' => 25.00,
                'order_type' => 'pickup',
                'delivery_cost' => 0,
                'status' => 'approved',
                'order_date' => now()->subDays(2),
                'approved_at' => now()->subHours(2),
            ],
            [
                'customer_id' => $customers->random()->id,
                'employee_id' => $employeeId,
                'vendor' => 'Zong Distribution', // ✅ Added vendor
                'brand' => 'Generic',
                'sim_type' => 'Dual',
                'quantity' => 3,
                'unit_cost' => 25.00,
                'total_cost' => 90.99,
                'order_type' => 'delivery',
                'delivery_service_id' => $deliveryServices->random()->id,
                'delivery_cost' => 15.99,
                'delivery_address' => '456 Oak Ave',
                'delivery_city' => 'Los Angeles',
                'delivery_state' => 'CA',
                'delivery_zip' => '90210',
                'delivery_phone' => '+1987654321',
                'status' => 'shipped',
                'tracking_number' => '1Z999AA1234567890',
                'estimated_delivery' => now()->addDays(2),
                'order_date' => now()->subDays(1),
                'approved_at' => now()->subDays(1),
            ],
        ];

        foreach ($orders as $orderData) {
            SimOrder::create($orderData);
        }
    }
}
