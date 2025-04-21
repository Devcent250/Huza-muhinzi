@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ __('Farmer Dashboard') }}</h1>

    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">{{ __('My Products') }}</h6>
                            <h2 class="mb-0">{{ $totalProducts ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-seedling fa-2x opacity-75"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('farmer.products.index') }}">{{ __('View Details') }}</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">{{ __('Total Orders') }}</h6>
                            <h2 class="mb-0">{{ $totalOrders ?? 0 }}</h2>
                        </div>
                        <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('farmer.orders.index') }}">{{ __('View Details') }}</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Quick Actions') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('farmer.products.create') }}" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-plus-circle me-2"></i>{{ __('Add New Product') }}
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('farmer.orders.index') }}" class="btn btn-info w-100 mb-3">
                                <i class="fas fa-list me-2"></i>{{ __('View Orders') }}
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-secondary w-100 mb-3">
                                <i class="fas fa-user-edit me-2"></i>{{ __('Edit Profile') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Farmer Information -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Farmer Information') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>{{ __('Location') }}:</strong> {{ auth()->user()->location }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>{{ __('Contact Person') }}:</strong> {{ auth()->user()->name }}</p>
                            <p><strong>{{ __('Email') }}:</strong> {{ auth()->user()->email }}</p>
                            <p><strong>{{ __('Phone') }}:</strong> {{ auth()->user()->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Recent Activity') }}
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ __('Your recent activity will appear here.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush