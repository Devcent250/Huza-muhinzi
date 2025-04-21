@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Place Order') }}</div>

                <div class="card-body">
                    <div class="mb-4">
                        <h5>{{ __('Product Details') }}</h5>
                        <div class="row">
                            <div class="col-md-4">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                                @else
                                <div class="bg-light rounded p-3 text-center">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h4>{{ $product->name }}</h4>
                                <p class="text-muted">{{ $product->description }}</p>
                                <p class="h5">{{ __('Price') }}: RWF {{ number_format($product->price, 2) }}</p>
                                <p>{{ __('Available Quantity') }}: {{ $product->quantity }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('orders.store', $product) }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-3">
                            <label for="quantity" class="form-label">{{ __('Order Quantity') }}</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" value="{{ old('quantity', 1) }}"
                                min="1" max="{{ $product->quantity }}" required>
                            @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">{{ __('Maximum available quantity') }}: {{ $product->quantity }}</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">{{ __('Total Price') }}</label>
                            <div class="h4" id="totalPrice">RWF {{ number_format($product->price, 2) }}</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Place Order') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pass the price value safely from PHP to JavaScript
        var price = parseFloat("{{ $product->price }}");
        var quantityInput = document.getElementById('quantity');
        var totalPriceElement = document.getElementById('totalPrice');

        function updateTotalPrice() {
            var quantity = parseInt(quantityInput.value) || 0;
            var total = quantity * price;
            totalPriceElement.textContent = 'RWF ' + total.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        quantityInput.addEventListener('input', updateTotalPrice);
        updateTotalPrice(); // Initialize total price
    });
</script>
@endpush
@endsection
