@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <div class="mt-4">
                        @if(auth()->user()->role === 'cooperative_member')
                        <a href="{{ route('cooperative.dashboard') }}" class="btn btn-primary">
                            Go to Cooperative Dashboard
                        </a>
                        @elseif(auth()->user()->role === 'supplier')
                        <a href="{{ route('supplier.dashboard') }}" class="btn btn-primary">
                            Go to Supplier Dashboard
                        </a>
                        @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            Go to Admin Dashboard
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection