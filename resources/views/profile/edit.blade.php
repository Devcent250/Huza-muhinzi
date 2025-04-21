@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profile') }}</div>

                <div class="card-body">
                    @if(session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ __('Profile updated successfully.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('Phone') }}</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(auth()->user()->role !== 'admin')
                        <div class="mb-3">
                            <label for="company_name" class="form-label">{{ __('Company/Cooperative Name') }}</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', auth()->user()->company_name) }}">
                            @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="business_type" class="form-label">{{ __('Business Type') }}</label>
                            <input type="text" class="form-control @error('business_type') is-invalid @enderror" id="business_type" name="business_type" value="{{ old('business_type', auth()->user()->business_type) }}">
                            @error('business_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">{{ __('Location') }}</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', auth()->user()->location) }}">
                            @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('sms_notifications') is-invalid @enderror" id="sms_notifications" name="sms_notifications" value="1" {{ old('sms_notifications', auth()->user()->sms_notifications) ? 'checked' : '' }}>
                                <label class="form-check-label" for="sms_notifications">{{ __('Receive SMS Notifications') }}</label>
                                @error('sms_notifications')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="language" class="form-label">{{ __('Preferred Language') }}</label>
                            <select class="form-select @error('language') is-invalid @enderror" id="language" name="language">
                                <option value="en" {{ old('language', auth()->user()->language) === 'en' ? 'selected' : '' }}>English</option>
                                <option value="rw" {{ old('language', auth()->user()->language) === 'rw' ? 'selected' : '' }}>Kinyarwanda</option>
                            </select>
                            @error('language')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="card mt-4">
                        <div class="card-header text-white bg-danger">{{ __('Delete Account') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('{{ __('Are you sure you want to delete your account? This action cannot be undone.') }}');">
                                @csrf
                                @method('DELETE')

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Current Password') }}</label>
                                    <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" id="password" name="password" required>
                                    @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection