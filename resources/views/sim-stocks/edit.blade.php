@extends('layouts.app')

@section('title', 'Edit SIM Stock')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit SIM Stock</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sim-stocks.update', $simStock->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sim_number" class="form-label">Sim Number</label>
                                <input type="text" class="form-control @error('sim_number') is-invalid @enderror"
                                    id="sim_number" name="sim_number" value="{{ old('sim_number', $simStock->sim_number) }}" required>
                                @error('sim_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="iccid" class="form-label">ICCID</label>
                                <input type="text" class="form-control @error('iccid') is-invalid @enderror"
                                    id="iccid" name="iccid" value="{{ old('iccid', $simStock->iccid) }}" required>
                                @error('iccid')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="vendor" class="form-label">Vendor</label>
                                <input type="text" class="form-control @error('vendor') is-invalid @enderror"
                                    id="vendor" name="vendor" value="{{ old('vendor', $simStock->vendor) }}" required>
                                @error('vendor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="brand" class="form-label">Brand</label>
                                <select class="form-control @error('brand') is-invalid @enderror" name="brand" id="brand" required>
                                    <option value="">Select Brand</option>
                                    @foreach(['Verizon', 'AT&T', 'T-Mobile', 'Sprint', 'Cricket', 'Metro PCS', 'Boost Mobile', 'Other'] as $brand)
                                        <option value="{{ $brand }}" {{ old('brand', $simStock->brand) == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                    @endforeach
                                </select>
                                @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sim_type" class="form-label">SIM Type</label>
                                <select class="form-control @error('sim_type') is-invalid @enderror" name="sim_type" id="sim_type" required>
                                    <option value="">Select SIM Type</option>
                                    @foreach(['Nano SIM', 'Micro SIM', 'Standard SIM', 'eSIM', 'Triple Cut'] as $type)
                                        <option value="{{ $type }}" {{ old('sim_type', $simStock->sim_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('sim_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cost" class="form-label">Cost ($)</label>
                                <input type="number" class="form-control @error('cost') is-invalid @enderror"
                                    id="cost" name="cost" value="{{ old('cost', $simStock->cost) }}" min="0" step="0.01" required>
                                @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
                                    <option value="">Select Status</option>
                                    @foreach(['available', 'used', 'reserved', 'sold'] as $status)
                                        <option value="{{ $status }}" {{ old('status', $simStock->status) == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pin1" class="form-label">PIN 1</label>
                                <input type="text" class="form-control @error('pin1') is-invalid @enderror"
                                    id="pin1" name="pin1" value="{{ old('pin1', $simStock->pin1) }}" required>
                                @error('pin1')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="puk1" class="form-label">PUK 1</label>
                                <input type="text" class="form-control @error('puk1') is-invalid @enderror"
                                    id="puk1" name="puk1" value="{{ old('puk1', $simStock->puk1) }}" required>
                                @error('puk1')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pin2" class="form-label">PIN 2</label>
                                <input type="text" class="form-control @error('pin2') is-invalid @enderror"
                                    id="pin2" name="pin2" value="{{ old('pin2', $simStock->pin2) }}" required>
                                @error('pin2')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="puk2" class="form-label">PUK 2</label>
                                <input type="text" class="form-control @error('puk2') is-invalid @enderror"
                                    id="puk2" name="puk2" value="{{ old('puk2', $simStock->puk2) }}" required>
                                @error('puk2')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qr_activation_code" class="form-label">QR Activation Code</label>
                                <input type="text" class="form-control @error('qr_activation_code') is-invalid @enderror"
                                    id="qr_activation_code" name="qr_activation_code" value="{{ old('qr_activation_code', $simStock->qr_activation_code) }}" required>
                                @error('qr_activation_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="batch_id" class="form-label">Batch ID</label>
                                <input type="number" class="form-control @error('batch_id') is-invalid @enderror"
                                    id="batch_id" name="batch_id" value="{{ old('batch_id', $simStock->batch_id) }}" required>
                                @error('batch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('sim-stocks.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update SIM Stock</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
