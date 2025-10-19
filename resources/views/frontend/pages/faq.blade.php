@extends('frontend.layouts.app')

@section('title', 'FAQ - Rubista')

@section('extra-css')
<style>
    .faq-hero {
        background: linear-gradient(rgba(124, 58, 237, 0.9), rgba(168, 85, 247, 0.8)), 
                    url('https://images.unsplash.com/photo-1551434678-e076c223a692?w=1200&h=400&fit=crop') center/cover;
        color: white;
        padding: 100px 0;
        text-align: center;
        position: relative;
    }

    .faq-hero-content {
        position: relative;
        z-index: 2;
    }

    .faq-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .faq-hero p {
        font-size: 1.3rem;
        opacity: 0.95;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .faq-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        position: relative;
    }

    .faq-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1200&h=800&fit=crop&opacity=0.05') center/cover;
        pointer-events: none;
    }

    .faq-container {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .faq-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .faq-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 1rem;
    }

    .faq-header p {
        font-size: 1.1rem;
        color: #64748b;
        max-width: 500px;
        margin: 0 auto;
    }

    .faq-categories {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .faq-category-btn {
        background: white;
        border: 2px solid #e2e8f0;
        color: #64748b;
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .faq-category-btn:hover,
    .faq-category-btn.active {
        background: var(--primary-purple);
        border-color: var(--primary-purple);
        color: white;
        transform: translateY(-2px);
    }

    .faq-accordion {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .faq-item {
        border-bottom: 1px solid rgba(241, 245, 249, 0.8);
        transition: all 0.3s ease;
    }

    .faq-item:last-child {
        border-bottom: none;
    }

    .faq-item:hover {
        background: rgba(248, 250, 252, 0.8);
    }

    .faq-question {
        background: none;
        border: none;
        width: 100%;
        padding: 25px 30px;
        text-align: left;
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a202c;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
    }

    .faq-question:hover {
        background: #f8fafc;
    }

    .faq-question::after {
        content: '\f107';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 1.2rem;
        color: var(--primary-purple);
        transition: transform 0.3s ease;
    }

    .faq-question[aria-expanded="true"]::after {
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 30px 25px;
        color: #64748b;
        line-height: 1.6;
        font-size: 1rem;
    }

    .faq-answer p {
        margin-bottom: 1rem;
    }

    .faq-answer p:last-child {
        margin-bottom: 0;
    }

    .faq-answer ul {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .faq-answer li {
        margin-bottom: 0.5rem;
    }

    .contact-support {
        background: linear-gradient(rgba(124, 58, 237, 0.05), rgba(168, 85, 247, 0.05)), 
                    url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=400&fit=crop&opacity=0.1') center/cover;
        padding: 80px 0;
        text-align: center;
        position: relative;
    }

    .support-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 50px;
        max-width: 500px;
        margin: 0 auto;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        z-index: 2;
    }

    .support-card h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 1rem;
    }

    .support-card p {
        color: #64748b;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .support-btn {
        background: var(--primary-purple);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .support-btn:hover {
        background: var(--dark-purple);
        transform: translateY(-2px);
        color: white;
    }

    @media (max-width: 768px) {
        .faq-hero {
            padding: 80px 0;
            background: linear-gradient(rgba(124, 58, 237, 0.95), rgba(168, 85, 247, 0.9)), 
                        url('https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&h=300&fit=crop') center/cover;
        }

        .faq-hero h1 {
            font-size: 2.5rem;
        }

        .faq-hero p {
            font-size: 1.1rem;
        }

        .faq-section {
            padding: 60px 0;
        }

        .faq-header h2 {
            font-size: 2rem;
        }

        .faq-categories {
            gap: 15px;
        }

        .faq-category-btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .faq-question {
            padding: 20px 25px;
            font-size: 1rem;
        }

        .faq-answer {
            padding: 0 25px 20px;
        }

        .contact-support {
            padding: 60px 0;
        }

        .support-card {
            padding: 40px 25px;
            margin: 0 20px;
        }
    }
</style>
@endsection

@section('content')
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
                <button class="faq-category-btn" data-category="orders">Orders & Shipping</button>
                <button class="faq-category-btn" data-category="returns">Returns & Refunds</button>
                <button class="faq-category-btn" data-category="products">Products & Warranty</button>
                <button class="faq-category-btn" data-category="payment">Payment & Security</button>
            </div>

            <!-- FAQ Accordion -->
            <div class="faq-accordion">
                <!-- Orders & Shipping -->
                <div class="faq-item" data-category="orders">
                    <button class="faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
                        How long does delivery take?
                    </button>
                    <div id="faq1" class="faq-answer collapse show" data-bs-parent="#faqAccordion">
                        <p>Our delivery times vary based on your location and the shipping method you choose:</p>
                        <ul>
                            <li><strong>Standard Delivery:</strong> 3-5 business days</li>
                            <li><strong>Express Delivery:</strong> 1-2 business days</li>
                            <li><strong>Same Day Delivery:</strong> Available in select cities</li>
                        </ul>
                        <p>You'll receive tracking information via email once your order ships.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="orders">
                    <button class="faq-question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Do you ship internationally?
                    </button>
                    <div id="faq2" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                        <p>Currently, we ship to all major cities in India. International shipping is not available at this time. We're working on expanding our shipping network to serve customers worldwide.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="orders">
                    <button class="faq-question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        How can I track my order?
                    </button>
                    <div id="faq3" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                        <p>You can track your order in several ways:</p>
                        <ul>
                            <li>Check your email for tracking information</li>
                            <li>Log into your account and visit the "My Orders" section</li>
                            <li>Contact our customer support team</li>
                        </ul>
                        <p>Tracking information is typically available within 24 hours of order confirmation.</p>
                    </div>
                </div>

                <!-- Returns & Refunds -->
                <div class="faq-item" data-category="returns">
                    <button class="faq-question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        What is your return policy?
                    </button>
                    <div id="faq4" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                        <p>We offer a 30-day return policy for all products with the following conditions:</p>
                        <ul>
                            <li>Items must be in original condition with all packaging</li>
                            <li>No signs of use or damage</li>
                            <li>Original receipt or order confirmation required</li>
                        </ul>
                        <p>Contact our support team to initiate a return. We'll provide a prepaid shipping label for your convenience.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="returns">
                    <button class="faq-question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                        How long does it take to process a refund?
                    </button>
                    <div id="faq5" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                        <p>Refund processing times depend on your payment method:</p>
                        <ul>
                            <li><strong>Credit/Debit Cards:</strong> 5-7 business days</li>
                            <li><strong>UPI/Net Banking:</strong> 2-3 business days</li>
                            <li><strong>Cash on Delivery:</strong> Bank transfer within 3-5 days</li>
                        </ul>
                        <p>You'll receive an email confirmation once the refund is processed.</p>
                    </div>
                </div>

                <!-- Products & Warranty -->
                <div class="faq-item" data-category="products">
                    <button class="faq-question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                        Do you offer warranty on products?
                    </button>
                    <div id="faq6" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                        <p>Yes, all our products come with manufacturer warranty:</p>
                        <ul>
                            <li><strong>Standard Warranty:</strong> 1 year manufacturer warranty</li>
                            <li><strong>Extended Warranty:</strong> Available for select items</li>
                            <li><strong>Warranty Coverage:</strong> Manufacturing defects and hardware issues</li>
                        </ul>
                        <p>Check individual product pages for specific warranty details. Extended warranty can be purchased at checkout.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="products">
                    <button class="faq-question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                        Are your products genuine and authentic?
                    </button>
                    <div id="faq7" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                        <p>Absolutely! We only sell genuine, authentic products from authorized manufacturers and distributors. All our products come with:</p>
                        <ul>
                            <li>Original manufacturer warranty</li>
                            <li>Genuine product packaging</li>
                            <li>Authenticity certificates where applicable</li>
                            <li>Direct partnership with brands</li>
                        </ul>
                        <p>We never sell counterfeit or refurbished products as new.</p>
                    </div>
                </div>

                <!-- Payment & Security -->
                <div class="faq-item" data-category="payment">
                    <button class="faq-question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                        What payment methods do you accept?
                    </button>
                    <div id="faq8" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                        <p>We accept all major payment methods:</p>
                        <ul>
                            <li><strong>Cards:</strong> Visa, MasterCard, American Express, RuPay</li>
                            <li><strong>Digital Wallets:</strong> Paytm, PhonePe, Google Pay, Amazon Pay</li>
                            <li><strong>UPI:</strong> All UPI apps supported</li>
                            <li><strong>Net Banking:</strong> All major banks</li>
                            <li><strong>Cash on Delivery:</strong> Available for orders up to ₹10,000</li>
                        </ul>
                        <p>All online payments are secured with SSL encryption.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="payment">
                    <button class="faq-question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                        Is my payment information secure?
                    </button>
                    <div id="faq9" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                        <p>Yes, your payment information is completely secure. We use:</p>
                        <ul>
                            <li><strong>SSL Encryption:</strong> 256-bit encryption for all transactions</li>
                            <li><strong>PCI DSS Compliance:</strong> Industry-standard security protocols</li>
                            <li><strong>Secure Payment Gateways:</strong> Trusted payment processors</li>
                            <li><strong>No Data Storage:</strong> We don't store your card details</li>
                        </ul>
                        <p>Your personal and financial information is protected at every step.</p>
                    </div>
                </div>

                <div class="faq-item" data-category="payment">
                    <button class="faq-question collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                        Can I cancel my order after payment?
                    </button>
                    <div id="faq10" class="faq-answer collapse" data-bs-parent="#faqAccordion">
                        <p>Yes, you can cancel your order under certain conditions:</p>
                        <ul>
                            <li><strong>Before Shipping:</strong> Full refund available</li>
                            <li><strong>After Shipping:</strong> Return policy applies</li>
                            <li><strong>Processing Time:</strong> 24-48 hours for cancellation</li>
                        </ul>
                        <p>Contact our customer support immediately if you need to cancel your order.</p>
                    </div>
                </div>
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
        border-radius: 25px;
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        font-size: 1rem;
    `;

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
