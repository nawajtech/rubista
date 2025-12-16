@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel - ' . ($settings['site_name'] ?? 'Rubista'))</title>

    <!-- Favicon -->
    @if(isset($settings['favicon']) && $settings['favicon'])
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($settings['favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: {{ $settings['admin_primary_color'] ?? '#667eea' }};
            --primary-dark: {{ $settings['admin_secondary_color'] ?? '#5a67d8' }};
            --sidebar-bg: {{ $settings['admin_sidebar_color'] ?? '#1a202c' }};
            --sidebar-hover: {{ $settings['admin_sidebar_hover_color'] ?? '#2d3748' }};
            --text-light: #a0aec0;
            --text-white: #ffffff;
            --border-color: #e2e8f0;
            --admin-text-color: {{ $settings['admin_text_color'] ?? '#2d3748' }};
            --admin-bg-color: {{ $settings['admin_background_color'] ?? '#f7fafc' }};
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--admin-bg-color);
            color: var(--admin-text-color);
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #2d3748 100%);
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid #4a5568;
            text-align: center;
        }

        .sidebar-brand h3 {
            color: var(--text-white);
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }

        .sidebar-brand p {
            color: var(--text-light);
            font-size: 0.875rem;
            margin: 0.25rem 0 0 0;
        }

        .sidebar-brand img {
            max-height: 40px;
            max-width: 200px;
            object-fit: contain;
        }

        .sidebar-nav {
            padding: 1rem 0;
            height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            padding: 0 1.5rem;
            color: var(--text-light);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            background: none;
            position: relative;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: var(--text-white);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            color: var(--text-white);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            border-radius: 0 25px 25px 0;
            margin-right: 1rem;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--text-white);
            border-radius: 0 4px 4px 0;
        }

        .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.125rem;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .top-navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--admin-text-color);
            margin: 0;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .main-content {
            padding: 2rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block;
            }
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--admin-text-color);
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
        }

        /* Card Enhancements */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        /* Scrollbar */
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #4a5568;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            @if(isset($settings['logo']) && $settings['logo'])
                <img src="{{ Storage::url($settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Rubista' }}" class="mb-2">
            @else
                <h3><i class="bi bi-shield-check"></i> {{ $settings['site_name'] ?? 'Rubista' }}</h3>
            @endif
            <p>Admin Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Content Management</div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                       href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tags"></i>
                        <span>Categories</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                       href="{{ route('admin.products.index') }}">
                        <i class="bi bi-box"></i>
                        <span>Products</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}" 
                       href="{{ route('admin.cms.index') }}">
                        <i class="bi bi-file-text"></i>
                        <span>CMS Pages</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.homepage-content.*') ? 'active' : '' }}" 
                       href="{{ route('admin.homepage-content.index') }}">
                        <i class="bi bi-house-gear"></i>
                        <span>Homepage Content</span>
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Sales & Customers</div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-bag"></i>
                        <span>Orders</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" 
                       href="{{ route('admin.customers.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Customers</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" 
                       href="{{ route('admin.reviews.index') }}">
                        <i class="bi bi-star"></i>
                        <span>Reviews & Ratings</span>
                    </a>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">System</div>
                <div class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
                       href="{{ route('admin.settings.index') }}">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-btn me-3" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title">@yield('page-title', 'Admin Panel')</h1>
            </div>
            
            <div class="user-menu">
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle d-flex align-items-center" 
                            type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar me-2">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="text-dark fw-medium">{{ auth()->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                                                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i> Please fix the following errors:
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Auto-hide alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @yield('scripts')
</body>
</html> 