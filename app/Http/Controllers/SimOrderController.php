<?php

namespace App\Http\Controllers;

use App\Models\SimOrder;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SimOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage orders|view orders');
    }

    public function index()
    {
        $orders = SimOrder::with(['customer', 'employee'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('sim-orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('sim-orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vendor' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'sim_type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'order_date' => 'required|date',
            'cost_per_sim' => 'required|numeric|min:0',
            'invoice_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $totalCost = $request->quantity * $request->cost_per_sim;
        
        $invoiceFile = null;
        if ($request->hasFile('invoice_file')) {
            $invoiceFile = $request->file('invoice_file')->store('sim-orders', 'public');
        }

        SimOrder::create([
            'order_number' => SimOrder::generateOrderNumber(),
            'customer_id' => $request->customer_id,
            'vendor' => $request->vendor,
            'brand' => $request->brand,
            'sim_type' => $request->sim_type,
            'quantity' => $request->quantity,
            'order_date' => $request->order_date,
            'cost_per_sim' => $request->cost_per_sim,
            'total_cost' => $totalCost,
            'status' => 'pending',
            'tracking_number' => $request->tracking_number,
            'invoice_file' => $invoiceFile,
            'employee_id' => auth()->id(),
        ]);

        return redirect()->route('sim-orders.index')
            ->with('success', 'SIM order created successfully.');
    }

    public function show(SimOrder $simOrder)
    {
        $simOrder->load(['customer', 'employee']);
        return view('sim-orders.show', compact('simOrder'));
    }

    public function edit(SimOrder $simOrder)
    {
        $customers = Customer::orderBy('name')->get();
        return view('sim-orders.edit', compact('simOrder', 'customers'));
    }

    public function update(Request $request, SimOrder $simOrder)
    {
        $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $simOrder->update($request->only('status', 'tracking_number'));

        return redirect()->route('sim-orders.index')
            ->with('success', 'SIM order updated successfully.');
    }

    public function destroy(SimOrder $simOrder)
    {
        if ($simOrder->invoice_file) {
            Storage::disk('public')->delete($simOrder->invoice_file);
        }
        
        $simOrder->delete();
        return redirect()->route('sim-orders.index')
            ->with('success', 'SIM order deleted successfully.');
    }
}
