<?php

namespace App\Http\Controllers;

use App\Models\SimOrder;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function index()
    {
        $orders = SimOrder::with(['customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sim-orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        
        return view('sim-orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'brand' => 'required|string|max:255',
            'sim_type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'vendor' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $totalCost = $request->quantity * $request->unit_cost;

        SimOrder::create([
            'customer_id' => $request->customer_id,
            'brand' => $request->brand,
            'sim_type' => $request->sim_type,
            'quantity' => $request->quantity,
            'unit_cost' => $request->unit_cost,
            'total_cost' => $totalCost,
            'vendor' => $request->vendor,
            'notes' => $request->notes,
            'status' => 'pending',
            'employee_id' => Auth::id()
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
        $customers = Customer::where('status', 'active')->get();
        
        return view('sim-orders.edit', compact('simOrder', 'customers'));
    }

    public function update(Request $request, SimOrder $simOrder)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'brand' => 'required|string|max:255',
            'sim_type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:0',
            'vendor' => 'required|string|max:255',
            'status' => 'required|in:pending,delivered,cancelled',
            'notes' => 'nullable|string'
        ]);

        $totalCost = $request->quantity * $request->unit_cost;

        $simOrder->update([
            'customer_id' => $request->customer_id,
            'brand' => $request->brand,
            'sim_type' => $request->sim_type,
            'quantity' => $request->quantity,
            'unit_cost' => $request->unit_cost,
            'total_cost' => $totalCost,
            'vendor' => $request->vendor,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('sim-orders.index')
            ->with('success', 'SIM order updated successfully.');
    }

    public function destroy(SimOrder $simOrder)
    {
        $simOrder->delete();

        return redirect()->route('sim-orders.index')
            ->with('success', 'SIM order deleted successfully.');
    }
}
