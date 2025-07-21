<?php

namespace App\Http\Controllers;

use App\Models\SimOrder;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\SimOrdersExport;
use App\Models\DeliveryService;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $deliveryServices = DeliveryService::all();

        return view('sim-orders.create', compact('customers', 'deliveryServices'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',
                'brand' => 'required|string|max:255',
                'sim_type' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'unit_cost' => 'required|numeric|min:0',
                'vendor' => 'required|string|max:255',
                'order_type' => 'required|in:pickup,delivery',
                'delivery_service_id' => 'nullable|exists:delivery_services,id',
                'delivery_cost' => 'nullable|numeric|min:0',
                'delivery_address' => 'nullable|string|max:255',
                'delivery_city' => 'nullable|string|max:255',
                'delivery_state' => 'nullable|string|max:255',
                'delivery_zip' => 'nullable|string|max:255',
                'delivery_phone' => 'nullable|string|max:255',
                'tracking_number' => 'nullable|string|max:255',
                'order_date' => 'nullable|date',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            if ($request->order_type === 'delivery') {
                $validator = Validator::make($request->all(), [
                    'delivery_service_id' => 'required|exists:delivery_services,id',
                    'delivery_address' => 'required|string|max:255',
                    'delivery_city' => 'required|string|max:255',
                    'delivery_state' => 'required|string|max:255',
                    'delivery_zip' => 'required|string|max:255',
                    'delivery_phone' => 'required|string|max:255',
                    'delivery_cost' => 'required|numeric|min:0',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }

            $totalCost = ($request->quantity * $request->unit_cost) + ($request->delivery_cost ?? 0);

            $order = SimOrder::create([
                'customer_id' => $request->customer_id,
                'employee_id' => Auth::id(),
                'brand' => $request->brand,
                'sim_type' => $request->sim_type,
                'quantity' => $request->quantity,
                'unit_cost' => $request->unit_cost,
                'total_cost' => $totalCost,
                'vendor' => $request->vendor,
                'order_type' => $request->order_type,
                'delivery_service_id' => $request->delivery_service_id,
                'delivery_address' => $request->delivery_address,
                'delivery_city' => $request->delivery_city,
                'delivery_state' => $request->delivery_state,
                'delivery_zip' => $request->delivery_zip,
                'delivery_phone' => $request->delivery_phone,
                'delivery_cost' => $request->delivery_cost ?? 0,
                'tracking_number' => $request->tracking_number,
                'order_date' => $request->order_date ?? now(),
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            $pdf = PDF::loadView('invoices.sim-order', ['order' => $order]);
            $fileName = 'invoices/sim-order-' . $order->id . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());

            return redirect()->route('sim-orders.index')
                ->with('success', 'SIM order created and invoice generated successfully.');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function show(SimOrder $simOrder)
    {
        $simOrder->load(['customer', 'employee']);
        return view('sim-orders.show', compact('simOrder'));
    }

    public function edit(SimOrder $simOrder)
    {
        $customers = Customer::where('status', 'active')->get();
        $deliveryServices = DeliveryService::all();
        return view('sim-orders.edit', compact('simOrder', 'customers', 'deliveryServices'));
    }

    public function update(Request $request, SimOrder $simOrder)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,delivered,cancelled,shipped,processing',
            'tracking_number' => 'nullable|string|max:255',
            'delivery_service_id' => 'nullable|exists:delivery_services,id',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $totalCost = $request->quantity * $request->unit_cost;

        $simOrder->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number,
            'delivery_service_id' => $request->delivery_service_id,
            'notes' => $request->notes
        ]);

        $fileName = 'invoices/sim-order-' . $simOrder->id . '.pdf';
        if (Storage::disk('public')->exists($fileName)) {
            Storage::disk('public')->delete($fileName);
        }

        $pdf = PDF::loadView('invoices.sim-order', ['order' => $simOrder]);
        Storage::disk('public')->put($fileName, $pdf->output());

        return redirect()->route('sim-orders.index')
            ->with('success', 'SIM order updated and new invoice generated successfully.');
    }

    public function destroy(SimOrder $simOrder)
    {
        $simOrder->delete();
        return redirect()->route('sim-orders.index')
            ->with('success', 'SIM order deleted successfully.');
    }

    public function export()
    {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        return Excel::download(new SimOrdersExport, 'sim-orders-' . $timestamp . '.xlsx');
    }
}
