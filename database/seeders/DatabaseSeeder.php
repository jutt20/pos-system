<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SampleDataSeeder::class,
            SimStockSeeder::class,
        ]);
        
        // Create additional users for customer and retailer portals
        User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
        ]);
        
        User::factory()->create([
            'name' => 'Retailer User',
            'email' => 'retailer@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
