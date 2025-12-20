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

    /* Hero Section - Ultra Compact */
    .hero-section {
        background: linear-gradient(135deg, #5b63d3 0%, #7c3aed 100%);
        color: white;
        padding: 30px 0;
        margin-bottom: 0;
        position: relative;
        overflow: hidden;
        min-height: 280px;
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
        padding: 15px 0;
    }

    .hero-content {
        position: relative;
        z-index: 3;
        animation: fadeInUp 0.8s ease-out;
        padding: 0;
        margin: 0;
    }

    .hero-content h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.2;
        position: relative;
        letter-spacing: -0.02em;
    }

    .hero-content h1 .highlight {
        color: #fbbf24;
    }

    .hero-content .subtitle {
        font-size: 0.875rem;
        margin-bottom: 16px;
        opacity: 0.95;
        line-height: 1.5;
        font-weight: 400;
        max-width: 600px;
    }

    .hero-content .highlight {
        color: #fbbf24;
        font-weight: 600;
    }

    .hero-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .btn-hero-primary {
        background: white;
        color: #7c3aed;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-hero-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        color: #7c3aed;
    }

    .btn-hero-secondary {
        background: transparent;
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 8px 18px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .btn-hero-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: white;
        transform: translateY(-2px);
    }

    .hero-stats {
        display: flex;
        gap: 20px;
    }

    .hero-stat {
        text-align: left;
    }

    .hero-stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        display: block;
        line-height: 1;
    }

    .hero-stat-label {
        font-size: 0.75rem;
        opacity: 0.8;
        margin-top: 4px;
    }

    .hero-image-container {
        position: relative;
        animation: slideInRight 1s ease-out 0.5s both;
        text-align: center;
    }

    .hero-image {
        width: 100%;
        max-width: 380px;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
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

    /* Services Section - Ultra Compact */
    .services-section {
        padding: 20px 0;
        background: #f8f9fa;
        margin-top: 0;
    }

    .service-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
        background: white;
        border: 1px solid #e5e7eb;
    }

    .service-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border-color: #7c3aed;
    }

    .service-icon {
        width: 36px;
        height: 36px;
        background: #f3e8ff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7c3aed;
        font-size: 16px;
        flex-shrink: 0;
    }

    .service-content {
        flex: 1;
    }

    .service-content h5 {
        margin: 0 0 2px 0;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-purple);
    }

    .service-content p {
        margin: 0;
        font-size: 0.7rem;
        color: var(--gray-600);
        line-height: 1.3;
    }

    /* Section Title - Compact Design */
    .section-title {
        font-size: 1.35rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
        color: #1a202c;
        position: relative;
        padding-bottom: 0;
        letter-spacing: -0.02em;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-purple), var(--light-purple));
        border-radius: 2px;
    }

    /* Ultra Compact section spacing */
    section:not(.hero-section):not(.beautiful-banner-section) {
        padding: 25px 0;
        margin: 0;
    }

    /* Remove extra spacing between sections */
    section + section {
        margin-top: 0;
    }

    /* Alternating section backgrounds for visual separation */
    .featured-products-section {
        background: #ffffff;
    }

    .latest-products-section {
        background: #f8fafc;
    }

    /* Flash Deal Banner */
    .flash-deal-banner {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        padding: 25px 0;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .flash-deal-banner::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1), transparent);
        animation: pulse 3s infinite;
    }

    .deal-content {
        position: relative;
        z-index: 2;
    }

    .deal-badge {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 10px;
        backdrop-filter: blur(10px);
    }

    .deal-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .deal-subtitle {
        font-size: 0.95rem;
        opacity: 0.95;
        margin-bottom: 15px;
    }

    .deal-timer {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 15px;
    }

    .timer-box {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 10px 15px;
        border-radius: 8px;
        text-align: center;
        min-width: 60px;
    }

    .timer-number {
        font-size: 1.5rem;
        font-weight: 700;
        display: block;
    }

    .timer-label {
        font-size: 0.7rem;
        opacity: 0.9;
        text-transform: uppercase;
    }

    /* Deal of the Day */
    .deal-of-day {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px 0;
        color: white;
    }

    .deal-card {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .deal-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .deal-discount {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ff6b6b;
        color: white;
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    /* Brand Showcase */
    .brands-section {
        background: #f8f9fa;
        padding: 25px 0;
    }

    .brand-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 15px;
    }

    .brand-item {
        background: white;
        padding: 20px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        aspect-ratio: 1;
    }

    .brand-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .brand-item img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: grayscale(100%);
        transition: filter 0.3s ease;
    }

    .brand-item:hover img {
        filter: grayscale(0%);
    }

    /* Testimonials */
    .testimonials-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 30px 0;
    }

    .testimonial-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .testimonial-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    .testimonial-stars {
        color: #fbbf24;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }

    .testimonial-text {
        font-size: 0.9rem;
        color: #64748b;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .author-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #a78bfa);
    }

    .author-info h4 {
        font-size: 0.9rem;
        font-weight: 600;
        margin: 0;
        color: #1e293b;
    }

    .author-info p {
        font-size: 0.75rem;
        margin: 0;
        color: #94a3b8;
    }

    /* Newsletter */
    .newsletter-section {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        padding: 35px 0;
        color: white;
    }

    .newsletter-content {
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
    }

    .newsletter-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .newsletter-subtitle {
        font-size: 0.95rem;
        opacity: 0.9;
        margin-bottom: 20px;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
        max-width: 500px;
        margin: 0 auto;
    }

    .newsletter-input {
        flex: 1;
        padding: 12px 20px;
        border-radius: 25px;
        border: none;
        font-size: 0.95rem;
    }

    .newsletter-btn {
        background: #7c3aed;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .newsletter-btn:hover {
        background: #6d28d9;
        transform: translateY(-2px);
    }

    /* Categories Section - Compact */
    .categories-section {
        padding: 25px 0;
        background: #ffffff;
        overflow: hidden;
        position: relative;
    }

    .categories-container {
        position: relative;
        overflow: hidden;
        padding: 10px 0;
    }

    .categories-wrapper {
        display: flex;
        gap: 15px;
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
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        border: 1px solid rgba(124, 58, 237, 0.08);
        transition: all 0.3s ease;
        min-width: 120px;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        position: relative;
        cursor: pointer;
    }

    .category-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.12);
        border-color: var(--primary-purple);
    }

    .category-image-container {
        width: 50px;
        height: 50px;
        margin: 0 auto 8px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid rgba(124, 58, 237, 0.1);
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
        font-size: 20px;
    }

    .category-name {
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 4px;
        color: #1a202c;
    }

    .category-count {
        font-size: 0.7rem;
        color: #64748b;
        font-weight: 500;
        padding: 2px 7px;
        background: rgba(124, 58, 237, 0.08);
        border-radius: 10px;
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
        width: 44px;
        height: 44px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .nav-arrow:hover {
        background: var(--primary-purple);
        border-color: var(--primary-purple);
        transform: translateY(-50%) scale(1.05);
    }

    .nav-arrow i {
        font-size: 16px;
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

    /* 5 Products Per Row */
    .col-5-per-row {
        flex: 0 0 auto;
        width: 20%;
    }

    @media (max-width: 991px) {
        .col-5-per-row {
            width: 33.333%;
        }
    }

    @media (max-width: 767px) {
        .col-5-per-row {
            width: 50%;
        }
    }

    @media (max-width: 575px) {
        .col-5-per-row {
            width: 100%;
        }
    }

    /* Product Cards - Compact Style */
    .product-card-link,
    .product-item-link {
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
    }
    
    .product-card-link:hover,
    .product-item-link:hover {
        text-decoration: none;
        color: inherit;
    }
    
    .product-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        cursor: pointer;
    }

    .product-card-link:hover .product-card,
    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        border-color: #d1d5db;
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .product-info {
        padding: 12px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        gap: 6px;
    }

    .product-title {
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0;
        color: #1e293b;
        min-height: 38px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 1.4;
    }

    .rating-stars {
        color: #fbbf24;
        margin-bottom: 6px;
        font-size: 0.75rem;
        height: 14px;
    }

    .product-price {
        margin-bottom: 10px;
        margin-top: auto;
        min-height: 24px;
        display: flex;
        align-items: center;
    }

    .current-price {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-purple);
    }

    .original-price {
        text-decoration: line-through;
        color: #94a3b8;
        font-size: 0.75rem;
        margin-left: 5px;
    }

    .btn-add-cart {
        background: #7c3aed;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-add-cart:hover {
        background: #6d28d9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        color: white;
    }

    .btn-add-wishlist {
        background: #f1f5f9;
        color: var(--primary-purple);
        border: 2px solid var(--primary-purple);
        padding: 5px 8px;
        border-radius: 16px;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 32px;
        width: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .btn-add-wishlist:hover {
        background: var(--primary-purple);
        color: white;
    }

    /* Button container for uniform alignment */
    .d-flex.gap-2 {
        display: flex !important;
        gap: 0.5rem !important;
        align-items: stretch !important;
        margin-top: auto;
    }

    .d-flex.gap-2 .flex-fill {
        flex: 1 1 auto !important;
    }

    /* Best Selling Products Section - Compact Design */
    .best-selling-section {
        padding: 28px 0;
        background: #f8fafc;
    }

    .section-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .section-header .section-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 5px;
        padding-bottom: 8px;
    }

    .section-header .section-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    @media (max-width: 1200px) {
        .products-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 991px) {
        .products-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 767px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 575px) {
        .products-grid {
            grid-template-columns: repeat(1, 1fr);
        }
    }

    .product-item {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        height: 100%;
        cursor: pointer;
    }

    .product-item-link:hover .product-item,
    .product-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.12);
    }

    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 200px;
        flex-shrink: 0;
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
        padding: 3px 8px;
        border-radius: 14px;
        font-size: 0.65rem;
        font-weight: 600;
        z-index: 10;
    }

    .badge.best-seller {
        top: 8px;
        left: 8px;
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
        box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
    }

    .badge.discount {
        top: 8px;
        right: 50px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        z-index: 5;
    }

    .product-overlay {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        opacity: 1;
        transform: translateX(0);
        transition: all 0.3s ease;
        z-index: 15;
    }

    .product-item:hover .product-overlay {
        opacity: 1;
        transform: translateX(0);
    }
    
    /* Ensure overlay buttons are always visible in best seller section */
    .best-selling-section .product-overlay {
        opacity: 1;
        transform: translateX(0);
    }

    .overlay-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: white;
        border: none;
        color: var(--primary-purple);
        font-size: 0.7rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
        padding: 12px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 6px;
        line-height: 1.35;
        height: 38px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 6px;
        height: 14px;
    }

    .stars {
        color: #fbbf24;
        font-size: 0.75rem;
    }

    .review-count {
        font-size: 0.7rem;
        color: #64748b;
    }

    .product-price {
        margin-bottom: 12px;
        margin-top: auto;
        min-height: 28px;
        display: flex;
        align-items: center;
    }

    .current-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-purple);
    }

    .original-price {
        font-size: 0.8rem;
        color: #94a3b8;
        text-decoration: line-through;
        margin-left: 6px;
    }

    .add-to-cart-btn {
        width: 100%;
        background: var(--primary-purple);
        color: white;
        border: none;
        padding: 7px 12px;
        border-radius: 16px;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        height: 32px;
    }

    .add-to-cart-btn:hover {
        background: var(--dark-purple);
        transform: translateY(-1px);
    }

    .view-more {
        text-align: center;
        margin-top: 25px;
    }

    .view-more-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        color: var(--primary-purple);
        border: 2px solid var(--primary-purple);
        padding: 8px 20px;
        border-radius: 18px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
        min-width: 140px;
        height: 36px;
    }

    .view-more-btn:hover {
        background: var(--primary-purple);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    /* Beautiful Banner Section - Compact */
    .beautiful-banner-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #f5576c 75%, #4facfe 100%);
        position: relative;
        padding: 30px 0;
        overflow: hidden;
        min-height: 320px;
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
        padding: 15px 0;
    }

    .banner-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-bottom: 12px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: pulse 2s infinite;
    }

    .banner-badge i {
        color: #ff6b6b;
        animation: fire 1.5s infinite;
    }

    .banner-title {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 10px;
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
        font-size: 0.85rem;
        margin-bottom: 14px;
        opacity: 0.95;
        line-height: 1.5;
        font-weight: 400;
    }

    .banner-features {
        display: flex;
        gap: 10px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 5px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 5px 10px;
        border-radius: 14px;
        font-size: 0.7rem;
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
        font-size: 0.75rem;
    }

    .banner-actions {
        display: flex;
        gap: 10px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .btn-banner-primary {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
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
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
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
        gap: 8px;
        align-items: center;
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(15px);
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: inline-flex;
    }

    .timer-item {
        text-align: center;
        min-width: 40px;
    }

    .timer-number {
        display: block;
        font-size: 1.1rem;
        font-weight: 800;
        color: #ffd700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .timer-label {
        display: block;
        font-size: 0.6rem;
        opacity: 0.8;
        margin-top: 2px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .timer-separator {
        font-size: 1rem;
        font-weight: 700;
        color: #ffd700;
        margin-top: -6px;
    }

    .banner-image-container {
        position: relative;
        text-align: center;
        padding: 20px 0;
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
        max-width: 85%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .banner-image:hover img {
        transform: scale(1.05);
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
    }

    .price-tag {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        padding: 10px 14px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
        z-index: 3;
        animation: bounce 2s infinite;
    }

    .price-amount {
        display: block;
        font-size: 1.1rem;
        font-weight: 800;
        color: #ffd700;
    }

    .price-original {
        display: block;
        font-size: 0.75rem;
        text-decoration: line-through;
        opacity: 0.7;
        margin-top: 3px;
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

    /* Featured & Latest Products Sections - Compact */
    .featured-products-section,
    .latest-products-section {
        padding: 28px 0;
        background: #ffffff;
    }

    /* Compact row gaps across all product grids */
    .row.g-4 {
        --bs-gutter-x: 1rem;
        --bs-gutter-y: 1rem;
    }

    /* Banner Sections - Compact */
    .banner-section {
        background: white;
        padding: 28px 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    .feature-banner {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        border-radius: 10px;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
        min-height: 120px;
        position: relative;
        overflow: hidden;
    }

    .banner-content h3 {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .banner-content p {
        font-size: 0.85rem;
        margin-bottom: 8px;
    }

    .banner-image img {
        max-width: 130px;
        border-radius: 6px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .brand-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .testimonial-grid {
            grid-template-columns: repeat(1, 1fr);
        }
        
        .newsletter-form {
            flex-direction: column;
        }
        
        .deal-title {
            font-size: 1.35rem;
        }
        
        .hero-content h1 {
            font-size: 1.6rem;
        }
        
        .hero-section {
            min-height: 40vh;
            padding: 20px 0;
        }
        
        .hero-container {
            padding: 12px 0;
        }
        
        .hero-content {
            padding-left: 20px;
            margin-left: 8px;
            padding-top: 12px;
            padding-bottom: 12px;
            padding-right: 12px;
            border-left: 2px solid rgba(251, 191, 36, 0.4);
        }
        
        .hero-content .subtitle {
            font-size: 0.85rem;
            margin-bottom: 0.9rem;
        }
        
        .hero-stats {
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .hero-stat-number {
            font-size: 1.2rem;
        }
        
        .hero-actions {
            gap: 0.5rem;
            margin-bottom: 0.9rem;
        }
        
        .btn-hero-primary,
        .btn-hero-secondary {
            padding: 7px 16px;
            font-size: 0.8rem;
            min-width: 110px;
        }
        
        .hero-image {
            max-width: 300px;
        }
        
        .services-section {
            padding: 18px 0;
        }
        
        .service-card {
            padding: 9px;
        }
        
        .service-icon {
            width: 34px;
            height: 34px;
            font-size: 14px;
        }
        
        .categories-section {
            padding: 25px 0;
        }
        
        .category-card {
            min-width: 110px;
            padding: 9px;
        }
        
        .category-image-container {
            width: 48px;
            height: 48px;
        }
        
        .category-image-fallback {
            font-size: 18px;
        }
        
        .category-name {
            font-size: 0.8rem;
        }
        
        .category-count {
            font-size: 0.65rem;
        }
        
        .nav-arrow {
            width: 40px;
            height: 40px;
        }
        
        .nav-arrow i {
            font-size: 14px;
        }
        
        .nav-arrow.left {
            left: 10px;
        }
        
        .nav-arrow.right {
            right: 10px;
        }
        
        .section-title {
            font-size: 1.25rem;
            margin-bottom: 18px;
        }
        
        .feature-banner {
            flex-direction: column;
            text-align: center;
            padding: 14px;
        }
        
        .banner-content h3 {
            font-size: 1.2rem;
        }
        
        .banner-content p {
            font-size: 0.8rem;
        }
        
        .banner-image img {
            max-width: 120px;
            margin-top: 12px;
        }
        
        /* All Product Sections Responsive */
        .featured-products-section,
        .latest-products-section,
        .best-selling-section {
            padding: 25px 0;
        }
        
        .section-header .section-title {
            font-size: 1.25rem;
        }
        
        .section-header .section-subtitle {
            font-size: 0.8rem;
        }
        
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
        }
        
        .row.g-4 {
            --bs-gutter-x: 0.8rem;
            --bs-gutter-y: 0.8rem;
        }
        
        .product-image,
        .product-image-wrapper {
            height: 150px;
        }
        
        .product-info,
        .product-details {
            padding: 11px;
        }
        
        .product-title,
        .product-name {
            font-size: 0.8rem;
            height: 36px;
        }
        
        .btn-add-cart,
        .add-to-cart-btn {
            padding: 6px 10px;
            font-size: 0.75rem;
            height: 30px;
        }
        
        .btn-add-wishlist {
            width: 30px;
            height: 30px;
        }
        
        .overlay-btn {
            width: 28px;
            height: 28px;
            font-size: 0.65rem;
        }
        
        .product-overlay {
            opacity: 1;
            transform: translateX(0);
            flex-direction: row;
            gap: 5px;
        }
        
        /* Beautiful Banner Responsive */
        .beautiful-banner-section {
            padding: 25px 0;
            min-height: 300px;
        }
        
        .banner-title {
            font-size: 1.6rem;
        }
        
        .banner-subtitle {
            font-size: 0.8rem;
        }
        
        .banner-features {
            gap: 8px;
        }
        
        .feature-item {
            padding: 5px 8px;
            font-size: 0.65rem;
        }
        
        .btn-banner-primary,
        .btn-banner-secondary {
            padding: 7px 16px;
            font-size: 0.75rem;
        }
        
        .countdown-timer {
            gap: 6px;
            padding: 9px 12px;
        }
        
        .timer-item {
            min-width: 36px;
        }
        
        .timer-number {
            font-size: 1rem;
        }
        
        .timer-label {
            font-size: 0.6rem;
        }
        
        .timer-separator {
            font-size: 0.95rem;
        }
        
        .price-tag {
            padding: 8px 12px;
        }
        
        .price-amount {
            font-size: 0.95rem;
        }
        
        .price-original {
            font-size: 0.65rem;
        }
        
        .banner-image img {
            max-width: 75%;
        }
    }

    @media (max-width: 576px) {
        .brand-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .deal-timer {
            gap: 10px;
        }
        
        .timer-box {
            min-width: 50px;
            padding: 8px 10px;
        }
        
        .timer-number {
            font-size: 1.2rem;
        }
        
        .hero-content h1 {
            font-size: 1.5rem;
            margin-bottom: 0.6rem;
        }
        
        .hero-content .subtitle {
            font-size: 0.8rem;
            margin-bottom: 0.8rem;
        }
        
        .hero-section {
            min-height: 35vh;
            padding: 18px 0;
        }
        
        .hero-content {
            padding-left: 12px;
            margin-left: 5px;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 10px;
            border-left: 2px solid rgba(251, 191, 36, 0.5);
        }
        
        .hero-stats {
            gap: 0.8rem;
            justify-content: center;
            text-align: center;
        }
        
        .hero-stat-number {
            font-size: 1.1rem;
        }
        
        .hero-stat-label {
            font-size: 0.65rem;
        }
        
        .hero-actions {
            justify-content: center;
            margin-bottom: 0.8rem;
        }
        
        .btn-hero-primary,
        .btn-hero-secondary {
            padding: 6px 14px;
            font-size: 0.75rem;
            min-width: 100px;
        }
        
        .hero-image {
            max-width: 240px;
        }
        
        .services-section {
            padding: 15px 0;
        }
        
        .service-card {
            padding: 8px;
        }
        
        .service-icon {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }
        
        .service-content h5 {
            font-size: 0.8rem;
        }
        
        .service-content p {
            font-size: 0.65rem;
        }
        
        .categories-section {
            padding: 20px 0;
        }
        
        .category-card {
            min-width: 100px;
            padding: 8px;
        }
        
        .category-image-container {
            width: 44px;
            height: 44px;
        }
        
        .category-image-fallback {
            font-size: 16px;
        }
        
        .category-name {
            font-size: 0.75rem;
        }
        
        .category-count {
            font-size: 0.6rem;
        }
        
        /* Mobile Product Cards */
        .featured-products-section,
        .latest-products-section,
        .best-selling-section {
            padding: 20px 0;
        }
        
        .section-title {
            font-size: 1.15rem;
            margin-bottom: 16px;
        }
        
        .section-header .section-title {
            font-size: 1.15rem;
        }
        
        .section-header .section-subtitle {
            font-size: 0.75rem;
        }
        
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
            gap: 12px;
        }
        
        .row.g-4 {
            --bs-gutter-x: 0.6rem;
            --bs-gutter-y: 0.6rem;
        }
        
        .product-image,
        .product-image-wrapper {
            height: 140px;
        }
        
        .product-info,
        .product-details {
            padding: 10px;
        }
        
        .product-title,
        .product-name {
            font-size: 0.75rem;
            height: 34px;
            margin-bottom: 5px;
        }
        
        .rating-stars,
        .product-rating {
            font-size: 0.7rem;
            margin-bottom: 5px;
            height: 12px;
        }
        
        .product-price {
            margin-bottom: 8px;
            min-height: 22px;
        }
        
        .current-price {
            font-size: 0.9rem;
        }
        
        .btn-add-cart,
        .add-to-cart-btn {
            padding: 6px 10px;
            font-size: 0.7rem;
            height: 28px;
        }
        
        .btn-add-wishlist {
            width: 28px;
            height: 28px;
        }
        
        .overlay-btn {
            width: 26px;
            height: 26px;
        }
        
        .badge {
            padding: 2px 6px;
            font-size: 0.6rem;
        }
        
        .view-more-btn {
            padding: 6px 16px;
            font-size: 0.75rem;
            min-width: 120px;
            height: 30px;
        }
        
        /* Beautiful Banner Mobile */
        .beautiful-banner-section {
            padding: 20px 0;
            min-height: 280px;
        }
        
        .banner-title {
            font-size: 1.4rem;
        }
        
        .banner-subtitle {
            font-size: 0.75rem;
            margin-bottom: 10px;
        }
        
        .banner-badge {
            font-size: 0.65rem;
            padding: 3px 10px;
        }
        
        .banner-features {
            gap: 6px;
        }
        
        .feature-item {
            padding: 4px 7px;
            font-size: 0.6rem;
        }
        
        .btn-banner-primary,
        .btn-banner-secondary {
            padding: 6px 14px;
            font-size: 0.7rem;
        }
        
        .countdown-timer {
            gap: 5px;
            padding: 8px 10px;
        }
        
        .timer-item {
            min-width: 32px;
        }
        
        .timer-number {
            font-size: 0.9rem;
        }
        
        .timer-label {
            font-size: 0.55rem;
        }
        
        .price-tag {
            padding: 6px 10px;
        }
        
        .price-amount {
            font-size: 0.85rem;
        }
        
        .price-original {
            font-size: 0.6rem;
        }
        
        .banner-image img {
            max-width: 70%;
        }
        
        .floating-element,
        .shape {
            display: none;
        }
    }

    /* Feature Section Styles */
    .feature-section {
        position: relative;
        overflow: hidden;
    }

    .feature-image-wrapper:hover img {
        transform: scale(1.05);
    }

    /* Gallery Section Styles */
    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
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
                    <h1>{!! $heroContent->title ?? 'Welcome to <span class="highlight">RUBISTA</span>' !!}</h1>
                    <p class="subtitle">
                        {!! $heroContent->subtitle ?? 'Your Electronics Store - <span class="highlight">Quality Products</span>, Unbeatable Prices' !!}
                    </p>
                    
                    @if($heroContent->description)
                    <p class="subtitle" style="margin-top: 10px;">
                        {{ $heroContent->description }}
                    </p>
                    @endif
                    
                    <div class="hero-actions">
                        @if($heroContent->button_text && $heroContent->button_url)
                            <a href="{{ $heroContent->button_url }}" class="btn-hero-primary">
                                <i class="fas fa-shopping-bag"></i>
                                {{ $heroContent->button_text }}
                            </a>
                        @else
                            <a href="#featured" class="btn-hero-primary">
                                <i class="fas fa-shopping-bag"></i>
                                Shop Now
                            </a>
                        @endif
                        <a href="#categories" class="btn-hero-secondary">
                            <i class="fas fa-th-large"></i>
                            Browse Categories
                        </a>
                    </div>
                    
                    @if(isset($heroContent->extra_data['stats']) && is_array($heroContent->extra_data['stats']))
                    <div class="hero-stats">
                        @foreach($heroContent->extra_data['stats'] as $stat)
                        <div class="hero-stat">
                            <span class="hero-stat-number">{{ $stat['number'] ?? '0' }}</span>
                            <span class="hero-stat-label">{{ $stat['label'] ?? '' }}</span>
                        </div>
                        @endforeach
                    </div>
                    @else
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
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-container">
                    <div class="hero-image-bg"></div>
                    <img src="{{ $heroContent->image_url ?? 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=400&fit=crop' }}" 
                         class="hero-image" alt="{{ $heroContent->title ?? 'Rubista Electronics' }}">
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
                        <p>
                            @if($service->title && (stripos($service->title, 'shipping') !== false || stripos($service->title, 'free') !== false))
                                @if(isset($settings['free_shipping_threshold']) && $settings['free_shipping_threshold'] > 0)
                                    On orders over ₹{{ number_format($settings['free_shipping_threshold'], 0) }}
                                @else
                                    {{ $service->subtitle }}
                                @endif
                            @elseif($service->title && (stripos($service->title, 'support') !== false || stripos($service->title, 'contact') !== false))
                                {{ $settings['site_phone'] ?? $service->subtitle }}
                            @else
                                {{ $service->subtitle }}
                            @endif
                        </p>
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

<!-- Flash Deal Banner -->
@if($flashDealContent)
<section class="flash-deal-banner">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center deal-content">
                <div class="deal-badge">
                    <i class="{{ $flashDealContent->extra_data['badge_icon'] ?? 'fas fa-bolt' }}"></i> 
                    {{ $flashDealContent->extra_data['badge_text'] ?? 'LIMITED TIME OFFER' }}
                </div>
                <h2 class="deal-title">{{ $flashDealContent->title ?? 'Flash Sale - Up to 70% OFF!' }}</h2>
                <p class="deal-subtitle">{{ $flashDealContent->subtitle ?? $flashDealContent->description ?? 'Grab the best deals before they\'re gone. Hurry up!' }}</p>
                <div class="deal-timer">
                    <div class="timer-box">
                        <span class="timer-number" id="hours">{{ $flashDealContent->extra_data['hours'] ?? '12' }}</span>
                        <span class="timer-label">Hours</span>
                    </div>
                    <div class="timer-box">
                        <span class="timer-number" id="minutes">{{ $flashDealContent->extra_data['minutes'] ?? '34' }}</span>
                        <span class="timer-label">Minutes</span>
                    </div>
                    <div class="timer-box">
                        <span class="timer-number" id="seconds">{{ $flashDealContent->extra_data['seconds'] ?? '56' }}</span>
                        <span class="timer-label">Seconds</span>
                    </div>
                </div>
                @if($flashDealContent->button_text && $flashDealContent->button_url)
                <a href="{{ $flashDealContent->button_url }}" class="btn-hero-primary mt-3">
                    <i class="fas fa-shopping-cart"></i> {{ $flashDealContent->button_text }}
                </a>
                @else
                <a href="#" class="btn-hero-primary mt-3">
                    <i class="fas fa-shopping-cart"></i> Shop Now
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<!-- Featured Products Section -->
<section class="featured-products-section bg-white">
    <div class="container-fluid">
        <h2 class="section-title">{{ $featuredProductsContent->title ?? 'FEATURED PRODUCTS' }}</h2>
        @if($featuredProductsContent && $featuredProductsContent->subtitle)
        <p class="text-center text-muted mb-4">{{ $featuredProductsContent->subtitle }}</p>
        @endif
        <div class="row g-4">
            @foreach($trendingProducts->take(5) as $product)
            <div class="col-5-per-row">
                <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card-link">
                    <div class="product-card">
                        <div class="position-relative">
                            @if($product->image)
                                @if(Str::startsWith($product->image, 'http'))
                                    <img src="{{ $product->image }}" 
                                         class="product-image" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="product-image" alt="{{ $product->name }}">
                                @endif
                            @else
                                <div class="product-image" style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="product-info">
                            <h6 class="product-title">{{ $product->name }}</h6>
                            @php
                                $avgRating = $product->average_rating ?? 0;
                                $totalReviews = $product->total_reviews ?? 0;
                            @endphp
                            @if($totalReviews > 0)
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2" style="font-size: 0.75rem; padding: 3px 6px;">
                                    <i class="fas fa-star" style="font-size: 0.7rem;"></i> {{ number_format($avgRating, 1) }}
                                </span>
                                <small class="text-muted" style="font-size: 0.75rem;">({{ $totalReviews }})</small>
                            </div>
                            @else
                            <div class="mb-2">
                                <small class="text-muted" style="font-size: 0.75rem;">No reviews yet</small>
                            </div>
                            @endif
                            <div class="product-price">
                                <span class="current-price">₹{{ number_format($product->price, 0) }}</span>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn-add-cart flex-fill" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation();">
                                    <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                                </button>
                                <button class="btn-add-wishlist" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation();" style="@if(isset($product->is_in_wishlist) && $product->is_in_wishlist) background: #dc3545; border-color: #dc3545; color: white; @endif">
                                    <i class="{{ (isset($product->is_in_wishlist) && $product->is_in_wishlist) ? 'fas' : 'far' }} fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Beautiful Banner Section -->
@if($bannerContent && $bannerContent->count() > 0)
    @foreach($bannerContent as $banner)
    <section class="beautiful-banner-section">
        <div class="banner-overlay"></div>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="banner-content">
                        @if($banner->extra_data['badge_text'] ?? false)
                        <div class="banner-badge">
                            <i class="{{ $banner->extra_data['badge_icon'] ?? 'fas fa-fire' }}"></i>
                            <span>{{ $banner->extra_data['badge_text'] }}</span>
                        </div>
                        @else
                        <div class="banner-badge">
                            <i class="fas fa-fire"></i>
                            <span>Limited Time Offer</span>
                        </div>
                        @endif
                        <h1 class="banner-title">
                            @if($banner->title)
                                {!! $banner->title !!}
                            @else
                                <span class="gradient-text">Summer Sale</span>
                                <br>Up to 70% Off
                            @endif
                        </h1>
                        <p class="banner-subtitle">
                            {{ $banner->subtitle ?? $banner->description ?? 'Discover amazing deals on premium electronics. Don\'t miss out on these incredible savings!' }}
                        </p>
                        @if(isset($banner->extra_data['features']) && is_array($banner->extra_data['features']))
                        <div class="banner-features">
                            @foreach($banner->extra_data['features'] as $feature)
                            <div class="feature-item">
                                <i class="{{ $feature['icon'] ?? 'fas fa-check' }}"></i>
                                <span>{{ $feature['text'] ?? '' }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="banner-features">
                            @if($serviceContent && $serviceContent->count() > 0)
                                @foreach($serviceContent->take(3) as $service)
                                <div class="feature-item">
                                    <i class="{{ $service->extra_data['icon'] ?? 'fas fa-check' }}"></i>
                                    <span>
                                        {{ $service->title ?? 'Service' }}
                                        @if($service->title && (stripos($service->title, 'shipping') !== false) && isset($settings['free_shipping_threshold']) && $settings['free_shipping_threshold'] > 0)
                                            Over ₹{{ number_format($settings['free_shipping_threshold'], 0) }}
                                        @endif
                                    </span>
                                </div>
                                @endforeach
                            @else
                            <div class="feature-item">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Free Shipping @if(isset($settings['free_shipping_threshold']) && $settings['free_shipping_threshold'] > 0) Over ₹{{ number_format($settings['free_shipping_threshold'], 0) }}@endif</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Secure Payment</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-undo"></i>
                                <span>Easy Returns</span>
                            </div>
                            @endif
                        </div>
                        @endif
                        <div class="banner-actions">
                            @if($banner->button_text && $banner->button_url)
                                <a href="{{ $banner->button_url }}" class="btn-banner-primary">
                                    <i class="fas fa-shopping-bag"></i>
                                    {{ $banner->button_text }}
                                </a>
                            @else
                                <a href="#" class="btn-banner-primary">
                                    <i class="fas fa-shopping-bag"></i>
                                    Shop Now
                                </a>
                            @endif
                            @if(isset($banner->extra_data['secondary_button']))
                            <a href="{{ $banner->extra_data['secondary_button']['url'] ?? '#' }}" class="btn-banner-secondary">
                                <i class="{{ $banner->extra_data['secondary_button']['icon'] ?? 'fas fa-play' }}"></i>
                                {{ $banner->extra_data['secondary_button']['text'] ?? 'Watch Video' }}
                            </a>
                            @endif
                        </div>
                        @if(isset($banner->extra_data['countdown']) && $banner->extra_data['countdown'])
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
                        @endif
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
                            <img src="{{ $banner->image_url ?? 'https://images.unsplash.com/photo-1607082349566-187342175e2f?w=600&h=500&fit=crop' }}" 
                                 alt="{{ $banner->title ?? 'Summer Sale Electronics' }}">
                        </div>
                        @if(isset($banner->extra_data['price_tag']))
                        <div class="price-tag">
                            <span class="price-amount">{{ $banner->extra_data['price_tag']['current'] ?? '₹29,999' }}</span>
                            @if(isset($banner->extra_data['price_tag']['original']))
                            <span class="price-original">{{ $banner->extra_data['price_tag']['original'] }}</span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
@else
<!-- Default Beautiful Banner Section -->
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
@endif

<!-- Best Selling Products Section -->
<section class="best-selling-section">
    <div class="container-fluid">
        <div class="section-header">
            <h2 class="section-title">{{ $bestSellersContent->title ?? 'Best Sellers' }}</h2>
            <p class="section-subtitle">{{ $bestSellersContent->subtitle ?? $bestSellersContent->description ?? 'Top products loved by our customers' }}</p>
        </div>
        
        <div class="products-grid">
            @foreach($trendingProducts->take(10) as $index => $product)
            <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-item-link">
                <div class="product-item">
                    <div class="product-image-wrapper">
                        @if($product->image)
                            @if(Str::startsWith($product->image, 'http'))
                                <img src="{{ $product->image }}" 
                                     class="product-image" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="product-image" alt="{{ $product->name }}">
                            @endif
                        @else
                            <div class="product-image" style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        
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
                            <button class="overlay-btn wishlist-btn" id="wishlist-overlay-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation();" style="@if(isset($product->is_in_wishlist) && $product->is_in_wishlist) background: #dc3545; color: white; @endif">
                                <i class="{{ (isset($product->is_in_wishlist) && $product->is_in_wishlist) ? 'fas' : 'far' }} fa-heart"></i>
                            </button>
                            <button class="overlay-btn quick-view-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation();">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="product-details">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        
                        @php
                            $avgRating = $product->average_rating ?? 0;
                            $totalReviews = $product->total_reviews ?? 0;
                        @endphp
                        @if($totalReviews > 0)
                        <div class="product-rating">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($avgRating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i == floor($avgRating) + 1 && ($avgRating - floor($avgRating)) >= 0.5)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="review-count">({{ $totalReviews }})</span>
                        </div>
                        @else
                        <div class="product-rating">
                            <small class="text-muted">No reviews yet</small>
                        </div>
                        @endif
                        
                        <div class="product-price">
                            @if($product->price > 5000)
                                <span class="current-price">₹{{ number_format($product->price - 1000, 0) }}</span>
                                <span class="original-price">₹{{ number_format($product->price, 0) }}</span>
                            @else
                                <span class="current-price">₹{{ number_format($product->price, 0) }}</span>
                            @endif
                        </div>
                        
                        <button class="add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation();">
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        
        <div class="view-more">
            <a href="#" class="view-more-btn">View All Best Sellers</a>
        </div>
    </div>
</section>

<!-- Brands Showcase -->
@if($brandsContent)
<section class="brands-section">
    <div class="container-fluid">
        <h2 class="section-title">{{ $brandsContent->title ?? 'Trusted Brands' }}</h2>
        @if($brandsContent->subtitle)
        <p class="text-center text-muted mb-4">{{ $brandsContent->subtitle }}</p>
        @endif
        <div class="brand-grid">
            @if(isset($brandsContent->extra_data['brands']) && is_array($brandsContent->extra_data['brands']))
                @foreach($brandsContent->extra_data['brands'] as $brand)
                <div class="brand-item">
                    @if(isset($brand['image']))
                        <img src="{{ $brand['image'] }}" alt="{{ $brand['name'] ?? 'Brand' }}">
                    @else
                        <div style="font-size: 2rem; font-weight: 700; color: {{ $brand['color'] ?? '#7c3aed' }};">{{ $brand['name'] ?? 'BRAND' }}</div>
                    @endif
                </div>
                @endforeach
            @else
            <!-- Default brands if no data -->
            <div class="brand-item">
                <div style="font-size: 2rem; font-weight: 700; color: #7c3aed;">SONY</div>
            </div>
            <div class="brand-item">
                <div style="font-size: 2rem; font-weight: 700; color: #3b82f6;">SAMSUNG</div>
            </div>
            <div class="brand-item">
                <div style="font-size: 2rem; font-weight: 700; color: #10b981;">APPLE</div>
            </div>
            <div class="brand-item">
                <div style="font-size: 2rem; font-weight: 700; color: #f59e0b;">LG</div>
            </div>
            <div class="brand-item">
                <div style="font-size: 2rem; font-weight: 700; color: #ef4444;">CANON</div>
            </div>
            <div class="brand-item">
                <div style="font-size: 2rem; font-weight: 700; color: #8b5cf6;">NIKE</div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Testimonials -->
@if($testimonialsContent && $testimonialsContent->count() > 0)
@php
    $testimonialSection = $testimonialsContent->first();
    $testimonials = $testimonialSection->extra_data['testimonials'] ?? [];
@endphp
@if(count($testimonials) > 0)
<section class="testimonials-section">
    <div class="container-fluid">
        <h2 class="section-title">{{ $testimonialSection->title ?? 'What Our Customers Say' }}</h2>
        @if($testimonialSection->subtitle)
        <p class="text-center text-muted mb-4">{{ $testimonialSection->subtitle }}</p>
        @endif
        <div class="testimonial-grid">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    @php
                        $rating = $testimonial['rating'] ?? 5;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star text-warning"></i>
                    @endfor
                </div>
                <p class="testimonial-text">"{{ $testimonial['comment'] ?? 'Great service!' }}"</p>
                <div class="testimonial-author">
                    @if(isset($testimonial['avatar']))
                        <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] ?? 'Customer' }}" class="author-avatar-img" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    @else
                        <div class="author-avatar" style="background: linear-gradient(135deg, #7c3aed, #a78bfa); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            {{ strtoupper(substr($testimonial['name'] ?? 'C', 0, 1)) }}
                        </div>
                    @endif
                    <div class="author-info">
                        <h4 style="margin: 0; font-size: 1rem;">{{ $testimonial['name'] ?? 'Customer' }}</h4>
                        @if(isset($testimonial['location']))
                        <p style="margin: 0; font-size: 0.85rem; color: #64748b;">{{ $testimonial['location'] }}</p>
                        @else
                        <p style="margin: 0; font-size: 0.85rem; color: #64748b;">Verified Buyer</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($testimonialSection->button_text && $testimonialSection->button_url)
        <div class="text-center mt-4">
            <a href="{{ $testimonialSection->button_url }}" class="btn btn-primary">
                {{ $testimonialSection->button_text }}
            </a>
        </div>
        @endif
    </div>
</section>
@endif
@endif

<!-- Beautiful Banner Section -->
@if($bannerContent && $bannerContent->count() > 0)
    @foreach($bannerContent as $banner)
    <section class="beautiful-banner-section">
        <div class="banner-overlay"></div>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="banner-content">
                        @if($banner->extra_data['badge_text'] ?? false)
                        <div class="banner-badge">
                            <i class="{{ $banner->extra_data['badge_icon'] ?? 'fas fa-fire' }}"></i>
                            <span>{{ $banner->extra_data['badge_text'] }}</span>
                        </div>
                        @else
                        <div class="banner-badge">
                            <i class="fas fa-fire"></i>
                            <span>Limited Time Offer</span>
                        </div>
                        @endif
                        <h1 class="banner-title">
                            @if($banner->title)
                                {!! $banner->title !!}
                            @else
                                <span class="gradient-text">Summer Sale</span>
                                <br>Up to 70% Off
                            @endif
                        </h1>
                        <p class="banner-subtitle">
                            {{ $banner->subtitle ?? $banner->description ?? 'Discover amazing deals on premium electronics. Don\'t miss out on these incredible savings!' }}
                        </p>
                        @if(isset($banner->extra_data['features']) && is_array($banner->extra_data['features']))
                        <div class="banner-features">
                            @foreach($banner->extra_data['features'] as $feature)
                            <div class="feature-item">
                                <i class="{{ $feature['icon'] ?? 'fas fa-check' }}"></i>
                                <span>{{ $feature['text'] ?? '' }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="banner-features">
                            @if($serviceContent && $serviceContent->count() > 0)
                                @foreach($serviceContent->take(3) as $service)
                                <div class="feature-item">
                                    <i class="{{ $service->extra_data['icon'] ?? 'fas fa-check' }}"></i>
                                    <span>
                                        {{ $service->title ?? 'Service' }}
                                        @if($service->title && (stripos($service->title, 'shipping') !== false) && isset($settings['free_shipping_threshold']) && $settings['free_shipping_threshold'] > 0)
                                            Over ₹{{ number_format($settings['free_shipping_threshold'], 0) }}
                                        @endif
                                    </span>
                                </div>
                                @endforeach
                            @else
                            <div class="feature-item">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Free Shipping @if(isset($settings['free_shipping_threshold']) && $settings['free_shipping_threshold'] > 0) Over ₹{{ number_format($settings['free_shipping_threshold'], 0) }}@endif</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Secure Payment</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-undo"></i>
                                <span>Easy Returns</span>
                            </div>
                            @endif
                        </div>
                        @endif
                        <div class="banner-actions">
                            @if($banner->button_text && $banner->button_url)
                                <a href="{{ $banner->button_url }}" class="btn-banner-primary">
                                    <i class="fas fa-shopping-bag"></i>
                                    {{ $banner->button_text }}
                                </a>
                            @else
                                <a href="#" class="btn-banner-primary">
                                    <i class="fas fa-shopping-bag"></i>
                                    Shop Now
                                </a>
                            @endif
                            @if(isset($banner->extra_data['secondary_button']))
                            <a href="{{ $banner->extra_data['secondary_button']['url'] ?? '#' }}" class="btn-banner-secondary">
                                <i class="{{ $banner->extra_data['secondary_button']['icon'] ?? 'fas fa-play' }}"></i>
                                {{ $banner->extra_data['secondary_button']['text'] ?? 'Watch Video' }}
                            </a>
                            @endif
                        </div>
                        @if(isset($banner->extra_data['countdown']) && $banner->extra_data['countdown'])
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
                        @endif
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
                            <img src="{{ $banner->image_url ?? 'https://images.unsplash.com/photo-1607082349566-187342175e2f?w=600&h=500&fit=crop' }}" 
                                 alt="{{ $banner->title ?? 'Summer Sale Electronics' }}">
                        </div>
                        @if(isset($banner->extra_data['price_tag']))
                        <div class="price-tag">
                            <span class="price-amount">{{ $banner->extra_data['price_tag']['current'] ?? '₹29,999' }}</span>
                            @if(isset($banner->extra_data['price_tag']['original']))
                            <span class="price-original">{{ $banner->extra_data['price_tag']['original'] }}</span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
@else
<!-- Default Beautiful Banner Section -->
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
@endif

<!-- Feature Section -->
@if($featureContent && $featureContent->count() > 0)
    @foreach($featureContent as $feature)
    <section class="feature-section" style="padding: 40px 0; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 {{ $loop->odd ? 'order-lg-1' : 'order-lg-2' }}">
                    @if($feature->image_url)
                    <div class="feature-image-wrapper" style="position: relative; overflow: hidden; border-radius: 15px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);">
                        <img src="{{ $feature->image_url }}" 
                             class="img-fluid" 
                             alt="{{ $feature->title }}"
                             style="width: 100%; height: auto; transition: transform 0.5s ease;">
                    </div>
                    @endif
                </div>
                <div class="col-lg-6 {{ $loop->odd ? 'order-lg-2' : 'order-lg-1' }}">
                    <div class="feature-content" style="padding: 30px;">
                        @if($feature->title)
                        <h2 class="section-title" style="text-align: left; margin-bottom: 20px; font-size: 2rem; font-weight: 700; color: #1a202c;">
                            {{ $feature->title }}
                        </h2>
                        @endif
                        @if($feature->subtitle)
                        <h3 style="font-size: 1.3rem; color: var(--primary-purple); margin-bottom: 15px; font-weight: 600;">
                            {{ $feature->subtitle }}
                        </h3>
                        @endif
                        @if($feature->description)
                        <p style="font-size: 1rem; color: #64748b; line-height: 1.8; margin-bottom: 25px;">
                            {{ $feature->description }}
                        </p>
                        @endif
                        @if($feature->button_text && $feature->button_url)
                        <a href="{{ $feature->button_url }}" 
                           class="btn-hero-primary" 
                           style="display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-arrow-right"></i>
                            {{ $feature->button_text }}
                        </a>
                        @endif
                        @if(isset($feature->extra_data['features']) && is_array($feature->extra_data['features']))
                        <div style="margin-top: 30px;">
                            @foreach($feature->extra_data['features'] as $feat)
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-purple), var(--light-purple)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px;">
                                    <i class="{{ $feat['icon'] ?? 'fas fa-check' }}"></i>
                                </div>
                                <div>
                                    <h5 style="margin: 0; font-size: 1rem; font-weight: 600; color: #1a202c;">{{ $feat['title'] ?? '' }}</h5>
                                    <p style="margin: 0; font-size: 0.9rem; color: #64748b;">{{ $feat['description'] ?? '' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach
@endif

<!-- Gallery Section -->
@if($galleryContent && $galleryContent->count() > 0)
<section class="gallery-section" style="padding: 50px 0; background: #ffffff;">
    <div class="container-fluid">
        <div class="section-header" style="text-align: center; margin-bottom: 40px;">
            <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #1a202c; margin-bottom: 10px;">
                @if($galleryContent->first()->title)
                    {{ $galleryContent->first()->title }}
                @else
                    Our Gallery
                @endif
            </h2>
            @if($galleryContent->first()->subtitle)
            <p style="font-size: 1.1rem; color: #64748b; margin: 0;">
                {{ $galleryContent->first()->subtitle }}
            </p>
            @endif
        </div>
        <div class="row g-4">
            @foreach($galleryContent as $gallery)
            <div class="col-lg-4 col-md-6">
                <div class="gallery-item" style="position: relative; overflow: hidden; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; cursor: pointer;">
                    @if($gallery->image_url)
                    <img src="{{ $gallery->image_url }}" 
                         class="img-fluid" 
                         alt="{{ $gallery->title ?? 'Gallery Image' }}"
                         style="width: 100%; height: 300px; object-fit: cover; transition: transform 0.5s ease;">
                    @endif
                    <div class="gallery-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: flex-end; padding: 20px;">
                        <div style="color: white;">
                            @if($gallery->title)
                            <h4 style="color: white; margin: 0 0 5px 0; font-size: 1.2rem; font-weight: 600;">
                                {{ $gallery->title }}
                            </h4>
                            @endif
                            @if($gallery->subtitle)
                            <p style="color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 0.9rem;">
                                {{ $gallery->subtitle }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($galleryContent->first()->description)
        <div style="text-align: center; margin-top: 30px;">
            <p style="font-size: 1rem; color: #64748b; max-width: 800px; margin: 0 auto;">
                {{ $galleryContent->first()->description }}
            </p>
        </div>
        @endif
        @if($galleryContent->first()->button_text && $galleryContent->first()->button_url)
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ $galleryContent->first()->button_url }}" 
               class="btn-hero-primary" 
               style="display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-arrow-right"></i>
                {{ $galleryContent->first()->button_text }}
            </a>
        </div>
        @endif
    </div>
</section>
@endif

<!-- Latest Products Section -->
<section class="latest-products-section bg-white">
    <div class="container-fluid">
        <h2 class="section-title">{{ $latestProductsContent->title ?? 'LATEST PRODUCTS' }}</h2>
        @if($latestProductsContent && $latestProductsContent->subtitle)
        <p class="text-center text-muted mb-4">{{ $latestProductsContent->subtitle }}</p>
        @endif
        @if(isset($latestProducts) && $latestProducts->count() > 0)
        <div class="row g-4">
            @foreach($latestProducts as $product)
            <div class="col-5-per-row">
                <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card-link">
                    <div class="product-card">
                        <div class="position-relative">
                            @if($product->image)
                                @if(Str::startsWith($product->image, 'http'))
                                    <img src="{{ $product->image }}" 
                                         class="product-image" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="product-image" alt="{{ $product->name }}">
                                @endif
                            @else
                                <div class="product-image" style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="product-info">
                            <h6 class="product-title">{{ $product->name }}</h6>
                            <div class="rating-stars">
                                @php
                                    $rating = isset($product->average_rating) ? round($product->average_rating) : 0;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $rating ? 'fas' : 'far' }} fa-star {{ $i <= $rating ? 'text-warning' : '' }}"></i>
                                @endfor
                                @if(isset($product->total_reviews) && $product->total_reviews > 0)
                                    <span class="rating-count ms-1">({{ $product->total_reviews }})</span>
                                @endif
                            </div>
                            <div class="product-price">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="current-price">₹{{ number_format($product->sale_price, 0) }}</span>
                                    <span class="old-price">₹{{ number_format($product->price, 0) }}</span>
                                @else
                                    <span class="current-price">₹{{ number_format($product->price, 0) }}</span>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn-add-cart flex-fill" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation();">
                                    <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                                </button>
                                <button class="btn-add-wishlist" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation();" style="@if(isset($product->is_in_wishlist) && $product->is_in_wishlist) background: #dc3545; border-color: #dc3545; color: white; @endif">
                                    <i class="{{ (isset($product->is_in_wishlist) && $product->is_in_wishlist) ? 'fas' : 'far' }} fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <p class="text-muted">No products available at the moment.</p>
        </div>
        @endif
    </div>
</section>

<!-- Newsletter Section -->
<!-- <section class="newsletter-section">
    <div class="container-fluid">
        <div class="newsletter-content">
            <h2 class="newsletter-title">
                <i class="fas fa-envelope"></i> Subscribe to Our Newsletter
            </h2>
            <p class="newsletter-subtitle">Get the latest deals, new arrivals, and exclusive offers delivered to your inbox!</p>
            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Enter your email address" required>
                <button type="submit" class="newsletter-btn">
                    Subscribe <i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <p style="font-size: 0.8rem; opacity: 0.8; margin-top: 10px;">
                <i class="fas fa-lock"></i> We respect your privacy. Unsubscribe anytime.
            </p>
        </div>
    </div>
</section> -->
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery hover effects
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1.1)';
            }
        });
        
        item.addEventListener('mouseleave', function() {
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1)';
            }
        });
    });

    // Feature section image hover
    const featureImageWrappers = document.querySelectorAll('.feature-image-wrapper');
    featureImageWrappers.forEach(wrapper => {
        wrapper.addEventListener('mouseenter', function() {
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1.05)';
            }
        });
        
        wrapper.addEventListener('mouseleave', function() {
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1)';
            }
        });
    });

    // Flash Deal Countdown Timer
    function updateCountdown() {
        const now = new Date();
        const endTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59);
        const diff = endTime - now;
        
        if (diff > 0) {
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
    
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
    
    const observer = new IntersectionObserver((entries) => {
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
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Adding...';
            this.disabled = true;
            
            // Call API
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: parseInt(productId),
                    quantity: 1
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Request failed');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.innerHTML = '<i class="fas fa-check me-1"></i>Added!';
                    this.style.background = '#10b981';
                    
                    // Show success message
                    showToast('Product added to cart!', 'success');
                    
                    // Update cart count in navbar
                    updateCartCount(data.cart_count);
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.background = '';
                        this.disabled = false;
                    }, 2000);
                } else {
                    showToast(data.message || 'Error adding product to cart', 'error');
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Error adding product to cart', 'error');
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
    
    // Add to wishlist functionality
    const addToWishlistButtons = document.querySelectorAll('.btn-add-wishlist');
    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Use toggle endpoint - server will check if product is in wishlist
            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: parseInt(productId)
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Request failed');
                    }).catch(() => {
                        throw new Error('Request failed with status: ' + response.status);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update icon based on server response
                    if (data.in_wishlist) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        this.style.background = '#dc3545';
                        this.style.borderColor = '#dc3545';
                        this.style.color = 'white';
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        this.style.background = '';
                        this.style.borderColor = '';
                        this.style.color = '';
                    }
                    updateWishlistCount(data.wishlist_count);
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Error updating wishlist', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Error updating wishlist', 'error');
            });
        });
    });
    
    // Best Selling Products functionality - Compact Design
    const bestSellingCartButtons = document.querySelectorAll('.add-to-cart-btn');
    bestSellingCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            this.disabled = true;
            
            // Call API
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: parseInt(productId),
                    quantity: 1
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Request failed');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.innerHTML = '<i class="fas fa-check"></i> Added!';
                    this.style.background = '#10b981';
                    
                    // Show success message
                    showToast('Product added to cart!', 'success');
                    
                    // Update cart count
                    updateCartCount(data.cart_count);
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.background = '';
                        this.disabled = false;
                    }, 2000);
                } else {
                    showToast(data.message || 'Error adding product to cart', 'error');
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Error adding product to cart', 'error');
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
    
    // Wishlist functionality
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Use toggle endpoint - server will check if product is in wishlist
            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: parseInt(productId)
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Request failed');
                    }).catch(() => {
                        throw new Error('Request failed with status: ' + response.status);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update icon based on server response
                    if (data.in_wishlist) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        this.style.background = '#dc3545';
                        this.style.color = 'white';
                        this.classList.add('active');
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        this.style.background = '';
                        this.style.color = '';
                        this.classList.remove('active');
                    }
                    updateWishlistCount(data.wishlist_count);
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Error updating wishlist', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast(error.message || 'Error updating wishlist', 'error');
            });
        });
    });
    
    // Quick view functionality
    const quickViewButtons = document.querySelectorAll('.quick-view-btn');
    quickViewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
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
    
    // Helper function to show toast notifications
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#667eea';
        toast.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${bgColor};
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                z-index: 9999;
                font-weight: 600;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                animation: slideInRight 0.3s ease;
            ">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} me-2"></i>${message}
            </div>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
    
    // Helper function to update cart count in navbar
    function updateCartCount(count) {
        const cartBadges = document.querySelectorAll('.cart-count, .cart-badge, [data-cart-count], .action-badge.cart-count');
        cartBadges.forEach(badge => {
            badge.textContent = count;
            if (count > 0) {
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        });
    }
    
    // Helper function to update wishlist count in navbar
    function updateWishlistCount(count) {
        const wishlistBadges = document.querySelectorAll('.wishlist-count, .wishlist-badge, [data-wishlist-count], .action-badge.wishlist-count');
        wishlistBadges.forEach(badge => {
            badge.textContent = count;
            if (count > 0) {
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        });
    }
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

 
 