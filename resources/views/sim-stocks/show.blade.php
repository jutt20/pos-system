@extends('layouts.app')

@section('title', 'SIM Stock Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">SIM Stock Details</h5>
                <a href="{{ route('sim-stocks.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $simStock->id }}</td>
                        </tr>
                        <tr>
                            <th>SIM Number</th>
                            <td>{{ $simStock->sim_number }}</td>
                        </tr>
                        <tr>
                            <th>ICCID</th>
                            <td>{{ $simStock->iccid }}</td>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <td>{{ $simStock->brand }}</td>
                        </tr>
                        <tr>
                            <th>SIM Type</th>
                            <td>{{ $simStock->sim_type }}</td>
                        </tr>
                        <tr>
                            <th>Vendor</th>
                            <td>{{ $simStock->vendor }}</td>
                        </tr>
                        <tr>
                            <th>Cost</th>
                            <td>${{ number_format($simStock->cost, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge bg-info">{{ ucfirst($simStock->status) }}</span></td>
                        </tr>
                        <tr>
                            <th>PIN 1</th>
                            <td>{{ $simStock->pin1 }}</td>
                        </tr>
                        <tr>
                            <th>PUK 1</th>
                            <td>{{ $simStock->puk1 }}</td>
                        </tr>
                        <tr>
                            <th>PIN 2</th>
                            <td>{{ $simStock->pin2 }}</td>
                        </tr>
                        <tr>
                            <th>PUK 2</th>
                            <td>{{ $simStock->puk2 }}</td>
                        </tr>
                        <tr>
                            <th>QR Activation Code</th>
                            <td>{{ $simStock->qr_activation_code }}</td>
                        </tr>
                        <tr>
                            <th>Batch ID</th>
                            <td>{{ $simStock->batch_id }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $simStock->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $simStock->updated_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-3 d-flex justify-content-end">
                    @can('manage sim stock')
                    <a href="{{ route('sim-stocks.edit', $simStock->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('sim-stocks.destroy', $simStock->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="fas fa-trash me-1"></i> Delete</button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
