@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Add New Product') }}</h5>
                    <a href="{{ route('supplier.products') }}" class="btn btn-secondary btn-sm">
                        {{ __('Back to Products') }}
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Product Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">{{ __('Category') }}</label>
                            <select id="category" class="form-select @error('category') is-invalid @enderror"
                                name="category" required>
                                <option value="">{{ __('Select Category') }}</option>
                                <option value="Seeds" {{ old('category') == 'Seeds' ? 'selected' : '' }}>
                                    {{ __('Seeds') }}
                                </option>
                                <option value="Fertilizers" {{ old('category') == 'Fertilizers' ? 'selected' : '' }}>
                                    {{ __('Fertilizers') }}
                                </option>
                                <option value="Pesticides" {{ old('category') == 'Pesticides' ? 'selected' : '' }}>
                                    {{ __('Pesticides') }}
                                </option>
                                <option value="Equipment" {{ old('category') == 'Equipment' ? 'selected' : '' }}>
                                    {{ __('Equipment') }}
                                </option>
                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>
                                    {{ __('Other') }}
                                </option>
                            </select>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">{{ __('Price') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">RWF</span>
                                        <input id="price" type="number" step="0.01" min="0"
                                            class="form-control @error('price') is-invalid @enderror"
                                            name="price" value="{{ old('price') }}" required>
                                    </div>
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                                    <input id="quantity" type="number" min="0"
                                        class="form-control @error('quantity') is-invalid @enderror"
                                        name="quantity" value="{{ old('quantity') }}" required>
                                    @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Add Product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 500;
    }
</style>
@endpush