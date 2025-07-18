<?php

namespace Database\Seeders;

use App\Models\SimStock;
use Illuminate\Database\Seeder;

class SimStockSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'nexitel_purple_physical',
            'nexitel_purple_esim',
            'nexitel_blue_physical',
            'nexitel_blue_esim',
            'esim_only'
        ];

        $simTypes = ['Nano SIM', 'Micro SIM', 'eSIM', 'Triple Cut'];
        $statuses = ['available', 'used', 'reserved', 'sold'];

        for ($i = 1; $i <= 50; $i++) {
            $category = $categories[array_rand($categories)];
            $isESim = str_contains($category, 'esim') || $category === 'esim_only';
            
            // Set brand based on category
            $brand = 'Generic';
            if (str_contains($category, 'nexitel_purple')) {
                $brand = 'Nexitel Purple';
            } elseif (str_contains($category, 'nexitel_blue')) {
                $brand = 'Nexitel Blue';
            }

            SimStock::create([
                'sim_number' => $isESim ? null : 'SIM' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'iccid' => 'ICCID' . str_pad($i, 15, '0', STR_PAD_LEFT),
                'category' => $category,
                'sim_type' => $isESim ? 'eSIM' : $simTypes[array_rand($simTypes)],
                'vendor' => 'Vendor ' . rand(1, 5),
                'brand' => $brand,
                'network_provider' => ['AT&T', 'Verizon', 'T-Mobile', 'Sprint'][array_rand(['AT&T', 'Verizon', 'T-Mobile', 'Sprint'])],
                'plan_type' => ['Unlimited', 'Limited', 'Pay-as-you-go'][array_rand(['Unlimited', 'Limited', 'Pay-as-you-go'])],
                'cost' => rand(10, 50) + (rand(0, 99) / 100),
                'monthly_cost' => rand(20, 80) + (rand(0, 99) / 100),
                'status' => $statuses[array_rand($statuses)],
                'stock_level' => rand(1, 100),
                'minimum_stock' => rand(5, 20),
                'pin1' => str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                'puk1' => str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'pin2' => str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                'puk2' => str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'qr_activation_code' => 'QR' . str_pad($i, 10, '0', STR_PAD_LEFT),
                'batch_id' => 'BATCH' . str_pad(rand(1, 10), 3, '0', STR_PAD_LEFT),
                'expiry_date' => now()->addYears(rand(1, 3))->format('Y-m-d'),
                'serial_number' => 'SN' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'warehouse_location' => 'Warehouse ' . ['A', 'B', 'C'][array_rand(['A', 'B', 'C'])],
                'shelf_position' => 'Shelf-' . rand(1, 20) . '-' . ['A', 'B', 'C', 'D'][array_rand(['A', 'B', 'C', 'D'])],
            ]);
        }
    }
}
