<?php

namespace Database\Seeders;

use App\Models\SimStock;
use App\Models\SimStockMovement;
use App\Models\User;
use Illuminate\Database\Seeder;

class SimStockMovementSeeder extends Seeder
{
    public function run(): void
    {
        $simStocks = SimStock::all();
        $users = User::all();
        
        if ($simStocks->isEmpty() || $users->isEmpty()) {
            return;
        }

        $movementTypes = ['in', 'out', 'transfer', 'adjustment'];
        $reasons = [
            'Initial stock',
            'Customer purchase',
            'Warehouse transfer',
            'Inventory adjustment',
            'Damaged goods',
            'Return from customer',
            'Bulk order received',
            'Stock correction'
        ];

        foreach ($simStocks->take(20) as $simStock) {
            $movementCount = rand(1, 5);
            $currentStock = $simStock->stock_level;
            
            for ($i = 0; $i < $movementCount; $i++) {
                $movementType = $movementTypes[array_rand($movementTypes)];
                $quantity = rand(1, 10);
                $previousStock = $currentStock;
                
                // Calculate new stock based on movement type
                switch ($movementType) {
                    case 'in':
                        $newStock = $currentStock + $quantity;
                        break;
                    case 'out':
                        $newStock = max(0, $currentStock - $quantity);
                        $quantity = $currentStock - $newStock; // Adjust quantity if stock goes below 0
                        break;
                    case 'transfer':
                        $newStock = $currentStock; // Transfer doesn't change total stock
                        break;
                    case 'adjustment':
                        $newStock = rand(0, $currentStock + 10);
                        $quantity = abs($newStock - $currentStock);
                        break;
                }
                
                SimStockMovement::create([
                    'sim_stock_id' => $simStock->id,
                    'movement_type' => $movementType,
                    'quantity' => $quantity,
                    'previous_stock' => $previousStock,
                    'new_stock' => $newStock,
                    'reason' => $reasons[array_rand($reasons)],
                    'notes' => 'Automated seeder movement for testing',
                    'created_by' => $users->random()->id,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
                
                $currentStock = $newStock;
            }
            
            // Update the sim stock with final stock level
            $simStock->update(['stock_level' => $currentStock]);
        }
    }
}
