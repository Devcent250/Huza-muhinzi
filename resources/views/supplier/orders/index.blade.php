@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">{{ __('Manage Orders') }}</h5>
                    <small class="text-muted">{{ __('Manage and track your product orders') }}</small>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('supplier.orders.index') }}" method="GET" class="d-flex gap-2">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="{{ __('Search orders...') }}"
                                value="{{ request('search') }}">
                            <select name="status" class="form-select" style="max-width: 150px;">
                                <option value="">{{ __('All Status') }}</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                </option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>
                                    {{ __('Completed') }}
                                </option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>
                                    {{ __('Cancelled') }}
                                </option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> {{ __('Search') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(request('search') || request('status'))
            <div class="mb-3">
                <a href="{{ route('supplier.orders.index') }}" class="btn btn-link btn-sm ps-0">
                    <i class="fas fa-times"></i> {{ __('Clear Filters') }}
                </a>
            </div>
            @endif
            @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Order ID') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Total Price') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Order Date') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                <div>{{ $order->user->name }}</div>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </td>
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>RWF {{ number_format($order->total_price, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'danger') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('supplier.orders.show', $order) }}" class="btn btn-sm btn-info">
                                        {{ __('View') }}
                                    </a>
                                    @if($order->status === 'pending')
                                    <form action="{{ route('supplier.orders.update', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-sm btn-success ms-1"
                                            onclick="return confirm('{{ __('Are you sure you want to mark this order as completed?') }}')">
                                            {{ __('Complete') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('supplier.orders.update', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn btn-sm btn-danger ms-1"
                                            onclick="return confirm('{{ __('Are you sure you want to cancel this order?') }}')">
                                            {{ __('Cancel') }}
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
            @else
            <div class="text-center py-4">
                <p class="text-muted mb-0">{{ __('No orders found.') }}</p>
            </div>
            @endif
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Order Statistics') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6 class="card-title">{{ __('Total Orders') }}</h6>
                            <h3 class="mb-0">{{ $totalOrders }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h6 class="card-title">{{ __('Pending Orders') }}</h6>
                            <h3 class="mb-0">{{ $pendingOrders }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6 class="card-title">{{ __('Completed Orders') }}</h6>
                            <h3 class="mb-0">{{ $completedOrders }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h6 class="card-title">{{ __('Cancelled Orders') }}</h6>
                            <h3 class="mb-0">{{ $cancelledOrders }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection