<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:employee', 'permission:manage billing']);
    }

    public function index()
    {
        $invoices = Invoice::with('customer', 'employee')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'customer_id' => $request->customer_id,
            'employee_id' => auth()->id(),
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'subtotal' => 0,
            'tax_amount' => 0,
            'total_amount' => 0,
            'status' => 'draft',
            'notes' => $request->notes,
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $totalPrice = $item['quantity'] * $item['unit_price'];
            $subtotal += $totalPrice;

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $totalPrice,
            ]);
        }

        $taxAmount = $subtotal * 0.08; // 8% tax
        $totalAmount = $subtotal + $taxAmount;

        $invoice->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
        ]);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('customer', 'employee', 'items');
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $customers = Customer::orderBy('name')->get();
        $invoice->load('items');
        return view('invoices.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'payment_method' => 'nullable|in:cash,card,bank_transfer,check',
            'notes' => 'nullable|string',
        ]);

        $invoice->update($request->only('status', 'payment_method', 'notes'));

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('customer', 'employee', 'items');
        
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
