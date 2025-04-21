@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{ __('Admin Dashboard') }}</h2>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Total Users</h5>
                                    <p class="card-text display-4">{{ $totalUsers ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Cooperatives</h5>
                                    <p class="card-text display-4">{{ $totalCooperatives ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Suppliers</h5>
                                    <p class="card-text display-4">{{ $totalSuppliers ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Total Products</h5>
                                    <p class="card-text display-4">{{ $totalProducts ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Recent Users</h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($recentUsers) && $recentUsers->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Joined</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recentUsers as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ ucfirst($user->role) }}</td>
                                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <p>No recent users</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>System Statistics</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th>Total Orders</th>
                                                    <td>{{ $totalOrders ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Revenue</th>
                                                    <td>RWF {{ number_format($totalRevenue ?? 0) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Active Products</th>
                                                    <td>{{ $activeProducts ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Pending Orders</th>
                                                    <td>{{ $pendingOrders ?? 0 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection