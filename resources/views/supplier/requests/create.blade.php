@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">{{ __('Make Request') }}</h2>
            <a href="{{ route('supplier.products.browse') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> {{ __('Back to Products') }}
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Product Details -->
                <div class="col-md-4">
                    <div class="card">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                            class="card-img-top" alt="{{ $product->name }}"
                            style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">
                                <strong>{{ __('Type') }}:</strong> {{ __(ucfirst(str_replace('_', ' ', $product->type))) }}<br>
                                <strong>{{ __('Price') }}:</strong> ${{ number_format($product->price, 2) }}<br>
                                <strong>{{ __('Quantity Available') }}:</strong> {{ $product->quantity }} {{ $product->unit }}<br>
                                <strong>{{ __('Farmer') }}:</strong> {{ $product->user->name }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Request Form -->
                <div class="col-md-8">
                    <form action="{{ route('supplier.requests.store', $product) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="quantity" class="form-label">{{ __('Quantity Required') }}</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    id="quantity" name="quantity" min="1" max="{{ $product->quantity }}"
                                    value="{{ old('quantity', 1) }}" required>
                                <span class="input-group-text">{{ $product->unit }}</span>
                                @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                {{ __('Maximum available') }}: {{ $product->quantity }} {{ $product->unit }}
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">{{ __('Message to Farmer') }} ({{ __('Optional') }})</label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                id="message" name="message" rows="3">{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price Calculation -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('Order Summary') }}</h5>
                                <div class="d-flex justify-content-between">
                                    <span>{{ __('Unit Price') }}:</span>
                                    <span>${{ number_format($product->price, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>{{ __('Total Price') }}:</span>
                                    <span id="totalPrice">${{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> {{ __('Submit Request') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('quantity').addEventListener('input', function() {
        const quantity = this.value;
        const unitPrice = {
            {
                $product - > price
            }
        };
        const total = quantity * unitPrice;
        document.getElementById('totalPrice').textContent = '$' + total.toFixed(2);
    });
</script>
@endpush
@endsection