@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', ($settings['site_name'] ?? 'Rubista') . ' - ' . ($settings['site_description'] ?? 'Your Electronics Store'))</title>
    
    <!-- Favicon -->
    @if(isset($settings['favicon']) && $settings['favicon'])
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($settings['favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #7c3aed;
            --primary-dark: #6d28d9;
            --secondary-color: #f8f9fa;
            --text-color: #333;
            --border-color: #dee2e6;
            --white: #ffffff;
            --gray-100: #f8f9fa;
            --gray-600: #6c757d;
            --gray-900: #212529;
        }
        
        * {
            box-sizing: border-box;
        }
        
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--secondary-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Top Banner */
        .top-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            text-align: center;
            padding: 8px 0;
            font-size: 14px;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .top-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Main Header */
        .main-header {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-bottom: 1px solid #e9ecef;
        }

                 .header-content {
             padding: 15px 0;
         }
         
         .header-row {
             display: flex;
             align-items: center;
             justify-content: space-between;
             gap: 20px;
         }

         .brand-section {
             flex-shrink: 0;
         }

         .header-actions {
             display: flex;
             align-items: center;
             gap: 30px;
             flex-shrink: 0;
         }

        .brand-logo {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-color);
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-logo:hover {
            color: var(--primary-dark);
            text-decoration: none;
        }

        .brand-logo .com-text {
            font-weight: 400;
            font-size: 20px;
            color: var(--gray-600);
        }

        /* Search Bar */
        .header-search {
            max-width: 500px;
            flex: 1;
            margin: 0 20px;
            position: relative;
        }

        .search-form {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            width: 100%;
            padding: 12px 50px 12px 20px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .search-btn {
            position: absolute;
            right: 8px;
            background: var(--primary-color);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .search-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        /* Contact Info */
        .contact-info {
            color: var(--gray-600);
            text-align: center;
            padding: 8px 15px;
            border-radius: 8px;
            background: rgba(124, 58, 237, 0.02);
            border: 1px solid rgba(124, 58, 237, 0.1);
            transition: all 0.3s ease;
        }

        .contact-info:hover {
            background: rgba(124, 58, 237, 0.05);
            border-color: rgba(124, 58, 237, 0.2);
            transform: translateY(-1px);
        }

        .contact-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            font-weight: 600;
            color: var(--gray-600);
        }

        .contact-number {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }

        .contact-number:hover {
            color: var(--primary-dark);
            text-decoration: none;
            transform: scale(1.05);
        }

        /* User Actions */
        .user-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-action {
            position: relative;
            color: var(--gray-600);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 500;
            padding: 8px 10px;
            border-radius: 8px;
            min-width: 60px;
        }

        .user-action i {
            font-size: 22px;
            transition: all 0.3s ease;
        }

        .user-action:hover {
            color: var(--primary-color);
            text-decoration: none;
            background: rgba(124, 58, 237, 0.05);
            transform: translateY(-2px);
        }

        .user-action:hover i {
            transform: scale(1.1);
        }

        .action-badge {
            position: absolute;
            top: 2px;
            right: 8px;
            background: #dc3545;
            color: white;
            border-radius: 12px;
            padding: 3px 7px;
            font-size: 11px;
            font-weight: 700;
            min-width: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }

        .profile-action {
            background: var(--primary-color);
            color: white;
            border-radius: 8px;
            padding: 8px 15px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .profile-action:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }

        .profile-action i {
            font-size: 16px;
        }

        /* Navigation Menu */
        .main-navigation {
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 0;
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
            gap: 40px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: block;
            padding: 15px 0;
            color: var(--gray-900);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
            text-decoration: none;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--gray-900);
            font-size: 24px;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .header-row {
                flex-wrap: wrap;
            }
            
            .brand-section {
                order: 1;
            }
            
            .header-actions {
                order: 2;
            }
            
            .header-search {
                order: 3;
                width: 100%;
                margin: 15px 0;
            }
            
            .contact-info .contact-label {
                display: none;
            }
            
            .contact-info .contact-number {
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .brand-logo {
                font-size: 20px;
            }
            
            .brand-logo .com-text {
                font-size: 16px;
            }
            
            .search-input {
                padding: 10px 45px 10px 15px;
                font-size: 14px;
            }
            
            .header-actions {
                gap: 15px;
            }
            
            .user-action {
                min-width: 50px;
                padding: 6px 8px;
            }
            
            .user-action i {
                font-size: 20px;
            }
            
            .user-action span:not(.action-badge) {
                font-size: 10px;
            }
            
            .profile-action {
                padding: 6px 12px;
            }
            
            .contact-info {
                display: none;
            }
            
            .nav-menu {
                flex-direction: column;
                gap: 0;
                background: white;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                border-top: 1px solid #e9ecef;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                display: none;
            }
            
            .nav-menu.show {
                display: flex;
            }
            
            .nav-link {
                padding: 12px 20px;
                border-bottom: 1px solid #f8f9fa;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .main-navigation {
                position: relative;
            }
        }

        /* Content Styling */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .product-card {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,.15);
        }
        
        .footer {
            background: linear-gradient(135deg, #343a40, #495057);
            color: white;
            padding: 3rem 0;
            margin-top: 5rem;
        }
    </style>
    @yield('extra-css')
</head>
<body>
    <!-- Top Banner -->
    <div class="top-banner">
        <div class="container">
            <strong>Free Shipping on orders over 1000/-</strong>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="header-row">
                    <!-- Brand Logo -->
                    <div class="brand-section">
                        <a href="{{ route('frontend.home') }}" class="brand-logo">
                            RUBISTA<span class="com-text">.COM</span>
                        </a>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="header-search">
                        <form action="{{ route('frontend.search') }}" method="GET" class="search-form">
                            <input type="text" name="q" class="search-input" placeholder="Search for products..." 
                                   value="{{ request('q') }}">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Contact & User Actions -->
                    <div class="header-actions">
                        <div class="contact-info">
                            <div class="contact-label">Need Help?</div>
                            <a href="tel:+919051888500" class="contact-number">+91 90518 88500</a>
                        </div>
                        
                        <div class="user-actions">
                            <a href="#" class="user-action profile-action">
                                <i class="far fa-user"></i>
                                <span>My Profile</span>
                            </a>
                            
                            <a href="{{ route('frontend.cart') }}" class="user-action">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Cart</span>
                                <span class="action-badge">02</span>
                            </a>
                            
                            <a href="{{ route('frontend.wishlist') }}" class="user-action">
                                <i class="far fa-heart"></i>
                                <span>Wishlist</span>
                                <span class="action-badge">20</span>
                            </a>
                            
                            @guest
                                <a href="{{ route('frontend.login') }}" class="user-action profile-action">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>navaj</span>
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Menu -->
    <nav class="main-navigation">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="{{ route('frontend.home') }}" class="nav-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                            HOME
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.about') }}" class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}">
                            ABOUT US
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            BLOG
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.contact') }}" class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}">
                            CONTACT US
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            FAQS
                        </a>
                    </li>
                </ul>
                
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>{{ $settings['site_name'] ?? 'Rubista' }}</h5>
                    <p>{{ $settings['site_description'] ?? 'Your trusted electronics store' }}</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('frontend.home') }}" class="text-light">Home</a></li>
                        <li><a href="{{ route('frontend.about') }}" class="text-light">About Us</a></li>
                        <li><a href="{{ route('frontend.contact') }}" class="text-light">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <p><i class="fas fa-envelope"></i> {{ $settings['site_email'] ?? 'info@rubista.com' }}</p>
                    <p><i class="fas fa-phone"></i> {{ $settings['site_phone'] ?? '+91 90518 88500' }}</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('show');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            
            if (!navMenu.contains(event.target) && !mobileToggle.contains(event.target)) {
                navMenu.classList.remove('show');
            }
        });

        // Active nav link highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    
    @yield('extra-js')
</body>
</html> 