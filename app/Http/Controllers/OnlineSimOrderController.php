<?php

namespace App\Http\Controllers;

use App\Models\OnlineSimOrder;
use App\Models\DeliveryService;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineSimOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee')->except(['publicCreate', 'publicStore', 'track']);
    }

    public function index()
    {
        $orders = OnlineSimOrder::with(['customer', 'deliveryService', 'approvedBy'])
            ->latest()
            ->paginate(20);

        return view('online-sim-orders.index', compact('orders'));
    }

    public function show(OnlineSimOrder $onlineSimOrder)
    {
        $onlineSimOrder->load(['customer', 'deliveryService', 'approvedBy']);
        return view('online-sim-orders.show', compact('onlineSimOrder'));
    }

    public function publicCreate()
    {
        $deliveryServices = DeliveryService::active()->get();
        return view('online-sim-orders.create', compact('deliveryServices'));
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
            'delivery_address' => 'required_if:delivery_option,delivery|string|max:500',
            'delivery_city' => 'required_if:delivery_option,delivery|string|max:100',
            'delivery_state' => 'required_if:delivery_option,delivery|string|max:100',
            'delivery_zip' => 'required_if:delivery_option,delivery|string|max:20',
            'delivery_phone' => 'required_if:delivery_option,delivery|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Create or find customer
        $customer = Customer::firstOrCreate(
            ['email' => $request->customer_email],
            [
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'status' => 'active',
            ]
        );

        // Calculate pricing
        $unitPrice = 25.00; // Base SIM price
        $totalAmount = $unitPrice * $request->quantity;
        $deliveryCost = 0;

        if ($request->delivery_option === 'delivery') {
            $deliveryService = DeliveryService::find($request->delivery_service_id);
            $deliveryCost = $deliveryService->calculateCost($request->quantity);
            $totalAmount += $deliveryCost;
        }

        $order = OnlineSimOrder::create([
            'customer_id' => $customer->id,
            'brand' => $request->brand,
            'sim_type' => $request->sim_type,
            'quantity' => $request->quantity,
            'unit_price' => $unitPrice,
            'total_amount' => $totalAmount,
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

        return redirect()->route('online-sim-orders.track', $order->order_number)
            ->with('success', 'Your order has been submitted successfully! Please save your order number: ' . $order->order_number);
    }

    public function track($orderNumber)
    {
        $order = OnlineSimOrder::where('order_number', $orderNumber)
            ->with(['customer', 'deliveryService'])
            ->firstOrFail();

        return view('online-sim-orders.track', compact('order'));
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
            'tracking_number' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $onlineSimOrder->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function destroy(OnlineSimOrder $onlineSimOrder)
    {
        $onlineSimOrder->delete();
        return redirect()->route('online-sim-orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
