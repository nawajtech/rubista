@extends('frontend.layouts.app')

@section('title', 'About Us - Rubista')

@section('extra-css')
<style>
    .about-page .hero-about {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #fff;
        padding: 80px 0;
    }
    .about-page .hero-about .lead,
    .about-page .hero-about p { color: rgba(255,255,255,0.9); }
    .about-page .hero-about h1 { color: #fff; }

    .about-page .about-section {
        padding: 80px 0;
    }
    .about-page .about-section h2,
    .about-page .about-section h3 {
        color: #1a1a2e;
    }

    .about-page .feature-card {
        text-align: center;
        padding: 40px 20px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(26,26,46,0.08);
        height: 100%;
        transition: all 0.3s ease;
        background: #fff;
        border: 1px solid rgba(245,166,35,0.15);
    }
    .about-page .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(245,166,35,0.2);
        border-color: rgba(245,166,35,0.35);
    }
    .about-page .feature-icon {
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
    }

    .about-page .stats-section {
        background: #1a1a2e;
        padding: 80px 0;
        color: #fff;
    }
    .about-page .stat-item {
        text-align: center;
        padding: 20px;
    }
    .about-page .stat-number {
        font-size: 3rem;
        font-weight: 700;
        color: #f5a623;
        display: block;
    }
    .about-page .stat-label {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.8);
        margin-top: 10px;
    }

    .about-page .team-section {
        padding: 80px 0;
    }
    .about-page .team-card {
        text-align: center;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(26,26,46,0.08);
        transition: all 0.3s ease;
        background: #fff;
        border: 1px solid rgba(245,166,35,0.12);
    }
    .about-page .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(245,166,35,0.15);
    }
    .about-page .team-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #f5a623, #e0941a);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 3rem;
    }
    .about-page .team-card h5 { color: #1a1a2e; }
    .about-page .team-card .text-muted { color: #5a5a6e !important; }

    .about-page .about-section.bg-light {
        background: #f8f9fa;
    }
    .about-page .about-section.bg-light .feature-card {
        border-color: rgba(26,26,46,0.06);
    }
    .about-page .about-section.bg-light h2 { color: #1a1a2e; }
    .about-page .about-section.bg-light .text-muted { color: #5a5a6e !important; }

    .about-page .cta-about {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        padding: 80px 0;
        color: #fff;
    }
    .about-page .cta-about .btn-light {
        background: #fff;
        color: #1a1a2e;
        border: none;
        font-weight: 600;
    }
    .about-page .cta-about .btn-light:hover {
        background: #f5a623;
        color: #fff;
    }
    .about-page .cta-about .btn-outline-light {
        border-color: rgba(255,255,255,0.8);
        color: #fff;
    }
    .about-page .cta-about .btn-outline-light:hover {
        background: #f5a623;
        border-color: #f5a623;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="about-page">
<!-- Hero Section -->
<section class="hero-about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">{!! ($aboutUs && !empty($aboutUs->hero_title)) ? $aboutUs->hero_title : 'About RUBISTA' !!}</h1>
                <p class="lead mb-4">{!! ($aboutUs && !empty($aboutUs->hero_subtitle)) ? $aboutUs->hero_subtitle : 'Your trusted partner in electronics since 2020. We bring you the latest technology with uncompromising quality and exceptional service.' !!}</p>
                @if($aboutUs && $aboutUs->hero_description)
                    <p>{!! $aboutUs->hero_description !!}</p>
                @endif
            </div>
            <div class="col-lg-6">
                @if($aboutUs && $aboutUs->hero_image_url)
                    <img src="{{ $aboutUs->hero_image_url }}" alt="About Us" class="img-fluid rounded shadow-lg">
                @else
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=600&h=400&fit=crop" 
                         alt="About Us" class="img-fluid rounded shadow-lg">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                @if($aboutUs && $aboutUs->our_story_image_url)
                    <img src="{{ $aboutUs->our_story_image_url }}" alt="Our Story" class="img-fluid rounded shadow">
                @else
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop" 
                         alt="Our Story" class="img-fluid rounded shadow">
                @endif
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-5">
                    <h2 class="fw-bold mb-4">Our Story</h2>
                    @if($aboutUs && $aboutUs->content)
                        {!! nl2br(e($aboutUs->content)) !!}
                    @else
                        <p class="mb-4">Founded in 2020, RUBISTA began as a small electronics store with a big vision: to make cutting-edge technology accessible to everyone. What started as a passion project has grown into a trusted online destination for electronics enthusiasts across the country.</p>
                        <p class="mb-4">We believe that great technology should enhance your life, not complicate it. That's why we carefully curate our selection to include only the best products from renowned brands, ensuring quality, reliability, and innovation in every purchase.</p>
                        <p>Today, we serve thousands of satisfied customers, building lasting relationships through exceptional service, competitive prices, and unwavering commitment to excellence.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
@if($aboutUs && $aboutUs->features && count($aboutUs->features) > 0)
<section class="about-section bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-3">Why Choose RUBISTA?</h2>
                <p class="text-muted">We're committed to providing you with the best shopping experience</p>
            </div>
        </div>
        <div class="row">
            @foreach($aboutUs->features as $feature)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="feature-card bg-white">
                    <div class="feature-icon">
                        <i class="{{ $feature['icon'] ?? 'fas fa-star' }}"></i>
                    </div>
                    <h5 class="fw-bold mb-3">{{ $feature['title'] ?? '' }}</h5>
                    <p class="text-muted">{{ $feature['description'] ?? '' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Stats Section -->
@if($aboutUs && $aboutUs->stats && count($aboutUs->stats) > 0)
<section class="stats-section">
    <div class="container">
        <div class="row">
            @foreach($aboutUs->stats as $stat)
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <span class="stat-number">{{ $stat['number'] ?? '' }}</span>
                    <div class="stat-label">{{ $stat['label'] ?? '' }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Mission, Vision, Values Section -->
@if($aboutUs && ($aboutUs->mission || $aboutUs->vision || $aboutUs->values))
<section class="about-section">
    <div class="container">
        <div class="row">
            @if($aboutUs->mission)
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    @if($aboutUs->mission_image_url)
                        <div class="mb-3">
                            <img src="{{ $aboutUs->mission_image_url }}" alt="Our Mission" 
                                 class="img-fluid rounded shadow" style="max-height: 200px; object-fit: cover;">
                        </div>
                    @else
                        <div class="feature-icon mb-3">
                            <i class="fas fa-bullseye"></i>
                        </div>
                    @endif
                    <h3 class="fw-bold mb-3">Our Mission</h3>
                    <p class="text-muted">{!! nl2br(e($aboutUs->mission)) !!}</p>
                </div>
            </div>
            @endif
            @if($aboutUs->vision)
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    @if($aboutUs->vision_image_url)
                        <div class="mb-3">
                            <img src="{{ $aboutUs->vision_image_url }}" alt="Our Vision" 
                                 class="img-fluid rounded shadow" style="max-height: 200px; object-fit: cover;">
                        </div>
                    @else
                        <div class="feature-icon mb-3">
                            <i class="fas fa-eye"></i>
                        </div>
                    @endif
                    <h3 class="fw-bold mb-3">Our Vision</h3>
                    <p class="text-muted">{!! nl2br(e($aboutUs->vision)) !!}</p>
                </div>
            </div>
            @endif
            @if($aboutUs->values)
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Our Values</h3>
                    <p class="text-muted">{!! nl2br(e($aboutUs->values)) !!}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Team Section -->
@if($aboutUs && $aboutUs->team && count($aboutUs->team) > 0)
<section class="team-section">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold mb-3">Meet Our Team</h2>
                <p class="text-muted">The passionate people behind RUBISTA</p>
            </div>
        </div>
        <div class="row">
            @foreach($aboutUs->team as $member)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="team-card">
                    <div class="team-photo">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="fw-bold">{{ $member['name'] ?? '' }}</h5>
                    <p class="text-muted mb-3">{{ $member['position'] ?? '' }}</p>
                    @if(!empty($member['description']))
                    <p class="small">{{ $member['description'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

</div>
@endsection 