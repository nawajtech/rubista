
@extends('frontend.layouts.app')

@section('title', 'Contact Us - Rubista')

@section('extra-css')
<style>
    .contact-page .hero-contact {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #fff;
        padding: 80px 0;
    }
    .contact-page .hero-contact h1 { color: #fff; }
    .contact-page .hero-contact .lead,
    .contact-page .hero-contact p { color: rgba(255,255,255,0.9); }

    .contact-page .contact-section {
        padding: 80px 0;
    }
    .contact-page .contact-section h2,
    .contact-page .contact-section h3 { color: #1a1a2e; }
    .contact-page .contact-section .text-muted { color: #5a5a6e !important; }

    .contact-page .contact-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(26,26,46,0.08);
        padding: 40px;
        height: 100%;
        border: 1px solid rgba(245,166,35,0.12);
        transition: box-shadow 0.3s ease;
    }
    .contact-page .contact-card:hover {
        box-shadow: 0 8px 28px rgba(245,166,35,0.12);
    }
    .contact-page .contact-card h5 { color: #1a1a2e; }

    .contact-page .contact-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        color: #fff;
        font-size: 2rem;
        box-shadow: 0 4px 16px rgba(245,166,35,0.35);
    }

    .contact-page .form-section {
        background: #f8f9fa;
        padding: 80px 0;
    }
    .contact-page .form-section .contact-card {
        border-color: rgba(26,26,46,0.06);
    }
    .contact-page .form-section h2 { color: #1a1a2e; }
    .contact-page .form-section .form-label { color: #1a1a2e; }

    .contact-page .form-control {
        border: 2px solid rgba(26,26,46,0.1);
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 1rem;
        transition: all 0.25s ease;
    }
    .contact-page .form-control:focus {
        border-color: #f5a623;
        box-shadow: 0 0 0 0.2rem rgba(245, 166, 35, 0.25);
        outline: 0;
    }

    .contact-page .btn-submit {
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border: none;
        color: #fff;
        padding: 15px 40px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(245,166,35,0.35);
    }
    .contact-page .btn-submit:hover {
        background: #1a1a2e;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26,26,46,0.3);
        color: #fff;
    }

    .contact-page .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .contact-page .info-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #f5a623, #e0941a);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        margin-right: 20px;
        flex-shrink: 0;
        font-size: 1.2rem;
        box-shadow: 0 3px 12px rgba(245,166,35,0.3);
    }
    .contact-page .info-item h6 { color: #1a1a2e; }

    .contact-page .map-section {
        padding: 0;
        height: 400px;
        background: linear-gradient(135deg, rgba(26,26,46,0.06) 0%, rgba(245,166,35,0.06) 100%);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(245,166,35,0.12);
    }
    .contact-page .map-section .fa-map-marked-alt { color: #f5a623; opacity: 0.8; }
    .contact-page .map-section h5 { color: #1a1a2e; }

    .contact-page .alert-success {
        background: rgba(245,166,35,0.15);
        border-color: rgba(245,166,35,0.4);
        color: #1a1a2e;
        border-radius: 12px;
    }
</style>
@endsection

@section('content')
<div class="contact-page">
<!-- Hero Section -->
<section class="hero-contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">{!! $contactUs->hero_title ?? 'Get in Touch' !!}</h1>
                <p class="lead mb-4">{!! $contactUs->hero_subtitle ?? 'Have questions? We\'d love to hear from you. Send us a message and we\'ll respond as soon as possible.' !!}</p>
                @if($contactUs && $contactUs->hero_description)
                    <p>{!! $contactUs->hero_description !!}</p>
                @endif
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=600&h=400&fit=crop" 
                     alt="Contact Us" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Contact Info Section -->
<section class="contact-section">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-3">Contact Information</h2>
                <p class="text-muted">Multiple ways to reach us</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-card text-center">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Visit Our Store</h5>
                    <p class="text-muted">{!! $contactUs->address ?? '123 Electronics Street<br>Tech City, TC 12345<br>India' !!}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-card text-center">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Call Us</h5>
                    <p class="text-muted">
                        @if($contactUs && $contactUs->phone)
                            Phone: {{ $contactUs->phone }}<br>
                        @else
                            Phone: +91 98765 43210<br>
                        @endif
                        @if($contactUs && $contactUs->working_hours)
                            {{ $contactUs->working_hours }}
                        @else
                            Mon-Sat 9AM-8PM
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-card text-center">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Email Us</h5>
                    <p class="text-muted">
                        @if($contactUs && $contactUs->email)
                            {{ $contactUs->email }}<br>
                        @else
                            info@rubista.com<br>
                        @endif
                        We reply within 24 hours
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="form-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="contact-card">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-3">{!! $contactUs->form_title ?? 'Send Us a Message' !!}</h2>
                        <p class="text-muted">{!! $contactUs->form_description ?? 'Fill out the form below and we\'ll get back to you soon' !!}</p>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('frontend.contact.submit') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label fw-bold">Full Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label fw-bold">Email Address *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="form-label fw-bold">Subject *</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Message *</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="fw-bold mb-4">Quick Contact</h3>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Business Hours</h6>
                        <p class="text-muted mb-0">Monday - Saturday: 9:00 AM - 8:00 PM<br>Sunday: 10:00 AM - 6:00 PM</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Customer Support</h6>
                        <p class="text-muted mb-0">24/7 online support available<br>Live chat on website</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Delivery Info</h6>
                        <p class="text-muted mb-0">Free delivery on orders above ₹1000<br>Same day delivery available</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Returns & Exchanges</h6>
                        <p class="text-muted mb-0">30-day return policy<br>Easy exchange process</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="map-section d-flex align-items-center justify-content-center">
                    <div class="text-center text-muted">
                        <i class="fas fa-map-marked-alt fa-5x mb-3"></i>
                        <h5>Store Location Map</h5>
                        <p>Interactive map will be integrated here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection 