
@extends('frontend.layouts.app')

@section('title', 'Home - Rubista')

@section('extra-css')
<style>
    .home-product-wishlist-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.95);
        color: #f5a623;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s, color 0.2s;
    }
    .home-product-wishlist-btn:hover { background: #f5a623; color: #fff; }
    .home-product-wishlist-btn i { font-size: 1rem; }
    .home-product-wishlist-btn.active { background: #ef4444; color: #fff; }
    .product-card-actions {
        display: flex;
        gap: 8px;
        margin-top: 10px;
        flex-wrap: wrap;
    }
    .home-add-to-cart-btn {
        width: 100%;
        background: #1a1a2e;
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .home-add-to-cart-btn:hover { background: #333; }
</style>
@endsection

@php
    use Illuminate\Support\Str;
    $shippingThreshold = $settings['free_shipping_threshold'] ?? 500;
@endphp

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            @if(isset($heroContent) && $heroContent)
                <h1>{!! $heroContent->title ?? 'Welcome to RUBISTA' !!}</h1>
                <p>{!! $heroContent->subtitle ?? 'Your one-stop shop for electronics & accessories' !!}</p>
                @if($heroContent->button_text && $heroContent->button_url)
                    <a href="{{ $heroContent->button_url }}" class="buy-btn" style="margin-top: 15px; display: inline-block;">{{ $heroContent->button_text }}</a>
                @endif
            @else
                <h1>Welcome to RUBISTA</h1>
                <p>Your one-stop shop for electronics & accessories</p>
            @endif
        </div>
    </section>

    <!-- Features Bar -->
    <div class="features-bar">
        <div class="container">
            @if(isset($serviceContent) && $serviceContent->count() > 0)
                @foreach($serviceContent->take(4) as $service)
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="{{ $service->extra_data['icon'] ?? 'fas fa-star' }}"></i>
                        </div>
                        <div class="feature-text">
                            <h4>{{ strtoupper($service->title ?? 'Feature') }}</h4>
                            <p>
                                @if($service->title && (stripos($service->title, 'shipping') !== false || stripos($service->title, 'free') !== false))
                                    On orders over ₹{{ number_format($shippingThreshold, 0) }}
                                @elseif($service->title && (stripos($service->title, 'support') !== false || stripos($service->title, 'contact') !== false))
                                    {{ $settings['site_phone'] ?? $service->subtitle ?? 'Any Time Customer Support' }}
                                @else
                                    {{ $service->subtitle ?? '' }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-truck"></i></div>
                    <div class="feature-text">
                        <h4>FREE SHIPPING</h4>
                        <p>On orders over ₹{{ number_format($shippingThreshold, 0) }}</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-headset"></i></div>
                    <div class="feature-text">
                        <h4>24/7 SUPPORT</h4>
                        <p>{{ $settings['site_phone'] ?? 'Any Time Customer Support' }}</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="feature-text">
                        <h4>SECURE PAYMENT</h4>
                        <p>100% Safe & Secure Payment</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-gift"></i></div>
                    <div class="feature-text">
                        <h4>FREE GIFTS</h4>
                        <p>Free Gift on Shopping on all items</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Categories -->
    <section class="categories">
        <div class="container">
            <p class="category-title">CATEGORIES</p>
            <div class="category-grid">
                @php
                    $categoryIcons = ['fa-cable-car', 'fa-plug', 'fa-battery-full', 'fa-mobile-screen', 'fa-sd-card', 'fa-clock', 'fa-mobile-alt', 'fa-mobile'];
                @endphp
                @forelse($categories ?? [] as $category)
                    <a href="{{ route('frontend.category.products', $category->id) }}" class="category-item" style="display: block; text-align: center;">
                        <div class="category-icon {{ $loop->index == 3 ? 'orange' : '' }}">
                            @if($category->image)
                                @if(Str::startsWith($category->image, 'http'))
                                    <img src="{{ $category->image }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                @endif
                            @else
                                <i class="fas {{ $categoryIcons[$loop->index % count($categoryIcons)] ?? 'fa-box' }}"></i>
                            @endif
                        </div>
                        <span>{{ Str::limit($category->name, 12) }}</span>
                    </a>
                @empty
                    <div class="category-item">
                        <div class="category-icon"><i class="fas fa-box"></i></div>
                        <span>No categories yet</span>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @php
        $productImageUrl = function($product) {
            if (empty($product->image)) return 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=200&h=200&fit=crop';
            return \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image);
        };
        $productDisplayPrice = function($product) {
            $current = $product->sale_price ?? $product->price;
            $original = ($product->sale_price && $product->price > $product->sale_price) ? $product->price : null;
            return ['current' => $current, 'original' => $original];
        };
    @endphp

    <!-- Trending Products (with Special Offer in the middle) -->
    <section class="products-section">
        <div class="container">
            <div class="section-title left">
                <h2>{{ $featuredProductsContent->title ?? 'TRENDING PRODUCTS' }}</h2>
            </div>
            @php $trending = ($trendingProducts ?? collect())->take(8); @endphp
            <div class="products-grid">
                @forelse($trending as $index => $product)
                    @if($index === 5 || ($trending->count() <= 5 && $trending->count() >= 2 && $index === (int)($trending->count() / 2)))
                        {{-- Special Offer card in the middle (after first row, or after half when fewer products) --}}
                        <div class="earbuds-card dark" style="grid-column: 1 / -1; margin: 10px 0;">
                            @if(isset($offerContent) && $offerContent->count() > 0)
                                @php $offer = $offerContent->first(); @endphp
                                <img src="{{ $offer->image_url ?? $productImageUrl($trending->first()) }}" alt="{{ $offer->title ?? 'Offer' }}" style="border-radius: 12px;">
                                <div class="earbuds-info">
                                    <p>{{ $offer->subtitle ?? 'Up to 50% OFF on Smart Watches & Wearables' }}</p>
                                    <h3>{{ $offer->title ?? 'Special Offer - Limited Time!' }}</h3>
                                    @if($offer->description ?? null)
                                        <p class="price">{{ $offer->description }}</p>
                                    @endif
                                </div>
                            @else
                                <img src="{{ $productImageUrl($trending->first()) }}" alt="Special Offer" style="border-radius: 12px;">
                                <div class="earbuds-info">
                                    <p>Up to 50% OFF on Smart Watches & Wearables</p>
                                    <h3>Special Offer - Limited Time!</h3>
                                </div>
                            @endif
                        </div>
                    @endif
                    <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card" style="display: block; text-decoration: none; color: inherit; position: relative;">
                        @if($product->featured)
                            <span class="product-badge">Featured</span>
                        @elseif($product->sale_price && $product->price > $product->sale_price)
                            <span class="product-badge red">{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF</span>
                        @endif
                        <button type="button" class="home-product-wishlist-btn" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeWishlistToggle({{ $product->id }})" title="Add to wishlist"><i class="far fa-heart"></i></button>
                        <img src="{{ $productImageUrl($product) }}" alt="{{ $product->name }}" class="product-image">
                        <p class="product-title">{{ $product->category->name ?? 'Product' }}</p>
                        <h3 class="product-name">{{ Str::limit($product->name, 30) }}</h3>
                        <div class="product-price">
                            @php $prices = $productDisplayPrice($product); @endphp
                            <span class="current-price">₹{{ number_format($prices['current'], 0) }}</span>
                            @if($prices['original'])
                                <span class="original-price">₹{{ number_format($prices['original'], 0) }}</span>
                            @endif
                        </div>
                        <div class="product-card-actions">
                            <button type="button" class="home-add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeAddToCart({{ $product->id }})">Add to Cart</button>
                        </div>
                    </a>
                @empty
                    <p style="grid-column: 1/-1; text-align: center; color: #666;">No products yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Discounts For You (featured or sale products) -->
    @php $discountProducts = ($featuredProducts ?? collect())->count() > 0 ? $featuredProducts : $trendingProducts; @endphp
    @if(($discountProducts ?? collect())->count() > 0)
        <section class="products-section">
            <div class="container">
                <div class="section-title left">
                    <h2>{{ (isset($offerContent) && $offerContent->count() > 0) ? $offerContent->first()->title : 'DISCOUNTS FOR YOU' }}</h2>
                </div>
                <div class="products-grid">
                    @foreach($discountProducts->take(5) as $index => $product)
                        <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card" style="display: block; text-decoration: none; color: inherit; position: relative;">
                            @if($product->sale_price && $product->price > $product->sale_price)
                                <span class="product-badge red">{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF</span>
                            @else
                                <span class="product-badge">{{ $product->category->name ?? 'Sale' }}</span>
                            @endif
                            <button type="button" class="home-product-wishlist-btn" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeWishlistToggle({{ $product->id }})" title="Add to wishlist"><i class="far fa-heart"></i></button>
                            <img src="{{ $productImageUrl($product) }}" alt="{{ $product->name }}" class="product-image">
                            <p class="product-title">{{ $product->category->name ?? 'Product' }}</p>
                            <h3 class="product-name">{{ Str::limit($product->name, 30) }}</h3>
                            <div class="product-price">
                                @php $prices = $productDisplayPrice($product); @endphp
                                <span class="current-price">₹{{ number_format($prices['current'], 0) }}</span>
                                @if($prices['original'])
                                    <span class="original-price">₹{{ number_format($prices['original'], 0) }}</span>
                                @endif
                            </div>
                            <div class="product-card-actions">
                                <button type="button" class="home-add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeAddToCart({{ $product->id }})">Add to Cart</button>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Smart Watches Section (category or trending) -->
    @php
        $watchCategory = ($categories ?? collect())->first(fn($c) => stripos($c->name, 'watch') !== false);
        $watchProducts = $watchCategory ? $watchCategory->products->take(2) : ($trendingProducts ?? collect())->take(2);
    @endphp
    @if($watchProducts->count() > 0)
        <section class="watches-section">
            <div class="container">
                <div class="section-header">
                    <h2>SMART WATCHES</h2>
                    @if($watchCategory)
                        <a href="{{ route('frontend.category.products', $watchCategory->id) }}" class="view-all">VIEW ALL &gt;</a>
                    @else
                        <a href="#" class="view-all">VIEW ALL &gt;</a>
                    @endif
                </div>
                <div class="watches-grid">
                    <div class="watch-products">
                        @foreach($watchProducts as $product)
                            <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card" style="display: block; text-decoration: none; color: inherit; position: relative;">
                                <span class="product-badge">WATCH</span>
                                <button type="button" class="home-product-wishlist-btn" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeWishlistToggle({{ $product->id }})" title="Add to wishlist"><i class="far fa-heart"></i></button>
                                <img src="{{ $productImageUrl($product) }}" alt="{{ $product->name }}" class="product-image">
                                <p class="product-title">{{ Str::limit($product->name, 25) }}</p>
                                <div class="product-price">
                                    @php $prices = $productDisplayPrice($product); @endphp
                                    <span class="current-price">₹{{ number_format($prices['current'], 0) }}</span>
                                    @if($prices['original'])
                                        <span class="original-price">₹{{ number_format($prices['original'], 0) }}</span>
                                    @endif
                                </div>
                                <div class="product-card-actions">
                                    <button type="button" class="home-add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeAddToCart({{ $product->id }})">Add to Cart</button>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="watch-banner">
                        <div>
                            <h3>Resistance</h3>
                            <p>Zinc Alloy body</p>
                        </div>
                        <img src="{{ $watchProducts->first() ? $productImageUrl($watchProducts->first()) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&h=200&fit=crop' }}" alt="Smart Watch">
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Power Banks Section -->
    @php
        $powerCategory = ($categories ?? collect())->first(fn($c) => stripos($c->name, 'power') !== false || stripos($c->name, 'bank') !== false || stripos($c->name, 'charger') !== false);
        $powerProducts = $powerCategory ? $powerCategory->products->take(2) : ($trendingProducts ?? collect())->skip(2)->take(2);
    @endphp
    @if($powerProducts->count() > 0)
        <section class="powerbank-section">
            <div class="container">
                <div class="powerbank-grid">
                    <div class="powerbank-banner">
                        <img src="{{ $powerProducts->first() ? $productImageUrl($powerProducts->first()) : 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=200&h=200&fit=crop' }}" alt="Power Bank">
                        <div class="powerbank-info">
                            <h3>20000mAh</h3>
                            <p>Lithium Polymer Battery</p>
                        </div>
                    </div>
                    <div class="powerbank-products">
                        <div class="section-header">
                            <h2>POWER BANKS</h2>
                            @if($powerCategory)
                                <a href="{{ route('frontend.category.products', $powerCategory->id) }}" class="view-all">VIEW ALL &gt;</a>
                            @else
                                <a href="#" class="view-all">VIEW ALL &gt;</a>
                            @endif
                        </div>
                        @foreach($powerProducts as $product)
                            <a href="{{ route('frontend.product.detail', $product->id) }}" class="powerbank-item" style="text-decoration: none; color: inherit;">
                                <img src="{{ $productImageUrl($product) }}" alt="{{ $product->name }}">
                                <div>
                                    <p style="font-size: 12px;">{{ $product->category->name ?? 'Power Bank' }}</p>
                                    <h4 style="font-size: 14px;">{{ Str::limit($product->name, 25) }}</h4>
                                    <div class="product-price" style="justify-content: flex-start;">
                                        @php $prices = $productDisplayPrice($product); @endphp
                                        <span class="current-price">₹{{ number_format($prices['current'], 0) }}</span>
                                        @if($prices['original'])
                                            <span class="original-price">₹{{ number_format($prices['original'], 0) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Top Rated Products (featured) -->
    @if(($featuredProducts ?? collect())->count() > 0)
        <section class="products-section">
            <div class="container">
                <div class="section-title left">
                    <h2>{{ $bestSellersContent->title ?? 'TOP RATED PRODUCTS' }}</h2>
                </div>
                <div class="products-grid">
                    @foreach($featuredProducts->take(5) as $index => $product)
                        <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card" style="display: block; text-decoration: none; color: inherit; position: relative;">
                            <span class="product-badge">{{ $product->category->name ?? 'Featured' }}</span>
                            <button type="button" class="home-product-wishlist-btn" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeWishlistToggle({{ $product->id }})" title="Add to wishlist"><i class="far fa-heart"></i></button>
                            <img src="{{ $productImageUrl($product) }}" alt="{{ $product->name }}" class="product-image">
                            <p class="product-title">{{ $product->category->name ?? 'Product' }}</p>
                            <h3 class="product-name">{{ Str::limit($product->name, 30) }}</h3>
                            <div class="product-price">
                                @php $prices = $productDisplayPrice($product); @endphp
                                <span class="current-price">₹{{ number_format($prices['current'], 0) }}</span>
                                @if($prices['original'])
                                    <span class="original-price">₹{{ number_format($prices['original'], 0) }}</span>
                                @endif
                            </div>
                            <div class="product-card-actions">
                                <button type="button" class="home-add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeAddToCart({{ $product->id }})">Add to Cart</button>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Flash Sale Section -->
    <section class="container">
        <div class="products-grid" style="grid-template-columns: 1fr 1.5fr 1fr;">
            <div style="display: grid; gap: 15px;">
                @foreach(($trendingProducts ?? collect())->take(2) as $product)
                    <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card" style="display: block; text-decoration: none; color: inherit; position: relative;">
                        @if($product->sale_price && $product->price > $product->sale_price)
                            <span class="product-badge red">{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF</span>
                        @else
                            <span class="product-badge">{{ $product->category->name ?? 'Sale' }}</span>
                        @endif
                        <button type="button" class="home-product-wishlist-btn" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeWishlistToggle({{ $product->id }})" title="Add to wishlist"><i class="far fa-heart"></i></button>
                        <img src="{{ $productImageUrl($product) }}" alt="{{ $product->name }}" class="product-image">
                        <p class="product-title">{{ Str::limit($product->name, 25) }}</p>
                        <div class="product-price">
                            @php $prices = $productDisplayPrice($product); @endphp
                            <span class="current-price">₹{{ number_format($prices['current'], 0) }}</span>
                            @if($prices['original'])
                                <span class="original-price">₹{{ number_format($prices['original'], 0) }}</span>
                            @endif
                        </div>
                        <div class="product-card-actions">
                            <button type="button" class="home-add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeAddToCart({{ $product->id }})">Add to Cart</button>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="flash-sale">
                @if(isset($flashDealContent) && $flashDealContent)
                    <p style="font-size: 14px; margin-bottom: 10px;">{{ $flashDealContent->title ?? 'Flash Sale' }}</p>
                    <h2>{!! $flashDealContent->subtitle ?? 'Premium Smartwatches<br>at Crazy Prices!' !!}</h2>
                    @if($flashDealContent->image_url)
                        <div style="margin: 20px 0;">
                            <img src="{{ $flashDealContent->image_url }}" alt="Flash" style="width: 80px; border-radius: 50%;">
                        </div>
                    @else
                        <div style="margin: 20px 0;">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop" alt="Watch" style="width: 80px; border-radius: 50%;">
                        </div>
                    @endif
                    @if($flashDealContent->button_url)
                        <a href="{{ $flashDealContent->button_url }}" class="shop-now-btn" style="display: inline-block; text-decoration: none; color: inherit;">SHOP NOW</a>
                    @else
                        <a href="#featured" class="shop-now-btn" style="display: inline-block; text-decoration: none; color: inherit;">SHOP NOW</a>
                    @endif
                @else
                    <p style="font-size: 14px; margin-bottom: 10px;">Flash Sale</p>
                    <h2>Premium Smartwatches<br>at Crazy Prices!</h2>
                    <div style="margin: 20px 0;">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=100&h=100&fit=crop" alt="Watch" style="width: 80px; border-radius: 50%;">
                    </div>
                    <a href="#" class="shop-now-btn" style="display: inline-block; text-decoration: none; color: inherit;">SHOP NOW</a>
                @endif
                <p style="margin-top: 15px; font-size: 12px;">www.rubista.com</p>
                <div style="margin-top: 10px;">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-instagram" style="margin-left: 10px;"></i>
                </div>
            </div>
            <div style="display: grid; gap: 15px;">
                @foreach(($trendingProducts ?? collect())->skip(2)->take(2) as $index => $product)
                    <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card" style="display: block; text-decoration: none; color: inherit; position: relative;">
                        <span class="product-badge {{ $index === 0 ? 'red' : '' }}">{{ $product->category->name ?? 'Sale' }}</span>
                        <button type="button" class="home-product-wishlist-btn" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeWishlistToggle({{ $product->id }})" title="Add to wishlist"><i class="far fa-heart"></i></button>
                        <img src="{{ $productImageUrl($product) }}" alt="{{ $product->name }}" class="product-image">
                        <p class="product-title">{{ Str::limit($product->name, 25) }}</p>
                        <div class="product-price">
                            @php $prices = $productDisplayPrice($product); @endphp
                            <span class="current-price">₹{{ number_format($prices['current'], 0) }}</span>
                            @if($prices['original'])
                                <span class="original-price">₹{{ number_format($prices['original'], 0) }}</span>
                            @endif
                        </div>
                        <div class="product-card-actions">
                            <button type="button" class="home-add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeAddToCart({{ $product->id }})">Add to Cart</button>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Shop By Discounts -->
    <section class="discounts-section">
        <div class="container">
            <div class="section-title">
                <h2>Shop By <span>Discounts</span>!</h2>
                <p style="font-size: 12px; color: #666;">HURRY UP! SALE ENDS IN</p>
            </div>
            <div class="countdown">
                <div class="countdown-item">21</div>
                <div class="countdown-item">50</div>
                <div class="countdown-item">12</div>
                <div class="countdown-item">02</div>
            </div>
            <div class="products-grid" style="margin-top: 30px;">
                @foreach(($trendingProducts ?? collect())->take(5) as $index => $product)
                    <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card" style="display: block; text-decoration: none; color: inherit; position: relative;">
                        @if($product->sale_price && $product->price > $product->sale_price)
                            <span class="product-badge red">{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF</span>
                        @else
                            <span class="product-badge">{{ $product->category->name ?? 'Deal' }}</span>
                        @endif
                        <button type="button" class="home-product-wishlist-btn" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeWishlistToggle({{ $product->id }})" title="Add to wishlist"><i class="far fa-heart"></i></button>
                        <img src="{{ $productImageUrl($product) }}" alt="{{ $product->name }}" class="product-image">
                        <p class="product-title">{{ $product->category->name ?? 'Product' }}</p>
                        <h3 class="product-name">{{ Str::limit($product->name, 30) }}</h3>
                        <div class="product-price">
                            @php $prices = $productDisplayPrice($product); @endphp
                            <span class="current-price">₹{{ number_format($prices['current'], 0) }}</span>
                            @if($prices['original'])
                                <span class="original-price">₹{{ number_format($prices['original'], 0) }}</span>
                            @endif
                        </div>
                        <div class="product-card-actions">
                            <button type="button" class="home-add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeAddToCart({{ $product->id }})">Add to Cart</button>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Promotional Banners -->
    <section class="promo-section">
        <div class="container">
            <div class="promo-grid">
                @if(isset($bannerContent) && $bannerContent->count() >= 2)
                    @foreach($bannerContent->take(2) as $banner)
                        <div class="promo-banner {{ $loop->first ? 'sale' : 'headphone' }}">
                            @if($banner->image_url)
                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.3;">
                            @endif
                            <p>{{ $banner->extra_data['line1'] ?? 'WWW.RUBISTA.COM' }}</p>
                            <p style="font-size: 12px;">{{ $banner->title ?? '' }}</p>
                            <h3>{!! nl2br(e($banner->subtitle ?? 'ONLINE<br>SALE')) !!}</h3>
                            @if($banner->description)
                                <p style="font-size: 11px; margin-top: 10px;">{{ $banner->description }}</p>
                            @endif
                        </div>
                    @endforeach
                @elseif(isset($bannerContent) && $bannerContent->count() === 1)
                    <div class="promo-banner sale">
                        <p>{{ $bannerContent->first()->extra_data['line1'] ?? 'WWW.RUBISTA.COM' }}</p>
                        <p style="font-size: 12px;">{{ $bannerContent->first()->title ?? 'BLACK FRIDAY PRESENTS' }}</p>
                        <h3>{!! nl2br(e($bannerContent->first()->subtitle ?? 'ONLINE<br>SALE')) !!}</h3>
                        <p style="font-size: 11px; margin-top: 10px;">Get 20% Off On Selected Items</p>
                    </div>
                    <div class="promo-banner headphone">
                        <div>
                            <p style="font-size: 12px;">EXCLUSIVE</p>
                            <h3>HEADPHONE</h3>
                            <p style="font-size: 14px;">Premium Sound Quality</p>
                        </div>
                    </div>
                @else
                    <div class="promo-banner sale">
                        <p>WWW.RUBISTA.COM</p>
                        <p style="font-size: 12px;">BLACK FRIDAY PRESENTS</p>
                        <h3>ONLINE<br>SALE</h3>
                        <p style="font-size: 11px; margin-top: 10px;">Get 20% Off On Selected Items<br>LOCAL SHOPPING MALL</p>
                    </div>
                    <div class="promo-banner headphone">
                        <div>
                            <p style="font-size: 12px;">EXCLUSIVE</p>
                            <h3>HEADPHONE</h3>
                            <p style="font-size: 14px;">Premium Sound Quality</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Recommended Items -->
    <section class="products-section">
        <div class="container">
            <div class="section-title left">
                <h2>{{ $latestProductsContent->title ?? 'RECOMMENDED ITEMS FOR YOU' }}</h2>
            </div>
            <div class="products-grid">
                @forelse(($featuredProducts ?? $trendingProducts ?? collect())->take(5) as $index => $product)
                    <a href="{{ route('frontend.product.detail', $product->id) }}" class="product-card" style="display: block; text-decoration: none; color: inherit; position: relative;">
                        <span class="product-badge">{{ $product->category->name ?? 'Featured' }}</span>
                        <button type="button" class="home-product-wishlist-btn" id="wishlist-btn-{{ $product->id }}" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeWishlistToggle({{ $product->id }})" title="Add to wishlist"><i class="far fa-heart"></i></button>
                        <img src="{{ $productImageUrl($product) }}" alt="{{ $product->name }}" class="product-image">
                        <p class="product-title">{{ $product->category->name ?? 'Product' }}</p>
                        <h3 class="product-name">{{ Str::limit($product->name, 30) }}</h3>
                        <div class="product-price">
                            @php $prices = $productDisplayPrice($product); @endphp
                            <span class="current-price">₹{{ number_format($prices['current'], 0) }}</span>
                            @if($prices['original'])
                                <span class="original-price">₹{{ number_format($prices['original'], 0) }}</span>
                            @endif
                        </div>
                        <div class="product-card-actions">
                            <button type="button" class="home-add-to-cart-btn" data-product-id="{{ $product->id }}" onclick="event.preventDefault(); event.stopPropagation(); homeAddToCart({{ $product->id }})">Add to Cart</button>
                        </div>
                    </a>
                @empty
                    <p style="grid-column: 1/-1; text-align: center; color: #666;">No recommended products yet.</p>
                @endforelse
            </div>
        </div>
    </section>

@endsection

@section('extra-js')
<script>
(function() {
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) return;
    csrfToken = csrfToken.getAttribute('content');

    function showToast(message, type) {
        type = type || 'success';
        var el = document.createElement('div');
        el.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;padding:12px 20px;border-radius:10px;font-weight:600;font-size:14px;box-shadow:0 4px 14px rgba(0,0,0,0.2);';
        el.style.background = type === 'success' ? '#f5a623' : '#ef4444';
        el.style.color = '#fff';
        el.innerHTML = (type === 'success' ? '<i class="fas fa-check me-2"></i>' : '') + message;
        document.body.appendChild(el);
        setTimeout(function() { el.remove(); }, 3000);
    }

    window.homeAddToCart = function(productId) {
        var btn = document.querySelector('.home-add-to-cart-btn[data-product-id="' + productId + '"]');
        if (!btn) return;
        var orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;
        fetch('{{ url("/cart/add") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: parseInt(productId), quantity: 1 })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                showToast('Added to cart!', 'success');
                var badge = document.getElementById('header-cart-count');
                if (badge) { badge.textContent = data.cart_count || 0; badge.style.display = data.cart_count > 0 ? 'inline-block' : 'none'; }
            } else {
                showToast(data.message || 'Could not add to cart', 'error');
            }
        })
        .catch(function() { showToast('Error adding to cart', 'error'); })
        .finally(function() { btn.innerHTML = orig; btn.disabled = false; });
    };

    window.homeWishlistToggle = function(productId) {
        var btn = document.getElementById('wishlist-btn-' + productId);
        if (!btn) return;
        fetch('{{ url("/wishlist/toggle") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: parseInt(productId) })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                showToast(data.message || (data.in_wishlist ? 'Added to wishlist' : 'Removed from wishlist'), 'success');
                var icon = btn.querySelector('i');
                if (data.in_wishlist) {
                    btn.classList.add('active');
                    if (icon) { icon.className = 'fas fa-heart'; }
                } else {
                    btn.classList.remove('active');
                    if (icon) { icon.className = 'far fa-heart'; }
                }
                var badge = document.getElementById('header-wishlist-count');
                if (badge) { badge.textContent = data.wishlist_count || 0; badge.style.display = (data.wishlist_count > 0) ? 'inline-block' : 'none'; }
            } else {
                showToast(data.message || 'Error', 'error');
            }
        })
        .catch(function() { showToast('Error updating wishlist', 'error'); });
    };
})();
</script>
@endsection
