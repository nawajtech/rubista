@extends('frontend.layouts.app')

@section('title', 'Login - Rubista')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card mt-5">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-laptop fa-3x text-primary mb-3"></i>
                        <h3>Welcome Back</h3>
                        <p class="text-muted">Sign in to your account</p>
                    </div>
                    
                    <form method="POST" action="{{ route('frontend.login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p class="mb-0">Don't have an account? 
                            <a href="{{ route('frontend.register') }}" class="text-decoration-none">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 