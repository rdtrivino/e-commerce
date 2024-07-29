@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h1 class="mb-0">Edit Order</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="order_number" class="form-label">Order Number</label>
                        <input type="text" name="order_number" id="order_number" class="form-control"
                            value="{{ $order->order_number }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="number" name="total" id="total" class="form-control" value="{{ $order->total }}"
                            required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" name="status" id="status" class="form-control"
                            value="{{ $order->status }}" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Orders
                        </a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Orders
                </a>
            </div>
        </div>
    </div>
@endsection
