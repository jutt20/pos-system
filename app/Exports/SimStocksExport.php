<?php

namespace App\Exports;

use App\Models\SimStock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SimStocksExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return SimStock::select(
            'sim_number',
            'iccid',
            'category',
            'sim_type',
            'vendor',
            'brand',
            'network_provider',
            'plan_type',
            'monthly_cost',
            'cost',
            'status',
            'stock_level',
            'minimum_stock',
            'pin1',
            'puk1',
            'pin2',
            'puk2',
            'qr_activation_code',
            'batch_id',
            'warehouse_location',
            'shelf_position',
            'expiry_date'
        )->get();
    }

    public function headings(): array
    {
        return [
            'SIM Number',
            'ICCID',
            'Category',
            'SIM Type',
            'Vendor',
            'Brand',
            'Network Provider',
            'Plan Type',
            'Monthly Cost',
            'Cost',
            'Status',
            'Stock Level',
            'Minimum Stock',
            'PIN 1',
            'PUK 1',
            'PIN 2',
            'PUK 2',
            'QR Activation Code',
            'Batch ID',
            'Warehouse Location',
            'Shelf Position',
            'Expiry Date',
        ];
    }
}
