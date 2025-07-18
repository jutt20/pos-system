<?php

namespace Database\Seeders;

use App\Models\OnlineSimOrder;
use App\Models\Customer;
use App\Models\DeliveryService;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class OnlineSimOrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $deliveryServices = DeliveryService::all();
        $employees = Employee::all();
        
        if ($customers->isEmpty() || $deliveryServices->isEmpty() || $employees->isEmpty()) {
            return;
        }

        $brands = ['Verizon', 'AT&T', 'T-Mobile', 'Sprint', 'Mint Mobile'];
        $simTypes = ['Prepaid', 'Postpaid', 'Business', 'Data Only', 'International'];
        $statuses = ['pending', 'approved', 'processing', 'shipped', 'delivered'];
        
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'];
        $states = ['NY', 'CA', 'IL', 'TX', 'AZ'];

        for ($i = 0; $i < 25; $i++) {
            $customer = $customers->random();
            $deliveryOption = rand(0, 1) ? 'delivery' : 'pickup';
            $deliveryService = $deliveryOption === 'delivery' ? $deliveryServices->random() : null;
            $quantity = rand(1, 5);
            $unitPrice = rand(20, 50);
            $totalAmount = $quantity * $unitPrice;
            $deliveryCost = 0;
            
            if ($deliveryService) {
                $deliveryCost = $deliveryService->calculateCost($quantity);
                $totalAmount += $deliveryCost;
            }
            
            $status = $statuses[array_rand($statuses)];
            $approvedBy = null;
            $approvedAt = null;
            
            if (in_array($status, ['approved', 'processing', 'shipped', 'delivered'])) {
                $approvedBy = $employees->random()->id;
                $approvedAt = now()->subDays(rand(1, 10));
            }
            
            $trackingNumber = null;
            $estimatedDelivery = null;
            
            if ($status === 'shipped' && $deliveryService) {
                $trackingNumber = 'TRK' . rand(100000000, 999999999);
                $estimatedDelivery = now()->addDays($deliveryService->estimated_days);
            }
            
            $cityIndex = array_rand($cities);
            
            OnlineSimOrder::create([
                'customer_id' => $customer->id,
                'brand' => $brands[array_rand($brands)],
                'sim_type' => $simTypes[array_rand($simTypes)],
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_amount' => $totalAmount,
                'delivery_option' => $deliveryOption,
                'delivery_service_id' => $deliveryService?->id,
                'delivery_cost' => $deliveryCost,
                'delivery_address' => $deliveryOption === 'delivery' ? rand(100, 9999) . ' Main St' : null,
                'delivery_city' => $deliveryOption === 'delivery' ? $cities[$cityIndex] : null,
                'delivery_state' => $deliveryOption === 'delivery' ? $states[$cityIndex] : null,
                'delivery_zip' => $deliveryOption === 'delivery' ? rand(10000, 99999) : null,
                'delivery_phone' => $deliveryOption === 'delivery' ? '+1' . rand(1000000000, 9999999999) : null,
                'status' => $status,
                'tracking_number' => $trackingNumber,
                'estimated_delivery' => $estimatedDelivery,
                'notes' => rand(0, 1) ? 'Please handle with care' : null,
                'admin_notes' => $status !== 'pending' ? 'Processed successfully' : null,
                'approved_by' => $approvedBy,
                'approved_at' => $approvedAt,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
