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
            'sim_type',
            'vendor',
            'brand',
            'cost',
            'status',
            'pin1',
            'puk1',
            'pin2',
            'puk2',
            'qr_activation_code',
            'batch_id'
        )->get();
    }

    public function headings(): array
    {
        return [
            'SIM Number',
            'ICCID',
            'SIM Type',
            'Vendor',
            'Brand',
            'Cost',
            'Status',
            'PIN 1',
            'PUK 1',
            'PIN 2',
            'PUK 2',
            'QR Activation Code',
            'Batch ID',
        ];
    }
}
