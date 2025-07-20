<?php

namespace App\Imports;

use App\Models\SimStock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SimStockImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['iccid'])) {
            return null; // Skip rows without ICCID, considered invalid
        }

        return new SimStock([
            'sim_number' => $row['sim_number'] ?? null,
            'sim_type' => $row['sim_type'] ?? 'Nano SIM',
            'vendor' => $row['vendor'] ?? null,
            'brand' => $row['brand'] ?? null,
            'cost' => $row['cost'] ?? 0,
            'status' => $row['status'] ?? 'available',
            'iccid' => $row['iccid'] ?? null,
            'pin1' => $row['pin1'] ?? null,
            'puk1' => $row['puk1'] ?? null,
            'pin2' => $row['pin2'] ?? null,
            'puk2' => $row['puk2'] ?? null,
            'qr_activation_code' => $row['qr_activation_code'] ?? null,
            'batch_id' => $row['batch_id'] ?? null,
            'stock_level' => $row['stock_level'] ?? 1,
            'minimum_stock' => $row['minimum_stock'] ?? 10,
        ]);
    }
}
