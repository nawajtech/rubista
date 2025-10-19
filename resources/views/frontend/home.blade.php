@extends('frontend.layouts.app')

@section('title', 'Home - Rubista')

@php
    use Illuminate\Support\Str;
@endphp

@section('extra-css')
<style>
    :root {
        --primary-purple: #7c3aed;
        --light-purple: #a855f7;
        --dark-purple: #6d28d9;
        --orange: #f97316;
        --light-gray: #f8fafc;
        --dark-gray: #64748b;
        --gray-600: #6b7280;
    }

    /* Compact Hero Section */
    .hero-section {
        background: linear-gradient(135deg, var(--primary-purple), var(--light-purple));
        color: white;
        padding: 40px 0;
        margin-bottom: 0;
        position: relative;
        overflow: hidden;
        min-height: 50vh;
        display: flex;
        align-items: center;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        pointer-events: none;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 50px,
            rgba(255, 255, 255, 0.02) 50px,
            rgba(255, 255, 255, 0.02) 100px
        );
        animation: heroPattern 20s linear infinite;
        pointer-events: none;
    }

    @keyframes heroPattern {
        0% { transform: translate(-50px, -50px); }
        100% { transform: translate(50px, 50px); }
    }

    .hero-container {
        position: relative;
        z-index: 2;
        padding: 20px 0;
    }

    .hero-content {
        position: relative;
        z-index: 3;
        animation: slideInLeft 1s ease-out;
        padding-left: 40px;
        margin-left: 20px;
        border-left: 4px solid rgba(251, 191, 36, 0.3);
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        border-radius: 0 15px 15px 0;
        backdrop-filter: blur(5px);
        padding-top: 20px;
        padding-bottom: 20px;
        padding-right: 20px;
        transition: all 0.3s ease;
    }

    .hero-content:hover {
        border-left-color: rgba(251, 191, 36, 0.6);
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.15) 0%, transparent 60%);
        transform: translateX(5px);
    }

    .hero-content h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.3;
        position: relative;
    }

    .hero-content h1 .highlight {
        background: linear-gradient(45deg, #fbbf24, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-content h1::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #fbbf24, #f59e0b);
        border-radius: 2px;
        animation: slideInLine 1.5s ease-out 0.5s both;
    }

    .hero-content .subtitle {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
        opacity: 0.95;
        line-height: 1.5;
        font-weight: 400;
        animation: slideInLeft 1s ease-out 0.3s both;
    }

    .hero-content .highlight {
        color: #fbbf24;
        font-weight: 600;
    }

    .hero-actions {
        display: flex;
        gap: 0.8rem;
        margin-bottom: 1.5rem;
        animation: slideInLeft 1s ease-out 0.6s both;
        flex-wrap: wrap;
    }

    .btn-hero-primary {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #1a1a1a;
        border: none;
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        min-width: 140px;
        justify-content: center;
    }

    .btn-hero-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s ease;
    }

    .btn-hero-primary:hover::before {
        left: 100%;
    }

    .btn-hero-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(251, 191, 36, 0.3);
        color: #1a1a1a;
    }

    .btn-hero-secondary {
        background: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 10px 22px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        min-width: 140px;
        justify-content: center;
    }

    .btn-hero-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.6);
        transform: translateY(-2px);
        color: white;
    }

    .hero-stats {
        display: flex;
        gap: 2rem;
        animation: slideInLeft 1s ease-out 0.9s both;
    }

    .hero-stat {
        text-align: left;
    }

    .hero-stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: #fbbf24;
        display: block;
        line-height: 1;
    }

    .hero-stat-label {
        font-size: 0.85rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.2rem;
    }

    .hero-image-container {
        position: relative;
        animation: slideInRight 1s ease-out 0.5s both;
        text-align: center;
    }

    .hero-image {
        width: 100%;
        max-width: 450px;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .hero-image:hover {
        transform: scale(1.02);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    }

    .hero-image-bg {
        position: absolute;
        top: 15px;
        left: 15px;
        right: -15px;
        bottom: -15px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
        border-radius: 20px;
        z-index: 1;
        animation: float 6s ease-in-out infinite;
    }

    .hero-floating-elements {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 1;
    }

    .floating-element {
        position: absolute;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    .floating-element:nth-child(1) {
        width: 40px;
        height: 40px;
        top: 20%;
        left: 10%;
        animation-delay: -2s;
    }

    .floating-element:nth-child(2) {
        width: 30px;
        height: 30px;
        top: 60%;
        right: 15%;
        animation-delay: -4s;
    }

    .floating-element:nth-child(3) {
        width: 50px;
        height: 50px;
        bottom: 20%;
        left: 20%;
        animation-delay: -6s;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInLine {
        from {
            width: 0;
        }
        to {
            width: 80px;
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-15px) rotate(3deg);
        }
    }

    /* Services Section */
    .services-section {
        padding: 35px 0;
        background: white;
        margin-top: -15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .service-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: rgba(124, 58, 237, 0.02);
        border: 1px solid rgba(124, 58, 237, 0.1);
    }

    .service-card:hover {
        transform: translateY(-2px);
        background: rgba(124, 58, 237, 0.05);
        border-color: rgba(124, 58, 237, 0.2);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.1);
    }

    .service-icon {
        width: 45px;
        height: 45px;
        background: var(--primary-purple);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        flex-shrink: 0;
    }

    .service-content {
        flex: 1;
    }

    .service-content h5 {
        margin: 0 0 3px 0;
        font-size: 15px;
        font-weight: 600;
        color: var(--primary-purple);
    }

    .service-content p {
        margin: 0;
        font-size: 12px;
        color: var(--gray-600);
        line-height: 1.4;
    }

    /* Section Title */
    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 25px;
        color: #333;
        position: relative;
        padding-bottom: 12px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-purple), var(--light-purple));
        border-radius: 2px;
    }

    /* Categories Section - Simplified */
    .categories-section {
        padding: 40px 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
        overflow: hidden;
        position: relative;
    }

    .categories-container {
        position: relative;
        overflow: hidden;
        padding: 15px 0;
    }

    .categories-wrapper {
        display: flex;
        gap: 20px;
        animation: autoSlide 30s infinite linear;
        will-change: transform;
    }

    .categories-wrapper:hover {
        animation-play-state: paused;
    }

    @keyframes autoSlide {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .category-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        border: 1px solid rgba(124, 58, 237, 0.08);
        transition: all 0.3s ease;
        min-width: 160px;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        position: relative;
        cursor: pointer;
    }

    .category-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.12);
        border-color: var(--primary-purple);
    }

    .category-image-container {
        width: 70px;
        height: 70px;
        margin: 0 auto 12px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid rgba(124, 58, 237, 0.1);
        transition: all 0.3s ease;
    }

    .category-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .category-image-fallback {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-purple), var(--light-purple));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
    }

    .category-name {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 6px;
        color: #1a202c;
    }

    .category-count {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 500;
        padding: 3px 10px;
        background: rgba(124, 58, 237, 0.08);
        border-radius: 15px;
        display: inline-block;
    }

    .category-card:hover .category-name {
        color: var(--primary-purple);
    }

    .category-card:hover .category-count {
        background: var(--primary-purple);
        color: white;
    }

    /* Navigation */
    .nav-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .nav-arrow:hover {
        background: var(--primary-purple);
        border-color: var(--primary-purple);
        transform: translateY(-50%) scale(1.05);
    }

    .nav-arrow i {
        font-size: 18px;
        color: #6b7280;
        transition: color 0.3s ease;
    }

    .nav-arrow:hover i {
        color: white;
    }

    .nav-arrow.left {
        left: 20px;
    }

    .nav-arrow.right {
        right: 20px;
    }

    /* Product Cards */
    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #f1f5f9;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.12);
    }

    .product-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .product-info {
        padding: 16px;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        height: 45px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-price {
        margin-bottom: 12px;
    }

    .current-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-purple);
    }

    .original-price {
        text-decoration: line-through;
        color: #94a3b8;
        font-size: 0.9rem;
        margin-left: 8px;
    }

    .btn-add-cart {
        background: var(--primary-purple);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }

    .btn-add-cart:hover {
        background: var(--dark-purple);
        transform: translateY(-1px);
        color: white;
    }

    .btn-add-wishlist {
        background: #f1f5f9;
        color: var(--primary-purple);
        border: 2px solid var(--primary-purple);
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-add-wishlist:hover {
        background: var(--primary-purple);
        color: white;
    }

    .rating-stars {
        color: #fbbf24;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    /* Best Selling Products Section - Compact Design */
    .best-selling-section {
        padding: 60px 0;
        background: #f8fafc;
    }

    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-header .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 10px;
    }

    .section-header .section-subtitle {
        font-size: 1.1rem;
        color: #64748b;
        margin: 0;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .product-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
    }

    .product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 200px;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-item:hover .product-image {
        transform: scale(1.05);
    }

    .badge {
        position: absolute;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 10;
    }

    .badge.best-seller {
        top: 12px;
        left: 12px;
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
    }

    .badge.discount {
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .product-overlay {
        position: absolute;
        top: 12px;
        right: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
    }

    .product-item:hover .product-overlay {
        opacity: 1;
        transform: translateX(0);
    }

    .overlay-btn {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: white;
        border: none;
        color: var(--primary-purple);
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .overlay-btn:hover {
        background: var(--primary-purple);
        color: white;
        transform: scale(1.1);
    }

    .overlay-btn.wishlist-btn.active {
        background: #fecaca;
        color: #dc2626;
    }

    .product-details {
        padding: 20px;
    }

    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 8px;
        line-height: 1.4;
        height: 2.8em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .stars {
        color: #fbbf24;
        font-size: 0.9rem;
    }

    .review-count {
        font-size: 0.8rem;
        color: #64748b;
    }

    .product-price {
        margin-bottom: 15px;
    }

    .current-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-purple);
    }

    .original-price {
        font-size: 0.9rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 8px;
    }

    .add-to-cart-btn {
        width: 100%;
        background: var(--primary-purple);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .add-to-cart-btn:hover {
        background: var(--dark-purple);
        transform: translateY(-2px);
    }

    .view-more {
        text-align: center;
    }

    .view-more-btn {
        display: inline-block;
        background: transparent;
        color: var(--primary-purple);
        border: 2px solid var(--primary-purple);
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .view-more-btn:hover {
        background: var(--primary-purple);
        color: white;
        transform: translateY(-2px);
    }

    /* Beautiful Banner Section */
    .beautiful-banner-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
        position: relative;
        padding: 80px 0;
        overflow: hidden;
        min-height: 600px;
        display: flex;
        align-items: center;
    }

    .banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
            linear-gradient(45deg, rgba(0, 0, 0, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .banner-content {
        position: relative;
        z-index: 3;
        color: white;
        padding: 40px 0;
    }

    .banner-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: pulse 2s infinite;
    }

    .banner-badge i {
        color: #ff6b6b;
        animation: fire 1.5s infinite;
    }

    .banner-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .gradient-text {
        background: linear-gradient(45deg, #ffd700, #ffed4e, #fff200);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: none;
    }

    .banner-subtitle {
        font-size: 1.2rem;
        margin-bottom: 30px;
        opacity: 0.95;
        line-height: 1.6;
        font-weight: 400;
    }

    .banner-features {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 10px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    .feature-item i {
        color: #4ade80;
        font-size: 1rem;
    }

    .banner-actions {
        display: flex;
        gap: 15px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .btn-banner-primary {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 30px;
        font-weight: 700;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        position: relative;
        overflow: hidden;
    }

    .btn-banner-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.6s ease;
    }

    .btn-banner-primary:hover::before {
        left: 100%;
    }

    .btn-banner-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255, 107, 107, 0.6);
        color: white;
    }

    .btn-banner-secondary {
        background: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.4);
        padding: 13px 28px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .btn-banner-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.8);
        transform: translateY(-3px);
        color: white;
    }

    .countdown-timer {
        display: flex;
        gap: 15px;
        align-items: center;
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(15px);
        padding: 20px;
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .timer-item {
        text-align: center;
        min-width: 60px;
    }

    .timer-number {
        display: block;
        font-size: 1.8rem;
        font-weight: 800;
        color: #ffd700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .timer-label {
        display: block;
        font-size: 0.8rem;
        opacity: 0.8;
        margin-top: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .timer-separator {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffd700;
        margin-top: -10px;
    }

    .banner-image-container {
        position: relative;
        text-align: center;
        padding: 40px 0;
    }

    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 1;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
    }

    .shape-1 {
        width: 80px;
        height: 80px;
        top: 10%;
        left: 10%;
        animation-delay: -2s;
    }

    .shape-2 {
        width: 60px;
        height: 60px;
        top: 60%;
        right: 15%;
        animation-delay: -4s;
    }

    .shape-3 {
        width: 100px;
        height: 100px;
        bottom: 20%;
        left: 20%;
        animation-delay: -6s;
    }

    .shape-4 {
        width: 40px;
        height: 40px;
        top: 30%;
        right: 30%;
        animation-delay: -8s;
    }

    .banner-image {
        position: relative;
        z-index: 2;
        display: inline-block;
    }

    .banner-image img {
        max-width: 100%;
        height: auto;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .banner-image:hover img {
        transform: scale(1.05);
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
    }

    .price-tag {
        position: absolute;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        padding: 15px 20px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        z-index: 3;
        animation: bounce 2s infinite;
    }

    .price-amount {
        display: block;
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffd700;
    }

    .price-original {
        display: block;
        font-size: 0.9rem;
        text-decoration: line-through;
        opacity: 0.7;
        margin-top: 5px;
    }

    /* Animations */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes fire {
        0%, 100% { transform: rotate(-5deg); }
        50% { transform: rotate(5deg); }
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* Banner Sections */
    .banner-section {
        background: white;
        padding: 40px 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .feature-banner {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        border-radius: 16px;
        padding: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        min-height: 160px;
        position: relative;
        overflow: hidden;
    }

    .banner-content h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .banner-content p {
        font-size: 1rem;
        margin-bottom: 12px;
    }

    .banner-image img {
        max-width: 180px;
        border-radius: 8px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2rem;
        }
        
        .hero-section {
            min-height: 45vh;
            padding: 30px 0;
        }
        
        .hero-container {
            padding: 15px 0;
        }
        
        .hero-content {
            padding-left: 25px;
            margin-left: 10px;
            padding-top: 15px;
            padding-bottom: 15px;
            padding-right: 15px;
            border-left: 3px solid rgba(251, 191, 36, 0.4);
        }
        
        .hero-content .subtitle {
            font-size: 1rem;
            margin-bottom: 1.2rem;
        }
        
        .hero-stats {
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .hero-actions {
            gap: 0.6rem;
            margin-bottom: 1.2rem;
        }
        
        .btn-hero-primary,
        .btn-hero-secondary {
            padding: 10px 20px;
            font-size: 0.9rem;
            min-width: 120px;
        }
        
        .hero-image {
            max-width: 350px;
        }
        
        .services-section {
            padding: 30px 0;
        }
        
        .categories-section {
            padding: 40px 0;
        }
        
        .category-card {
            min-width: 150px;
            padding: 15px;
        }
        
        .category-image-container {
            width: 60px;
            height: 60px;
        }
        
        .category-image-fallback {
            font-size: 20px;
        }
        
        .nav-arrow {
            width: 40px;
            height: 40px;
        }
        
        .nav-arrow i {
            font-size: 16px;
        }
        
        .nav-arrow.left {
            left: 10px;
        }
        
        .nav-arrow.right {
            right: 10px;
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
        }
        
        .service-card {
            padding: 15px;
            gap: 12px;
        }
        
        .service-icon {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }
        
        .service-content h5 {
            font-size: 14px;
        }
        
        .service-content p {
            font-size: 12px;
        }
        
        .feature-banner {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        
        .banner-content h3 {
            font-size: 1.5rem;
        }
        
        .banner-image img {
            max-width: 150px;
            margin-top: 15px;
        }
        
        /* Best Selling Products Responsive */
        .best-selling-section {
            padding: 40px 0;
        }
        
        .section-header .section-title {
            font-size: 2rem;
        }
        
        .section-header .section-subtitle {
            font-size: 1rem;
        }
        
        .products-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .product-image-wrapper {
            height: 180px;
        }
        
        .product-details {
            padding: 15px;
        }
        
        .product-name {
            font-size: 1rem;
            height: 2.4em;
        }
        
        .add-to-cart-btn {
            padding: 10px 16px;
            font-size: 0.9rem;
        }
        
        .overlay-btn {
            width: 30px;
            height: 30px;
            font-size: 0.7rem;
        }
        
        .product-overlay {
            opacity: 1;
            transform: translateX(0);
            flex-direction: row;
            gap: 6px;
        }
        
        /* Beautiful Banner Responsive */
        .beautiful-banner-section {
            padding: 60px 0;
            min-height: 500px;
        }
        
        .banner-title {
            font-size: 2.5rem;
        }
        
        .banner-subtitle {
            font-size: 1rem;
        }
        
        .banner-features {
            gap: 15px;
        }
        
        .feature-item {
            padding: 8px 12px;
            font-size: 0.8rem;
        }
        
        .btn-banner-primary,
        .btn-banner-secondary {
            padding: 12px 24px;
            font-size: 1rem;
        }
        
        .countdown-timer {
            gap: 10px;
            padding: 15px;
        }
        
        .timer-item {
            min-width: 50px;
        }
        
        .timer-number {
            font-size: 1.4rem;
        }
        
        .timer-label {
            font-size: 0.7rem;
        }
        
        .timer-separator {
            font-size: 1.2rem;
        }
        
        .price-tag {
            padding: 12px 16px;
        }
        
        .price-amount {
            font-size: 1.2rem;
        }
        
        .price-original {
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .hero-content h1 {
            font-size: 1.8rem;
            margin-bottom: 0.8rem;
        }
        
        .hero-content .subtitle {
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }
        
        .hero-section {
            min-height: 40vh;
            padding: 25px 0;
        }
        
        .hero-content {
            padding-left: 15px;
            margin-left: 5px;
            padding-top: 12px;
            padding-bottom: 12px;
            padding-right: 12px;
            border-left: 2px solid rgba(251, 191, 36, 0.5);
        }
        
        .hero-stats {
            gap: 1rem;
            justify-content: center;
            text-align: center;
        }
        
        .hero-stat-number {
            font-size: 1.5rem;
        }
        
        .hero-stat-label {
            font-size: 0.8rem;
        }
        
        .hero-actions {
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .btn-hero-primary,
        .btn-hero-secondary {
            padding: 8px 16px;
            font-size: 0.85rem;
            min-width: 110px;
        }
        
        .hero-image {
            max-width: 280px;
        }
        
        .category-card {
            min-width: 120px;
            padding: 10px;
        }
        
        .category-image-container {
            width: 50px;
            height: 50px;
        }
        
        .category-image-fallback {
            font-size: 18px;
        }
        
        .product-image {
            height: 150px;
        }
        
        .product-info {
            padding: 15px;
        }
        
        .product-title {
            font-size: 1rem;
            height: 40px;
        }
        
        .current-price {
            font-size: 1.1rem;
        }
        
        .floating-element {
            display: none;
        }
    }
</style>
@endsection

@section('content')
<!-- Enhanced Hero Section -->
@if($heroContent)
<section class="hero-section">
    <div class="hero-floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="container-fluid hero-container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1>Welcome to <span class="highlight">RUBISTA</span></h1>
                    <p class="subtitle">
                        Your Electronics Store - <span class="highlight">Quality Products</span>, Unbeatable Prices
                    </p>
                    
                    <div class="hero-actions">
                        <a href="#featured" class="btn-hero-primary">
                            <i class="fas fa-shopping-bag"></i>
                            Shop Now
                        </a>
                        <a href="#categories" class="btn-hero-secondary">
                            <i class="fas fa-th-large"></i>
                            Browse Categories
                        </a>
                    </div>
                    
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="hero-stat-number">10K+</span>
                            <span class="hero-stat-label">Products</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number">50K+</span>
                            <span class="hero-stat-label">Happy Customers</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number">4.9</span>
                            <span class="hero-stat-label">Rating</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-container">
                    <div class="hero-image-bg"></div>
                    <img src="{{ $heroContent->image_url ?? 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=400&fit=crop' }}" 
                         class="hero-image" alt="Rubista Electronics">
                </div>
            </div>
        </div>
    </div>
</section>
@else
<!-- Default Hero Section -->
<section class="hero-section">
    <div class="hero-floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>
    
    <div class="container-fluid hero-container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1>Welcome to <span class="highlight">RUBISTA</span></h1>
                    <p class="subtitle">
                        Your Premier E-commerce Destination for <span class="highlight">Electronics & More</span>
                    </p>
                    
                    <div class="hero-actions">
                        <a href="#featured" class="btn-hero-primary">
                            <i class="fas fa-shopping-bag"></i>
                            Shop Now
                        </a>
                        <a href="#categories" class="btn-hero-secondary">
                            <i class="fas fa-th-large"></i>
                            Browse Categories
                        </a>
                    </div>
                    
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="hero-stat-number">10K+</span>
                            <span class="hero-stat-label">Products</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number">50K+</span>
                            <span class="hero-stat-label">Happy Customers</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number">4.9</span>
                            <span class="hero-stat-label">Rating</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-container">
                    <div class="hero-image-bg"></div>
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=400&fit=crop" 
                         class="hero-image" alt="Rubista Electronics">
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Services Section -->
@if($serviceContent && $serviceContent->count() > 0)
<section class="services-section">
    <div class="container-fluid">
        <div class="row">
            @foreach($serviceContent as $service)
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="{{ $service->extra_data['icon'] ?? 'fas fa-star' }}"></i>
                    </div>
                    <div class="service-content">
                        <h5>{{ $service->title }}</h5>
                        <p>{{ $service->subtitle }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Categories Section -->
<section class="categories-section">
    <div class="container-fluid">
        <h2 class="section-title">CATEGORIES</h2>
        <div class="categories-container">
            <!-- Navigation Arrows -->
            <div class="nav-arrow left" id="prevArrow">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="nav-arrow right" id="nextArrow">
                <i class="fas fa-chevron-right"></i>
            </div>
            
            <div class="categories-wrapper" id="categoriesWrapper">
                @foreach($categories as $category)
                <a href="{{ route('frontend.category.products', $category->id) }}" class="text-decoration-none">
                    <div class="category-card">
                        <div class="category-image-container">
                            @if($category->image)
                                @if(Str::startsWith($category->image, 'http'))
                                    <img src="{{ $category->image }}" class="category-image" alt="{{ $category->name }}" 
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @else
                                    <img src="{{ asset('storage/' . $category->image) }}" class="category-image" alt="{{ $category->name }}" 
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="category-image-fallback" style="display: none;">
                                    <i class="fas fa-{{ $loop->index % 6 == 0 ? 'laptop' : ($loop->index % 6 == 1 ? 'mobile-alt' : ($loop->index % 6 == 2 ? 'headphones' : ($loop->index % 6 == 3 ? 'tv' : ($loop->index % 6 == 4 ? 'camera' : 'gamepad')))) }}"></i>
                                </div>
                            @else
                                <div class="category-image-fallback">
                                    <i class="fas fa-{{ $loop->index % 6 == 0 ? 'laptop' : ($loop->index % 6 == 1 ? 'mobile-alt' : ($loop->index % 6 == 2 ? 'headphones' : ($loop->index % 6 == 3 ? 'tv' : ($loop->index % 6 == 4 ? 'camera' : 'gamepad')))) }}"></i>
                                </div>
                            @endif
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                        <div class="category-count">{{ $category->products_count ?? 0 }} Products</div>
                    </div>
                </a>
                @endforeach
                
                <!-- Duplicate for seamless loop -->
                @foreach($categories as $category)
                <a href="{{ route('frontend.category.products', $category->id) }}" class="text-decoration-none">
                    <div class="category-card">
                        <div class="category-image-container">
                            @if($category->image)
                                @if(Str::startsWith($category->image, 'http'))
                                    <img src="{{ $category->image }}" class="category-image" alt="{{ $category->name }}" 
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @else
                                    <img src="{{ asset('storage/' . $category->image) }}" class="category-image" alt="{{ $category->name }}" 
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="category-image-fallback" style="display: none;">
                                    <i class="fas fa-{{ $loop->index % 6 == 0 ? 'laptop' : ($loop->index % 6 == 1 ? 'mobile-alt' : ($loop->index % 6 == 2 ? 'headphones' : ($loop->index % 6 == 3 ? 'tv' : ($loop->index % 6 == 4 ? 'camera' : 'gamepad')))) }}"></i>
                                </div>
                            @else
                                <div class="category-image-fallback">
                                    <i class="fas fa-{{ $loop->index % 6 == 0 ? 'laptop' : ($loop->index % 6 == 1 ? 'mobile-alt' : ($loop->index % 6 == 2 ? 'headphones' : ($loop->index % 6 == 3 ? 'tv' : ($loop->index % 6 == 4 ? 'camera' : 'gamepad')))) }}"></i>
                                </div>
                            @endif
                        </div>
                        <div class="category-name">{{ $category->name }}</div>
                        <div class="category-count">{{ $category->products_count ?? 0 }} Products</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-4 bg-light">
    <div class="container-fluid">
        <h2 class="section-title">FEATURED PRODUCTS</h2>
        <div class="row">
            @foreach($trendingProducts->take(4) as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=300&h=200&fit=crop" 
                             class="product-image" alt="{{ $product->name }}">
                    </div>
                    <div class="product-info">
                        <h6 class="product-title">{{ $product->name }}</h6>
                        <div class="rating-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="product-price">
                            <span class="current-price">₹{{ number_format($product->price, 0) }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-add-cart flex-fill" data-product-id="{{ $product->id }}">
                                <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                            </button>
                            <button class="btn-add-wishlist" data-product-id="{{ $product->id }}">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Special Offers Section -->
@if($offerContent && $offerContent->count() > 0)
    @foreach($offerContent as $offer)
    <section class="banner-section">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="banner-content">
                        <h3>{{ $offer->title }}</h3>
                        <p>{{ $offer->subtitle }}</p>
                        @if($offer->button_text && $offer->button_url)
                            <a href="{{ $offer->button_url }}" class="btn btn-primary btn-lg">{{ $offer->button_text }}</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    @if($offer->image_url)
                        <div class="banner-image">
                            <img src="{{ $offer->image_url }}" class="img-fluid" alt="{{ $offer->title }}">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endforeach
@endif

<!-- Best Selling Products Section -->
<section class="best-selling-section">
    <div class="container-fluid">
        <div class="section-header">
            <h2 class="section-title">Best Sellers</h2>
            <p class="section-subtitle">Top products loved by our customers</p>
        </div>
        
        <div class="products-grid">
            @foreach($trendingProducts->take(8) as $index => $product)
            <div class="product-item">
                <div class="product-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=300&h=250&fit=crop" 
                         class="product-image" alt="{{ $product->name }}">
                    
                    @if($index < 3)
                    <div class="badge best-seller">
                        <i class="fas fa-crown"></i>
                    </div>
                    @endif
                    
                    @if($product->price > 5000)
                    <div class="badge discount">
                        {{ round((($product->price - 4000) / $product->price) * 100) }}% OFF
                    </div>
                    @endif
                    
                    <div class="product-overlay">
                        <button class="overlay-btn wishlist-btn" data-product-id="{{ $product->id }}">
                            <i class="far fa-heart"></i>
                        </button>
                        <button class="overlay-btn quick-view-btn" data-product-id="{{ $product->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="product-details">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    
                    <div class="product-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="review-count">({{ rand(50, 200) }})</span>
                    </div>
                    
                    <div class="product-price">
                        @if($product->price > 5000)
                            <span class="current-price">₹{{ number_format($product->price - 1000, 0) }}</span>
                            <span class="original-price">₹{{ number_format($product->price, 0) }}</span>
                        @else
                            <span class="current-price">₹{{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                    
                    <button class="add-to-cart-btn" data-product-id="{{ $product->id }}">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="view-more">
            <a href="#" class="view-more-btn">View All Best Sellers</a>
        </div>
    </div>
</section>

<!-- Beautiful Banner Section -->
<section class="beautiful-banner-section">
    <div class="banner-overlay"></div>
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="banner-content">
                    <div class="banner-badge">
                        <i class="fas fa-fire"></i>
                        <span>Limited Time Offer</span>
                    </div>
                    <h1 class="banner-title">
                        <span class="gradient-text">Summer Sale</span>
                        <br>Up to 70% Off
                    </h1>
                    <p class="banner-subtitle">
                        Discover amazing deals on premium electronics. Don't miss out on these incredible savings!
                    </p>
                    <div class="banner-features">
                        <div class="feature-item">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Free Shipping</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Secure Payment</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-undo"></i>
                            <span>Easy Returns</span>
                        </div>
                    </div>
                    <div class="banner-actions">
                        <a href="#" class="btn-banner-primary">
                            <i class="fas fa-shopping-bag"></i>
                            Shop Now
                        </a>
                        <a href="#" class="btn-banner-secondary">
                            <i class="fas fa-play"></i>
                            Watch Video
                        </a>
                    </div>
                    <div class="countdown-timer">
                        <div class="timer-item">
                            <span class="timer-number">02</span>
                            <span class="timer-label">Days</span>
                        </div>
                        <div class="timer-separator">:</div>
                        <div class="timer-item">
                            <span class="timer-number">18</span>
                            <span class="timer-label">Hours</span>
                        </div>
                        <div class="timer-separator">:</div>
                        <div class="timer-item">
                            <span class="timer-number">45</span>
                            <span class="timer-label">Minutes</span>
                        </div>
                        <div class="timer-separator">:</div>
                        <div class="timer-item">
                            <span class="timer-number">32</span>
                            <span class="timer-label">Seconds</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="banner-image-container">
                    <div class="floating-shapes">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                        <div class="shape shape-4"></div>
                    </div>
                    <div class="banner-image">
                        <img src="https://images.unsplash.com/photo-1607082349566-187342175e2f?w=600&h=500&fit=crop" 
                             alt="Summer Sale Electronics">
                    </div>
                    <div class="price-tag">
                        <span class="price-amount">₹29,999</span>
                        <span class="price-original">₹99,999</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="py-4">
    <div class="container-fluid">
        <h2 class="section-title">LATEST PRODUCTS</h2>
        <div class="row">
            @foreach($trendingProducts->skip(4)->take(8) as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=300&h=200&fit=crop" 
                             class="product-image" alt="{{ $product->name }}">
                    </div>
                    <div class="product-info">
                        <h6 class="product-title">{{ $product->name }}</h6>
                        <div class="rating-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="product-price">
                            <span class="current-price">₹{{ number_format($product->price, 0) }}</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-add-cart flex-fill" data-product-id="{{ $product->id }}">
                                <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                            </button>
                            <button class="btn-add-wishlist" data-product-id="{{ $product->id }}">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add scroll-to-top button
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollToTopBtn.className = 'scroll-to-top-btn';
    scrollToTopBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary-purple);
        color: white;
        border: none;
        font-size: 20px;
        cursor: pointer;
        z-index: 1000;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
    `;
    document.body.appendChild(scrollToTopBtn);
    
    // Show/hide scroll-to-top button based on scroll position
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) {
            scrollToTopBtn.style.opacity = '1';
            scrollToTopBtn.style.visibility = 'visible';
            scrollToTopBtn.style.transform = 'translateY(0)';
        } else {
            scrollToTopBtn.style.opacity = '0';
            scrollToTopBtn.style.visibility = 'hidden';
            scrollToTopBtn.style.transform = 'translateY(10px)';
        }
    });
    
    // Scroll to top when button is clicked
    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Add hover effect to scroll-to-top button
    scrollToTopBtn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-3px) scale(1.1)';
        this.style.boxShadow = '0 8px 20px rgba(124, 58, 237, 0.3)';
    });
    
    scrollToTopBtn.addEventListener('mouseleave', function() {
        this.style.transform = window.scrollY > 300 ? 'translateY(0) scale(1)' : 'translateY(10px) scale(1)';
        this.style.boxShadow = '0 4px 12px rgba(124, 58, 237, 0.2)';
    });
    
    // Categories navigation
    const wrapper = document.getElementById('categoriesWrapper');
    const prevArrow = document.getElementById('prevArrow');
    const nextArrow = document.getElementById('nextArrow');
    
    if (wrapper && prevArrow && nextArrow) {
        let isScrolling = false;
        
        // Pause animation on hover
        wrapper.addEventListener('mouseenter', function() {
            wrapper.style.animationPlayState = 'paused';
        });
        
        wrapper.addEventListener('mouseleave', function() {
            wrapper.style.animationPlayState = 'running';
        });
        
        // Arrow navigation
        prevArrow.addEventListener('click', function() {
            if (!isScrolling) {
                isScrolling = true;
                wrapper.style.animationPlayState = 'paused';
                wrapper.style.transform = 'translateX(150px)';
                setTimeout(() => {
                    wrapper.style.transform = '';
                    wrapper.style.animationPlayState = 'running';
                    isScrolling = false;
                }, 400);
            }
        });
        
        nextArrow.addEventListener('click', function() {
            if (!isScrolling) {
                isScrolling = true;
                wrapper.style.animationPlayState = 'paused';
                wrapper.style.transform = 'translateX(-150px)';
                setTimeout(() => {
                    wrapper.style.transform = '';
                    wrapper.style.animationPlayState = 'running';
                    isScrolling = false;
                }, 400);
            }
        });
    }
    
    // Smooth scrolling for hero buttons
    const heroButtons = document.querySelectorAll('.btn-hero-primary, .btn-hero-secondary');
    heroButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const targetElement = document.querySelector(href);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                } else if (href === '#featured') {
                    // Scroll to featured products section
                    const featuredSection = document.querySelector('.py-4.bg-light') || 
                                          document.querySelector('.product-card').closest('section');
                    if (featuredSection) {
                        featuredSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                } else if (href === '#categories') {
                    // Scroll to categories section
                    const categoriesSection = document.querySelector('.categories-section');
                    if (categoriesSection) {
                        categoriesSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            }
        });
    });
    
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -20px 0px'
    };
    
    const observer = 
     IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe product cards and other elements
    const animatedElements = document.querySelectorAll('.product-card, .category-card, .service-card');
    animatedElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(el);
    });
    
    // Add to cart functionality with better feedback
    const addToCartButtons = document.querySelectorAll('.btn-add-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Adding...';
            this.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-check me-1"></i>Added!';
                this.style.background = '#10b981';
                this.disabled = false;
                
                // Show success message
                const toast = document.createElement('div');
                toast.innerHTML = `
                    <div style="
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: #10b981;
                        color: white;
                        padding: 12px 20px;
                        border-radius: 8px;
                        z-index: 9999;
                        font-weight: 600;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                        animation: slideInRight 0.3s ease;
                    ">
                        <i class="fas fa-check me-2"></i>Product added to cart!
                    </div>
                `;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.background = '';
                }, 2000);
            }, 800);
        });
    });
    
    // Add to wishlist functionality
    const addToWishlistButtons = document.querySelectorAll('.btn-add-wishlist');
    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');
            
            if (icon.classList.contains('fas')) {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.style.background = '#f1f5f9';
                this.style.color = 'var(--primary-purple)';
            } else {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.style.background = '#fecaca';
                this.style.color = '#dc2626';
            }
        });
    });
    
    // Best Selling Products functionality - Compact Design
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-check"></i> Added!';
                this.style.background = '#10b981';
                
                // Show success message
                const toast = document.createElement('div');
                toast.innerHTML = `
                    <div style="
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: #10b981;
                        color: white;
                        padding: 12px 20px;
                        border-radius: 8px;
                        z-index: 9999;
                        font-weight: 600;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                        animation: slideInRight 0.3s ease;
                    ">
                        <i class="fas fa-check me-2"></i>Product added to cart!
                    </div>
                `;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.background = '';
                    this.disabled = false;
                }, 2000);
            }, 800);
        });
    });
    
    // Wishlist functionality
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');
            
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.classList.add('active');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.classList.remove('active');
            }
        });
    });
    
    // Quick view functionality
    const quickViewButtons = document.querySelectorAll('.quick-view-btn');
    quickViewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            showQuickViewModal(productId);
        });
    });
    
    // Quick view modal function
    function showQuickViewModal(productId) {
        const modal = document.createElement('div');
        modal.innerHTML = `
            <div class="quick-view-modal" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: fadeIn 0.3s ease;
            ">
                <div class="modal-content" style="
                    background: white;
                    border-radius: 12px;
                    padding: 20px;
                    max-width: 400px;
                    width: 90%;
                    max-height: 80vh;
                    overflow-y: auto;
                    animation: slideInUp 0.3s ease;
                ">
                    <div class="modal-header" style="
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 15px;
                    ">
                        <h5 style="margin: 0; color: var(--primary-purple);">Quick View</h5>
                        <button class="close-modal" style="
                            background: none;
                            border: none;
                            font-size: 20px;
                            cursor: pointer;
                            color: #64748b;
                        ">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Product ID: ${productId}</p>
                        <p>Quick view functionality will be implemented here.</p>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Close modal functionality
        const closeBtn = modal.querySelector('.close-modal');
        const modalOverlay = modal.querySelector('.quick-view-modal');
        
        closeBtn.addEventListener('click', () => modal.remove());
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) modal.remove();
        });
    }
    
    // Hero stats counter animation
    const statNumbers = document.querySelectorAll('.hero-stat-number');
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const text = target.textContent;
                const number = parseInt(text.replace(/\D/g, ''));
                const suffix = text.replace(/\d/g, '');
                
                if (number > 0) {
                    let current = 0;
                    const increment = number / 40;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= number) {
                            current = number;
                            clearInterval(timer);
                        }
                        
                        if (text.includes('.')) {
                            target.textContent = current.toFixed(1) + suffix;
                        } else if (number >= 1000) {
                            target.textContent = Math.floor(current / 1000) + 'K' + suffix;
                        } else {
                            target.textContent = Math.floor(current) + suffix;
                        }
                    }, 40);
                }
                
                statsObserver.unobserve(target);
            }
        });
    }, { threshold: 0.5 });
    
    statNumbers.forEach(stat => statsObserver.observe(stat));
    
    // Lazy loading for images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Countdown Timer Functionality
    function updateCountdown() {
        const now = new Date().getTime();
        const endDate = new Date(now + (2 * 24 * 60 * 60 * 1000) + (18 * 60 * 60 * 1000) + (45 * 60 * 1000) + (32 * 1000)).getTime();
        
        const timerNumbers = document.querySelectorAll('.timer-number');
        if (timerNumbers.length > 0) {
            const timeLeft = endDate - now;
            
            if (timeLeft > 0) {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                
                timerNumbers[0].textContent = days.toString().padStart(2, '0');
                timerNumbers[1].textContent = hours.toString().padStart(2, '0');
                timerNumbers[2].textContent = minutes.toString().padStart(2, '0');
                timerNumbers[3].textContent = seconds.toString().padStart(2, '0');
            } else {
                // Reset timer when it reaches zero
                timerNumbers[0].textContent = '00';
                timerNumbers[1].textContent = '00';
                timerNumbers[2].textContent = '00';
                timerNumbers[3].textContent = '00';
            }
        }
    }
    
    // Update countdown every second
    setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial call
    
    // Banner button interactions
    const bannerButtons = document.querySelectorAll('.btn-banner-primary, .btn-banner-secondary');
    bannerButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Add ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
            
            // Show success message
            const toast = document.createElement('div');
            toast.innerHTML = `
                <div style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: white;
                    padding: 15px 25px;
                    border-radius: 12px;
                    z-index: 9999;
                    font-weight: 600;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
                    animation: slideInRight 0.3s ease;
                    backdrop-filter: blur(10px);
                ">
                    <i class="fas fa-check me-2"></i>Action completed successfully!
                </div>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        });
    });
    
    // Floating shapes animation enhancement
    const shapes = document.querySelectorAll('.shape');
    shapes.forEach((shape, index) => {
        shape.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.2) rotate(180deg)';
            this.style.background = 'rgba(255, 255, 255, 0.2)';
        });
        
        shape.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.background = 'rgba(255, 255, 255, 0.1)';
        });
    });
    
    // Performance improvements
    let ticking = false;
    function updateScrollEffects() {
        const scrolled = window.pageYOffset;
        const parallax = scrolled * 0.1;
        
        // Update floating elements
        const floatingElements = document.querySelectorAll('.floating-element');
        floatingElements.forEach((element, index) => {
            const speed = (index + 1) * 0.05;
            element.style.transform = `translateY(${parallax * speed}px)`;
        });
        
        // Update banner shapes with parallax
        const bannerShapes = document.querySelectorAll('.shape');
        bannerShapes.forEach((shape, index) => {
            const speed = (index + 1) * 0.02;
            shape.style.transform = `translateY(${parallax * speed}px)`;
        });
        
        ticking = false;
    }
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateScrollEffects);
            ticking = true;
        }
    });
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .lazy {
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .lazy.loaded {
        opacity: 1;
    }
    
    .scroll-to-top-btn:hover {
        background: var(--dark-purple) !important;
    }
`;
document.head.appendChild(style);
</script>
@endsection

 