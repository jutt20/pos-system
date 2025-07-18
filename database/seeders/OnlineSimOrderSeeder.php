<?php

namespace Database\Seeders;

use App\Models\OnlineSimOrder;
use App\Models\Customer;
use App\Models\DeliveryService;
use Illuminate\Database\Seeder;

class OnlineSimOrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $deliveryServices = DeliveryService::all();

        if ($customers->isEmpty() || $deliveryServices->isEmpty()) {
            return;
        }

        $orders = [
            [
                'customer_id' => $customers->random()->id,
                'brand' => 'Nexitel Purple',
                'sim_type' => 'Physical',
                'quantity' => 2,
                'unit_price' => 25.00,
                'total_amount' => 58.99,
                'delivery_option' => 'delivery',
                'delivery_service_id' => $deliveryServices->random()->id,
                'delivery_cost' => 8.99,
                'delivery_address' => '123 Main St',
                'delivery_city' => 'New York',
                'delivery_state' => 'NY',
                'delivery_zip' => '10001',
                'delivery_phone' => '+1234567890',
                'status' => 'pending',
                'notes' => 'Please deliver during business hours',
            ],
            [
                'customer_id' => $customers->random()->id,
                'brand' => 'Nexitel Blue',
                'sim_type' => 'eSIM',
                'quantity' => 1,
                'unit_price' => 25.00,
                'total_amount' => 25.00,
                'delivery_option' => 'pickup',
                'delivery_cost' => 0,
                'status' => 'approved',
                'approved_at' => now()->subHours(2),
            ],
            [
                'customer_id' => $customers->random()->id,
                'brand' => 'Generic',
                'sim_type' => 'Dual',
                'quantity' => 3,
                'unit_price' => 25.00,
                'total_amount' => 90.99,
                'delivery_option' => 'delivery',
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
                'approved_at' => now()->subDays(1),
            ],
        ];

        foreach ($orders as $orderData) {
            OnlineSimOrder::create($orderData);
        }
    }
}
