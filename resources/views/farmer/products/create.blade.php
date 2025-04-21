@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">{{ __('Add New Product') }}</h2>
            <a href="{{ route('farmer.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> {{ __('Back to Dashboard') }}
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('farmer.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Product Type') }}</label>
                            <select class="form-select @error('name') is-invalid @enderror"
                                id="name" name="name" required>
                                <option value="">{{ __('Select product type') }}</option>
                                <option value="irish potatoes" {{ old('name') == 'irish potatoes' ? 'selected' : '' }}>
                                    {{ __('Irish Potatoes') }}
                                </option>
                                <option value="maize" {{ old('name') == 'maize' ? 'selected' : '' }}>
                                    {{ __('Maize') }}
                                </option>
                                <option value="beans" {{ old('name') == 'beans' ? 'selected' : '' }}>
                                    {{ __('Beans') }}
                                </option>
                            </select>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                            <div class="input-group">
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    id="quantity" name="quantity" value="{{ old('quantity') }}"
                                    min="1" required>
                                <span class="input-group-text">Kg</span>
                                @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">{{ __('Price per Kg') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price') }}"
                                    min="0" step="0.01" required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Available From -->
                        <div class="mb-3">
                            <label for="available_from" class="form-label">{{ __('Available From') }}</label>
                            <input type="date" class="form-control @error('available_from') is-invalid @enderror"
                                id="available_from" name="available_from"
                                value="{{ old('available_from', date('Y-m-d')) }}" required>
                            @error('available_from')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }} ({{ __('Optional') }})</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                {{ __('Add any additional information about your product that might be helpful for buyers.') }}
                            </small>
                        </div>

                        <!-- Product Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Product Image') }} ({{ __('Optional') }})</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*">
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                {{ __('Upload a clear image of your product. Maximum size: 2MB') }}
                            </small>
                        </div>

                        <!-- Preview Image -->
                        <div class="mb-3 d-none" id="imagePreviewContainer">
                            <label class="form-label">{{ __('Image Preview') }}</label>
                            <img id="imagePreview" src="#" alt="Preview"
                                class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> {{ __('Add Product') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');

        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }

            reader.readAsDataURL(e.target.files[0]);
        } else {
            preview.src = '#';
            container.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection