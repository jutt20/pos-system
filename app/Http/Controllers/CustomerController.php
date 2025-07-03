<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage customers');
    }

    public function index()
    {
        $customers = Customer::with('assignedEmployee')->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('customers.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'prepaid_status' => 'required|in:prepaid,postpaid',
            'assigned_employee_id' => 'nullable|exists:employees,id',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->load('assignedEmployee', 'invoices', 'activations', 'documents');
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $employees = Employee::all();
        return view('customers.edit', compact('customer', 'employees'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'balance' => 'nullable|numeric',
            'prepaid_status' => 'required|in:prepaid,postpaid',
            'assigned_employee_id' => 'nullable|exists:employees,id',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
