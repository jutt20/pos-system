<?php

namespace App\Exports;

use App\Models\SimOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SimOrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return SimOrder::with('customer')
            ->get()
            ->map(function ($order) {
                return [
                    'Order No' => $order->order_number,
                    'Customer' => $order->customer->name ?? 'N/A',
                    'Brand' => $order->brand,
                    'SIM Type' => $order->sim_type,
                    'Quantity' => $order->quantity,
                    'Unit Cost' => $order->unit_cost,
                    'Total Cost' => $order->total_cost,
                    'Vendor' => $order->vendor,
                    'Order Type' => ucfirst($order->order_type),
                    'Status' => ucfirst($order->status),
                    'Order Date' => optional($order->order_date)->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Order No',
            'Customer',
            'Brand',
            'SIM Type',
            'Quantity',
            'Unit Cost',
            'Total Cost',
            'Vendor',
            'Order Type',
            'Status',
            'Order Date',
        ];
    }
}
