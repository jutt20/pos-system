<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SimStockPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permission
        $permission = Permission::firstOrCreate(['name' => 'manage sim stock']);

        // Assign to roles
        $roles = ['Super Admin', 'Manager', 'Admin']; // Add other roles if needed

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->givePermissionTo($permission);
            }
        }

        $this->command->info('Permission "manage sim stock" created and assigned to roles.');
    }
}
