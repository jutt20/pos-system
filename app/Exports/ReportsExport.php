<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Activation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new CustomersSheet(),
            new InvoicesSheet(),
            new ActivationsSheet(),
        ];
    }
}

class CustomersSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Customer::select('name', 'email', 'phone', 'company', 'balance', 'prepaid_status', 'created_at')->get();
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Phone', 'Company', 'Balance', 'Prepaid Status', 'Created At'];
    }

    public function title(): string
    {
        return 'Customers';
    }
}

class InvoicesSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Invoice::with('customer')
            ->get()
            ->map(function ($invoice) {
                return [
                    'invoice_number' => $invoice->invoice_number,
                    'customer_name' => $invoice->customer->name,
                    'invoice_date' => $invoice->invoice_date,
                    'total_amount' => $invoice->total_amount,
                    'status' => $invoice->status,
                    'created_at' => $invoice->created_at,
                ];
            });
    }

    public function headings(): array
    {
        return ['Invoice Number', 'Customer', 'Billing Date', 'Total Amount', 'Status', 'Created At'];
    }

    public function title(): string
    {
        return 'Invoices';
    }
}

class ActivationsSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Activation::with('customer')
            ->get()
            ->map(function ($activation) {
                return [
                    'customer_name' => $activation->customer->name,
                    'brand' => $activation->brand,
                    'plan' => $activation->plan,
                    'sku' => $activation->sku,
                    'quantity' => $activation->quantity,
                    'price' => $activation->price,
                    'cost' => $activation->cost,
                    'profit' => $activation->profit,
                    'activation_date' => $activation->activation_date,
                ];
            });
    }

    public function headings(): array
    {
        return ['Customer', 'Brand', 'Plan', 'SKU', 'Quantity', 'Price', 'Cost', 'Profit', 'Activation Date'];
    }

    public function title(): string
    {
        return 'Activations';
    }
}
