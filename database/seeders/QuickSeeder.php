<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class QuickSeeder extends Seeder
{
    public function run()
    {
        // Create basic employee without Spatie (for quick setup)
        DB::table('employees')->insert([
            'name' => 'System Administrator',
            'email' => 'admin@nexitel.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create sample customer
        DB::table('customers')->insert([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1555123456',
            'company' => 'Example Corp',
            'address' => '123 Main St, City, State',
            'balance' => 250.00,
            'prepaid_status' => 'prepaid',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "✅ Quick setup data created!\n";
        echo "🔐 Login: admin / password\n";
    }
}
