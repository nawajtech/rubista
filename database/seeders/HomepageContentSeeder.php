<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomepageContent;

class HomepageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all existing homepage content first
        HomepageContent::truncate();

        $contents = [
            [
                'section_type' => 'hero',
                'title' => 'Welcome to <span class="highlight">RUBISTA</span>',
                'subtitle' => 'Your Premier E-commerce Destination - Quality Products, Unbeatable Prices',
                'description' => 'Discover the latest electronics, gadgets, and lifestyle products at amazing prices. From smartphones to smart home devices, we have everything you need for a modern lifestyle.',
                'image_url' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=1200&h=600&fit=crop',
                'button_text' => 'Shop Now',
                'button_url' => '/search',
                'sort_order' => 1,
                'is_active' => true,
                'extra_data' => [
                    'background_type' => 'gradient',
                    'text_color' => 'white',
                    'stats' => [
                        ['number' => '10K+', 'label' => 'Happy Customers'],
                        ['number' => '500+', 'label' => 'Products'],
                        ['number' => '50+', 'label' => 'Categories'],
                        ['number' => '24/7', 'label' => 'Support']
                    ]
                ]
            ],
            [
                'section_type' => 'service',
                'title' => 'Free Shipping',
                'subtitle' => 'On orders over ₹500',
                'description' => 'Get free shipping on all orders above ₹500. Fast and reliable delivery to your doorstep.',
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 2,
                'is_active' => true,
                'extra_data' => [
                    'icon' => 'fas fa-shipping-fast',
                    'icon_color' => '#7c3aed'
                ]
            ],
            [
                'section_type' => 'service',
                'title' => '24/7 Support',
                'subtitle' => 'Dedicated support team',
                'description' => 'Our customer support team is available 24/7 to help you with any questions or issues.',
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 3,
                'is_active' => true,
                'extra_data' => [
                    'icon' => 'fas fa-headset',
                    'icon_color' => '#7c3aed'
                ]
            ],
            [
                'section_type' => 'service',
                'title' => 'Secure Payment',
                'subtitle' => '100% secure transactions',
                'description' => 'Your payment information is always safe and secure with our encrypted payment system.',
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 4,
                'is_active' => true,
                'extra_data' => [
                    'icon' => 'fas fa-shield-alt',
                    'icon_color' => '#7c3aed'
                ]
            ],
            [
                'section_type' => 'service',
                'title' => 'Best Quality',
                'subtitle' => 'Premium products only',
                'description' => 'We only sell high-quality products from trusted brands and manufacturers.',
                'image_url' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 5,
                'is_active' => true,
                'extra_data' => [
                    'icon' => 'fas fa-award',
                    'icon_color' => '#7c3aed'
                ]
            ],
            [
                'section_type' => 'offer',
                'title' => '🎉 Special Offer - Limited Time!',
                'subtitle' => 'Up to 50% OFF on Smart Watches & Wearables',
                'description' => 'Don\'t miss this incredible opportunity! Get premium smart watches with advanced health tracking, GPS, and 7-day battery life. Limited stock available.',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&h=600&fit=crop',
                'button_text' => 'Shop Smart Watches',
                'button_url' => '/search?q=smart+watch',
                'sort_order' => 6,
                'is_active' => true,
                'extra_data' => [
                    'background_color' => '#f97316',
                    'text_color' => 'white',
                    'badge_text' => 'Limited Time',
                    'badge_icon' => 'fas fa-fire',
                    'discount_percent' => '50',
                    'features' => [
                        ['icon' => 'fas fa-heartbeat', 'text' => 'Health Tracking'],
                        ['icon' => 'fas fa-map-marker-alt', 'text' => 'GPS Enabled'],
                        ['icon' => 'fas fa-battery-full', 'text' => '7-Day Battery']
                    ]
                ]
            ],
            [
                'section_type' => 'banner',
                'title' => '🔥 BIGGEST SALE OF THE YEAR',
                'subtitle' => 'Up to 70% OFF on All Electronics',
                'description' => 'Don\'t miss out on our biggest sale of the year! Huge discounts on smartphones, laptops, headphones, and all electronic items. Limited time only!',
                'image_url' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800&h=400&fit=crop',
                'button_text' => 'Shop Sale Now',
                'button_url' => '/search',
                'sort_order' => 7,
                'is_active' => true,
                'extra_data' => [
                    'background_color' => '#f97316',
                    'text_color' => 'white',
                    'badge_text' => 'Flash Sale',
                    'badge_icon' => 'fas fa-bolt',
                    'countdown' => true,
                    'features' => [
                        ['icon' => 'fas fa-truck', 'text' => 'Free Shipping'],
                        ['icon' => 'fas fa-undo', 'text' => 'Easy Returns'],
                        ['icon' => 'fas fa-shield-alt', 'text' => 'Secure Payment']
                    ]
                ]
            ],
            [
                'section_type' => 'banner',
                'title' => '🎧 PREMIUM HEADPHONES',
                'subtitle' => 'Experience Crystal-Clear Audio',
                'description' => 'Immerse yourself in premium sound quality with our collection of noise-cancelling headphones, wireless earbuds, and studio-grade audio equipment.',
                'image_url' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&h=400&fit=crop',
                'button_text' => 'Explore Headphones',
                'button_url' => '/search?q=headphone',
                'sort_order' => 8,
                'is_active' => true,
                'extra_data' => [
                    'background_color' => '#0ea5e9',
                    'text_color' => 'white',
                    'badge_text' => 'New Collection',
                    'badge_icon' => 'fas fa-star',
                    'features' => [
                        ['icon' => 'fas fa-volume-up', 'text' => 'Hi-Fi Sound'],
                        ['icon' => 'fas fa-headphones', 'text' => 'Noise Cancelling'],
                        ['icon' => 'fas fa-bluetooth', 'text' => 'Wireless']
                    ]
                ]
            ],
            [
                'section_type' => 'feature',
                'title' => '⚡ Flash Sale - Don\'t Miss Out!',
                'subtitle' => 'Premium Products at Unbeatable Prices',
                'description' => 'Limited time flash sale with incredible discounts on premium electronics. Shop now before the timer runs out!',
                'image_url' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=600&h=400&fit=crop',
                'button_text' => 'Shop Flash Sale',
                'button_url' => '/search?sale=true',
                'sort_order' => 9,
                'is_active' => true,
                'extra_data' => [
                    'countdown_hours' => '48',
                    'countdown_minutes' => '0',
                    'countdown_seconds' => '0',
                    'background_color' => '#7c3aed',
                    'features' => [
                        ['icon' => 'fas fa-tag', 'title' => 'Up to 60% Off', 'description' => 'Massive discounts on selected items'],
                        ['icon' => 'fas fa-shipping-fast', 'title' => 'Free Shipping', 'description' => 'On orders above ₹500'],
                        ['icon' => 'fas fa-gift', 'title' => 'Extra Gifts', 'description' => 'Free accessories with purchase']
                    ]
                ]
            ],
            [
                'section_type' => 'feature',
                'title' => 'Why Choose Rubista?',
                'subtitle' => 'Your Trusted Shopping Partner',
                'description' => 'We are committed to providing you with the best shopping experience, quality products, and exceptional customer service.',
                'image_url' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop',
                'button_text' => 'Learn More',
                'button_url' => '/about-us',
                'sort_order' => 10,
                'is_active' => true,
                'extra_data' => [
                    'background_color' => '#ffffff',
                    'text_color' => '#1a202c',
                    'features' => [
                        ['icon' => 'fas fa-check-circle', 'title' => '100% Authentic', 'description' => 'All products are genuine and verified'],
                        ['icon' => 'fas fa-shield-alt', 'title' => 'Secure Payment', 'description' => 'Your transactions are safe and encrypted'],
                        ['icon' => 'fas fa-undo-alt', 'title' => 'Easy Returns', 'description' => '7-day return policy on all products'],
                        ['icon' => 'fas fa-truck', 'title' => 'Fast Delivery', 'description' => 'Quick and reliable shipping nationwide']
                    ]
                ]
            ],
            [
                'section_type' => 'gallery',
                'title' => 'Smart Watches Collection',
                'subtitle' => 'Latest Smart Watch Technology',
                'description' => 'Discover our premium collection of smart watches with advanced features.',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=400&fit=crop',
                'button_text' => 'View Collection',
                'button_url' => '/search?q=smart+watch',
                'sort_order' => 10,
                'is_active' => true,
                'extra_data' => [
                    'category' => 'Smart Watches',
                    'product_count' => '50+'
                ]
            ],
            [
                'section_type' => 'testimonial',
                'title' => 'What Our Customers Say',
                'subtitle' => 'Trusted by thousands of satisfied customers worldwide',
                'description' => 'Read what our customers have to say about their shopping experience with us. We take pride in delivering exceptional service.',
                'image_url' => null,
                'button_text' => 'Read More Reviews',
                'button_url' => '/reviews',
                'sort_order' => 11,
                'is_active' => true,
                'extra_data' => [
                    'testimonials' => [
                        [
                            'name' => 'Sarah Johnson',
                            'rating' => 5,
                            'comment' => 'Amazing products and fast delivery! The quality exceeded my expectations. Highly recommended!',
                            'location' => 'Mumbai, India',
                            'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=7c3aed&color=fff'
                        ],
                        [
                            'name' => 'Michael Chen',
                            'rating' => 5,
                            'comment' => 'Best online shopping experience I\'ve ever had. Great customer service and the products are top-notch!',
                            'location' => 'Delhi, India',
                            'avatar' => 'https://ui-avatars.com/api/?name=Michael+Chen&background=0ea5e9&color=fff'
                        ],
                        [
                            'name' => 'Priya Sharma',
                            'rating' => 5,
                            'comment' => 'Excellent quality products at reasonable prices. The delivery was super fast and packaging was perfect.',
                            'location' => 'Bangalore, India',
                            'avatar' => 'https://ui-avatars.com/api/?name=Priya+Sharma&background=f97316&color=fff'
                        ],
                        [
                            'name' => 'Rajesh Kumar',
                            'rating' => 5,
                            'comment' => 'Outstanding service! The customer support team helped me choose the perfect product. Will definitely shop again!',
                            'location' => 'Chennai, India',
                            'avatar' => 'https://ui-avatars.com/api/?name=Rajesh+Kumar&background=10b981&color=fff'
                        ]
                    ]
                ]
            ],
            [
                'section_type' => 'cta',
                'title' => 'Join Our Newsletter',
                'subtitle' => 'Get exclusive deals and updates',
                'description' => 'Subscribe to our newsletter and get 10% off your first order. Stay updated with latest products and special offers.',
                'image_url' => null,
                'button_text' => 'Subscribe Now',
                'button_url' => '/newsletter',
                'sort_order' => 12,
                'is_active' => true,
                'extra_data' => [
                    'background_color' => '#7c3aed',
                    'text_color' => 'white'
                ]
            ],
            [
                'section_type' => 'feature',
                'title' => 'Featured Products',
                'subtitle' => 'Handpicked for you',
                'description' => 'Discover our carefully selected featured products that offer the best value and quality.',
                'image_url' => null,
                'button_text' => 'View All Products',
                'button_url' => '/products',
                'sort_order' => 13,
                'is_active' => true,
                'extra_data' => [
                    'show_featured_products' => true,
                    'product_count' => 8
                ]
            ],
            [
                'section_type' => 'banner',
                'title' => '🆕 NEW ARRIVALS',
                'subtitle' => 'Check Out Our Latest Products',
                'description' => 'Explore our newest collection of products. Fresh arrivals every week! Be the first to get your hands on the latest technology.',
                'image_url' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&h=400&fit=crop',
                'button_text' => 'Shop New Arrivals',
                'button_url' => '/products?new=true',
                'sort_order' => 14,
                'is_active' => true,
                'extra_data' => [
                    'background_color' => '#0ea5e9',
                    'text_color' => 'white',
                    'badge_text' => 'Just In',
                    'badge_icon' => 'fas fa-sparkles',
                    'features' => [
                        ['icon' => 'fas fa-box', 'text' => 'Latest Models'],
                        ['icon' => 'fas fa-star', 'text' => 'Premium Quality'],
                        ['icon' => 'fas fa-shipping-fast', 'text' => 'Fast Delivery']
                    ]
                ]
            ],
            [
                'section_type' => 'gallery',
                'title' => 'Shop by Category',
                'subtitle' => 'Explore Our Product Collections',
                'description' => 'Browse through our carefully curated collections and find exactly what you\'re looking for.',
                'image_url' => null,
                'button_text' => 'View All Categories',
                'button_url' => '/categories',
                'sort_order' => 15,
                'is_active' => true,
                'extra_data' => [
                    'show_categories' => true,
                    'category_count' => 8
                ]
            ]
        ];

        foreach ($contents as $content) {
            HomepageContent::create($content);
        }
    }
}
