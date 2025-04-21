@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $product->name }}</h4>
                    <span class="badge bg-{{ $product->status === 'available' ? 'success' : ($product->status === 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>{{ __('Product Details') }}</h5>
                            <ul class="list-unstyled">
                                <li><strong>{{ __('Category') }}:</strong> {{ $product->categoryName }}</li>
                                <li><strong>{{ __('Price') }}:</strong> RWF {{ number_format($product->price, 2) }}</li>
                                <li><strong>{{ __('Quantity') }}:</strong> {{ $product->quantity }} {{ $product->unit }}</li>
                                <li><strong>{{ __('Status') }}:</strong> {{ ucfirst($product->status) }}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>{{ __('Farmer Information') }}</h5>
                            <ul class="list-unstyled">
                                <li><strong>{{ __('Name') }}:</strong> {{ $product->farmer->name }}</li>
                                <li><strong>{{ __('Location') }}:</strong> {{ $product->farmer->location }}</li>
                                <li><strong>{{ __('Phone') }}:</strong> {{ $product->farmer->phone }}</li>
                                <li><strong>{{ __('Email') }}:</strong> {{ $product->farmer->email }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>{{ __('Description') }}</h5>
                        <p>{{ $product->description ?: __('No description provided.') }}</p>
                    </div>

                    @if($product->status === 'available')
                    <div class="d-flex justify-content-between">
                        @if(auth()->user()->id === $product->farmer_id)
                        <div>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this product?') }}')">
                                    <i class="fas fa-trash"></i> {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                        @endif

                        @if(auth()->user()->role === 'supplier')
                        <a href="{{ route('orders.create', $product) }}" class="btn btn-success">
                            <i class="fas fa-shopping-cart"></i> {{ __('Place Order') }}
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection