<?php

namespace App\Imports;

use App\Models\SimStock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SimStockImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new SimStock([
            'sim_number' => $row['sim_number'] ?? null, // Optional, can be removed if not needed
            'sim_type' => $row['sim_type'] ?? null,
            'vendor' => $row['vendor'] ?? null,
            'brand' => $row['brand'] ?? null,
            'cost' => $row['cost'] ?? 0,
            'status' => $row['status'] ?? 'available',
            'iccid' => $row['iccid'] ?? null,
            'pin1' => $row['pin_1'] ?? null,
            'puk1' => $row['puk_1'] ?? null,
            'pin2' => $row['pin_2'] ?? null,
            'puk2' => $row['puk_2'] ?? null,
            'qr_activation_code' => $row['qr_activation_code'] ?? null,
            'batch_id' => $row['batch_id'] ?? null,
        ]);
    }
}
