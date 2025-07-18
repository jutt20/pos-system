<?php

namespace App\Http\Controllers;

use App\Models\OnlineSimOrder;
use App\Models\Customer;
use App\Models\DeliveryService;
use App\Models\SimStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineSimOrderController extends Controller
{
    public function index()
    {
        $orders = OnlineSimOrder::with(['customer', 'deliveryService', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('online-sim-orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        $deliveryServices = DeliveryService::active()->get();
        $simTypes = SimStock::select('brand', 'sim_type')->distinct()->get();

        return view('online-sim-orders.create', compact('customers', 'deliveryServices', 'simTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'brand' => 'required|string|max:255',
            'sim_type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'delivery_option' => 'required|in:pickup,delivery',
            'delivery_service_id' => 'required_if:delivery_option,delivery|exists:delivery_services,id',
            'delivery_address' => 'required_if:delivery_option,delivery',
            'delivery_city' => 'required_if:delivery_option,delivery',
            'delivery_state' => 'required_if:delivery_option,delivery',
            'delivery_zip' => 'required_if:delivery_option,delivery',
            'delivery_phone' => 'required_if:delivery_option,delivery',
            'notes' => 'nullable|string',
        ]);

        $totalAmount = $request->quantity * $request->unit_price;
        $deliveryCost = 0;

        if ($request->delivery_option === 'delivery' && $request->delivery_service_id) {
            $deliveryService = DeliveryService::find($request->delivery_service_id);
            $deliveryCost = $deliveryService->calculateCost($request->quantity);
        }

        $order = OnlineSimOrder::create([
            'customer_id' => $request->customer_id,
            'brand' => $request->brand,
            'sim_type' => $request->sim_type,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_amount' => $totalAmount + $deliveryCost,
            'delivery_option' => $request->delivery_option,
            'delivery_service_id' => $request->delivery_service_id,
            'delivery_cost' => $deliveryCost,
            'delivery_address' => $request->delivery_address,
            'delivery_city' => $request->delivery_city,
            'delivery_state' => $request->delivery_state,
            'delivery_zip' => $request->delivery_zip,
            'delivery_phone' => $request->delivery_phone,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('online-sim-orders.show', $order)
            ->with('success', 'Online SIM order created successfully.');
    }

    public function show(OnlineSimOrder $onlineSimOrder)
    {
        $onlineSimOrder->load(['customer', 'deliveryService', 'approvedBy']);
        return view('online-sim-orders.show', compact('onlineSimOrder'));
    }

    public function approve(OnlineSimOrder $onlineSimOrder)
    {
        $onlineSimOrder->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Order approved successfully.');
    }

    public function updateStatus(Request $request, OnlineSimOrder $onlineSimOrder)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ];

        if ($request->tracking_number) {
            $updateData['tracking_number'] = $request->tracking_number;
        }

        if ($request->status === 'shipped' && $onlineSimOrder->deliveryService) {
            $updateData['estimated_delivery'] = now()->addDays($onlineSimOrder->deliveryService->estimated_days);
        }

        $onlineSimOrder->update($updateData);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function track($orderNumber)
    {
        $order = OnlineSimOrder::where('order_number', $orderNumber)
            ->with(['customer', 'deliveryService'])
            ->firstOrFail();

        return view('online-sim-orders.track', compact('order'));
    }

    public function publicCreate()
    {
        $deliveryServices = DeliveryService::active()->get();
        $simTypes = SimStock::select('brand', 'sim_type', 'unit_price')->distinct()->get();

        return view('online-sim-orders.public-create', compact('deliveryServices', 'simTypes'));
    }

    public function publicStore(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'brand' => 'required|string|max:255',
            'sim_type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1|max:10',
            'delivery_option' => 'required|in:pickup,delivery',
            'delivery_service_id' => 'required_if:delivery_option,delivery|exists:delivery_services,id',
            'delivery_address' => 'required_if:delivery_option,delivery',
            'delivery_city' => 'required_if:delivery_option,delivery',
            'delivery_state' => 'required_if:delivery_option,delivery',
            'delivery_zip' => 'required_if:delivery_option,delivery',
            'delivery_phone' => 'required_if:delivery_option,delivery',
            'notes' => 'nullable|string|max:500',
        ]);

        // Find or create customer
        $customer = Customer::firstOrCreate(
            ['email' => $request->customer_email],
            [
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'status' => 'active',
            ]
        );

        // Get SIM price
        $simStock = SimStock::where('brand', $request->brand)
            ->where('sim_type', $request->sim_type)
            ->first();

        $unitPrice = $simStock ? $simStock->unit_price : 25.00; // Default price
        $totalAmount = $request->quantity * $unitPrice;
        $deliveryCost = 0;

        if ($request->delivery_option === 'delivery' && $request->delivery_service_id) {
            $deliveryService = DeliveryService::find($request->delivery_service_id);
            $deliveryCost = $deliveryService->calculateCost($request->quantity);
        }

        $order = OnlineSimOrder::create([
            'customer_id' => $customer->id,
            'brand' => $request->brand,
            'sim_type' => $request->sim_type,
            'quantity' => $request->quantity,
            'unit_price' => $unitPrice,
            'total_amount' => $totalAmount + $deliveryCost,
            'delivery_option' => $request->delivery_option,
            'delivery_service_id' => $request->delivery_service_id,
            'delivery_cost' => $deliveryCost,
            'delivery_address' => $request->delivery_address,
            'delivery_city' => $request->delivery_city,
            'delivery_state' => $request->delivery_state,
            'delivery_zip' => $request->delivery_zip,
            'delivery_phone' => $request->delivery_phone ?: $request->customer_phone,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('online-sim-orders.track', $order->order_number)
            ->with('success', 'Your order has been placed successfully! Please save your order number: ' . $order->order_number);
    }
}
