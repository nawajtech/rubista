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

        /* Custom Container for Header */
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Top Banner */
        .top-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            text-align: center;
            padding: 6px 0;
            font-size: 13px;
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
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            border-bottom: 1px solid rgba(124, 58, 237, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .header-content {
            padding: 12px 0;
        }
        
        .header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .brand-section {
            flex-shrink: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 25px;
            flex-shrink: 0;
        }

        .brand-logo {
            font-size: 26px;
            font-weight: 800;
            color: var(--primary-color);
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            position: relative;
        }

        .brand-logo::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            transition: width 0.3s ease;
        }

        .brand-logo:hover::before {
            width: 100%;
        }

        .brand-logo:hover {
            color: var(--primary-dark);
            text-decoration: none;
            transform: scale(1.02);
        }

        .brand-logo .com-text {
            font-weight: 400;
            font-size: 18px;
            color: var(--gray-600);
        }

        /* Search Bar */
        .header-search {
            max-width: 450px;
            flex: 1;
            margin: 0 15px;
            position: relative;
        }

        .search-form {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            width: 100%;
            padding: 10px 45px 10px 18px;
            border: 2px solid #e9ecef;
            border-radius: 22px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: rgba(248, 249, 250, 0.8);
            backdrop-filter: blur(5px);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.08);
            transform: translateY(-1px);
        }

        .search-btn {
            position: absolute;
            right: 6px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(124, 58, 237, 0.2);
        }

        .search-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        /* Contact Info */
        .contact-info {
            color: var(--gray-600);
            text-align: center;
            padding: 6px 12px;
            border-radius: 8px;
            background: rgba(124, 58, 237, 0.03);
            border: 1px solid rgba(124, 58, 237, 0.1);
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .contact-info:hover {
            background: rgba(124, 58, 237, 0.08);
            border-color: rgba(124, 58, 237, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.1);
        }

        .contact-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            font-weight: 600;
            color: var(--gray-600);
        }

        .contact-number {
            font-size: 14px;
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
            gap: 15px;
        }

        .user-action {
            position: relative;
            color: var(--gray-600);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            font-size: 11px;
            font-weight: 500;
            padding: 6px 8px;
            border-radius: 8px;
            min-width: 55px;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(5px);
        }

        .user-action i {
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .user-action:hover {
            color: var(--primary-color);
            text-decoration: none;
            background: rgba(124, 58, 237, 0.08);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.1);
        }

        .user-action:hover i {
            transform: scale(1.1);
        }

        .action-badge {
            position: absolute;
            top: 0;
            right: 6px;
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border-radius: 12px;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: 700;
            min-width: 18px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .profile-action {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 8px;
            padding: 6px 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(124, 58, 237, 0.2);
        }

        .profile-action:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.3);
        }

        .profile-action i {
            font-size: 16px;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            border: 1px solid rgba(124, 58, 237, 0.1);
            overflow: hidden;
        }

        .profile-dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .profile-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: var(--gray-900);
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid #f8f9fa;
        }

        .profile-dropdown-item:last-child {
            border-bottom: none;
        }

        .profile-dropdown-item:hover {
            background: rgba(124, 58, 237, 0.08);
            color: var(--primary-color);
            text-decoration: none;
        }

        .profile-dropdown-item i {
            width: 20px;
            text-align: center;
            color: var(--primary-color);
        }

        .profile-dropdown-item.logout-item {
            color: #dc3545;
        }

        .profile-dropdown-item.logout-item:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .profile-dropdown-item.logout-item i {
            color: #dc3545;
        }

        .profile-user-info {
            padding: 12px 18px;
            border-bottom: 1px solid #f8f9fa;
            background: rgba(124, 58, 237, 0.05);
        }

        .profile-user-name {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 14px;
            margin-bottom: 2px;
        }

        .profile-user-email {
            font-size: 12px;
            color: var(--gray-600);
        }

        /* Navigation Menu */
        .main-navigation {
            background: rgba(255, 255, 255, 0.95);
            border-top: 1px solid rgba(233, 236, 239, 0.8);
            padding: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            backdrop-filter: blur(10px);
        }

        .nav-menu {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
            gap: 35px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: block;
            padding: 12px 0;
            color: var(--gray-900);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
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
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
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
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(124, 58, 237, 0.2);
            color: var(--gray-900);
            font-size: 22px;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .mobile-menu-toggle:hover {
            background: rgba(124, 58, 237, 0.1);
            color: var(--primary-color);
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .header-row {
                flex-wrap: wrap;
                gap: 12px;
            }
            
            .brand-section {
                order: 1;
            }
            
            .header-actions {
                order: 2;
                gap: 20px;
            }
            
            .header-search {
                order: 3;
                width: 100%;
                margin: 12px 0;
                max-width: 100%;
            }
            
            .contact-info .contact-label {
                display: none;
            }
            
            .contact-info .contact-number {
                font-size: 12px;
            }
            
            .contact-info {
                padding: 4px 8px;
            }
            
            .user-actions {
                gap: 12px;
            }
            
            .user-action {
                min-width: 50px;
                padding: 5px 6px;
            }
            
            .nav-menu {
                gap: 25px;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                padding: 10px 0;
            }
            
            .brand-logo {
                font-size: 22px;
            }
            
            .brand-logo .com-text {
                font-size: 16px;
            }
            
            .search-input {
                padding: 8px 40px 8px 15px;
                font-size: 14px;
            }
            
            .search-btn {
                width: 28px;
                height: 28px;
                right: 5px;
            }
            
            .header-actions {
                gap: 15px;
            }
            
            .user-action {
                min-width: 45px;
                padding: 4px 5px;
            }
            
            .user-action i {
                font-size: 18px;
            }
            
            .user-action span:not(.action-badge) {
                font-size: 9px;
            }
            
            .profile-action {
                padding: 4px 8px;
            }
            
            .profile-action i {
                font-size: 14px;
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
                padding: 10px 20px;
                border-bottom: 1px solid #f8f9fa;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .main-navigation {
                position: relative;
            }
        }

        @media (max-width: 576px) {
            .header-content {
                padding: 8px 0;
            }
            
            .brand-logo {
                font-size: 20px;
            }
            
            .brand-logo .com-text {
                font-size: 14px;
            }
            
            .header-row {
                gap: 8px;
            }
            
            .header-actions {
                gap: 10px;
            }
            
            .user-action {
                min-width: 40px;
                padding: 3px 4px;
            }
            
            .user-action i {
                font-size: 16px;
            }
            
            .user-action span:not(.action-badge) {
                font-size: 8px;
            }
            
            .profile-action {
                padding: 3px 6px;
            }
            
            .action-badge {
                font-size: 8px;
                padding: 1px 4px;
                min-width: 15px;
            }
            
            .nav-link {
                padding: 8px 15px;
                font-size: 13px;
            }
            
            .search-input {
                padding: 6px 35px 6px 12px;
                font-size: 13px;
            }
            
            .search-btn {
                width: 25px;
                height: 25px;
                right: 4px;
            }
            
            .mobile-menu-toggle {
                font-size: 20px;
                padding: 6px;
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
        
        /* Modern Footer Styles */
        .footer {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
            color: white;
            padding: 0;
            margin-top: 5rem;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(124, 58, 237, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(168, 85, 247, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .footer-main {
            padding: 4rem 0 2rem;
            position: relative;
            z-index: 2;
        }

        .footer-brand {
            margin-bottom: 2rem;
        }

        .footer-logo {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-logo:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        .footer-tagline {
            font-size: 1.1rem;
            color: #b0b0b0;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .footer-section h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
            position: relative;
            display: inline-block;
        }

        .footer-section h5::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, #7c3aed, #a855f7);
            border-radius: 2px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #b0b0b0;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
        }

        .footer-links a:hover {
            color: #7c3aed;
            transform: translateX(5px);
        }

        .footer-links a::before {
            content: '';
            position: absolute;
            left: -15px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 2px;
            background: #7c3aed;
            transition: width 0.3s ease;
        }

        .footer-links a:hover::before {
            width: 10px;
        }

        .contact-list {
            margin-top: 1rem;
        }

        .contact-list-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
        }

        .contact-list-item:last-child {
            margin-bottom: 0;
        }

        .contact-list-item:hover {
            transform: translateX(5px);
        }

        .contact-list-item i {
            width: 20px;
            color: #7c3aed;
            font-size: 0.9rem;
            margin-right: 0.8rem;
            flex-shrink: 0;
        }

        .contact-list-item span {
            color: #b0b0b0;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-link {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .social-link:hover {
            background: #7c3aed;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(124, 58, 237, 0.4);
            color: white;
        }

        .social-link.facebook:hover { background: #1877f2; }
        .social-link.twitter:hover { background: #1da1f2; }
        .social-link.instagram:hover { background: #e4405f; }
        .social-link.youtube:hover { background: #ff0000; }
        .social-link.linkedin:hover { background: #0077b5; }

        .newsletter-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .newsletter-form {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .newsletter-input {
            flex: 1;
            padding: 0.8rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 0.95rem;
            backdrop-filter: blur(10px);
        }

        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .newsletter-input:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.2);
        }

        .newsletter-btn {
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            border: none;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .newsletter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(124, 58, 237, 0.4);
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.3);
            padding: 1.5rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 2;
        }

        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .copyright {
            color: #b0b0b0;
            font-size: 0.9rem;
        }

        .footer-bottom-links {
            display: flex;
            gap: 2rem;
        }

        .footer-bottom-links a {
            color: #b0b0b0;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: #7c3aed;
        }

        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
        }

        .scroll-top.show {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(124, 58, 237, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-main {
                padding: 3rem 0 1.5rem;
            }
            
            .footer-brand {
                text-align: center;
                margin-bottom: 2rem;
            }
            
            .footer-section {
                text-align: center;
                margin-bottom: 2rem;
            }
            
            .social-links {
                justify-content: center;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .newsletter-btn {
                align-self: center;
                min-width: 150px;
            }
            
            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-bottom-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .contact-list-item {
                margin-bottom: 0.6rem;
            }
            
            .contact-list-item i {
                font-size: 0.8rem;
                margin-right: 0.6rem;
            }
            
            .contact-list-item span {
                font-size: 0.8rem;
            }
        }
    </style>
    @yield('extra-css')
</head>
<body>
    <!-- Top Banner -->
    <div class="top-banner">
        <div class="container">
            <strong>
                @if(isset($settings['free_shipping_threshold']) && $settings['free_shipping_threshold'] > 0)
                    Free Shipping on orders over ₹{{ number_format($settings['free_shipping_threshold'], 0) }}/-
                @else
                    Free Shipping Available
                @endif
            </strong>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="header-container">
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
                        @if(isset($settings['site_phone']) && $settings['site_phone'])
                        <div class="contact-info">
                            <div class="contact-label">Need Help?</div>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['site_phone']) }}" class="contact-number">{{ $settings['site_phone'] }}</a>
                        </div>
                        @endif
                        
                        <div class="user-actions">
                            @auth
                            <div class="profile-dropdown">
                                <a href="#" class="user-action profile-action" onclick="toggleProfileDropdown(event)">
                                    <i class="far fa-user"></i>
                                    <span>My Profile</span>
                                </a>
                                <div class="profile-dropdown-menu" id="profileDropdown">
                                    <div class="profile-user-info">
                                        <div class="profile-user-name">{{ Auth::user()->name }}</div>
                                        @if(Auth::user()->phone)
                                        <div class="profile-user-email">+91 {{ Auth::user()->phone }}</div>
                                        @elseif(!str_contains(Auth::user()->email, '@rubista.com'))
                                        <div class="profile-user-email">{{ Auth::user()->email }}</div>
                                        @endif
                                    </div>
                                    <a href="{{ route('frontend.profile') }}" class="profile-dropdown-item">
                                        <i class="fas fa-user"></i>
                                        <span>My Profile</span>
                                    </a>
                                    <a href="{{ route('frontend.orders') }}" class="profile-dropdown-item">
                                        <i class="fas fa-shopping-bag"></i>
                                        <span>My Orders</span>
                                    </a>
                                    <form action="{{ route('frontend.logout') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="profile-dropdown-item logout-item" style="width: 100%; border: none; background: none; text-align: left; cursor: pointer;">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @else
                            <a href="{{ route('frontend.login') }}" class="user-action profile-action">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Login</span>
                            </a>
                            @endauth
                            
                            <a href="{{ route('frontend.cart') }}" class="user-action">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Cart</span>
                                @if(isset($cartCount) && $cartCount > 0)
                                <span class="action-badge cart-count">{{ $cartCount }}</span>
                                @else
                                <span class="action-badge cart-count" style="display: none;">0</span>
                                @endif
                            </a>
                            
                            <a href="{{ route('frontend.wishlist') }}" class="user-action">
                                <i class="far fa-heart"></i>
                                <span>Wishlist</span>
                                @if(isset($wishlistCount) && $wishlistCount > 0)
                                <span class="action-badge wishlist-count">{{ $wishlistCount }}</span>
                                @else
                                <span class="action-badge wishlist-count" style="display: none;">0</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Menu -->
    <nav class="main-navigation">
        <div class="header-container">
            <div class="d-flex justify-content-between align-items-center">
                <ul class="nav-menu" id="navMenu">
                    <li class="nav-item">
                        <a href="{{ route('frontend.home') }}" class="nav-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                            HOME
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.categories') }}" class="nav-link {{ request()->routeIs('frontend.categories') ? 'active' : '' }}">
                            CATEGORIES
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.about') }}" class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}">
                            ABOUT US
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.contact') }}" class="nav-link {{ request()->routeIs('frontend.contact') ? 'active' : '' }}">
                            CONTACT US
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('frontend.faq') }}" class="nav-link {{ request()->routeIs('frontend.faq') ? 'active' : '' }}">
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
        <div class="footer-main">
            <div class="container">
                <div class="row">
                    <!-- Brand Section -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-brand">
                            <a href="{{ route('frontend.home') }}" class="footer-logo">
                                RUBISTA.COM
                            </a>
                            <p class="footer-tagline">
                                Your Premier E-commerce Destination for Electronics & More. 
                                Discover quality products at unbeatable prices with fast delivery.
                            </p>
                            <div class="social-links">
                                @if(isset($settings['facebook_url']) && $settings['facebook_url'])
                                <a href="{{ $settings['facebook_url'] }}" class="social-link facebook" target="_blank" rel="noopener">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                @endif
                                @if(isset($settings['twitter_url']) && $settings['twitter_url'])
                                <a href="{{ $settings['twitter_url'] }}" class="social-link twitter" target="_blank" rel="noopener">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                @endif
                                @if(isset($settings['instagram_url']) && $settings['instagram_url'])
                                <a href="{{ $settings['instagram_url'] }}" class="social-link instagram" target="_blank" rel="noopener">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                @endif
                                @if(isset($settings['youtube_url']) && $settings['youtube_url'])
                                <a href="{{ $settings['youtube_url'] }}" class="social-link youtube" target="_blank" rel="noopener">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5>Quick Links</h5>
                            <ul class="footer-links">
                                <li><a href="{{ route('frontend.home') }}">Home</a></li>
                                <li><a href="{{ route('frontend.about') }}">About Us</a></li>
                                <li><a href="{{ route('frontend.contact') }}">Contact</a></li>
                                <li><a href="{{ route('frontend.faq') }}">FAQ</a></li>
                                <li><a href="{{ route('frontend.categories') }}">Categories</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5>Categories</h5>
                            <ul class="footer-links">
                                <li><a href="#">Electronics</a></li>
                                <li><a href="#">Smartphones</a></li>
                                <li><a href="#">Laptops</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Gaming</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5>Contact</h5>
                            <div class="contact-list">
                                <div class="contact-list-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>{{ $settings['site_email'] ?? 'info@rubista.com' }}</span>
                                </div>
                                <div class="contact-list-item">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $settings['site_phone'] ?? '+91 90518 88500' }}</span>
                                </div>
                                <div class="contact-list-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $settings['site_address'] ?? 'India' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; 2024 Rubista.com. All rights reserved.</p>
                    </div>
                    <div class="footer-bottom-links">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                        <!-- <a href="#">Shipping Policy</a>
                        <a href="#">Return Policy</a> -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scroll to Top Button -->
    <div class="scroll-top" id="scrollTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Profile dropdown toggle
        function toggleProfileDropdown(event) {
            event.preventDefault();
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }

        // Close profile dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('profileDropdown');
            const profileAction = document.querySelector('.profile-action');
            
            if (dropdown && profileAction && !dropdown.contains(event.target) && !profileAction.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

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
            
            // Scroll to top functionality
            const scrollTop = document.getElementById('scrollTop');
            
            // Show/hide scroll to top button
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollTop.classList.add('show');
                } else {
                    scrollTop.classList.remove('show');
                }
            });
            
            // Scroll to top click event
            scrollTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // Newsletter form submission
            const newsletterForm = document.querySelector('.newsletter-form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const emailInput = this.querySelector('.newsletter-input');
                    const submitBtn = this.querySelector('.newsletter-btn');
                    
                    if (emailInput.value.trim() === '') {
                        alert('Please enter your email address');
                        return;
                    }
                    
                    // Show loading state
                    const originalBtnContent = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;
                    
                    // Simulate API call (replace with actual newsletter subscription logic)
                    setTimeout(() => {
                        alert('Thank you for subscribing to our newsletter!');
                        emailInput.value = '';
                        submitBtn.innerHTML = originalBtnContent;
                        submitBtn.disabled = false;
                    }, 1500);
                });
            }
            
            // Social link click tracking (optional)
            const socialLinks = document.querySelectorAll('.social-link');
            socialLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const platform = this.classList.contains('facebook') ? 'Facebook' : 
                                   this.classList.contains('twitter') ? 'Twitter' : 
                                   this.classList.contains('instagram') ? 'Instagram' : 
                                   this.classList.contains('youtube') ? 'YouTube' : 
                                   this.classList.contains('linkedin') ? 'LinkedIn' : 'Unknown';
                    
                    console.log('Social link clicked:', platform);
                    // Add your analytics tracking here
                });
            });
        });
    </script>
    
    @yield('extra-js')
</body>
</html> 