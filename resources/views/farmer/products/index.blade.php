@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">{{ __('My Products') }}</h2>
                <p class="text-muted mb-0">{{ __('Manage your agricultural products') }}</p>
            </div>
            <a href="{{ route('farmer.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> {{ __('Add New Product') }}
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Available From') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}" class="me-2"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                    @endif
                                    <div>
                                        <strong>{{ __(ucfirst($product->name)) }}</strong>
                                        @if($product->description)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->quantity }} {{ $product->unit }}</td>
                            <td>${{ number_format($product->price, 2) }}/{{ $product->unit }}</td>
                            <td>
                                <span class="badge bg-{{ $product->status === 'available' ? 'success' : 'warning' }}">
                                    {{ __(ucfirst($product->status)) }}
                                </span>
                            </td>
                            <td>{{ $product->available_from->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('farmer.products.edit', $product) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('farmer.products.destroy', $product) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                    <p class="mb-0 mt-2">{{ __('No products added yet') }}</p>
                                    <a href="{{ route('farmer.products.create') }}" class="btn btn-primary mt-3">
                                        {{ __('Add Your First Product') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection