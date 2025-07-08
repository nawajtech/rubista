<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Rubista</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
        }
        
        .brand-section {
            color: white;
            text-align: center;
            padding: 40px;
        }
        
        .brand-logo {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .brand-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .brand-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 40px;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            text-align: left;
            max-width: 300px;
            margin: 0 auto;
        }
        
        .feature-list li {
            padding: 10px 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .feature-list i {
            margin-right: 15px;
            width: 20px;
        }
        
        .login-form-section {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 450px;
            width: 100%;
        }
        
        .login-title {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
            font-weight: 700;
            font-size: 2rem;
        }
        
        .login-subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
        }
        
        .form-control {
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .input-group-text {
            background: transparent;
            border: 2px solid #e1e5e9;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        @media (max-width: 768px) {
            .brand-section {
                display: none;
            }
            .login-form-section {
                margin: 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container">
        <div class="row w-100 justify-content-center align-items-center">
            <!-- Brand Section (Left Side) -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="brand-section">
                    <div class="brand-logo">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h1 class="brand-title">Rubista Admin</h1>
                    <p class="brand-subtitle">Complete Content Management System for Modern Business</p>
                    
                    <ul class="feature-list">
                        <li><i class="bi bi-speedometer2"></i> Dashboard Analytics</li>
                        <li><i class="bi bi-tags"></i> Category Management</li>
                        <li><i class="bi bi-box"></i> Product Management</li>
                        <li><i class="bi bi-file-text"></i> Content Management</li>
                        <li><i class="bi bi-gear"></i> System Settings</li>
                    </ul>
                </div>
            </div>
            
            <!-- Login Form Section (Right Side) -->
            <div class="col-lg-6 d-flex justify-content-center">
                <div class="login-form-section">
                    <h2 class="login-title">Welcome Back!</h2>
                    <p class="login-subtitle">Please sign in to your admin account</p>
                    
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Email Address" 
                                       required 
                                       autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       placeholder="Password" 
                                       required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="#" class="forgot-password">
                                <i class="bi bi-key"></i> Forgot Password?
                            </a>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-login w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Sign In
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Admin access only - Contact administrator for account access
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 