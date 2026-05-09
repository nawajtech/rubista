@extends('frontend.layouts.app')

@section('title', 'Register - Rubista')

@section('extra-css')

<style>

.auth-register-page{
    background:#f8fafc;
    min-height:100vh;
    padding:40px 0;
}

.auth-register-page .card{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 40px rgba(0,0,0,0.08);
    overflow:hidden;
}

.auth-logo{
    width:85px;
    height:85px;
    background:linear-gradient(135deg,#4f46e5,#7c3aed);
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    color:#fff;
    font-size:34px;
    box-shadow:0 12px 25px rgba(79,70,229,0.25);
}

.auth-title{
    font-weight:700;
    color:#111827;
}

.auth-subtitle{
    color:#6b7280;
    font-size:15px;
}

.google-register-btn{
    width:100%;
    height:56px;
    border:1px solid #e5e7eb;
    border-radius:14px;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    text-decoration:none;
    color:#111827;
    font-weight:600;
    transition:0.3s ease;
    margin-bottom:20px;
}

.google-register-btn:hover{
    background:#f9fafb;
    color:#111827;
    transform:translateY(-2px);
}

.google-register-btn img{
    width:22px;
    height:22px;
}

.divider{
    position:relative;
    text-align:center;
    margin:25px 0;
}

.divider::before{
    content:'';
    position:absolute;
    width:100%;
    height:1px;
    background:#e5e7eb;
    left:0;
    top:50%;
}

.divider span{
    position:relative;
    background:#fff;
    padding:0 15px;
    color:#9ca3af;
    font-size:12px;
    letter-spacing:1px;
    font-weight:600;
}

.form-label{
    font-weight:600;
    color:#374151;
}

.form-control{
    height:50px;
    border-radius:12px;
    border:1px solid #d1d5db;
}

.form-control:focus{
    border-color:#6366f1;
    box-shadow:0 0 0 0.2rem rgba(99,102,241,0.15);
}

.btn-register{
    height:52px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#4f46e5,#7c3aed);
    color:#fff;
    font-weight:600;
    transition:0.3s ease;
}

.btn-register:hover{
    transform:translateY(-2px);
    color:#fff;
}

.auth-footer a{
    color:#4f46e5;
    font-weight:600;
    text-decoration:none;
}

.auth-footer a:hover{
    color:#4338ca;
}

.form-check-input:checked{
    background-color:#4f46e5;
    border-color:#4f46e5;
}

</style>

@endsection

@section('content')

<div class="auth-register-page">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-5">

                <div class="card">

                    <div class="card-body p-4 p-md-5">

                        <!-- Header -->
                        <div class="text-center mb-4">

                            <div class="auth-logo mb-3">
                                <i class="fas fa-user-plus"></i>
                            </div>

                            <h2 class="auth-title mb-2">
                                Join Rubista
                            </h2>

                            <p class="auth-subtitle">
                                Create your account and start exploring
                            </p>

                        </div>

                        <!-- Google Register -->
                        <a href="{{ url('/auth/google') }}" class="google-register-btn">

                            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google">

                            <span>Continue with Google</span>

                        </a>

                        <!-- Divider -->
                        <div class="divider">
                            <span>OR REGISTER WITH EMAIL</span>
                        </div>

                        <!-- Register Form -->
                        <form method="POST" action="{{ route('frontend.register') }}">

                            @csrf

                            <!-- Name -->
                            <div class="mb-3">

                                <label class="form-label">
                                    Full Name
                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter your full name"
                                       value="{{ old('name') }}"
                                       required>

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <!-- Email -->
                            <div class="mb-3">

                                <label class="form-label">
                                    Email Address
                                </label>

                                <input type="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Enter your email"
                                       value="{{ old('email') }}"
                                       required>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <!-- Password -->
                            <div class="mb-3">

                                <label class="form-label">
                                    Password
                                </label>

                                <input type="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Create password"
                                       required>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">

                                <label class="form-label">
                                    Confirm Password
                                </label>

                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       placeholder="Confirm password"
                                       required>

                            </div>

                            <!-- Terms -->
                            <div class="mb-4 form-check">

                                <input type="checkbox"
                                       class="form-check-input"
                                       id="terms"
                                       required>

                                <label class="form-check-label" for="terms">

                                    I agree to the
                                    <a href="#">Terms & Conditions</a>

                                </label>

                            </div>

                            <!-- Register Button -->
                            <button type="submit" class="btn btn-register w-100">

                                <i class="fas fa-user-plus me-2"></i>

                                Create Account

                            </button>

                        </form>

                        <!-- Footer -->
                        <div class="text-center mt-4 auth-footer">

                            <p class="mb-0">

                                Already have an account?

                                <a href="{{ route('frontend.login') }}">
                                    Sign In
                                </a>

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection