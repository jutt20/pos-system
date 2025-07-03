<?php

namespace App\Http\Controllers;

use App\Models\Activation;
use App\Models\Customer;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage activations');
    }

    public function index()
    {
        $activations = Activation::with('customer', 'employee')->paginate(10);
        return view('activations.index', compact('activations'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('activations.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'brand' => 'required|string|max:255',
            'plan' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'activation_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
        ]);

        $profit = ($request->price - $request->cost) * $request->quantity;

        Activation::create([
            'customer_id' => $request->customer_id,
            'employee_id' => auth()->id(),
            'brand' => $request->brand,
            'plan' => $request->plan,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
            'activation_date' => $request->activation_date,
            'price' => $request->price,
            'cost' => $request->cost,
            'profit' => $profit,
            'notes' => $request->notes,
        ]);

        return redirect()->route('activations.index')
            ->with('success', 'Activation created successfully.');
    }

    public function show(Activation $activation)
    {
        $activation->load('customer', 'employee');
        return view('activations.show', compact('activation'));
    }

    public function edit(Activation $activation)
    {
        $customers = Customer::all();
        return view('activations.edit', compact('activation', 'customers'));
    }

    public function update(Request $request, Activation $activation)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'brand' => 'required|string|max:255',
            'plan' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'activation_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
        ]);

        $profit = ($request->price - $request->cost) * $request->quantity;

        $activation->update([
            'customer_id' => $request->customer_id,
            'brand' => $request->brand,
            'plan' => $request->plan,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
            'activation_date' => $request->activation_date,
            'price' => $request->price,
            'cost' => $request->cost,
            'profit' => $profit,
            'notes' => $request->notes,
        ]);

        return redirect()->route('activations.index')
            ->with('success', 'Activation updated successfully.');
    }

    public function destroy(Activation $activation)
    {
        $activation->delete();
        return redirect()->route('activations.index')
            ->with('success', 'Activation deleted successfully.');
    }
}
