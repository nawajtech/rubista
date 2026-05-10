@extends('frontend.layouts.app')

@section('title', 'Add mobile number - Rubista')

@section('extra-css')
<style>
.auth-login-page .card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.auth-login-page {
    background: #f8fafc;
    min-height: 70vh;
    padding: 40px 0;
}

.auth-logo {
    width: 85px;
    height: 85px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    color: #fff;
    font-size: 34px;
    box-shadow: 0 12px 25px rgba(79, 70, 229, 0.25);
}

.auth-title {
    font-weight: 700;
    color: #111827;
}

.auth-subtitle {
    color: #6b7280;
    font-size: 15px;
}

.btn-submit-phone {
    width: 100%;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border: none;
    color: #fff;
    font-weight: 600;
    transition: 0.3s ease;
}

.btn-submit-phone:hover {
    filter: brightness(1.05);
    color: #fff;
}
</style>
@endsection

@section('content')
<div class="auth-login-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="auth-logo mb-3">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h2 class="auth-title h4 mb-2">Add your mobile number</h2>
                            <p class="auth-subtitle mb-0">
                                We need a valid 10-digit mobile number to reach you about orders and updates. This step is required once.
                            </p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success small">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('frontend.phone.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="phone">Mobile number</label>
                                <input type="tel"
                                       name="phone"
                                       id="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="10-digit mobile (e.g. 9876543210)"
                                       value="{{ old('phone') }}"
                                       inputmode="numeric"
                                       maxlength="10"
                                       pattern="[0-9]{10}"
                                       autocomplete="tel"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-submit-phone w-100">
                                <i class="fas fa-check me-2"></i>
                                Save and continue
                            </button>
                        </form>

                        <form method="POST" action="{{ route('frontend.logout') }}" class="mt-3 text-center">
                            @csrf
                            <button type="submit" class="btn btn-link btn-sm text-muted p-0">Sign out instead</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
