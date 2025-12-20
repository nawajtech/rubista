<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutUs;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing About Us or create new one
        $aboutUs = AboutUs::first();
        
        $data = [
            'title' => 'About Us',
            'hero_title' => 'About RUBISTA',
            'hero_subtitle' => 'Your trusted partner in electronics since 2020. We bring you the latest technology with uncompromising quality and exceptional service.',
            'hero_description' => 'Discover the latest electronics, gadgets, and lifestyle products at amazing prices. From smartphones to smart home devices, we have everything you need for a modern lifestyle.',
            'content' => 'Founded in 2020, RUBISTA began as a small electronics store with a big vision: to make cutting-edge technology accessible to everyone. What started as a passion project has grown into a trusted online destination for electronics enthusiasts across the country.

We believe that great technology should enhance your life, not complicate it. That\'s why we carefully curate our selection to include only the best products from renowned brands, ensuring quality, reliability, and innovation in every purchase.

Today, we serve thousands of satisfied customers, building lasting relationships through exceptional service, competitive prices, and unwavering commitment to excellence.',
            'mission' => 'To make cutting-edge technology accessible to everyone by providing quality products, exceptional service, and competitive prices.',
            'vision' => 'To become the most trusted and preferred online electronics destination, known for innovation, quality, and customer satisfaction.',
            'values' => 'Quality, Innovation, Customer-Centricity, Integrity, and Excellence in everything we do.',
            'features' => [
                [
                    'title' => 'Quality Assurance',
                    'description' => 'Every product undergoes rigorous quality checks to ensure you receive only the best.',
                    'icon' => 'fas fa-shield-check'
                ],
                [
                    'title' => 'Fast Delivery',
                    'description' => 'Quick and secure delivery to your doorstep with real-time tracking.',
                    'icon' => 'fas fa-shipping-fast'
                ],
                [
                    'title' => 'Expert Support',
                    'description' => 'Our knowledgeable team is here to help you make the right choice.',
                    'icon' => 'fas fa-headset'
                ],
                [
                    'title' => 'Best Prices',
                    'description' => 'Competitive pricing with regular deals and discounts for maximum value.',
                    'icon' => 'fas fa-tag'
                ]
            ],
            'stats' => [
                [
                    'number' => '50K+',
                    'label' => 'Happy Customers'
                ],
                [
                    'number' => '10K+',
                    'label' => 'Products Sold'
                ],
                [
                    'number' => '500+',
                    'label' => 'Product Varieties'
                ],
                [
                    'number' => '4.8★',
                    'label' => 'Customer Rating'
                ]
            ],
            'team' => [
                [
                    'name' => 'Tanbir Ahamed',
                    'position' => 'CEO',
                    'description' => 'Visionary leader with extensive experience in the electronics industry, passionate about bringing the latest technology to customers.'
                ],
                [
                    'name' => 'Nawaj Sharif',
                    'position' => 'Software Engineer',
                    'description' => 'Expert in software development and technology solutions, ensuring our platform delivers the best user experience.'
                ],
                [
                    'name' => 'Imran Ahamed',
                    'position' => 'Animation Specialist',
                    'description' => 'Creative professional specializing in animation and visual design, bringing our brand to life through engaging visuals.'
                ]
            ],
            'meta_title' => 'About Us - RUBISTA Electronics Store',
            'meta_description' => 'Learn about RUBISTA, your trusted partner in electronics. Discover our mission, vision, values, and meet our passionate team.',
            'is_active' => true,
        ];
        
        if ($aboutUs) {
            $aboutUs->update($data);
        } else {
            AboutUs::create($data);
        }
    }
}
