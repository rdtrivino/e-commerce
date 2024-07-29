@extends('layouts.admin')

@section('content')
    <div class="container mt-1">
        <div class="d-flex justify-content-start mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" title="Volver al Dashboard">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
        <div class="card">
            <div class="card-header text-center">
                <h1 class="mb-0">Orders</h1>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center mb-4">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">Create Order</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Order Number</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning btn-sm me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
