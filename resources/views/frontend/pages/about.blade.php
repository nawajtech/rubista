@extends('frontend.layouts.app')

@section('title', 'About Us - Rubista')

@section('extra-css')
<style>
    .hero-about {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
    }
    
    .about-section {
        padding: 80px 0;
    }
    
    .feature-card {
        text-align: center;
        padding: 40px 20px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        height: 100%;
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        color: white;
        font-size: 2rem;
    }
    
    .stats-section {
        background: #f8f9fa;
        padding: 80px 0;
    }
    
    .stat-item {
        text-align: center;
        padding: 20px;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        color: #667eea;
        display: block;
    }
    
    .stat-label {
        font-size: 1.1rem;
        color: #666;
        margin-top: 10px;
    }
    
    .team-section {
        padding: 80px 0;
    }
    
    .team-card {
        text-align: center;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
    }
    
    .team-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">About RUBISTA</h1>
                <p class="lead mb-4">Your trusted partner in electronics since 2020. We bring you the latest technology with uncompromising quality and exceptional service.</p>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=400&fit=crop" 
                     alt="About Us" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop" 
                     alt="Our Story" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-5">
                    <h2 class="fw-bold mb-4">Our Story</h2>
                    <p class="mb-4">Founded in 2020, RUBISTA began as a small electronics store with a big vision: to make cutting-edge technology accessible to everyone. What started as a passion project has grown into a trusted online destination for electronics enthusiasts across the country.</p>
                    <p class="mb-4">We believe that great technology should enhance your life, not complicate it. That's why we carefully curate our selection to include only the best products from renowned brands, ensuring quality, reliability, and innovation in every purchase.</p>
                    <p>Today, we serve thousands of satisfied customers, building lasting relationships through exceptional service, competitive prices, and unwavering commitment to excellence.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="about-section bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-3">Why Choose RUBISTA?</h2>
                <p class="text-muted">We're committed to providing you with the best shopping experience</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card bg-white">
                    <div class="feature-icon">
                        <i class="fas fa-shield-check"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Quality Assurance</h5>
                    <p class="text-muted">Every product undergoes rigorous quality checks to ensure you receive only the best.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card bg-white">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Fast Delivery</h5>
                    <p class="text-muted">Quick and secure delivery to your doorstep with real-time tracking.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card bg-white">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Expert Support</h5>
                    <p class="text-muted">Our knowledgeable team is here to help you make the right choice.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card bg-white">
                    <div class="feature-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Best Prices</h5>
                    <p class="text-muted">Competitive pricing with regular deals and discounts for maximum value.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">50K+</span>
                    <div class="stat-label">Happy Customers</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">10K+</span>
                    <div class="stat-label">Products Sold</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <div class="stat-label">Product Varieties</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">4.8★</span>
                    <div class="stat-label">Customer Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-3">Meet Our Team</h2>
                <p class="text-muted">The passionate people behind RUBISTA</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="team-card">
                    <div class="team-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="fw-bold">Rajesh Kumar</h5>
                    <p class="text-muted mb-3">Founder & CEO</p>
                    <p class="small">Visionary leader with 15+ years in electronics industry, passionate about bringing latest technology to customers.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="team-card">
                    <div class="team-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="fw-bold">Priya Sharma</h5>
                    <p class="text-muted mb-3">Head of Customer Experience</p>
                    <p class="small">Ensuring every customer has an exceptional experience with our products and services.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="team-card">
                    <div class="team-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="fw-bold">Amit Patel</h5>
                    <p class="text-muted mb-3">Technical Director</p>
                    <p class="small">Electronics expert who carefully selects and tests every product in our catalog.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="team-card">
                    <div class="team-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="fw-bold">Neha Singh</h5>
                    <p class="text-muted mb-3">Operations Manager</p>
                    <p class="small">Ensuring smooth operations and timely delivery of products to our customers.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="about-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container text-center text-white">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold mb-4">Ready to Experience the RUBISTA Difference?</h2>
                <p class="lead mb-4">Join thousands of satisfied customers who trust us for their electronics needs.</p>
                <a href="{{ route('frontend.home') }}" class="btn btn-light btn-lg px-5 me-3">Shop Now</a>
                <a href="{{ route('frontend.contact') }}" class="btn btn-outline-light btn-lg px-5">Contact Us</a>
            </div>
        </div>
    </div>
</section>
@endsection 