@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">{{ __('Available Products') }}</h2>
            <a href="{{ route('supplier.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> {{ __('Back to Dashboard') }}
            </a>
        </div>

        <div class="card-body">
            <!-- Search and Filter -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('supplier.products.browse') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2"
                            placeholder="{{ __('Search products...') }}"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <select name="product_type" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ __('All Products') }}</option>
                        <option value="irish_potatoes" {{ request('product_type') == 'irish_potatoes' ? 'selected' : '' }}>
                            {{ __('Irish Potatoes') }}
                        </option>
                        <option value="maize" {{ request('product_type') == 'maize' ? 'selected' : '' }}>
                            {{ __('Maize') }}
                        </option>
                        <option value="beans" {{ request('product_type') == 'beans' ? 'selected' : '' }}>
                            {{ __('Beans') }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse ($products as $product)
                <div class="col">
                    <div class="card h-100">
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
                            <a href="{{ route('supplier.requests.create', $product) }}"
                                class="btn btn-primary">
                                <i class="bi bi-cart-plus"></i> {{ __('Make Request') }}
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        {{ __('No products available at the moment.') }}
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection