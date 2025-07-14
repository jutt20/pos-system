<?php

namespace App\Http\Controllers;

use App\Models\SimStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SimStockController extends Controller
{
    public function index(Request $request)
    {
        $query = SimStock::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search (by sim_number or iccid)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sim_number', 'like', "%$search%")
                    ->orWhere('iccid', 'like', "%$search%");
            });
        }

        $simStocks = $query->orderByDesc('id')->paginate(10)->withQueryString();

        // Count for cards
        $availableCount = SimStock::where('status', 'available')->count();
        $usedCount = SimStock::where('status', 'used')->count();
        $reservedCount = SimStock::where('status', 'reserved')->count();
        $soldCount = SimStock::where('status', 'sold')->count();

        return view('sim-stocks.index', compact('simStocks', 'availableCount', 'usedCount', 'reservedCount', 'soldCount'));
    }

    public function create()
    {
        // Code to show the form for creating a new SIM stock
        return view('sim-stocks.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sim_number'         => 'required|string|max:50|unique:sim_stocks,sim_number',
            'iccid'              => 'required|string|max:50|unique:sim_stocks,iccid',
            'vendor'             => 'required|string|max:100',
            'brand'              => 'required|string',
            'sim_type'           => 'required|string',
            'cost'               => 'required|numeric|min:0',
            'status'             => 'required|in:available,used,reserved,sold',
            'pin1'               => 'required|string|max:20',
            'puk1'               => 'required|string|max:20',
            'pin2'               => 'required|string|max:20',
            'puk2'               => 'required|string|max:20',
            'qr_activation_code' => 'required|string|max:255',
            'batch_id'           => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        SimStock::create($validator->validated());

        return redirect()->route('sim-stocks.index')
            ->with('success', 'SIM Stock created successfully.');
    }

    public function show(SimStock $simStock)
    {
        // Code to show a specific SIM stock
        return view('sim-stocks.show', compact('simStock'));
    }

    public function edit(SimStock $simStock)
    {
        // Code to show the form for editing a specific SIM stock
        return view('sim-stocks.edit', compact('simStock'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'sim_number' => 'required|string|max:255',
            'iccid' => 'required|string|max:255',
            'vendor' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'sim_type' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:available,used,reserved,sold',
            'pin1' => 'required|string|max:255',
            'puk1' => 'required|string|max:255',
            'pin2' => 'required|string|max:255',
            'puk2' => 'required|string|max:255',
            'qr_activation_code' => 'required|string|max:255',
            'batch_id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $simStock = SimStock::findOrFail($id);

        $simStock->update([
            'sim_number' => $request->sim_number,
            'iccid' => $request->iccid,
            'vendor' => $request->vendor,
            'brand' => $request->brand,
            'sim_type' => $request->sim_type,
            'cost' => $request->cost,
            'status' => $request->status,
            'pin1' => $request->pin1,
            'puk1' => $request->puk1,
            'pin2' => $request->pin2,
            'puk2' => $request->puk2,
            'qr_activation_code' => $request->qr_activation_code,
            'batch_id' => $request->batch_id,
        ]);

        return redirect()->route('sim-stocks.index')
            ->with('success', 'SIM Stock updated successfully.');
    }

    public function destroy(SimStock $simStock)
    {
        // Optional: authorize if using policies/gates
        // $this->authorize('delete', $simStock);

        $simStock->delete();

        return redirect()
            ->route('sim-stocks.index')
            ->with('success', 'SIM Stock deleted successfully.');
    }

    public function restock(Request $request, SimStock $simStock)
    {
        // Code to restock a specific SIM stock
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);
        $simStock->increment('quantity', $request->input('quantity'));
        return redirect()->route('sim-stocks.index');
    }
}
