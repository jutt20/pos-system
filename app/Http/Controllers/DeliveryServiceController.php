<?php

namespace App\Http\Controllers;

use App\Models\DeliveryService;
use Illuminate\Http\Request;

class DeliveryServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee');
        $this->middleware('permission:manage delivery services');
    }

    public function index()
    {
        $deliveryServices = DeliveryService::latest()->paginate(20);
        return view('delivery-services.index', compact('deliveryServices'));
    }

    public function create()
    {
        return view('delivery-services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:delivery_services,code',
            'base_cost' => 'required|numeric|min:0',
            'per_item_cost' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1|max:30',
            'tracking_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
        ]);

        DeliveryService::create($request->all());

        return redirect()->route('delivery-services.index')
            ->with('success', 'Delivery service created successfully.');
    }

    public function show(DeliveryService $deliveryService)
    {
        return view('delivery-services.show', compact('deliveryService'));
    }

    public function edit(DeliveryService $deliveryService)
    {
        return view('delivery-services.edit', compact('deliveryService'));
    }

    public function update(Request $request, DeliveryService $deliveryService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:delivery_services,code,' . $deliveryService->id,
            'base_cost' => 'required|numeric|min:0',
            'per_item_cost' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1|max:30',
            'tracking_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
        ]);

        $deliveryService->update($request->all());

        return redirect()->route('delivery-services.index')
            ->with('success', 'Delivery service updated successfully.');
    }

    public function destroy(DeliveryService $deliveryService)
    {
        $deliveryService->delete();
        return redirect()->route('delivery-services.index')
            ->with('success', 'Delivery service deleted successfully.');
    }

    public function toggle(DeliveryService $deliveryService)
    {
        $deliveryService->update([
            'is_active' => !$deliveryService->is_active
        ]);

        $status = $deliveryService->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Delivery service {$status} successfully.");
    }
}
