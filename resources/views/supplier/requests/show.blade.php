@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">{{ __('Request Details') }}</h2>
                <p class="text-muted mb-0">
                    {{ __('Request') }} #{{ $order->id }} -
                    <span class="badge bg-{{ $order->status_color }}">{{ __(ucfirst($order->status)) }}</span>
                </p>
            </div>
            <a href="{{ route('supplier.requests.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> {{ __('Back to Requests') }}
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Product Details -->
                <div class="col-md-4">
                    <div class="card">
                        @if($order->product->image)
                        <img src="{{ asset('storage/' . $order->product->image) }}"
                            class="card-img-top" alt="{{ $order->product->name }}"
                            style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $order->product->name }}</h5>
                            <p class="card-text">
                                <strong>{{ __('Type') }}:</strong> {{ __(ucfirst(str_replace('_', ' ', $order->product->type))) }}<br>
                                <strong>{{ __('Unit Price') }}:</strong> ${{ number_format($order->unit_price, 2) }}<br>
                                <strong>{{ __('Quantity') }}:</strong> {{ $order->quantity }} {{ $order->product->unit }}<br>
                                <strong>{{ __('Total Price') }}:</strong> ${{ number_format($order->total_price, 2) }}<br>
                                <strong>{{ __('Farmer') }}:</strong> {{ $order->product->user->name }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Request Details -->
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Request Information') }}</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>{{ __('Request Date') }}:</strong><br>
                                        {{ $order->created_at->format('F j, Y g:i A') }}
                                    </p>
                                    <p><strong>{{ __('Last Updated') }}:</strong><br>
                                        {{ $order->updated_at->format('F j, Y g:i A') }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>{{ __('Status') }}:</strong><br>
                                        <span class="badge bg-{{ $order->status_color }}">
                                            {{ __(ucfirst($order->status)) }}
                                        </span>
                                    </p>
                                    @if($order->status === 'completed')
                                    <p><strong>{{ __('Completed Date') }}:</strong><br>
                                        {{ $order->completed_at?->format('F j, Y g:i A') }}
                                    </p>
                                    @elseif($order->status === 'cancelled')
                                    <p><strong>{{ __('Cancelled Date') }}:</strong><br>
                                        {{ $order->cancelled_at?->format('F j, Y g:i A') }}
                                    </p>
                                    @endif
                                </div>
                            </div>

                            @if($order->message)
                            <div class="mt-3">
                                <h6>{{ __('Message to Farmer') }}:</h6>
                                <p class="mb-0">{{ $order->message }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Updates -->
                    @if($order->status === 'pending')
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Actions') }}</h5>
                            <p class="text-muted">
                                {{ __('Your request is pending approval from the farmer.') }}
                            </p>
                            <form action="{{ route('supplier.requests.cancel', $order) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('{{ __('Are you sure you want to cancel this request?') }}')">
                                    <i class="bi bi-x-circle"></i> {{ __('Cancel Request') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection