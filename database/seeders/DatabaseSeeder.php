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
            DeliveryServiceSeeder::class,
            SimOrderSeeder::class,
            SimStockSeeder::class,
            ChatSeeder::class,
        ]);
    }
}
