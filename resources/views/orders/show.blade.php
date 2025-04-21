@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Order Details') }} #{{ $order->id }}</h5>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">
                        {{ __('Back to Orders') }}
                    </a>
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

                    @if($order->status === 'pending' && auth()->id() === $order->user_id)
                    <div class="mt-4 d-flex justify-content-end">
                        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('{{ __('Are you sure you want to cancel this order?') }}')">
                                {{ __('Cancel Order') }}
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
