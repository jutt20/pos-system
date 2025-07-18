<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OnlineSimOrder;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\DeliveryService;

class OnlineSimOrderSeeder extends Seeder
{
    public function run()
    {
        $customers = Customer::all();
        $employees = Employee::all();
        $deliveryServices = DeliveryService::all();
        
        if ($customers->isEmpty() || $employees->isEmpty()) {
            return;
        }

        $brands = ['Verizon', 'AT&T', 'T-Mobile', 'Sprint', 'Cricket', 'Metro PCS'];
        $simTypes = ['Nano SIM', 'Micro SIM', 'Standard SIM', 'eSIM', 'Triple Cut'];
        $statuses = ['pending', 'approved', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        for ($i = 1; $i <= 50; $i++) {
            $customer = $customers->random();
            $brand = $brands[array_rand($brands)];
            $simType = $simTypes[array_rand($simTypes)];
            $quantity = rand(1, 10);
            $unitPrice = rand(15, 50);
            $deliveryMethod = rand(0, 1) ? 'delivery' : 'pickup';
            $status = $statuses[array_rand($statuses)];
            
            $deliveryCost = 0;
            $deliveryService = null;
            $pickupRetailer = null;
            
            if ($deliveryMethod === 'delivery' && $deliveryServices->isNotEmpty()) {
                $service = $deliveryServices->random();
                $deliveryCost = $service->calculateCost($quantity);
                $deliveryService = $service->id;
            } else {
                $pickupRetailer = $employees->random()->id;
            }
            
            $totalAmount = ($quantity * $unitPrice) + $deliveryCost;
            
            $order = OnlineSimOrder::create([
                'customer_id' => $customer->id,
                'brand' => $brand,
                'sim_type' => $simType,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_amount' => $totalAmount,
                'delivery_method' => $deliveryMethod,
                'pickup_retailer_id' => $pickupRetailer,
                'delivery_address' => $deliveryMethod === 'delivery' ? fake()->streetAddress() : null,
                'delivery_city' => $deliveryMethod === 'delivery' ? fake()->city() : null,
                'delivery_state' => $deliveryMethod === 'delivery' ? fake()->stateAbbr() : null,
                'delivery_zip' => $deliveryMethod === 'delivery' ? fake()->postcode() : null,
                'delivery_phone' => $deliveryMethod === 'delivery' ? fake()->phoneNumber() : null,
                'delivery_service' => $deliveryService,
                'delivery_cost' => $deliveryCost,
                'status' => $status,
                'customer_notes' => rand(0, 1) ? fake()->sentence() : null,
                'admin_notes' => in_array($status, ['cancelled', 'processing']) ? fake()->sentence() : null,
                'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
            ]);
            
            // Set approval data for approved orders
            if (in_array($status, ['approved', 'processing', 'shipped', 'delivered'])) {
                $order->update([
                    'approved_by' => $employees->random()->id,
                    'approved_at' => fake()->dateTimeBetween($order->created_at, 'now'),
                ]);
            }
            
            // Set processing data for processing orders
            if (in_array($status, ['processing', 'shipped', 'delivered'])) {
                $order->update([
                    'processed_by' => $employees->random()->id,
                    'processed_at' => fake()->dateTimeBetween($order->approved_at, 'now'),
                ]);
            }
            
            // Set shipping data for shipped/delivered orders
            if (in_array($status, ['shipped', 'delivered']) && $deliveryMethod === 'delivery') {
                $order->update([
                    'tracking_number' => strtoupper(fake()->bothify('??########')),
                    'delivery_service_url' => 'https://tracking.example.com/track/{tracking_number}',
                    'shipped_at' => fake()->dateTimeBetween($order->processed_at, 'now'),
                    'estimated_delivery_date' => fake()->dateTimeBetween('now', '+1 week'),
                ]);
            }
            
            // Set delivery data for delivered orders
            if ($status === 'delivered') {
                $order->update([
                    'delivered_at' => fake()->dateTimeBetween($order->shipped_at ?? $order->processed_at, 'now'),
                ]);
            }
        }
    }
}
