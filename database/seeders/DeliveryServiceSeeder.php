<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryService;

class DeliveryServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'UPS Ground',
                'code' => 'ups_ground',
                'tracking_url' => 'https://www.ups.com/track?tracknum={tracking_number}',
                'base_cost' => 8.99,
                'per_item_cost' => 1.50,
                'estimated_days' => 3,
                'description' => 'Reliable ground shipping with tracking',
                'service_areas' => ['US', 'CA']
            ],
            [
                'name' => 'FedEx Express',
                'code' => 'fedex_express',
                'tracking_url' => 'https://www.fedex.com/apps/fedextrack/?tracknumbers={tracking_number}',
                'base_cost' => 12.99,
                'per_item_cost' => 2.00,
                'estimated_days' => 2,
                'description' => 'Fast express delivery service',
                'service_areas' => ['US', 'CA', 'MX']
            ],
            [
                'name' => 'USPS Priority Mail',
                'code' => 'usps_priority',
                'tracking_url' => 'https://tools.usps.com/go/TrackConfirmAction?tLabels={tracking_number}',
                'base_cost' => 6.99,
                'per_item_cost' => 1.00,
                'estimated_days' => 3,
                'description' => 'Affordable priority mail service',
                'service_areas' => ['US']
            ],
            [
                'name' => 'DHL Express',
                'code' => 'dhl_express',
                'tracking_url' => 'https://www.dhl.com/us-en/home/tracking/tracking-express.html?submit=1&tracking-id={tracking_number}',
                'base_cost' => 15.99,
                'per_item_cost' => 2.50,
                'estimated_days' => 1,
                'description' => 'Premium express international delivery',
                'service_areas' => ['US', 'CA', 'MX', 'EU']
            ],
            [
                'name' => 'Local Courier',
                'code' => 'local_courier',
                'tracking_url' => 'https://localcourier.example.com/track/{tracking_number}',
                'base_cost' => 5.99,
                'per_item_cost' => 0.75,
                'estimated_days' => 1,
                'description' => 'Same-day local delivery service',
                'service_areas' => ['Local']
            ]
        ];

        foreach ($services as $service) {
            DeliveryService::create($service);
        }
    }
}
