<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            QuickSeeder::class,
            SampleDataSeeder::class,
            SimStockSeeder::class,
            SimStockMovementSeeder::class,
            DeliveryServiceSeeder::class,
            OnlineSimOrderSeeder::class,
            ChatSeeder::class,
        ]);
    }
}
