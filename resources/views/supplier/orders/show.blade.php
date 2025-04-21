@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                {{ __('Order') }} #{{ $order->id }}
                                <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'danger') }} ms-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </h5>
                            <small class="text-muted">
                                {{ __('Ordered on') }}: {{ $order->created_at->format('F d, Y \a\t H:i') }}
                            </small>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group">
                                <a href="{{ route('supplier.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> {{ __('Back to Orders') }}
                                </a>
                                @if($order->status === 'pending')
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#completeOrderModal">
                                    <i class="fas fa-check"></i> {{ __('Complete') }}
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                    <i class="fas fa-times"></i> {{ __('Cancel') }}
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">{{ __('Order Information') }}</h6>
                            <dl class="row mb-0">
                                <dt class="col-sm-4">{{ __('Status') }}</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'danger') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </dd>

                                <dt class="col-sm-4">{{ __('Order Date') }}</dt>
                                <dd class="col-sm-8">{{ $order->created_at->format('M d, Y H:i') }}</dd>

                                <dt class="col-sm-4">{{ __('Last Update') }}</dt>
                                <dd class="col-sm-8">{{ $order->updated_at->format('M d, Y H:i') }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">{{ __('Customer Information') }}</h6>
                            <dl class="row mb-0">
                                <dt class="col-sm-4">{{ __('Name') }}</dt>
                                <dd class="col-sm-8">{{ $order->user->name }}</dd>

                                <dt class="col-sm-4">{{ __('Email') }}</dt>
                                <dd class="col-sm-8">{{ $order->user->email }}</dd>

                                <dt class="col-sm-4">{{ __('Phone') }}</dt>
                                <dd class="col-sm-8">{{ $order->user->phone }}</dd>

                                <dt class="col-sm-4">{{ __('Location') }}</dt>
                                <dd class="col-sm-8">{{ $order->user->location }}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Product') }}</th>
                                    <th>{{ __('Unit Price') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th class="text-end">{{ __('Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($order->product->image)
                                            <img src="{{ asset('storage/' . $order->product->image) }}"
                                                alt="{{ $order->product->name }}"
                                                class="img-thumbnail me-2"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $order->product->name }}</h6>
                                                <small class="text-muted">{{ Str::limit($order->product->description, 50) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>RWF {{ number_format($order->product->price, 2) }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td class="text-end">RWF {{ number_format($order->total_price, 2) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>{{ __('Total') }}</strong></td>
                                    <td class="text-end"><strong>RWF {{ number_format($order->total_price, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($order->status === 'pending')
<!-- Complete Order Modal -->
<div class="modal fade" id="completeOrderModal" tabindex="-1" aria-labelledby="completeOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completeOrderModalLabel">{{ __('Complete Order') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to mark this order as completed?') }}</p>
                <p class="mb-0"><strong>{{ __('Order ID') }}:</strong> #{{ $order->id }}</p>
                <p class="mb-0"><strong>{{ __('Customer') }}:</strong> {{ $order->user->name }}</p>
                <p class="mb-0"><strong>{{ __('Total Amount') }}:</strong> RWF {{ number_format($order->total_price, 2) }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form action="{{ route('supplier.orders.update', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="btn btn-success">{{ __('Complete Order') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">{{ __('Cancel Order') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Are you sure you want to cancel this order?') }}</p>
                <p class="mb-0"><strong>{{ __('Order ID') }}:</strong> #{{ $order->id }}</p>
                <p class="mb-0"><strong>{{ __('Customer') }}:</strong> {{ $order->user->name }}</p>
                <p class="mb-0"><strong>{{ __('Total Amount') }}:</strong> RWF {{ number_format($order->total_price, 2) }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('supplier.orders.update', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-danger">{{ __('Cancel Order') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection