<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Electronics
            [
                'name' => 'Smartphone X Pro',
                'description' => 'Latest smartphone with advanced features, 128GB storage, dual camera, and long-lasting battery life.',
                'price' => 45999.00,
                'stock_quantity' => 50,
                'category_id' => 1,
                'sku' => 'PHONE-001',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1580910051074-3eb694886505?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Laptop Gaming Beast',
                'description' => 'High-performance gaming laptop with RTX graphics, 16GB RAM, 512GB SSD, and RGB keyboard.',
                'price' => 89999.00,
                'stock_quantity' => 25,
                'category_id' => 1,
                'sku' => 'LAPTOP-001',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Wireless Earbuds Pro',
                'description' => 'Premium wireless earbuds with active noise cancellation, 30-hour battery, and crystal-clear sound.',
                'price' => 8999.00,
                'stock_quantity' => 100,
                'category_id' => 1,
                'sku' => 'EARBUDS-001',
                'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
            ],

            // Clothing
            [
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'Soft, comfortable cotton t-shirt available in multiple colors. Perfect for casual wear.',
                'price' => 1299.00,
                'stock_quantity' => 200,
                'category_id' => 2,
                'sku' => 'TSHIRT-001',
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1503341338655-b2d1df177b92?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Denim Jacket Classic',
                'description' => 'Timeless denim jacket with classic fit and durable construction. A wardrobe essential.',
                'price' => 3999.00,
                'stock_quantity' => 75,
                'category_id' => 2,
                'sku' => 'JACKET-001',
                'image' => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5e?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1544966503-7cc5ac882d5e?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
            ],
            [
                'name' => 'Running Shoes Elite',
                'description' => 'Professional running shoes with advanced cushioning and breathable mesh design.',
                'price' => 5999.00,
                'stock_quantity' => 120,
                'category_id' => 2,
                'sku' => 'SHOES-001',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
            ],

            // Books
            [
                'name' => 'Web Development Complete Guide',
                'description' => 'Comprehensive guide to modern web development covering HTML, CSS, JavaScript, and frameworks.',
                'price' => 2499.00,
                'stock_quantity' => 150,
                'category_id' => 3,
                'sku' => 'BOOK-001',
                'image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
            ],
            [
                'name' => 'Fiction Novel Collection',
                'description' => 'Bestselling fiction novels bundle - 5 books from award-winning authors.',
                'price' => 1899.00,
                'stock_quantity' => 80,
                'category_id' => 3,
                'sku' => 'BOOK-002',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
            ],

            // Home & Garden
            [
                'name' => 'Indoor Plant Collection',
                'description' => 'Beautiful indoor plants bundle including snake plant, pothos, and peace lily with decorative pots.',
                'price' => 2999.00,
                'stock_quantity' => 60,
                'category_id' => 4,
                'sku' => 'PLANT-001',
                'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Modern Table Lamp',
                'description' => 'Sleek modern table lamp with adjustable brightness and USB charging port.',
                'price' => 3499.00,
                'stock_quantity' => 45,
                'category_id' => 4,
                'sku' => 'LAMP-001',
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
            ],

            // Sports
            [
                'name' => 'Yoga Mat Professional',
                'description' => 'Premium yoga mat with non-slip surface and extra thickness for comfort during practice.',
                'price' => 1799.00,
                'stock_quantity' => 90,
                'category_id' => 5,
                'sku' => 'YOGA-001',
                'image' => 'https://images.unsplash.com/photo-1506629905061-9d1eb4d47f6d?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1506629905061-9d1eb4d47f6d?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
            ],
            [
                'name' => 'Basketball Premium',
                'description' => 'Official size basketball with superior grip and durability for indoor and outdoor play.',
                'price' => 2299.00,
                'stock_quantity' => 70,
                'category_id' => 5,
                'sku' => 'BALL-001',
                'image' => 'https://images.unsplash.com/photo-1574623452334-1e0ac2b3ccb4?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1574623452334-1e0ac2b3ccb4?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
            ],

            // Beauty & Health
            [
                'name' => 'Skincare Essentials Kit',
                'description' => 'Complete skincare routine kit with cleanser, toner, moisturizer, and serum for healthy skin.',
                'price' => 4999.00,
                'stock_quantity' => 85,
                'category_id' => 6,
                'sku' => 'SKIN-001',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1570194065650-d99fb4bedf0a?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
            ],
            [
                'name' => 'Vitamin D3 Supplement',
                'description' => 'High-quality Vitamin D3 supplement for bone health and immune system support.',
                'price' => 899.00,
                'stock_quantity' => 200,
                'category_id' => 6,
                'sku' => 'VITAMIN-001',
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 