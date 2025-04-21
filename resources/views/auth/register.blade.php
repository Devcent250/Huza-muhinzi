@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

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

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                            <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">{{ __('Register as') }}</label>
                            <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                                <option value="">{{ __('Select Role') }}</option>
                                <option value="farmer" {{ (old('role', $type) == 'farmer') ? 'selected' : '' }}>{{ __('Farmer') }}</option>
                                <option value="cooperative_member" {{ (old('role', $type) == 'cooperative_member') ? 'selected' : '' }}>{{ __('Cooperative Member') }}</option>
                                <option value="supplier" {{ (old('role', $type) == 'supplier') ? 'selected' : '' }}>{{ __('Supplier') }}</option>
                                <option value="admin" {{ (old('role', $type) == 'admin') ? 'selected' : '' }}>{{ __('Administrator') }}</option>
                            </select>
                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">{{ __('Location') }}</label>
                            <input id="location" type="text" class="form-control @error('location') is-invalid @enderror"
                                name="location" value="{{ old('location') }}" required
                                placeholder="{{ __('Enter your district or sector') }}">
                            @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="language" class="form-label">{{ __('Preferred Language') }}</label>
                            <select id="language" class="form-select @error('language') is-invalid @enderror" name="language" required>
                                <option value="en" {{ old('language', 'en') == 'en' ? 'selected' : '' }}>{{ __('English') }}</option>
                                <option value="rw" {{ old('language') == 'rw' ? 'selected' : '' }}>{{ __('Kinyarwanda') }}</option>
                            </select>
                            @error('language')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password">
                            <div class="form-text">{{ __('Password must be at least 8 characters.') }}</div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Register') }}
                            </button>
                        </div>

                        <div class="mb-3">
                            <div class="text-center">
                                <p class="mb-0">
                                    {{ __('Already have an account?') }}
                                    <a href="{{ route('login') }}">{{ __('Login here') }}</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection