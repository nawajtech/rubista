@extends('frontend.layouts.frontend')

@section('title', 'Register')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h2 class="mb-4 text-center">Create an Account</h2>
        <form>
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <div class="mt-3 text-center">
                <a href="login">Already have an account? Login</a>
            </div>
        </form>
    </div>
</div>
@endsection 