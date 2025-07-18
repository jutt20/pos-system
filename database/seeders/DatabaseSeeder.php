<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SampleDataSeeder::class,
            SimStockSeeder::class,
            DeliveryServiceSeeder::class,
            OnlineSimOrderSeeder::class,
            SimStockMovementSeeder::class,
            ChatSeeder::class,
        ]);
    }
}
