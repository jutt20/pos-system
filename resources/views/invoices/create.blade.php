@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="page-header">
        <h1 class="page-title">Create New Invoice</h1>
    </div>

    <div class="content-section">
        <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <div class="form-group">
                    <label for="customer_id" class="form-label">Customer *</label>
                    <select id="customer_id" name="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="billing_date" class="form-label">Billing Date *</label>
                    <input type="date" id="billing_date" name="billing_date" class="form-control" value="{{ old('billing_date', date('Y-m-d')) }}" required>
                    @error('billing_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                    @error('due_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h3 class="section-title">Invoice Items</h3>
            
            <div id="invoice-items">
                <div class="invoice-item" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto; gap: 10px; align-items: end; margin-bottom: 15px; padding: 15px; background: #f9fafb; border-radius: 8px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Description *</label>
                        <input type="text" name="items[0][description]" class="form-control" placeholder="Item description" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Plan</label>
                        <input type="text" name="items[0][plan]" class="form-control" placeholder="Plan name">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">SKU</label>
                        <input type="text" name="items[0][sku]" class="form-control" placeholder="SKU">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Quantity *</label>
                        <input type="number" name="items[0][quantity]" class="form-control quantity" min="1" value="1" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Unit Price *</label>
                        <input type="number" step="0.01" name="items[0][unit_price]" class="form-control unit-price" min="0" required>
                    </div>
                    <div style="padding-top: 25px;">
                        <button type="button" class="btn-sm remove-item" style="background: #fee2e2; color: #991b1b;">Remove</button>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <button type="button" id="add-item" class="btn-sm">Add Item</button>
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">Notes</label>
                <textarea id="notes" name="notes" class="form-control" rows="3" placeholder="Additional notes...">{{ old('notes') }}</textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-primary">Create Invoice</button>
                <a href="{{ route('invoices.index') }}" class="btn-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
let itemIndex = 1;

document.getElementById('add-item').addEventListener('click', function() {
    const container = document.getElementById('invoice-items');
    const newItem = document.createElement('div');
    newItem.className = 'invoice-item';
    newItem.style.cssText = 'display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr auto; gap: 10px; align-items: end; margin-bottom: 15px; padding: 15px; background: #f9fafb; border-radius: 8px;';
    
    newItem.innerHTML = `
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Description *</label>
            <input type="text" name="items[${itemIndex}][description]" class="form-control" placeholder="Item description" required>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Plan</label>
            <input type="text" name="items[${itemIndex}][plan]" class="form-control" placeholder="Plan name">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">SKU</label>
            <input type="text" name="items[${itemIndex}][sku]" class="form-control" placeholder="SKU">
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Quantity *</label>
            <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" min="1" value="1" required>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label">Unit Price *</label>
            <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="form-control unit-price" min="0" required>
        </div>
        <div style="padding-top: 25px;">
            <button type="button" class="btn-sm remove-item" style="background: #fee2e2; color: #991b1b;">Remove</button>
        </div>
    `;
    
    container.appendChild(newItem);
    itemIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        const items = document.querySelectorAll('.invoice-item');
        if (items.length > 1) {
            e.target.closest('.invoice-item').remove();
        } else {
            alert('At least one item is required.');
        }
    }
});
</script>
@endsection
