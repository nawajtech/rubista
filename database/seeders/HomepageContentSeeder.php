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
        $contents = [
            [
                'section_type' => 'hero',
                'title' => 'Welcome to RUBISTA',
                'subtitle' => 'Your Electronics Store - Quality Products, Unbeatable Prices',
                'description' => 'Discover the latest electronics and gadgets at amazing prices. From smartphones to smart home devices, we have everything you need.',
                'image_url' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=1200&h=600&fit=crop',
                'button_text' => 'Shop Now',
                'button_url' => '/search',
                'sort_order' => 1,
                'is_active' => true,
                'extra_data' => [
                    'background_type' => 'gradient',
                    'text_color' => 'white'
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
                'title' => 'Special Offer',
                'subtitle' => 'Up to 50% discount on Smart Watches',
                'description' => 'Limited time offer on our collection of premium smart watches. Get the latest features at incredible prices.',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&h=600&fit=crop',
                'button_text' => 'Shop Now',
                'button_url' => '/search?q=smart+watch',
                'sort_order' => 6,
                'is_active' => true,
                'extra_data' => [
                    'background_color' => '#f97316',
                    'text_color' => 'white'
                ]
            ],
            [
                'section_type' => 'banner',
                'title' => 'BIGGEST SALE',
                'subtitle' => 'Up to 70% off on Electronics',
                'description' => 'Don\'t miss out on our biggest sale of the year. Huge discounts on all electronic items.',
                'image_url' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800&h=400&fit=crop',
                'button_text' => 'Shop Now',
                'button_url' => '/search',
                'sort_order' => 7,
                'is_active' => true,
                'extra_data' => [
                    'background_color' => '#f97316',
                    'text_color' => 'white'
                ]
            ],
            [
                'section_type' => 'banner',
                'title' => 'HEADPHONE',
                'subtitle' => 'Premium Audio Experience',
                'description' => 'Experience crystal-clear sound with our premium headphone collection.',
                'image_url' => 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=800&h=400&fit=crop',
                'button_text' => 'Explore',
                'button_url' => '/search?q=headphone',
                'sort_order' => 8,
                'is_active' => true,
                'extra_data' => [
                    'background_color' => '#0ea5e9',
                    'text_color' => 'white'
                ]
            ],
            [
                'section_type' => 'feature',
                'title' => 'Flash Sale',
                'subtitle' => 'Premium Products at Crazy Prices!',
                'description' => 'Limited time flash sale with incredible discounts on premium electronics.',
                'image_url' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=600&h=400&fit=crop',
                'button_text' => 'Shop Flash Sale',
                'button_url' => '/search?sale=true',
                'sort_order' => 9,
                'is_active' => true,
                'extra_data' => [
                    'countdown_hours' => '24',
                    'countdown_minutes' => '15',
                    'countdown_seconds' => '32',
                    'background_color' => '#7c3aed'
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
            ]
        ];

        foreach ($contents as $content) {
            HomepageContent::create($content);
        }
    }
}
