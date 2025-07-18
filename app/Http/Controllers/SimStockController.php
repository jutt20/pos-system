<?php

namespace App\Http\Controllers;

use App\Models\SimStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage sim stock');
    }

    public function index(Request $request)
    {
        $query = SimStock::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('sim_number', 'like', "%{$search}%")
                  ->orWhere('iccid', 'like', "%{$search}%")
                  ->orWhere('batch_id', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $simStocks = $query->latest()->paginate(20);

        // Get categories for filter dropdown
        $categories = SimStock::getCategories();

        // Calculate stats
        $stats = [
            'total' => SimStock::count(),
            'available' => SimStock::where('status', 'available')->count(),
            'used' => SimStock::where('status', 'used')->count(),
            'nexitel_purple' => SimStock::whereIn('category', ['nexitel_purple_physical', 'nexitel_purple_esim'])->count(),
            'nexitel_blue' => SimStock::whereIn('category', ['nexitel_blue_physical', 'nexitel_blue_esim'])->count(),
            'esims' => SimStock::where('category', 'esim_only')->count(),
            'low_stock' => SimStock::whereRaw('stock_level <= minimum_stock')->count(),
        ];

        return view('sim-stocks.index', compact('simStocks', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = SimStock::getCategories();
        return view('sim-stocks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:nexitel_purple_physical,nexitel_purple_esim,nexitel_blue_physical,nexitel_blue_esim,esim_only',
            'iccid' => 'required|string|unique:sim_stocks,iccid',
            'sim_number' => 'nullable|string|unique:sim_stocks,sim_number',
            'sim_type' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:available,used,reserved,sold,damaged,expired',
            'stock_level' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'vendor' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'network_provider' => 'nullable|string|max:255',
            'plan_type' => 'nullable|string|max:255',
            'monthly_cost' => 'nullable|numeric|min:0',
            'pin1' => 'nullable|string|max:20',
            'puk1' => 'nullable|string|max:20',
            'pin2' => 'nullable|string|max:20',
            'puk2' => 'nullable|string|max:20',
            'qr_activation_code' => 'nullable|string',
            'batch_id' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date',
            'serial_number' => 'nullable|string|max:100',
            'warehouse_location' => 'nullable|string|max:255',
            'shelf_position' => 'nullable|string|max:100',
        ]);

        // Set brand based on category if not provided
        if (!$request->brand) {
            if (str_contains($request->category, 'nexitel_purple')) {
                $request->merge(['brand' => 'Nexitel Purple']);
            } elseif (str_contains($request->category, 'nexitel_blue')) {
                $request->merge(['brand' => 'Nexitel Blue']);
            } else {
                $request->merge(['brand' => 'Generic']);
            }
        }

        SimStock::create($request->all());

        return redirect()->route('sim-stocks.index')
            ->with('success', 'SIM Stock created successfully.');
    }

    public function show(SimStock $simStock)
    {
        return view('sim-stocks.show', compact('simStock'));
    }

    public function edit(SimStock $simStock)
    {
        $categories = SimStock::getCategories();
        return view('sim-stocks.edit', compact('simStock', 'categories'));
    }

    public function update(Request $request, SimStock $simStock)
    {
        $request->validate([
            'category' => 'required|in:nexitel_purple_physical,nexitel_purple_esim,nexitel_blue_physical,nexitel_blue_esim,esim_only',
            'iccid' => 'required|string|unique:sim_stocks,iccid,' . $simStock->id,
            'sim_number' => 'nullable|string|unique:sim_stocks,sim_number,' . $simStock->id,
            'sim_type' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:available,used,reserved,sold,damaged,expired',
            'stock_level' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
        ]);

        $simStock->update($request->all());

        return redirect()->route('sim-stocks.index')
            ->with('success', 'SIM Stock updated successfully.');
    }

    public function destroy(SimStock $simStock)
    {
        $simStock->delete();
        return redirect()->route('sim-stocks.index')
            ->with('success', 'SIM Stock deleted successfully.');
    }

    public function activate(SimStock $simStock)
    {
        $simStock->update([
            'status' => 'used',
            'activated_at' => now(),
            'activated_by' => Auth::id(),
        ]);

        return redirect()->route('sim-stocks.index')
            ->with('success', 'SIM activated successfully.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,mark_damaged,mark_expired',
            'sim_ids' => 'required|array',
            'sim_ids.*' => 'exists:sim_stocks,id',
        ]);

        $statusMap = [
            'activate' => 'used',
            'mark_damaged' => 'damaged',
            'mark_expired' => 'expired',
        ];

        $updateData = ['status' => $statusMap[$request->action]];
        
        if ($request->action === 'activate') {
            $updateData['activated_at'] = now();
            $updateData['activated_by'] = Auth::id();
        }

        SimStock::whereIn('id', $request->sim_ids)->update($updateData);

        $count = count($request->sim_ids);
        $action = str_replace('_', ' ', $request->action);
        
        return redirect()->route('sim-stocks.index')
            ->with('success', "{$count} SIM card(s) {$action}d successfully.");
    }

    public function export()
    {
        // Implementation for export functionality
        return redirect()->route('sim-stocks.index')
            ->with('success', 'Export functionality will be implemented.');
    }

    public function import(Request $request)
    {
        // Implementation for import functionality
        return redirect()->route('sim-stocks.index')
            ->with('success', 'Import functionality will be implemented.');
    }
}
