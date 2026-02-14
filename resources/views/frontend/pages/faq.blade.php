@extends('frontend.layouts.app')

@section('title', 'FAQ - Rubista')

@section('extra-css')
<style>
    .faq-page .faq-hero {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.92) 0%, rgba(22, 33, 62, 0.9) 50%, rgba(15, 52, 96, 0.88) 100%),
                    url('https://images.unsplash.com/photo-1551434678-e076c223a692?w=1200&h=400&fit=crop') center/cover;
        color: #fff;
        padding: 100px 0;
        text-align: center;
        position: relative;
    }
    .faq-page .faq-hero-content {
        position: relative;
        z-index: 2;
    }
    .faq-page .faq-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }
    .faq-page .faq-hero p {
        font-size: 1.3rem;
        color: rgba(255,255,255,0.95);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .faq-page .faq-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        position: relative;
    }
    .faq-page .faq-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1200&h=800&fit=crop&opacity=0.04') center/cover;
        pointer-events: none;
    }
    .faq-page .faq-container {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    .faq-page .faq-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .faq-page .faq-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 1rem;
    }
    .faq-page .faq-header p {
        font-size: 1.1rem;
        color: #5a5a6e;
        max-width: 500px;
        margin: 0 auto;
    }

    .faq-page .faq-categories {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }
    .faq-page .faq-category-btn {
        background: #fff;
        border: 2px solid rgba(26,26,46,0.12);
        color: #5a5a6e;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 2px 8px rgba(26,26,46,0.06);
    }
    .faq-page .faq-category-btn:hover {
        background: #f5a623;
        border-color: #f5a623;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(245,166,35,0.35);
    }
    .faq-page .faq-category-btn.active {
        background: #1a1a2e;
        border-color: #1a1a2e;
        color: #fff;
        box-shadow: 0 4px 14px rgba(26,26,46,0.25);
    }

    .faq-page .faq-accordion {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(26,26,46,0.08);
        overflow: hidden;
        border: 1px solid rgba(245,166,35,0.12);
    }
    .faq-page .faq-item {
        border-bottom: 1px solid rgba(26,26,46,0.06);
        transition: all 0.25s ease;
    }
    .faq-page .faq-item:last-child {
        border-bottom: none;
    }
    .faq-page .faq-item:hover {
        background: rgba(248, 250, 252, 0.9);
    }
    .faq-page .faq-question {
        background: none;
        border: none;
        width: 100%;
        padding: 25px 30px;
        text-align: left;
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a2e;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.25s ease;
    }
    .faq-page .faq-question:hover {
        background: rgba(245,166,35,0.06);
    }
    .faq-page .faq-question::after {
        content: '\f107';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 1.2rem;
        color: #f5a623;
        transition: transform 0.3s ease;
    }
    .faq-page .faq-question[aria-expanded="true"]::after {
        transform: rotate(180deg);
    }
    .faq-page .faq-answer {
        padding: 0 30px 25px;
        color: #5a5a6e;
        line-height: 1.6;
        font-size: 1rem;
    }
    .faq-page .faq-answer p { margin-bottom: 1rem; }
    .faq-page .faq-answer p:last-child { margin-bottom: 0; }
    .faq-page .faq-answer ul { margin: 1rem 0; padding-left: 1.5rem; }
    .faq-page .faq-answer li { margin-bottom: 0.5rem; }

    .faq-page .contact-support {
        background: linear-gradient(135deg, rgba(26,26,46,0.04) 0%, rgba(245,166,35,0.06) 100%),
                    url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=400&fit=crop&opacity=0.08') center/cover;
        padding: 80px 0;
        text-align: center;
        position: relative;
    }
    .faq-page .support-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 50px;
        max-width: 500px;
        margin: 0 auto;
        box-shadow: 0 4px 24px rgba(26,26,46,0.08);
        border: 1px solid rgba(245,166,35,0.15);
        position: relative;
        z-index: 2;
    }
    .faq-page .support-card h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 1rem;
    }
    .faq-page .support-card p {
        color: #5a5a6e;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    .faq-page .support-btn {
        background: linear-gradient(135deg, #f5a623, #e0941a);
        color: #fff;
        border: none;
        padding: 15px 30px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(245,166,35,0.35);
    }
    .faq-page .support-btn:hover {
        background: #1a1a2e;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(26,26,46,0.3);
        color: #fff;
    }

    .faq-page .text-muted { color: #5a5a6e !important; }

    @media (max-width: 768px) {
        .faq-page .faq-hero {
            padding: 80px 0;
            background: linear-gradient(135deg, rgba(26,26,46,0.94) 0%, rgba(22,33,62,0.92) 100%),
                        url('https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&h=300&fit=crop') center/cover;
        }
        .faq-page .faq-hero h1 { font-size: 2.5rem; }
        .faq-page .faq-hero p { font-size: 1.1rem; }
        .faq-page .faq-section { padding: 60px 0; }
        .faq-page .faq-header h2 { font-size: 2rem; }
        .faq-page .faq-categories { gap: 15px; }
        .faq-page .faq-category-btn { padding: 10px 20px; font-size: 0.9rem; }
        .faq-page .faq-question { padding: 20px 25px; font-size: 1rem; }
        .faq-page .faq-answer { padding: 0 25px 20px; }
        .faq-page .contact-support { padding: 60px 0; }
        .faq-page .support-card { padding: 40px 25px; margin: 0 20px; }
    }
</style>
@endsection

@section('content')
<div class="faq-page">
<!-- FAQ Hero Section -->
<section class="faq-hero">
    <div class="container">
        <div class="faq-hero-content">
            <h1>Frequently Asked Questions</h1>
            <p>Find quick answers to common questions about our products, services, and policies</p>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="faq-container">
            <div class="faq-header">
                <h2>How Can We Help You?</h2>
                <p>Browse through our most commonly asked questions to find the information you need</p>
            </div>

            <!-- FAQ Categories -->
            <div class="faq-categories">
                <button class="faq-category-btn active" data-category="all">All Questions</button>
                @if($faqsByCategory->has('orders'))
                    <button class="faq-category-btn" data-category="orders">Orders & Shipping</button>
                @endif
                @if($faqsByCategory->has('returns'))
                    <button class="faq-category-btn" data-category="returns">Returns & Refunds</button>
                @endif
                @if($faqsByCategory->has('products'))
                    <button class="faq-category-btn" data-category="products">Products & Warranty</button>
                @endif
                @if($faqsByCategory->has('payment'))
                    <button class="faq-category-btn" data-category="payment">Payment & Security</button>
                @endif
                @if($faqsByCategory->has('shipping'))
                    <button class="faq-category-btn" data-category="shipping">Shipping</button>
                @endif
                @if($faqsByCategory->has('general'))
                    <button class="faq-category-btn" data-category="general">General</button>
                @endif
            </div>

            <!-- FAQ Accordion -->
            <div class="faq-accordion" id="faqAccordion">
                @forelse($faqs as $index => $faq)
                <div class="faq-item" data-category="{{ $faq->category }}">
                    <button class="faq-question {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#faq{{ $faq->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                        {{ $faq->question }}
                    </button>
                    <div id="faq{{ $faq->id }}" class="faq-answer collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <p class="text-muted">No FAQs available at the moment. Please check back later.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Contact Support Section -->
<section class="contact-support">
    <div class="container">
        <div class="support-card">
            <h3>Still Need Help?</h3>
            <p>Can't find the answer you're looking for? Our customer support team is here to help you with any questions or concerns.</p>
            <a href="{{ route('frontend.contact') }}" class="support-btn">
                <i class="fas fa-headset me-2"></i>
                Contact Support
            </a>
        </div>
    </div>
</section>
</div>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Category Filter
    const categoryButtons = document.querySelectorAll('.faq-category-btn');
    const faqItems = document.querySelectorAll('.faq-item');

    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active button
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter FAQ items
            faqItems.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                    item.style.opacity = '1';
                } else {
                    item.style.display = 'none';
                    item.style.opacity = '0';
                }
            });
        });
    });

    // Smooth scroll for FAQ items
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            // Add smooth scroll to the question
            this.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        });
    });

    // Search functionality (optional enhancement)
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Search FAQs...';
    searchInput.className = 'form-control mb-4';
    searchInput.style.cssText = `
        max-width: 400px;
        margin: 0 auto 2rem;
        border-radius: 12px;
        padding: 12px 20px;
        border: 2px solid rgba(26,26,46,0.12);
        font-size: 1rem;
    `;
    searchInput.addEventListener('focus', function() {
        this.style.borderColor = '#f5a623';
        this.style.boxShadow = '0 0 0 0.2rem rgba(245, 166, 35, 0.25)';
    });
    searchInput.addEventListener('blur', function() {
        this.style.borderColor = '';
        this.style.boxShadow = '';
    });

    // Insert search input after categories
    const categoriesDiv = document.querySelector('.faq-categories');
    categoriesDiv.parentNode.insertBefore(searchInput, categoriesDiv.nextSibling);

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question').textContent.toLowerCase();
            const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.style.display = 'block';
                item.style.opacity = '1';
            } else {
                item.style.display = 'none';
                item.style.opacity = '0';
            }
        });
    });
});
</script>
@endsection
