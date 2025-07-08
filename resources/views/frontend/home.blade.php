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
    }

    .hero-section {
        background: linear-gradient(135deg, var(--primary-purple), var(--light-purple));
        color: white;
        padding: 60px 0 40px 0;
        margin-bottom: 0;
    }

    .hero-content h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .hero-content p {
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
    }

    .services-section {
        padding: 50px 0;
        background: white;
        margin-top: -20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .service-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
        background: rgba(124, 58, 237, 0.02);
        border: 1px solid rgba(124, 58, 237, 0.1);
    }

    .service-card:hover {
        transform: translateY(-3px);
        background: rgba(124, 58, 237, 0.05);
        border-color: rgba(124, 58, 237, 0.2);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.1);
    }

    .service-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-purple);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }

    .service-content {
        flex: 1;
    }

    .service-content h5 {
        margin: 0 0 4px 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-purple);
    }

    .service-content p {
        margin: 0;
        font-size: 13px;
        color: var(--gray-600);
        line-height: 1.4;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-purple), var(--light-purple));
        border-radius: 2px;
    }

    /* Enhanced Categories Section */
    .categories-section {
        padding: 50px 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
        overflow: hidden;
        position: relative;
        margin-top: 0;
    }

    .categories-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(124, 58, 237, 0.03) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(168, 85, 247, 0.03) 0%, transparent 50%);
        z-index: 1;
    }

    .categories-container {
        position: relative;
        overflow: hidden;
        padding: 20px 0;
        z-index: 2;
    }

    .categories-wrapper {
        display: flex;
        animation: autoSwipe 25s infinite linear;
        gap: 25px;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        will-change: transform;
    }

    .categories-wrapper:hover {
        animation-play-state: paused;
    }

    .categories-wrapper.paused {
        animation-play-state: paused;
    }

    @keyframes autoSwipe {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    .category-card {
        background: linear-gradient(145deg, #ffffff 0%, #fafbff 100%);
        border-radius: 24px;
        padding: 25px 20px;
        text-align: center;
        border: 1px solid rgba(124, 58, 237, 0.08);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        min-width: 180px;
        flex-shrink: 0;
        box-shadow: 
            0 4px 20px rgba(124, 58, 237, 0.06),
            0 1px 3px rgba(0, 0, 0, 0.02);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        backdrop-filter: blur(10px);
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary-purple), var(--light-purple));
        opacity: 0;
        transition: all 0.4s ease;
        z-index: 1;
        border-radius: 24px;
    }

    .category-card::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: rotate(45deg);
        transition: all 0.6s ease;
        opacity: 0;
        z-index: 3;
    }

    .category-card:hover {
        border-color: var(--primary-purple);
        transform: translateY(-12px) scale(1.03);
        box-shadow: 
            0 20px 40px rgba(124, 58, 237, 0.15),
            0 8px 16px rgba(124, 58, 237, 0.1),
            0 0 0 1px rgba(124, 58, 237, 0.1);
    }

    .category-card:hover::before {
        opacity: 0.03;
    }

    .category-card:hover::after {
        opacity: 1;
        transform: translateX(100%) translateY(-100%) rotate(45deg);
    }

    .category-image-container {
        width: 90px;
        height: 90px;
        margin: 0 auto 20px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        border: 4px solid transparent;
        background: 
            linear-gradient(white, white) padding-box, 
            linear-gradient(135deg, var(--primary-purple), var(--light-purple)) border-box;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 2;
        box-shadow: 
            0 8px 25px rgba(124, 58, 237, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .category-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        filter: saturate(1.1) contrast(1.05);
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
        font-size: 32px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .category-card:hover .category-image-container {
        transform: scale(1.15) rotateY(10deg);
        box-shadow: 
            0 15px 40px rgba(124, 58, 237, 0.25),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        border-width: 6px;
    }

    .category-card:hover .category-image {
        transform: scale(1.1);
        filter: saturate(1.3) contrast(1.1) brightness(1.05);
    }

    .category-card:hover .category-image-fallback {
        transform: scale(1.1) rotate(15deg);
        box-shadow: 
            inset 0 1px 0 rgba(255, 255, 255, 0.3),
            0 0 20px rgba(124, 58, 237, 0.3);
    }

    .category-name {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1a202c;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
        letter-spacing: -0.02em;
    }

    .category-count {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 600;
        position: relative;
        z-index: 2;
        transition: all 0.3s ease;
        padding: 4px 12px;
        background: rgba(124, 58, 237, 0.08);
        border-radius: 20px;
        display: inline-block;
    }

    .category-card:hover .category-name {
        color: var(--primary-purple);
        transform: translateY(-2px);
    }

    .category-card:hover .category-count {
        color: white;
        background: var(--primary-purple);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    /* Dynamic Loading Animation */
    .category-card {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    .category-card:nth-child(1) { animation-delay: 0.1s; }
    .category-card:nth-child(2) { animation-delay: 0.2s; }
    .category-card:nth-child(3) { animation-delay: 0.3s; }
    .category-card:nth-child(4) { animation-delay: 0.4s; }
    .category-card:nth-child(5) { animation-delay: 0.5s; }
    .category-card:nth-child(6) { animation-delay: 0.6s; }
    .category-card:nth-child(7) { animation-delay: 0.7s; }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Enhanced Navigation Arrows */
    .categories-nav-arrows {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 5;
        display: flex;
        gap: 10px;
    }

    .categories-nav-arrows.left {
        left: 30px;
    }

    .categories-nav-arrows.right {
        right: 30px;
    }

    .nav-arrow {
        width: 56px;
        height: 56px;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.9));
        border: 2px solid rgba(124, 58, 237, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(20px);
        box-shadow: 
            0 8px 25px rgba(124, 58, 237, 0.12),
            0 4px 8px rgba(0, 0, 0, 0.02);
        position: relative;
        overflow: hidden;
    }

    .nav-arrow::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary-purple), var(--light-purple));
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 50%;
    }

    .nav-arrow:hover {
        transform: scale(1.1);
        border-color: var(--primary-purple);
        box-shadow: 
            0 12px 35px rgba(124, 58, 237, 0.25),
            0 6px 12px rgba(124, 58, 237, 0.15);
    }

    .nav-arrow:hover::before {
        opacity: 1;
    }

    .nav-arrow:active {
        transform: scale(1.05);
    }

    .nav-arrow i {
        font-size: 22px;
        color: var(--primary-purple);
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .nav-arrow:hover i {
        color: white;
        transform: scale(1.1);
    }

    /* Enhanced Navigation Dots */
    .categories-nav {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 25px;
        z-index: 2;
        position: relative;
    }

    .nav-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: rgba(124, 58, 237, 0.2);
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        position: relative;
    }

    .nav-dot::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: var(--primary-purple);
        transition: all 0.3s ease;
        transform: translate(-50%, -50%);
    }

    .nav-dot.active {
        background: var(--primary-purple);
        transform: scale(1.3);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .nav-dot.active::before {
        width: 100%;
        height: 100%;
    }

    .nav-dot:hover:not(.active) {
        background: var(--light-purple);
        transform: scale(1.2);
        box-shadow: 0 2px 8px rgba(124, 58, 237, 0.2);
    }

    /* Responsive Enhancements */
    @media (max-width: 768px) {
        .categories-section {
            padding: 60px 0;
        }
        
        .category-card {
            min-width: 150px;
            padding: 20px 15px;
        }
        
        .category-image-container {
            width: 70px;
            height: 70px;
        }
        
        .category-image-fallback {
            font-size: 26px;
        }
        
        .nav-arrow {
            width: 44px;
            height: 44px;
        }
        
        .nav-arrow i {
            font-size: 18px;
        }
        
        .categories-nav-arrows.left {
            left: 15px;
        }
        
        .categories-nav-arrows.right {
            right: 15px;
        }
    }

    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #f1f5f9;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
    }

    .product-info {
        padding: 20px;
    }

    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
        height: 50px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
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
        text-decoration: line-through;
        color: #94a3b8;
        font-size: 1rem;
        margin-left: 10px;
    }

    .sale-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: var(--orange);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
    }

    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #dc2626;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 2;
    }

    .btn-add-cart {
        background: var(--primary-purple);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-add-cart:hover {
        background: var(--dark-purple);
        transform: translateY(-2px);
        color: white;
    }

    .btn-add-wishlist {
        background: #f1f5f9;
        color: var(--primary-purple);
        border: 2px solid var(--primary-purple);
        padding: 10px 15px;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .btn-add-wishlist:hover {
        background: var(--primary-purple);
        color: white;
    }

    .rating-stars {
        color: #fbbf24;
        margin-bottom: 10px;
    }

    .special-offer-section {
        background: linear-gradient(135deg, var(--orange), #fb923c);
        color: white;
        padding: 60px 0;
        margin: 30px 0;
    }

    .offer-content h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .offer-content p {
        font-size: 1.2rem;
        margin-bottom: 30px;
    }

    .smart-watches-section {
        background: var(--light-gray);
        padding: 80px 0;
    }

    .power-banks-section {
        background: #1e293b;
        color: white;
        padding: 80px 0;
    }

    .power-banks-section h2 {
        font-size: 4rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .resistance-banner {
        background: linear-gradient(135deg, var(--primary-purple), var(--dark-purple));
        color: white;
        padding: 50px;
        border-radius: 20px;
        text-align: center;
    }

    .resistance-banner h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .flash-sale-section {
        background: linear-gradient(135deg, var(--primary-purple), var(--light-purple));
        color: white;
        padding: 80px 0;
        margin: 50px 0;
    }

    .flash-sale-banner h2 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .countdown {
        display: flex;
        gap: 30px;
        justify-content: center;
        margin: 30px 0;
    }

    .countdown-item {
        text-align: center;
        background: rgba(255,255,255,0.1);
        padding: 20px;
        border-radius: 10px;
        min-width: 80px;
    }

    .countdown-number {
        display: block;
        font-size: 2rem;
        font-weight: 700;
    }

    .countdown-label {
        font-size: 0.9rem;
        margin-top: 5px;
    }

    .discount-badges {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin: 40px 0;
    }

    .discount-badge-btn {
        background: var(--primary-purple);
        color: white;
        padding: 15px 30px;
        border-radius: 50px;
        font-size: 1.5rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .discount-badge-btn:hover {
        background: var(--dark-purple);
        transform: translateY(-3px);
        color: white;
    }

    /* Professional Banner Section */
    .banner-section {
        background: white;
        margin: 0;
        padding: 50px 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .banner-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        position: relative;
    }

    .feature-banner {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        border-radius: 20px;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        min-height: 200px;
        position: relative;
        overflow: hidden;
    }

    .feature-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 50%);
        z-index: 1;
    }

    .banner-content {
        z-index: 2;
        position: relative;
    }

    .banner-tag {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .banner-subtitle {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        opacity: 0.9;
    }

    .banner-text {
        font-size: 14px;
        opacity: 0.8;
        font-weight: 500;
    }

    .banner-image {
        z-index: 2;
        position: relative;
        max-width: 200px;
    }

    .banner-image img {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    /* Smart Watch Banners */
    .smart-watch-banner {
        background: linear-gradient(135deg, #1e293b, #334155);
        border-radius: 15px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: white;
        min-height: 140px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .smart-watch-banner:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .smart-watch-banner::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 60px;
        height: 60px;
        background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
        border-radius: 50%;
        transform: translate(20px, -20px);
    }

    .watch-content {
        z-index: 2;
        position: relative;
    }

    .watch-brand {
        font-size: 18px;
        font-weight: 700;
        color: #60a5fa;
        margin-bottom: 4px;
    }

    .watch-model {
        font-size: 13px;
        opacity: 0.8;
        margin-bottom: 10px;
    }

    .watch-price {
        display: flex;
        align-items: baseline;
        gap: 5px;
    }

    .price-from {
        font-size: 12px;
        opacity: 0.7;
    }

    .price-amount {
        font-size: 24px;
        font-weight: 800;
        color: #fbbf24;
    }

    .price-amount small {
        font-size: 16px;
    }

    .watch-image {
        position: absolute;
        bottom: 10px;
        right: 10px;
        z-index: 1;
        max-width: 60px;
        opacity: 0.7;
    }

    /* Discount Section */
    .discount-section {
        background: white;
        padding: 50px 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .discount-title {
        font-size: 2rem;
        font-weight: 800;
        text-align: center;
        color: #1e293b;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Modern Sale Banners */
    .modern-sale-banners {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .modern-sale-banner {
        border-radius: 20px;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        min-height: 150px;
        position: relative;
        overflow: hidden;
    }

    .modern-sale-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 70%);
        z-index: 1;
    }

    .banner-content-modern {
        z-index: 2;
        position: relative;
    }

    .banner-title {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .banner-subtitle {
        font-size: 16px;
        margin-bottom: 15px;
        opacity: 0.9;
    }

    .btn-banner {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid rgba(255,255,255,0.3);
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-banner:hover {
        background: white;
        color: #333;
        border-color: white;
        transform: translateY(-2px);
    }

    .banner-image-modern {
        z-index: 2;
        position: relative;
        max-width: 120px;
    }

    .social-icons {
        margin-top: 30px;
    }

    .social-icons i {
        font-size: 1.5rem;
        margin: 0 10px;
        color: white;
    }

    /* Enhanced Trending Products Section */
    .trending-products-section {
        background: white;
        padding: 50px 0;
        margin: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .trending-products-container {
        position: relative;
        overflow: hidden;
        padding: 0 60px;
    }

    .trending-products-row {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 10px 0;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .trending-products-row::-webkit-scrollbar {
        display: none;
    }

    .trending-product-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #f1f5f9;
        min-width: 220px;
        flex-shrink: 0;
        text-align: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .trending-product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(124, 58, 237, 0.15);
        border-color: var(--primary-purple);
    }

    .product-wishlist {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 35px;
        height: 35px;
        background: #f8fafc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .product-wishlist:hover {
        background: #fecaca;
        transform: scale(1.1);
    }

    .wishlist-icon {
        color: #6b7280;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .product-wishlist:hover .wishlist-icon {
        color: #dc2626;
    }

    .product-wishlist.active {
        background: #fecaca;
    }

    .product-wishlist.active .wishlist-icon {
        color: #dc2626;
    }

    .product-brand {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .product-image-container {
        margin: 15px 0 20px 0;
        position: relative;
    }

    .trending-product-image {
        width: 100%;
        height: 120px;
        object-fit: contain;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .trending-product-card:hover .trending-product-image {
        transform: scale(1.05);
    }

    .product-pricing {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .current-price {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .original-price {
        font-size: 14px;
        color: #ef4444;
        text-decoration: line-through;
        font-weight: 500;
    }

    .buy-now-btn {
        background: #7c3aed;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .buy-now-btn:hover {
        background: #6d28d9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    /* Trending Navigation Arrows */
    .trending-nav-arrow {
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

    .trending-nav-arrow:hover {
        background: #7c3aed;
        border-color: #7c3aed;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
    }

    .trending-nav-arrow i {
        font-size: 18px;
        color: #6b7280;
        transition: all 0.3s ease;
    }

    .trending-nav-arrow:hover i {
        color: white;
    }

    .trending-nav-left {
        left: 10px;
    }

    .trending-nav-right {
        right: 10px;
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2rem;
        }
        
        .hero-section {
            padding: 40px 0 30px 0;
            margin-bottom: 15px;
        }
        
        .services-section {
            padding: 20px 0;
            margin-top: -10px;
        }
        
        .categories-section {
            padding: 30px 0;
            margin-top: 5px;
        }
        
        .categories-container {
            padding: 15px 0;
        }
        
        .categories-nav {
            margin-top: 20px;
        }
        
        .section-title {
            margin-bottom: 20px;
        }
        
        #trending {
            padding: 25px 0;
        }
        
        .banner-section {
            margin: 15px 0;
        }
        
        .banner-container {
            padding: 0 15px;
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
        }
        
        .section-title::after {
            width: 60px;
            height: 2px;
        }
        
        .discount-section {
            padding: 20px 0;
        }
        
        .service-card {
            padding: 15px;
            gap: 12px;
        }
        
        .service-icon {
            width: 45px;
            height: 45px;
            font-size: 18px;
        }
        
        .service-content h5 {
            font-size: 14px;
        }
        
        .service-content p {
            font-size: 12px;
        }
        
        .countdown {
            gap: 15px;
        }
        
        .countdown-item {
            min-width: 60px;
            padding: 15px;
        }
        
        .countdown-number {
            font-size: 1.5rem;
        }
        
        .sale-banners {
            grid-template-columns: 1fr;
        }
        
        .discount-badges {
            flex-wrap: wrap;
        }

        .category-card {
            min-width: 140px;
        }
        
        .category-image-container {
            width: 60px;
            height: 60px;
        }
        
        .category-image-fallback {
            font-size: 24px;
        }
        
        /* Banner Mobile Responsive */
        .feature-banner {
            flex-direction: column;
            text-align: center;
            min-height: 180px;
            padding: 25px;
        }
        
        .banner-tag {
            font-size: 24px;
        }
        
        .banner-image {
            max-width: 150px;
            margin-top: 15px;
        }
        
        .smart-watch-banner {
            min-height: 120px;
            padding: 15px;
        }
        
        .watch-brand {
            font-size: 16px;
        }
        
        .price-amount {
            font-size: 20px;
        }
        
        .watch-image {
            max-width: 50px;
        }
        
        .discount-title {
            font-size: 1.5rem;
        }
        
        .modern-sale-banners {
            grid-template-columns: 1fr;
        }
        
        .modern-sale-banner {
            flex-direction: column;
            text-align: center;
            min-height: 130px;
            padding: 20px;
        }
        
        .banner-title {
            font-size: 20px;
        }
        
        .banner-image-modern {
            margin-top: 10px;
            max-width: 100px;
        }
        
        /* Trending Products Mobile Responsive */
        .trending-products-section {
            padding: 30px 0;
        }
        
        .trending-products-container {
            padding: 0 50px;
        }
        
        .trending-product-card {
            min-width: 180px;
            padding: 15px;
        }
        
        .trending-product-image {
            height: 100px;
        }
        
        .product-name {
            font-size: 14px;
        }
        
        .current-price {
            font-size: 16px;
        }
        
        .original-price {
            font-size: 12px;
        }
        
        .buy-now-btn {
            padding: 8px 15px;
            font-size: 11px;
        }
        
        .trending-nav-arrow {
            width: 40px;
            height: 40px;
        }
        
        .trending-nav-arrow i {
            font-size: 16px;
        }
        
        .trending-nav-left {
            left: 5px;
        }
        
        .trending-nav-right {
            right: 5px;
        }
        
        /* Mobile Arrow Styles */
        .categories-nav-arrows.left {
            left: 10px;
        }
        
        .categories-nav-arrows.right {
            right: 10px;
        }
        
        .nav-arrow {
            width: 40px;
            height: 40px;
        }
        
        .nav-arrow i {
            font-size: 16px;
        }
    }

    /* Additional Sections Styles */
    
    /* Discounts Products Section */
    .discounts-products-section, .smart-watches-section, .top-rated-products-section, .shop-by-discounts-section {
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .discount-product-card, .smart-watch-product-card, .top-rated-product-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #f1f5f9;
        text-align: center;
        position: relative;
        transition: all 0.3s ease;
        height: 100%;
    }

    .discount-product-card:hover, .smart-watch-product-card:hover, .top-rated-product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(124, 58, 237, 0.15);
        border-color: var(--primary-purple);
    }

    .discount-product-card .product-image, .smart-watch-product-card .product-image, .top-rated-product-card .product-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .discount-product-card .product-brand, .smart-watch-product-card .product-brand, .top-rated-product-card .product-brand {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .discount-product-card .product-name, .smart-watch-product-card .product-name, .top-rated-product-card .product-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #1f2937;
    }

    .discount-product-card .product-rating, .smart-watch-product-card .product-rating, .top-rated-product-card .product-rating {
        margin-bottom: 10px;
    }

    .discount-product-card .product-rating i, .smart-watch-product-card .product-rating i, .top-rated-product-card .product-rating i {
        color: #fbbf24;
        font-size: 14px;
    }

    .discount-product-card .current-price, .smart-watch-product-card .current-price, .top-rated-product-card .current-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-purple);
    }

    .discount-product-card .original-price, .smart-watch-product-card .original-price, .top-rated-product-card .original-price {
        font-size: 14px;
        color: #9ca3af;
        text-decoration: line-through;
        margin-left: 8px;
    }

    .discount-product-card .buy-now-btn, .smart-watch-product-card .buy-now-btn, .top-rated-product-card .buy-now-btn {
        background: var(--primary-purple);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        margin-top: 10px;
        width: 100%;
    }

    .discount-product-card .buy-now-btn:hover, .smart-watch-product-card .buy-now-btn:hover, .top-rated-product-card .buy-now-btn:hover {
        background: var(--dark-purple);
        transform: translateY(-2px);
    }

    /* Resistance Banner Section */
    .resistance-banner-section {
        background: linear-gradient(135deg, #8b5a2b, #a0522d);
        color: white;
        padding: 50px 0;
    }

    .resistance-banner {
        text-align: center;
        position: relative;
    }

    .resistance-banner .banner-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .resistance-banner .banner-subtitle {
        font-size: 1.5rem;
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .resistance-product {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Power Banks Section */
    .power-banks-section {
        background: linear-gradient(135deg, #1e293b, #334155);
        color: white;
        padding: 50px 0;
    }

    .power-bank-banner {
        text-align: center;
    }

    .power-bank-banner .banner-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 10px;
        color: #60a5fa;
    }

    .power-bank-banner .banner-subtitle {
        font-size: 1.2rem;
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .power-bank-product-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 15px;
        text-align: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .power-bank-product-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
    }

    .power-bank-product-card .product-image {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .power-bank-product-card .product-brand {
        color: #60a5fa;
        font-size: 12px;
        font-weight: 600;
    }

    .power-bank-product-card .product-name {
        color: white;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .power-bank-product-card .current-price {
        color: #fbbf24;
        font-size: 16px;
        font-weight: 700;
    }

    .power-bank-product-card .original-price {
        color: #9ca3af;
        font-size: 12px;
        text-decoration: line-through;
    }

    .power-bank-product-card .buy-now-btn {
        background: var(--primary-purple);
        padding: 8px 15px;
        font-size: 10px;
    }

    /* Flash Sale Section */
    .flash-sale-section {
        background: linear-gradient(135deg, var(--primary-purple), var(--light-purple));
        color: white;
        padding: 50px 0;
    }

    .flash-sale-banner {
        text-align: center;
        position: relative;
    }

    .flash-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 10px;
        text-transform: uppercase;
        background: linear-gradient(45deg, #fff, #fbbf24);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .flash-subtitle {
        font-size: 1.2rem;
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .flash-website {
        font-size: 1rem;
        margin: 20px 0;
        font-weight: 600;
    }

    .flash-sale-product {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 15px;
        text-align: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .flash-sale-product .product-name {
        color: white;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .flash-sale-product .product-price {
        color: #fbbf24;
        font-size: 16px;
        font-weight: 700;
    }

    /* Shop by Discounts Section */
    .discount-icons {
        text-align: center;
        margin-bottom: 30px;
    }

    .discount-icon {
        font-size: 2rem;
        margin: 0 15px;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    /* Sale Banners Section */
    .sale-banners-section {
        background: white;
        padding: 50px 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .sale-banner {
        border-radius: 20px;
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 200px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .sale-banner-1 {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .sale-banner-2 {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
    }

    .sale-banner:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .sale-banner .banner-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .sale-banner .banner-subtitle {
        font-size: 1.1rem;
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .sale-banner .btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 10px 25px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .sale-banner .btn:hover {
        background: white;
        color: #333;
        border-color: white;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .resistance-banner .banner-title {
            font-size: 2rem;
        }
        
        .power-bank-banner .banner-title {
            font-size: 1.8rem;
        }
        
        .flash-title {
            font-size: 1.8rem;
        }
        
        .sale-banner {
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        
        .sale-banner .banner-image {
            margin-top: 15px;
            max-width: 150px;
        }
        
        .discount-icon {
            font-size: 1.5rem;
            margin: 0 10px;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
@if($heroContent)
<section class="hero-section">
    <div class="container-fluid">
        <div class="banner-container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1>{{ $heroContent->title }}</h1>
                        <p>{{ $heroContent->subtitle }}</p>
                        @if($heroContent->button_text && $heroContent->button_url)
                            <a href="{{ $heroContent->button_url }}" class="btn btn-light btn-lg px-4">{{ $heroContent->button_text }}</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ $heroContent->image_url ?? 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=400&fit=crop' }}" 
                         class="img-fluid rounded" alt="{{ $heroContent->title }}">
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
        <div class="banner-container">
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
    </div>
</section>
@endif

<!-- Enhanced Categories Section -->
<section class="categories-section position-relative">
    <div class="container-fluid">
        <div class="banner-container">
            <h2 class="section-title">- CATEGORIES -</h2>
            <div class="categories-container">
                <!-- Left Navigation Arrow -->
                <div class="categories-nav-arrows left">
                    <div class="nav-arrow" id="prevArrow">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                </div>
                
                <!-- Right Navigation Arrow -->
                <div class="categories-nav-arrows right">
                    <div class="nav-arrow" id="nextArrow">
                        <i class="fas fa-chevron-right"></i>
                    </div>
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
        <div class="categories-nav">
            <div class="nav-dot active"></div>
            <div class="nav-dot"></div>
            <div class="nav-dot"></div>
        </div>
        </div>
    </div>
</section>

<!-- Trending Products Section -->
<section id="trending" class="trending-products-section">
    <div class="container-fluid">
        <div class="banner-container">
            <h2 class="section-title">TRENDING PRODUCTS</h2>
            <div class="trending-products-container">
                <div class="trending-products-row">
                    @foreach($trendingProducts->take(5) as $product)
                    <div class="trending-product-card">
                        <div class="product-wishlist">
                            <i class="far fa-heart wishlist-icon"></i>
                        </div>
                        <div class="product-brand">Airdopes</div>
                        <div class="product-name">boAt Airdopes 100</div>
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=200&h=150&fit=crop" 
                                 class="trending-product-image" alt="{{ $product->name }}">
                        </div>
                        <div class="product-pricing">
                            <span class="current-price">₹1,099</span>
                            <span class="original-price">₹3,490</span>
                        </div>
                        <button class="buy-now-btn">BUY NOW</button>
                    </div>
                    @endforeach
                </div>
                
                <!-- Navigation Arrows -->
                <div class="trending-nav-arrow trending-nav-left">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="trending-nav-arrow trending-nav-right">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Offer Section -->
@if($offerContent && $offerContent->count() > 0)
    @foreach($offerContent as $offer)
    <section class="special-offer-section">
        <div class="container-fluid">
            <div class="banner-container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="offer-content">
                            <h2>{{ $offer->title }}</h2>
                            <p>{{ $offer->subtitle }}</p>
                            @if($offer->button_text && $offer->button_url)
                                <a href="{{ $offer->button_url }}" class="btn btn-light btn-lg px-4">{{ $offer->button_text }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        @if($offer->image_url)
                            <img src="{{ $offer->image_url }}" class="img-fluid rounded" alt="{{ $offer->title }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
@endif

<!-- Flash Sale Section -->
@if($featureContent && $featureContent->count() > 0)
    @foreach($featureContent as $feature)
    <section class="flash-sale-section">
        <div class="container-fluid">
            <div class="banner-container">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        @if($feature->image_url)
                        <div class="product-card">
                            <img src="{{ $feature->image_url }}" 
                                 class="product-image" alt="{{ $feature->title }}">
                            <div class="product-info text-center">
                                <h6 class="product-title">{{ $feature->title }}</h6>
                                <small class="text-muted">{{ $feature->button_text ?? 'BUY NOW' }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-lg-8 mb-4">
                        <div class="text-center">
                            <div class="flash-sale-banner">
                                <h2>{{ $feature->title }}</h2>
                                <p class="lead">{{ $feature->subtitle }}</p>
                                @if(isset($feature->extra_data['countdown_hours']))
                                <div class="countdown">
                                    <div class="countdown-item">
                                        <span class="countdown-number">{{ $feature->extra_data['countdown_hours'] }}</span>
                                        <span class="countdown-label">HOURS</span>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="countdown-number">{{ $feature->extra_data['countdown_minutes'] }}</span>
                                        <span class="countdown-label">MINS</span>
                                    </div>
                                    <div class="countdown-item">
                                        <span class="countdown-number">{{ $feature->extra_data['countdown_seconds'] }}</span>
                                        <span class="countdown-label">SECS</span>
                                    </div>
                                </div>
                                @endif
                                <p class="mt-4">www.rubista.com</p>
                                <div class="social-icons">
                                    <i class="fab fa-facebook"></i>
                                    <i class="fab fa-twitter"></i>
                                    <i class="fab fa-instagram"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        @if($feature->image_url)
                        <div class="product-card">
                            <img src="{{ $feature->image_url }}" 
                                 class="product-image" alt="{{ $feature->title }}">
                            <div class="product-info text-center">
                                <h6 class="product-title">{{ $feature->title }}</h6>
                                <small class="text-muted">{{ $feature->button_text ?? 'BUY NOW' }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
@endif

<!-- Professional Banner Section -->
<section class="banner-section py-4">
    <div class="container-fluid">
        <div class="banner-container">
            <div class="row g-4">
                <!-- Main Feature Banner -->
                <div class="col-lg-6">
                    <div class="feature-banner shine-banner">
                        <div class="banner-content">
                            <div class="banner-tag">SHINE ON</div>
                            <div class="banner-subtitle">WHEREVER YOU GO</div>
                            <div class="banner-text">Compact size | Stylish Chrome finish</div>
                        </div>
                        <div class="banner-image">
                            <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&h=300&fit=crop" alt="Earbuds" class="img-fluid">
                        </div>
                    </div>
                </div>
                
                <!-- Smart Watch Banners -->
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="smart-watch-banner watch-banner-1">
                                <div class="watch-content">
                                    <div class="watch-brand">smart63</div>
                                    <div class="watch-model">New with 4G</div>
                                    <div class="watch-price">
                                        <span class="price-from">from</span>
                                        <span class="price-amount">₹129<small>.98</small></span>
                                    </div>
                                </div>
                                <div class="watch-image">
                                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop" alt="Smart Watch" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="smart-watch-banner watch-banner-2">
                                <div class="watch-content">
                                    <div class="watch-brand">smart63</div>
                                    <div class="watch-model">New with 4G</div>
                                    <div class="watch-price">
                                        <span class="price-from">from</span>
                                        <span class="price-amount">₹129<small>.99</small></span>
                                    </div>
                                </div>
                                <div class="watch-image">
                                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop" alt="Smart Watch" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="smart-watch-banner watch-banner-3">
                                <div class="watch-content">
                                    <div class="watch-brand">smart63</div>
                                    <div class="watch-model">New with 4G</div>
                                    <div class="watch-price">
                                        <span class="price-from">from</span>
                                        <span class="price-amount">₹129<small>.98</small></span>
                                    </div>
                                </div>
                                <div class="watch-image">
                                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop" alt="Smart Watch" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="smart-watch-banner watch-banner-4">
                                <div class="watch-content">
                                    <div class="watch-brand">smart63</div>
                                    <div class="watch-model">New with 4G</div>
                                    <div class="watch-price">
                                        <span class="price-from">from</span>
                                        <span class="price-amount">₹129<small>.99</small></span>
                                    </div>
                                </div>
                                <div class="watch-image">
                                    <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop" alt="Smart Watch" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Discount Section -->
<section class="discount-section py-4">
    <div class="container-fluid">
        <div class="banner-container">
            <div class="discount-header">
                <h2 class="discount-title">% DISCOUNTS FOR YOU</h2>
            </div>
        </div>
    </div>
</section>

<!-- Dynamic Sale Banners -->
@if($bannerContent && $bannerContent->count() > 0)
<section class="py-4">
    <div class="container-fluid">
        <div class="banner-container">
            <div class="modern-sale-banners">
                @foreach($bannerContent as $banner)
                <div class="modern-sale-banner" style="background: linear-gradient(135deg, {{ $banner->extra_data['background_color'] ?? '#f97316' }}, {{ $banner->extra_data['background_color'] ?? '#fb923c' }});">
                    <div class="banner-content-modern">
                        <h3 class="banner-title">{{ $banner->title }}</h3>
                        <p class="banner-subtitle">{{ $banner->subtitle }}</p>
                        @if($banner->button_text && $banner->button_url)
                            <a href="{{ $banner->button_url }}" class="btn btn-banner">{{ $banner->button_text }}</a>
                        @endif
                    </div>
                    @if($banner->image_url)
                    <div class="banner-image-modern">
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="img-fluid">
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<!-- % Discounts For You Section -->
<section class="discounts-products-section py-5">
    <div class="container-fluid">
        <div class="banner-container">
            <h2 class="section-title">% DISCOUNTS FOR YOU</h2>
            <div class="row">
                @foreach($trendingProducts->take(5) as $product)
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <div class="discount-product-card">
                        <div class="product-wishlist">
                            <i class="far fa-heart wishlist-icon"></i>
                        </div>
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=200&h=150&fit=crop" 
                                 class="product-image" alt="{{ $product->name }}">
                        </div>
                        <div class="product-info">
                            <div class="product-brand">boAt</div>
                            <div class="product-name">boAt Airdopes 100</div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-pricing">
                                <span class="current-price">₹1,099</span>
                                <span class="original-price">₹3,490</span>
                            </div>
                            <button class="btn btn-primary buy-now-btn">BUY NOW</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Smart Watches Section -->
<section class="smart-watches-section py-5">
    <div class="container-fluid">
        <div class="banner-container">
            <h2 class="section-title">SMART WATCHES</h2>
            <div class="row">
                @foreach($trendingProducts->take(2) as $product)
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="smart-watch-product-card">
                        <div class="product-wishlist">
                            <i class="far fa-heart wishlist-icon"></i>
                        </div>
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&h=200&fit=crop" 
                                 class="product-image" alt="Smart Watch">
                        </div>
                        <div class="product-info">
                            <div class="product-brand">boAt</div>
                            <div class="product-name">Smart Watch Pro</div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-pricing">
                                <span class="current-price">₹2,999</span>
                                <span class="original-price">₹5,999</span>
                            </div>
                            <button class="btn btn-primary buy-now-btn">BUY NOW</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Resistance Banner Section -->
<section class="resistance-banner-section py-5">
    <div class="container-fluid">
        <div class="banner-container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="resistance-banner">
                        <h2 class="banner-title">Resistance</h2>
                        <p class="banner-subtitle">The Way You</p>
                        <div class="banner-image">
                            <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=500&h=300&fit=crop" 
                                 class="img-fluid" alt="Resistance">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="resistance-product">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=300&h=200&fit=crop" 
                                 class="img-fluid" alt="Product">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Power Banks Section -->
<section class="power-banks-section py-5">
    <div class="container-fluid">
        <div class="banner-container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="power-bank-banner">
                        <h2 class="banner-title">20000mAh</h2>
                        <p class="banner-subtitle">POWER BANKS</p>
                        <div class="banner-image">
                            <img src="https://images.unsplash.com/photo-1609592439804-9e7fcd4c4c7d?w=400&h=300&fit=crop" 
                                 class="img-fluid" alt="Power Bank">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        @foreach($trendingProducts->take(2) as $product)
                        <div class="col-6 mb-3">
                            <div class="power-bank-product-card">
                                <div class="product-wishlist">
                                    <i class="far fa-heart wishlist-icon"></i>
                                </div>
                                <div class="product-image-container">
                                    <img src="https://images.unsplash.com/photo-1609592439804-9e7fcd4c4c7d?w=200&h=150&fit=crop" 
                                         class="product-image" alt="Power Bank">
                                </div>
                                <div class="product-info">
                                    <div class="product-brand">boAt</div>
                                    <div class="product-name">Power Bank 20000mAh</div>
                                    <div class="product-pricing">
                                        <span class="current-price">₹1,999</span>
                                        <span class="original-price">₹3,999</span>
                                    </div>
                                    <button class="btn btn-primary buy-now-btn">BUY NOW</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Top Rated Products Section -->
<section class="top-rated-products-section py-5">
    <div class="container-fluid">
        <div class="banner-container">
            <h2 class="section-title">TOP RATED PRODUCTS</h2>
            <div class="row">
                @foreach($trendingProducts->take(5) as $product)
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <div class="top-rated-product-card">
                        <div class="product-wishlist">
                            <i class="far fa-heart wishlist-icon"></i>
                        </div>
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=200&h=150&fit=crop" 
                                 class="product-image" alt="{{ $product->name }}">
                        </div>
                        <div class="product-info">
                            <div class="product-brand">Airdopes</div>
                            <div class="product-name">boAt Airdopes 100</div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-pricing">
                                <span class="current-price">₹1,099</span>
                                <span class="original-price">₹3,490</span>
                            </div>
                            <button class="btn btn-primary buy-now-btn">BUY NOW</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Flash Sale Section -->
<section class="flash-sale-section py-5">
    <div class="container-fluid">
        <div class="banner-container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="flash-sale-product">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=200&h=150&fit=crop" 
                                 class="img-fluid" alt="Flash Sale Product">
                        </div>
                        <div class="product-info">
                            <div class="product-name">boAt Airdopes 100</div>
                            <div class="product-price">₹1,099</div>
                            <small class="text-muted">BUY NOW</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="flash-sale-banner">
                        <h2 class="flash-title">Flash Sale</h2>
                        <p class="flash-subtitle">Premium Headphones at Crazy Prices!</p>
                        <div class="flash-logo">
                            <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=100&h=100&fit=crop" 
                                 class="img-fluid" alt="Flash Sale">
                        </div>
                        <div class="flash-website">www.rubista.com</div>
                        <div class="social-icons">
                            <i class="fab fa-facebook"></i>
                            <i class="fab fa-twitter"></i>
                            <i class="fab fa-instagram"></i>
                            <i class="fab fa-youtube"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <div class="flash-sale-product">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=200&h=150&fit=crop" 
                                 class="img-fluid" alt="Flash Sale Product">
                        </div>
                        <div class="product-info">
                            <div class="product-name">boAt Airdopes 100</div>
                            <div class="product-price">₹1,099</div>
                            <small class="text-muted">BUY NOW</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Shop by Discounts Section -->
<section class="shop-by-discounts-section py-5">
    <div class="container-fluid">
        <div class="banner-container">
            <h2 class="section-title">Shop by Discounts</h2>
            <div class="discount-icons">
                <span class="discount-icon">🛍️</span>
                <span class="discount-icon">💳</span>
                <span class="discount-icon">🎁</span>
                <span class="discount-icon">💰</span>
            </div>
            <div class="row">
                @foreach($trendingProducts->take(4) as $product)
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <div class="discount-product-card">
                        <div class="product-wishlist">
                            <i class="far fa-heart wishlist-icon"></i>
                        </div>
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=200&h=150&fit=crop" 
                                 class="product-image" alt="{{ $product->name }}">
                        </div>
                        <div class="product-info">
                            <div class="product-brand">boAt</div>
                            <div class="product-name">boAt Airdopes 100</div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="product-pricing">
                                <span class="current-price">₹1,099</span>
                                <span class="original-price">₹3,490</span>
                            </div>
                            <button class="btn btn-primary buy-now-btn">BUY NOW</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Sale Banners Section -->
<section class="sale-banners-section py-5">
    <div class="container-fluid">
        <div class="banner-container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="sale-banner sale-banner-1">
                        <div class="banner-content">
                            <h3 class="banner-title">MEGA SALE</h3>
                            <p class="banner-subtitle">Up to 70% Off</p>
                            <button class="btn btn-light">Shop Now</button>
                        </div>
                        <div class="banner-image">
                            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=300&h=200&fit=crop" 
                                 class="img-fluid" alt="Sale Banner">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="sale-banner sale-banner-2">
                        <div class="banner-content">
                            <h3 class="banner-title">HEADPHONE</h3>
                            <p class="banner-subtitle">Premium Quality</p>
                            <button class="btn btn-light">Shop Now</button>
                        </div>
                        <div class="banner-image">
                            <img src="https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=300&h=200&fit=crop" 
                                 class="img-fluid" alt="Headphone Banner">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recommended Items -->
<section class="py-4">
    <div class="container-fluid">
        <div class="banner-container">
            <h2 class="section-title">RECOMMENDED ITEMS FOR YOU</h2>
            <div class="row">
                @foreach($trendingProducts as $product)
                <div class="col-lg-2 col-md-4 col-6 mb-4">
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
    </div>
</section>
@endsection

@section('additional-content')
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Categories navigation elements
    const dots = document.querySelectorAll('.nav-dot');
    const wrapper = document.querySelector('.categories-wrapper');
    const prevArrow = document.getElementById('prevArrow');
    const nextArrow = document.getElementById('nextArrow');
    const categoryCards = document.querySelectorAll('.category-card');
    
    let currentSlide = 0;
    let isAnimating = false;
    let autoSlideInterval;
    let touchStartX = 0;
    let touchEndX = 0;
    
    // Calculate slide width (responsive)
    const getSlideWidth = () => {
        const card = document.querySelector('.category-card');
        return card ? card.offsetWidth + 25 : 200; // card width + gap
    };
    
    // Pause and resume animation functions
    function pauseAnimation() {
        wrapper.style.animationPlayState = 'paused';
        wrapper.classList.add('paused');
    }
    
    function resumeAnimation() {
        wrapper.style.animationPlayState = 'running';
        wrapper.classList.remove('paused');
    }
    
    // Add ripple effect to navigation elements
    function createRipple(element, event) {
        const circle = document.createElement('span');
        const diameter = Math.max(element.clientWidth, element.clientHeight);
        const radius = diameter / 2;
        
        circle.style.width = circle.style.height = `${diameter}px`;
        circle.style.left = `${event.clientX - element.offsetLeft - radius}px`;
        circle.style.top = `${event.clientY - element.offsetTop - radius}px`;
        circle.classList.add('ripple');
        
        const ripple = element.getElementsByClassName('ripple')[0];
        if (ripple) {
            ripple.remove();
        }
        
        element.appendChild(circle);
        
        setTimeout(() => {
            circle.remove();
        }, 600);
    }
    
    // Enhanced navigation function with smooth transitions
    function navigateToSlide(direction, immediate = false) {
        if (isAnimating && !immediate) return;
        
        isAnimating = true;
        pauseAnimation();
        
        // Calculate new position
        if (direction === 'next') {
            currentSlide = (currentSlide + 1) % 3;
        } else {
            currentSlide = (currentSlide - 1 + 3) % 3;
        }
        
        // Smooth transform animation
        const slideWidth = getSlideWidth();
        const translateX = -currentSlide * slideWidth * 2;
        
        wrapper.style.transition = 'transform 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        wrapper.style.transform = `translateX(${translateX}px)`;
        
        // Update active dot with animation
        updateActiveDot(currentSlide);
        
        // Resume animation after delay
        setTimeout(() => {
            wrapper.style.transition = '';
            wrapper.style.transform = '';
            resumeAnimation();
            isAnimating = false;
        }, immediate ? 0 : 4000);
    }
    
    // Update active dot with smooth animation
    function updateActiveDot(index) {
        dots.forEach((d, i) => {
            d.classList.remove('active');
            if (i === index) {
                setTimeout(() => d.classList.add('active'), 100);
            }
        });
    }
    
    // Enhanced arrow navigation with haptic feedback
    function setupArrowNavigation() {
        [prevArrow, nextArrow].forEach(arrow => {
            arrow.addEventListener('click', function(e) {
                createRipple(this, e);
                
                // Haptic feedback (if supported)
                if (navigator.vibrate) {
                    navigator.vibrate(50);
                }
                
                const direction = this.id === 'nextArrow' ? 'next' : 'prev';
                navigateToSlide(direction);
            });
            
            // Enhanced hover effects
            arrow.addEventListener('mouseenter', function() {
                pauseAnimation();
                this.style.transform = 'translateY(-50%) scale(1.1)';
            });
            
            arrow.addEventListener('mouseleave', function() {
                resumeAnimation();
                this.style.transform = 'translateY(-50%) scale(1)';
            });
        });
    }
    
    // Enhanced dots navigation
    function setupDotsNavigation() {
        dots.forEach((dot, index) => {
            dot.addEventListener('click', function(e) {
                if (isAnimating) return;
                
                createRipple(this, e);
                
                isAnimating = true;
                pauseAnimation();
                
                currentSlide = index;
                
                const slideWidth = getSlideWidth();
                const translateX = -currentSlide * slideWidth * 2;
                
                wrapper.style.transition = 'transform 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                wrapper.style.transform = `translateX(${translateX}px)`;
                
                updateActiveDot(currentSlide);
                
                setTimeout(() => {
                    wrapper.style.transition = '';
                    wrapper.style.transform = '';
                    resumeAnimation();
                    isAnimating = false;
                }, 4000);
            });
            
            // Dot hover effects
            dot.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'scale(1.2)';
                }
            });
            
            dot.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'scale(1)';
                }
            });
        });
    }
    
    // Touch/Swipe navigation
    function setupTouchNavigation() {
        wrapper.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
            pauseAnimation();
        });
        
        wrapper.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            resumeAnimation();
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const swipeDistance = touchEndX - touchStartX;
            
            if (Math.abs(swipeDistance) > swipeThreshold) {
                if (swipeDistance > 0) {
                    navigateToSlide('prev'); // Swipe right
                } else {
                    navigateToSlide('next'); // Swipe left
                }
            }
        }
    }
    
    // Enhanced keyboard navigation
    function setupKeyboardNavigation() {
        document.addEventListener('keydown', function(e) {
            // Only activate when categories section is in view
            const categoriesSection = document.querySelector('.categories-section');
            const rect = categoriesSection.getBoundingClientRect();
            const isInView = rect.top >= 0 && rect.bottom <= window.innerHeight;
            
            if (isInView) {
                switch(e.key) {
                    case 'ArrowLeft':
                        e.preventDefault();
                        navigateToSlide('prev');
                        break;
                    case 'ArrowRight':
                        e.preventDefault();
                        navigateToSlide('next');
                        break;
                    case ' ': // Spacebar to pause/resume
                        e.preventDefault();
                        if (wrapper.style.animationPlayState === 'paused') {
                            resumeAnimation();
                        } else {
                            pauseAnimation();
                        }
                        break;
                }
            }
        });
    }
    
    // Auto-slide with dynamic timing
    function setupAutoSlide() {
        autoSlideInterval = setInterval(() => {
            if (!isAnimating && document.visibilityState === 'visible') {
                navigateToSlide('next', true);
            }
        }, 8000);
        
        // Pause auto-slide when tab is not visible
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                pauseAnimation();
            } else {
                resumeAnimation();
            }
        });
    }
    
    // Intersection Observer for performance
    function setupIntersectionObserver() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    resumeAnimation();
                } else {
                    pauseAnimation();
                }
            });
        }, {
            threshold: 0.5
        });
        
        observer.observe(document.querySelector('.categories-section'));
    }
    
    // Enhanced category card interactions
    function setupCategoryCardEffects() {
        categoryCards.forEach((card, index) => {
            card.addEventListener('mouseenter', function() {
                // Pause auto-slide on hover
                pauseAnimation();
                
                // Add subtle animation to neighboring cards
                const prevCard = categoryCards[index - 1];
                const nextCard = categoryCards[index + 1];
                
                if (prevCard) {
                    prevCard.style.transform = 'translateY(-4px) scale(0.98)';
                }
                if (nextCard) {
                    nextCard.style.transform = 'translateY(-4px) scale(0.98)';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                resumeAnimation();
                
                // Reset neighboring cards
                const prevCard = categoryCards[index - 1];
                const nextCard = categoryCards[index + 1];
                
                if (prevCard) {
                    prevCard.style.transform = '';
                }
                if (nextCard) {
                    nextCard.style.transform = '';
                }
            });
        });
    }
    
    // Initialize all functionality
    setupArrowNavigation();
    setupDotsNavigation();
    setupTouchNavigation();
    setupKeyboardNavigation();
    setupAutoSlide();
    setupIntersectionObserver();
    setupCategoryCardEffects();
    
    // Add ripple effect styles
    const style = document.createElement('style');
    style.textContent = `
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(124, 58, 237, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Responsive handling
    window.addEventListener('resize', function() {
        // Reset transforms on resize
        wrapper.style.transform = '';
        currentSlide = 0;
        updateActiveDot(0);
    });
});
</script>
@endsection

 