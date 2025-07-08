@extends('frontend.layouts.app')

@section('title', 'Contact Us - Rubista')

@section('extra-css')
<style>
    .hero-contact {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
    }
    
    .contact-section {
        padding: 80px 0;
    }
    
    .contact-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 40px;
        height: 100%;
    }
    
    .contact-icon {
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
    
    .form-section {
        background: #f8f9fa;
        padding: 80px 0;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 15px 40px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        background: #667eea;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 20px;
        flex-shrink: 0;
    }
    
    .map-section {
        padding: 0;
        height: 400px;
        background: #e9ecef;
        border-radius: 15px;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Get in Touch</h1>
                <p class="lead mb-4">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
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
                    <p class="text-muted">123 Electronics Street<br>Tech City, TC 12345<br>India</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-card text-center">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Call Us</h5>
                    <p class="text-muted">Phone: +91 98765 43210<br>Toll Free: 1800-123-4567<br>Mon-Sat 9AM-8PM</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="contact-card text-center">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Email Us</h5>
                    <p class="text-muted">info@rubista.com<br>support@rubista.com<br>We reply within 24 hours</p>
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
                        <h2 class="fw-bold mb-3">Send Us a Message</h2>
                        <p class="text-muted">Fill out the form below and we'll get back to you soon</p>
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

<!-- FAQ Section -->
<section class="form-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-3">Frequently Asked Questions</h2>
                    <p class="text-muted">Quick answers to common questions</p>
                </div>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                What is your return policy?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer a 30-day return policy for all products. Items must be in original condition with packaging. Contact our support team to initiate a return.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                How long does delivery take?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Standard delivery takes 3-5 business days. Express delivery is available for 1-2 days. Same-day delivery is available in select cities.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Do you offer warranty on products?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, all products come with manufacturer warranty. Extended warranty options are available for select items. Check product details for specific warranty information.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept all major credit/debit cards, UPI, net banking, and cash on delivery. All payments are secured with encryption.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 