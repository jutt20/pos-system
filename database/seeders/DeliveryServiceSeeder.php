<?php

namespace Database\Seeders;

use App\Models\DeliveryService;
use Illuminate\Database\Seeder;

class DeliveryServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'UPS Ground',
                'code' => 'UPS_GROUND',
                'base_cost' => 8.99,
                'per_item_cost' => 2.50,
                'estimated_days' => 3,
                'tracking_url' => 'https://www.ups.com/track?tracknum={tracking_number}',
                'description' => 'Reliable ground shipping with tracking',
                'is_active' => true,
            ],
            [
                'name' => 'FedEx Express',
                'code' => 'FEDEX_EXPRESS',
                'base_cost' => 15.99,
                'per_item_cost' => 3.00,
                'estimated_days' => 2,
                'tracking_url' => 'https://www.fedex.com/apps/fedextrack/?tracknumbers={tracking_number}',
                'description' => 'Fast express delivery service',
                'is_active' => true,
            ],
            [
                'name' => 'USPS Priority Mail',
                'code' => 'USPS_PRIORITY',
                'base_cost' => 7.50,
                'per_item_cost' => 1.75,
                'estimated_days' => 2,
                'tracking_url' => 'https://tools.usps.com/go/TrackConfirmAction?tLabels={tracking_number}',
                'description' => 'Affordable priority mail service',
                'is_active' => true,
            ],
            [
                'name' => 'DHL Express',
                'code' => 'DHL_EXPRESS',
                'base_cost' => 18.99,
                'per_item_cost' => 4.00,
                'estimated_days' => 1,
                'tracking_url' => 'https://www.dhl.com/us-en/home/tracking/tracking-express.html?submit=1&tracking-id={tracking_number}',
                'description' => 'Premium overnight delivery',
                'is_active' => true,
            ],
            [
                'name' => 'Local Courier',
                'code' => 'LOCAL_COURIER',
                'base_cost' => 12.00,
                'per_item_cost' => 2.00,
                'estimated_days' => 1,
                'tracking_url' => null,
                'description' => 'Same-day local delivery service',
                'is_active' => true,
            ],
            [
                'name' => 'Standard Shipping',
                'code' => 'STANDARD',
                'base_cost' => 5.99,
                'per_item_cost' => 1.00,
                'estimated_days' => 5,
                'tracking_url' => null,
                'description' => 'Economy shipping option',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            DeliveryService::create($service);
        }
    }
}
