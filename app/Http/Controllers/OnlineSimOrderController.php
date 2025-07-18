<?php

namespace App\Http\Controllers;

use App\Models\OnlineSimOrder;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\DeliveryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineSimOrderController extends Controller
{
    public function index()
    {
        $orders = OnlineSimOrder::with(['customer', 'approvedBy', 'processedBy', 'pickupRetailer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('online-sim-orders.index', compact('orders'));
    }

    public function create()
    {
        $deliveryServices = DeliveryService::active()->get();
        $retailers = Employee::whereHas('roles', function($query) {
            $query->where('name', 'retailer');
        })->get();

        return view('online-sim-orders.create', compact('deliveryServices', 'retailers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'sim_type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'delivery_method' => 'required|in:pickup,delivery',
            'pickup_retailer_id' => 'required_if:delivery_method,pickup|exists:employees,id',
            'delivery_address' => 'required_if:delivery_method,delivery|string|max:255',
            'delivery_city' => 'required_if:delivery_method,delivery|string|max:255',
            'delivery_state' => 'required_if:delivery_method,delivery|string|max:255',
            'delivery_zip' => 'required_if:delivery_method,delivery|string|max:20',
            'delivery_phone' => 'required_if:delivery_method,delivery|string|max:20',
            'delivery_service' => 'required_if:delivery_method,delivery|exists:delivery_services,id',
            'customer_notes' => 'nullable|string'
        ]);

        $totalAmount = $request->quantity * $request->unit_price;
        $deliveryCost = 0;

        if ($request->delivery_method === 'delivery') {
            $deliveryService = DeliveryService::find($request->delivery_service);
            $deliveryCost = $deliveryService->calculateCost($request->quantity);
            $totalAmount += $deliveryCost;
        }

        // Get or create customer
        $customer = null;
        if (Auth::check()) {
            $customer = Customer::where('email', Auth::user()->email)->first();
            if (!$customer) {
                $customer = Customer::create([
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => $request->delivery_phone ?? '',
                    'address' => $request->delivery_method === 'delivery' ? 
                        $request->delivery_address . ', ' . $request->delivery_city . ', ' . $request->delivery_state . ' ' . $request->delivery_zip : '',
                    'status' => 'active'
                ]);
            }
        }

        $order = OnlineSimOrder::create([
            'customer_id' => $customer->id,
            'brand' => $request->brand,
            'sim_type' => $request->sim_type,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_amount' => $totalAmount,
            'delivery_method' => $request->delivery_method,
            'pickup_retailer_id' => $request->pickup_retailer_id,
            'delivery_address' => $request->delivery_address,
            'delivery_city' => $request->delivery_city,
            'delivery_state' => $request->delivery_state,
            'delivery_zip' => $request->delivery_zip,
            'delivery_phone' => $request->delivery_phone,
            'delivery_service' => $request->delivery_method === 'delivery' ? $request->delivery_service : null,
            'delivery_cost' => $deliveryCost,
            'customer_notes' => $request->customer_notes,
            'status' => 'pending'
        ]);

        return redirect()->route('online-sim-orders.show', $order)
            ->with('success', 'Your SIM order has been placed successfully! Order Number: ' . $order->order_number);
    }

    public function show(OnlineSimOrder $onlineSimOrder)
    {
        $onlineSimOrder->load(['customer', 'approvedBy', 'processedBy', 'pickupRetailer']);
        
        return view('online-sim-orders.show', compact('onlineSimOrder'));
    }

    public function approve(OnlineSimOrder $onlineSimOrder)
    {
        if (!$onlineSimOrder->canBeApproved()) {
            return back()->with('error', 'This order cannot be approved.');
        }

        $onlineSimOrder->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return back()->with('success', 'Order approved successfully.');
    }

    public function process(OnlineSimOrder $onlineSimOrder, Request $request)
    {
        if (!$onlineSimOrder->canBeProcessed()) {
            return back()->with('error', 'This order cannot be processed.');
        }

        $request->validate([
            'admin_notes' => 'nullable|string'
        ]);

        $onlineSimOrder->update([
            'status' => 'processing',
            'processed_by' => Auth::id(),
            'processed_at' => now(),
            'admin_notes' => $request->admin_notes
        ]);

        return back()->with('success', 'Order is now being processed.');
    }

    public function ship(OnlineSimOrder $onlineSimOrder, Request $request)
    {
        if (!$onlineSimOrder->canBeShipped()) {
            return back()->with('error', 'This order cannot be shipped.');
        }

        $request->validate([
            'tracking_number' => 'required|string|max:255',
            'delivery_service_url' => 'nullable|url',
            'estimated_delivery_date' => 'nullable|date|after:today'
        ]);

        $onlineSimOrder->update([
            'status' => 'shipped',
            'tracking_number' => $request->tracking_number,
            'delivery_service_url' => $request->delivery_service_url,
            'estimated_delivery_date' => $request->estimated_delivery_date,
            'shipped_at' => now()
        ]);

        return back()->with('success', 'Order has been shipped with tracking number: ' . $request->tracking_number);
    }

    public function markDelivered(OnlineSimOrder $onlineSimOrder)
    {
        $onlineSimOrder->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);

        return back()->with('success', 'Order marked as delivered.');
    }

    public function cancel(OnlineSimOrder $onlineSimOrder, Request $request)
    {
        if (!$onlineSimOrder->canBeCancelled()) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        $request->validate([
            'admin_notes' => 'required|string'
        ]);

        $onlineSimOrder->update([
            'status' => 'cancelled',
            'admin_notes' => $request->admin_notes
        ]);

        return back()->with('success', 'Order has been cancelled.');
    }

    public function track($orderNumber)
    {
        $order = OnlineSimOrder::where('order_number', $orderNumber)
            ->with(['customer', 'pickupRetailer'])
            ->firstOrFail();

        return view('online-sim-orders.track', compact('order'));
    }
}
