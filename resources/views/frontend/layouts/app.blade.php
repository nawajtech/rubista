<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', ($settings['site_name'] ?? 'RUBISTA') . ' - Electronics Store')</title>
    @if(!empty($settings['favicon']))
    <link rel="icon" href="{{ asset('storage/' . $settings['favicon']) }}" type="image/x-icon">
    @endif
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Top Bar */
        .top-bar {
            background-color: #fff;
            padding: 5px 0;
            font-size: 12px;
            border-bottom: 1px solid #eee;
        }

        .top-bar .container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .top-bar span {
            color: #666;
        }

        /* Header */
        .header {
            background: #fff;
            padding: 18px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            position: relative;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
            flex-wrap: wrap;
        }

        .header .logo-wrap {
            flex-shrink: 0;
            text-decoration: none;
            color: inherit;
            transition: opacity 0.2s;
        }

        .header .logo-wrap:hover {
            opacity: 0.9;
        }

        .logo {
            font-size: 26px;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: -0.5px;
        }

        .logo span {
            color: #f5a623;
        }

        .logo small {
            font-size: 10px;
            display: block;
            color: #888;
            font-weight: 500;
            margin-top: 2px;
            letter-spacing: 0.5px;
        }

        .header nav {
            flex: 1;
            display: flex;
            justify-content: center;
            min-width: 220px;
        }

        .nav-menu {
            display: flex;
            gap: 32px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-menu a {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            letter-spacing: 0.5px;
            padding: 6px 0;
            position: relative;
            transition: color 0.2s;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 2px;
            background: #f5a623;
            transition: width 0.25s ease;
        }

        .nav-menu a:hover {
            color: #f5a623;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border: 1px solid #eee;
            border-radius: 50px;
            padding: 10px 16px 10px 20px;
            width: 280px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-box:focus-within {
            border-color: #f5a623;
            box-shadow: 0 0 0 3px rgba(245, 166, 35, 0.15);
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            flex: 1;
            font-size: 14px;
            color: #333;
        }

        .search-box input::placeholder {
            color: #999;
        }

        .search-box button {
            background: #f5a623;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, transform 0.2s;
        }

        .search-box button:hover {
            background: #e09600;
            transform: scale(1.05);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .header-action {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            color: #444;
            text-decoration: none;
            position: relative;
            transition: color 0.2s, background 0.2s;
        }

        .header-action:hover {
            color: #f5a623;
            background: rgba(245, 166, 35, 0.08);
        }

        .header-action i {
            font-size: 20px;
        }

        .header-action.wishlist-icon i {
            font-size: 21px;
        }

        .header-profile-wrap {
            position: relative;
        }
        .header-profile-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid #eee;
            background: #fff;
            color: #333;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .header-profile-btn:hover {
            border-color: #f5a623;
            color: #f5a623;
            background: rgba(245, 166, 35, 0.08);
        }
        .header-profile-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            min-width: 180px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border: 1px solid #eee;
            padding: 8px 0;
            z-index: 1000;
            display: none;
        }
        .header-profile-wrap.open .header-profile-dropdown {
            display: block;
        }
        .header-profile-dropdown a,
        .header-profile-dropdown button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 18px;
            border: none;
            background: none;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-align: left;
            text-decoration: none;
            transition: background 0.2s;
            font-family: inherit;
        }
        .header-profile-dropdown a:hover,
        .header-profile-dropdown button:hover {
            background: rgba(245, 166, 35, 0.1);
            color: #1a1a2e;
        }
        .header-profile-dropdown .dropdown-divider {
            height: 1px;
            background: #eee;
            margin: 6px 0;
        }

        .cart-badge,
        .wishlist-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            background: #f5a623;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wishlist-badge[style*="display: none"],
        .cart-badge:empty {
            display: none !important;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-content {
            text-align: center;
            color: #fff;
        }

        .hero h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 16px;
            opacity: 0.8;
        }

        /* Features Bar */
        .features-bar {
            background: #fff;
            padding: 20px 0;
            margin-top: -30px;
            position: relative;
            z-index: 10;
            border-radius: 10px;
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .features-bar .container {
            display: flex;
            justify-content: space-around;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: #f5f5f5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-icon i {
            font-size: 20px;
            color: #1a1a2e;
        }

        .feature-text h4 {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .feature-text p {
            font-size: 11px;
            color: #666;
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin: 40px 0 30px;
        }

        .section-title h2 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .section-title.left {
            text-align: left;
        }

        .section-title span {
            color: #f5a623;
        }

        /* Categories */
        .categories {
            padding: 20px 0;
        }

        .category-title {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .category-title::before,
        .category-title::after {
            content: '~';
            margin: 0 10px;
        }

        .category-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .category-item {
            text-align: center;
        }

        .category-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            transition: transform 0.3s;
        }

        .category-icon.orange {
            background: linear-gradient(135deg, #f5a623 0%, #f78b00 100%);
        }

        .category-icon:hover {
            transform: scale(1.1);
        }

        .category-icon i {
            font-size: 28px;
            color: #fff;
        }

        .category-item span {
            font-size: 12px;
            color: #333;
        }

        /* Products Section */
        .products-section {
            padding: 30px 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: box-shadow 0.3s;
            position: relative;
        }

        .product-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #f5a623;
            color: #fff;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 3px;
        }

        .product-badge.red {
            background: #e74c3c;
        }

        .product-image {
            width: 100%;
            height: 120px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .product-title {
            font-size: 11px;
            color: #666;
            margin-bottom: 5px;
        }

        .product-name {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .product-price {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .current-price {
            font-size: 16px;
            font-weight: 700;
            color: #f5a623;
        }

        .original-price {
            font-size: 12px;
            color: #999;
            text-decoration: line-through;
        }

        .buy-btn {
            background: #f5a623;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .buy-btn:hover {
            background: #e09600;
        }

        /* Smart Earbuds Banner */
        .earbuds-section {
            padding: 30px 0;
        }

        .earbuds-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .earbuds-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .earbuds-card.dark {
            background: linear-gradient(135deg, #2d3436 0%, #000 100%);
            color: #fff;
        }

        .earbuds-card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .earbuds-info h3 {
            font-size: 24px;
            font-weight: 700;
        }

        .earbuds-info .price {
            font-size: 20px;
            font-weight: 700;
            color: #f5a623;
        }

        .earbuds-info .original {
            font-size: 14px;
            color: #999;
            text-decoration: line-through;
        }

        /* Smart Watches Section */
        .watches-section {
            padding: 30px 0;
        }

        .watches-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
        }

        .watch-products {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .watch-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 30px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .watch-banner h3 {
            font-size: 28px;
            font-weight: 700;
        }

        .watch-banner p {
            font-size: 14px;
            opacity: 0.9;
        }

        .watch-banner img {
            width: 150px;
        }

        /* Power Banks Section */
        .powerbank-section {
            padding: 30px 0;
        }

        .powerbank-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .powerbank-banner {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 40px;
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .powerbank-banner img {
            width: 200px;
        }

        .powerbank-info h3 {
            font-size: 36px;
            font-weight: 800;
            color: #333;
        }

        .powerbank-info p {
            color: #666;
        }

        .powerbank-products {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .powerbank-item {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .powerbank-item img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        /* Flash Sale Banner */
        .flash-sale {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            border-radius: 15px;
            padding: 40px;
            margin: 30px 0;
            color: #fff;
            text-align: center;
        }

        .flash-sale h2 {
            font-size: 32px;
            color: #f5a623;
        }

        .flash-sale p {
            font-size: 18px;
        }

        .shop-now-btn {
            background: #f5a623;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
        }

        /* Shop By Discounts */
        .discounts-section {
            padding: 30px 0;
            text-align: center;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .countdown-item {
            background: #f5a623;
            color: #fff;
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
        }

        /* Promotional Banners */
        .promo-section {
            padding: 30px 0;
        }

        .promo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .promo-banner {
            border-radius: 15px;
            padding: 30px;
            color: #fff;
            position: relative;
            overflow: hidden;
            min-height: 200px;
        }

        .promo-banner.sale {
            background: linear-gradient(135deg, #f5a623 0%, #f78b00 100%);
        }

        .promo-banner.headphone {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .promo-banner h3 {
            font-size: 28px;
            font-weight: 800;
        }

        .promo-banner p {
            font-size: 14px;
        }

        /* Footer */
        .footer {
            background: #1a1a2e;
            color: #fff;
            padding: 50px 0 20px;
            margin-top: 50px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 2fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-logo {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .footer-logo span {
            color: #f5a623;
        }

        .footer-about p {
            font-size: 13px;
            color: #aaa;
            line-height: 1.6;
        }

        .footer h4 {
            font-size: 16px;
            margin-bottom: 20px;
            color: #f5a623;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            font-size: 13px;
            color: #aaa;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #f5a623;
        }

        .newsletter input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .newsletter button {
            background: #f5a623;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            width: 35px;
            height: 35px;
            background: #333;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .social-links a:hover {
            background: #f5a623;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
        }

        .thanks-note {
            color: #f5a623;
            font-style: italic;
        }

        /* View All Link */
        .view-all {
            color: #f5a623;
            font-size: 13px;
            text-decoration: none;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 20px;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            .header .logo small {
                display: none;
            }
            .header .container {
                gap: 16px;
            }
            .search-box {
                width: 180px;
                padding: 8px 12px 8px 16px;
            }
            .header-action {
                width: 40px;
                height: 40px;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .earbuds-grid,
            .watches-grid,
            .powerbank-grid,
            .promo-grid {
                grid-template-columns: 1fr;
            }

            .features-bar .container {
                flex-wrap: wrap;
                gap: 20px;
            }

            .feature-item {
                width: 45%;
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr;
            }

            .feature-item {
                width: 100%;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @yield('extra-css')
</head>
<body>
<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <span>Free Shipping on orders over ₹500!</span>
    </div>
</div>

<!-- Header -->
<header class="header">
    <div class="container">
        <a href="{{ route('frontend.home') }}" class="logo-wrap">
            <div class="logo">
                RUBI<span>STA</span>
                <small>Shop Smarter, Live Better</small>
            </div>
            <!-- @if(!empty($settings['logo']))
                <img src="{{ asset('storage/' . $settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Rubista' }}" class="logo-img" style="max-height: 45px; width: auto; display: block;">
            @else
                <div class="logo">
                    {{ strtoupper(substr($settings['site_name'] ?? 'Rubista', 0, 4)) }}<span>{{ strtoupper(substr($settings['site_name'] ?? 'Rubista', 4)) ?: 'STA' }}</span>
                    <small>{{ Str::limit($settings['site_description'] ?? 'Shop Smarter, Live Better', 25) }}</small>
                </div>
            @endif -->
        </a>

        <nav>
            <ul class="nav-menu">
                <li><a href="{{ route('frontend.home') }}">HOME</a></li>
                <li><a href="{{ route('frontend.about') }}">ABOUT US</a></li>
                <li><a href="{{ route('frontend.categories') }}">CATEGORIES</a></li>
                <li><a href="{{ route('frontend.contact') }}">CONTACT US</a></li>
                <li><a href="{{ route('frontend.faq') }}">FAQs</a></li>
            </ul>
        </nav>

        <form action="{{ route('frontend.search') }}" method="GET" class="search-box" style="margin: 0;">
            <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

        <div class="header-right">
            @auth
            <div class="header-profile-wrap" id="header-profile-wrap">
                <a href="#" class="header-profile-btn" title="Profile" onclick="event.preventDefault(); document.getElementById('header-profile-wrap').classList.toggle('open');">
                    <i class="fas fa-user"></i>
                </a>
                <div class="header-profile-dropdown">
                    <a href="{{ route('frontend.profile') }}"><i class="fas fa-user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('frontend.logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </div>
            </div>
            @else
            <a href="{{ route('frontend.login') }}" class="header-profile-btn" title="Login">
                <i class="fas fa-user"></i>
            </a>
            @endauth
            <a href="{{ route('frontend.wishlist') }}" class="header-action wishlist-icon" title="Favourites">
                <i class="far fa-heart"></i>
                @php $wishlistCount = count(session('wishlist', [])); @endphp
                @if($wishlistCount > 0)
                    <span class="wishlist-badge" id="header-wishlist-count">{{ $wishlistCount }}</span>
                @else
                    <span class="wishlist-badge" id="header-wishlist-count" style="display: none;">0</span>
                @endif
            </a>
            <a href="{{ route('frontend.cart') }}" class="header-action cart-icon" title="Cart">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge" id="header-cart-count">0</span>
            </a>
        </div>
    </div>
</header>

@yield('content')

<!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    @if(!empty($settings['logo']))
                        <div class="footer-logo-img mb-2">
                            <img src="{{ asset('storage/' . $settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Rubista' }}" style="max-height: 40px; width: auto;">
                        </div>
                    @else
                        <div class="footer-logo">{{ strtoupper(substr($settings['site_name'] ?? 'Rubista', 0, 4)) }}<span>{{ strtoupper(substr($settings['site_name'] ?? 'Rubista', 4)) ?: 'STA' }}</span></div>
                    @endif
                    <p>{{ $settings['site_description'] ?? 'Your Premier E-commerce Destination' }}</p>
                    <p class="thanks-note" style="margin-top: 10px;">Thanks for Visit !</p>
                </div>

                <div>
                    <h4>Contact Us</h4>
                    <ul class="footer-links">
                        @if(!empty($settings['site_phone']))
                        <li><i class="fas fa-phone-alt"></i> {{ $settings['site_phone'] }}</li>
                        @endif
                        <li style="margin-top: 15px;"><strong>Mail Us</strong></li>
                        <li><i class="fas fa-envelope"></i> <a href="mailto:{{ $settings['site_email'] ?? '#' }}" style="color: inherit;">{{ $settings['site_email'] ?? '—' }}</a></li>
                        @if(!empty($settings['site_address']))
                        <li style="margin-top: 15px;"><strong>Address</strong></li>
                        <li>{!! nl2br(e($settings['site_address'])) !!}</li>
                        @endif
                    </ul>
                </div>

                <div>
                    <h4>Sitemap</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('frontend.home') }}">Home</a></li>
                        <li><a href="{{ route('frontend.categories') }}">Categories</a></li>
                        <li><a href="{{ route('frontend.about') }}">About Us</a></li>
                        <li><a href="{{ route('frontend.contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('frontend.faq') }}">FAQs</a></li>
                    </ul>
                </div>

                <div>
                    <h4>Newsletter</h4>
                    <p style="font-size: 13px; color: #aaa; margin-bottom: 15px;">Get daily update of offers & discounts</p>
                    <div class="newsletter">
                        <input type="email" placeholder="Enter your email">
                        <button>Subscribe</button>
                    </div>
                    @if(!empty($settings['facebook_url']) || !empty($settings['twitter_url']) || !empty($settings['instagram_url']) || !empty($settings['youtube_url']))
                    <p style="font-size: 13px; color: #aaa; margin-top: 20px;"><strong>Follow Us</strong></p>
                    <div class="social-links">
                        @if(!empty($settings['facebook_url']))<a href="{{ $settings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" title="Facebook"><i class="fab fa-facebook-f"></i></a>@endif
                        @if(!empty($settings['instagram_url']))<a href="{{ $settings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" title="Instagram"><i class="fab fa-instagram"></i></a>@endif
                        @if(!empty($settings['twitter_url']))<a href="{{ $settings['twitter_url'] }}" target="_blank" rel="noopener noreferrer" title="Twitter"><i class="fab fa-twitter"></i></a>@endif
                        @if(!empty($settings['youtube_url']))<a href="{{ $settings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" title="YouTube"><i class="fab fa-youtube"></i></a>@endif
                    </div>
                    @endif
                </div>
            </div>

            <div class="footer-bottom">
                <p>© {{ $settings['site_name'] ?? 'Rubista' }} {{ date('Y') }}. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    @yield('extra-js')
    <script>
        document.addEventListener('click', function(e) {
            var wrap = document.getElementById('header-profile-wrap');
            if (wrap && !wrap.contains(e.target)) wrap.classList.remove('open');
        });
    </script>
    <script>
        // Simple countdown timer
        function updateCountdown() {
            const items = document.querySelectorAll('.countdown-item');
            let values = [21, 50, 12, 2];
            
            setInterval(() => {
                values[3]--;
                if (values[3] < 0) {
                    values[3] = 59;
                    values[2]--;
                }
                if (values[2] < 0) {
                    values[2] = 59;
                    values[1]--;
                }
                if (values[1] < 0) {
                    values[1] = 59;
                    values[0]--;
                }
                
                items.forEach((item, index) => {
                    item.textContent = values[index].toString().padStart(2, '0');
                });
            }, 1000);
        }
        
        updateCountdown();
    </script>
</body>
</html>