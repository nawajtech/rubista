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
        // Delete all existing products first
        Product::truncate();

        // Get categories by slug to ensure correct category_id
        $electronics = Category::where('slug', 'electronics')->first();
        $clothing = Category::where('slug', 'clothing')->first();
        $books = Category::where('slug', 'books')->first();
        $homeGarden = Category::where('slug', 'home-garden')->first();
        $sports = Category::where('slug', 'sports')->first();
        $beautyHealth = Category::where('slug', 'beauty-health')->first();
        $toysGames = Category::where('slug', 'toys-games')->first();
        $automotive = Category::where('slug', 'automotive')->first();

        // Safety check - if categories don't exist, create them
        if (!$electronics || !$clothing || !$books || !$homeGarden || !$sports || !$beautyHealth) {
            throw new \Exception('Categories must be seeded before products. Please run CategorySeeder first.');
        }

        $products = [
            // Electronics
            [
                'name' => 'Smartphone X Pro',
                'short_description' => 'Latest smartphone with 128GB storage and dual camera',
                'description' => 'Latest smartphone with advanced features, 128GB storage, dual camera, and long-lasting battery life. Features include 6.7-inch OLED display, 5G connectivity, and fast charging.',
                'price' => 45999.00,
                'sale_price' => 39999.00,
                'stock_quantity' => 50,
                'category_id' => $electronics->id,
                'sku' => 'PHONE-001',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1580910051074-3eb694886505?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'TechBrand',
                'color' => 'Midnight Black',
                'dimension' => '160 x 75 x 8.5 mm',
                'model' => 'X-Pro-2024',
                'warranty_period' => '1 Year',
                'return_policy' => '7 days return policy with original packaging',
                'sort_order' => 1,
            ],
            [
                'name' => 'Laptop Gaming Beast',
                'short_description' => 'High-performance gaming laptop with RTX graphics',
                'description' => 'High-performance gaming laptop with RTX graphics, 16GB RAM, 512GB SSD, and RGB keyboard. Perfect for gaming and professional work.',
                'price' => 89999.00,
                'sale_price' => 79999.00,
                'stock_quantity' => 25,
                'category_id' => $electronics->id,
                'sku' => 'LAPTOP-001',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'GameTech',
                'color' => 'Metallic Gray',
                'dimension' => '360 x 260 x 25 mm',
                'model' => 'GB-2024',
                'warranty_period' => '2 Years',
                'return_policy' => '15 days return policy',
                'sort_order' => 2,
            ],
            [
                'name' => 'Wireless Earbuds Pro',
                'short_description' => 'Premium wireless earbuds with noise cancellation',
                'description' => 'Premium wireless earbuds with active noise cancellation, 30-hour battery, and crystal-clear sound. Water-resistant design.',
                'price' => 8999.00,
                'sale_price' => 7499.00,
                'stock_quantity' => 100,
                'category_id' => $electronics->id,
                'sku' => 'EARBUDS-001',
                'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'AudioPro',
                'color' => 'White',
                'dimension' => '25 x 20 x 15 mm',
                'model' => 'EB-Pro-2024',
                'warranty_period' => '1 Year',
                'return_policy' => '7 days return policy',
                'sort_order' => 3,
            ],
            [
                'name' => 'Smart Watch Ultra',
                'short_description' => 'Advanced smartwatch with health tracking',
                'description' => 'Advanced smartwatch with health tracking, GPS, heart rate monitor, and 7-day battery life. Water-resistant up to 50m.',
                'price' => 24999.00,
                'sale_price' => 19999.00,
                'stock_quantity' => 75,
                'category_id' => $electronics->id,
                'sku' => 'WATCH-001',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'SmartTech',
                'color' => 'Black',
                'dimension' => '45 x 38 x 12 mm',
                'model' => 'SW-Ultra-2024',
                'warranty_period' => '1 Year',
                'return_policy' => '7 days return policy',
                'sort_order' => 4,
            ],
            [
                'name' => 'Tablet Pro 12',
                'short_description' => '12-inch tablet with high-resolution display',
                'description' => '12-inch tablet with high-resolution display, powerful processor, and all-day battery. Perfect for work and entertainment.',
                'price' => 34999.00,
                'stock_quantity' => 40,
                'category_id' => $electronics->id,
                'sku' => 'TABLET-001',
                'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1561154464-82e9adf327c1?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'TabTech',
                'color' => 'Space Gray',
                'dimension' => '280 x 200 x 7 mm',
                'model' => 'TP-12-2024',
                'warranty_period' => '1 Year',
                'return_policy' => '7 days return policy',
                'sort_order' => 5,
            ],

            // Clothing
            [
                'name' => 'Premium Cotton T-Shirt',
                'short_description' => 'Soft, comfortable cotton t-shirt in multiple colors',
                'description' => 'Soft, comfortable cotton t-shirt available in multiple colors. Perfect for casual wear. Made from 100% organic cotton.',
                'price' => 1299.00,
                'sale_price' => 999.00,
                'stock_quantity' => 200,
                'category_id' => $clothing->id,
                'sku' => 'TSHIRT-001',
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1503341338655-b2d1df177b92?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'FashionBrand',
                'color' => 'Navy Blue, White, Black',
                'dimension' => 'S, M, L, XL, XXL',
                'model' => 'CT-2024',
                'warranty_period' => 'N/A',
                'return_policy' => '7 days return policy with tags',
                'sort_order' => 6,
            ],
            [
                'name' => 'Denim Jacket Classic',
                'short_description' => 'Timeless denim jacket with classic fit',
                'description' => 'Timeless denim jacket with classic fit and durable construction. A wardrobe essential for all seasons.',
                'price' => 3999.00,
                'sale_price' => 3499.00,
                'stock_quantity' => 75,
                'category_id' => $clothing->id,
                'sku' => 'JACKET-001',
                'image' => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5e?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1544966503-7cc5ac882d5e?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'DenimCo',
                'color' => 'Classic Blue',
                'dimension' => 'S, M, L, XL',
                'model' => 'DJ-Classic-2024',
                'warranty_period' => 'N/A',
                'return_policy' => '7 days return policy',
                'sort_order' => 7,
            ],
            [
                'name' => 'Running Shoes Elite',
                'short_description' => 'Professional running shoes with advanced cushioning',
                'description' => 'Professional running shoes with advanced cushioning and breathable mesh design. Perfect for long-distance running.',
                'price' => 5999.00,
                'sale_price' => 4999.00,
                'stock_quantity' => 120,
                'category_id' => $clothing->id,
                'sku' => 'SHOES-001',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'RunPro',
                'color' => 'Black, White, Red',
                'dimension' => 'UK 6-12',
                'model' => 'RS-Elite-2024',
                'warranty_period' => '6 Months',
                'return_policy' => '7 days return policy, unused condition',
                'sort_order' => 8,
            ],
            [
                'name' => 'Designer Jeans',
                'short_description' => 'Premium designer jeans with perfect fit',
                'description' => 'Premium designer jeans with perfect fit and stretch comfort. Available in multiple sizes and washes.',
                'price' => 2999.00,
                'stock_quantity' => 150,
                'category_id' => $clothing->id,
                'sku' => 'JEANS-001',
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'FashionBrand',
                'color' => 'Dark Blue, Light Blue',
                'dimension' => '28-38 Waist',
                'model' => 'DJ-2024',
                'warranty_period' => 'N/A',
                'return_policy' => '7 days return policy',
                'sort_order' => 9,
            ],

            // Books
            [
                'name' => 'Web Development Complete Guide',
                'short_description' => 'Comprehensive guide to modern web development',
                'description' => 'Comprehensive guide to modern web development covering HTML, CSS, JavaScript, and frameworks. Perfect for beginners and professionals.',
                'price' => 2499.00,
                'sale_price' => 1999.00,
                'stock_quantity' => 150,
                'category_id' => $books->id,
                'sku' => 'BOOK-001',
                'image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'TechBooks',
                'color' => 'N/A',
                'dimension' => '23 x 18 x 3 cm',
                'model' => 'WD-Guide-2024',
                'warranty_period' => 'N/A',
                'return_policy' => '7 days return policy, unread condition',
                'sort_order' => 10,
            ],
            [
                'name' => 'Fiction Novel Collection',
                'short_description' => 'Bestselling fiction novels bundle - 5 books',
                'description' => 'Bestselling fiction novels bundle - 5 books from award-winning authors. Includes mystery, romance, and thriller genres.',
                'price' => 1899.00,
                'stock_quantity' => 80,
                'category_id' => $books->id,
                'sku' => 'BOOK-002',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'BookHouse',
                'color' => 'N/A',
                'dimension' => 'Set of 5 books',
                'model' => 'FC-Collection-2024',
                'warranty_period' => 'N/A',
                'return_policy' => '7 days return policy',
                'sort_order' => 11,
            ],
            [
                'name' => 'Business Strategy Masterclass',
                'short_description' => 'Learn business strategy from industry experts',
                'description' => 'Learn business strategy from industry experts. Comprehensive guide covering marketing, finance, and leadership.',
                'price' => 2999.00,
                'stock_quantity' => 60,
                'category_id' => $books->id,
                'sku' => 'BOOK-003',
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'BusinessBooks',
                'color' => 'N/A',
                'dimension' => '25 x 20 x 4 cm',
                'model' => 'BS-Master-2024',
                'warranty_period' => 'N/A',
                'return_policy' => '7 days return policy',
                'sort_order' => 12,
            ],

            // Home & Garden
            [
                'name' => 'Indoor Plant Collection',
                'short_description' => 'Beautiful indoor plants bundle with decorative pots',
                'description' => 'Beautiful indoor plants bundle including snake plant, pothos, and peace lily with decorative pots. Perfect for home decoration.',
                'price' => 2999.00,
                'sale_price' => 2499.00,
                'stock_quantity' => 60,
                'category_id' => $homeGarden->id,
                'sku' => 'PLANT-001',
                'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'GreenLife',
                'color' => 'Green',
                'dimension' => 'Set of 3 plants',
                'model' => 'IPC-2024',
                'warranty_period' => '30 Days',
                'return_policy' => '7 days return policy',
                'sort_order' => 13,
            ],
            [
                'name' => 'Modern Table Lamp',
                'short_description' => 'Sleek modern table lamp with adjustable brightness',
                'description' => 'Sleek modern table lamp with adjustable brightness and USB charging port. LED technology with energy-efficient design.',
                'price' => 3499.00,
                'sale_price' => 2999.00,
                'stock_quantity' => 45,
                'category_id' => $homeGarden->id,
                'sku' => 'LAMP-001',
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'HomeLight',
                'color' => 'Black, White',
                'dimension' => '40 x 15 x 15 cm',
                'model' => 'MTL-2024',
                'warranty_period' => '1 Year',
                'return_policy' => '7 days return policy',
                'sort_order' => 14,
            ],
            [
                'name' => 'Coffee Maker Premium',
                'short_description' => 'Premium coffee maker with programmable timer',
                'description' => 'Premium coffee maker with programmable timer, thermal carafe, and multiple brew strength options. Perfect for coffee lovers.',
                'price' => 5999.00,
                'stock_quantity' => 30,
                'category_id' => $homeGarden->id,
                'sku' => 'COFFEE-001',
                'image' => 'https://images.unsplash.com/photo-1517487881594-2787fef5ebf7?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1517487881594-2787fef5ebf7?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'BrewTech',
                'color' => 'Stainless Steel',
                'dimension' => '30 x 25 x 35 cm',
                'model' => 'CM-Premium-2024',
                'warranty_period' => '1 Year',
                'return_policy' => '7 days return policy',
                'sort_order' => 15,
            ],

            // Sports
            [
                'name' => 'Yoga Mat Professional',
                'short_description' => 'Premium yoga mat with non-slip surface',
                'description' => 'Premium yoga mat with non-slip surface and extra thickness for comfort during practice. Eco-friendly material.',
                'price' => 1799.00,
                'sale_price' => 1499.00,
                'stock_quantity' => 90,
                'category_id' => $sports->id,
                'sku' => 'YOGA-001',
                'image' => 'https://images.unsplash.com/photo-1506629905061-9d1eb4d47f6d?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1506629905061-9d1eb4d47f6d?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'FitPro',
                'color' => 'Purple, Blue, Pink',
                'dimension' => '183 x 61 x 0.6 cm',
                'model' => 'YM-Pro-2024',
                'warranty_period' => '6 Months',
                'return_policy' => '7 days return policy',
                'sort_order' => 16,
            ],
            [
                'name' => 'Basketball Premium',
                'short_description' => 'Official size basketball with superior grip',
                'description' => 'Official size basketball with superior grip and durability for indoor and outdoor play. Professional quality.',
                'price' => 2299.00,
                'stock_quantity' => 70,
                'category_id' => $sports->id,
                'sku' => 'BALL-001',
                'image' => 'https://images.unsplash.com/photo-1574623452334-1e0ac2b3ccb4?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1574623452334-1e0ac2b3ccb4?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'SportBall',
                'color' => 'Orange',
                'dimension' => 'Size 7 (29.5 inches)',
                'model' => 'BB-Premium-2024',
                'warranty_period' => '6 Months',
                'return_policy' => '7 days return policy',
                'sort_order' => 17,
            ],
            [
                'name' => 'Dumbbell Set 20kg',
                'short_description' => 'Professional dumbbell set for home gym',
                'description' => 'Professional dumbbell set for home gym. Adjustable weights with comfortable grip handles. Perfect for strength training.',
                'price' => 4999.00,
                'sale_price' => 4499.00,
                'stock_quantity' => 50,
                'category_id' => $sports->id,
                'sku' => 'DUMBBELL-001',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'FitPro',
                'color' => 'Black',
                'dimension' => '20kg set (2 x 10kg)',
                'model' => 'DB-20kg-2024',
                'warranty_period' => '1 Year',
                'return_policy' => '7 days return policy',
                'sort_order' => 18,
            ],

            // Beauty & Health
            [
                'name' => 'Skincare Essentials Kit',
                'short_description' => 'Complete skincare routine kit',
                'description' => 'Complete skincare routine kit with cleanser, toner, moisturizer, and serum for healthy skin. Suitable for all skin types.',
                'price' => 4999.00,
                'sale_price' => 3999.00,
                'stock_quantity' => 85,
                'category_id' => $beautyHealth->id,
                'sku' => 'SKIN-001',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1570194065650-d99fb4bedf0a?w=400&h=400&fit=crop'
                ]),
                'featured' => true,
                'status' => true,
                'brand' => 'BeautyCare',
                'color' => 'N/A',
                'dimension' => '4-piece set',
                'model' => 'SE-Kit-2024',
                'warranty_period' => 'N/A',
                'return_policy' => '7 days return policy, unopened',
                'sort_order' => 19,
            ],
            [
                'name' => 'Vitamin D3 Supplement',
                'short_description' => 'High-quality Vitamin D3 supplement',
                'description' => 'High-quality Vitamin D3 supplement for bone health and immune system support. 60 capsules per bottle.',
                'price' => 899.00,
                'sale_price' => 749.00,
                'stock_quantity' => 200,
                'category_id' => $beautyHealth->id,
                'sku' => 'VITAMIN-001',
                'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'HealthPlus',
                'color' => 'N/A',
                'dimension' => '60 capsules',
                'model' => 'VD3-2024',
                'warranty_period' => 'N/A',
                'return_policy' => '7 days return policy, unopened',
                'sort_order' => 20,
            ],
            [
                'name' => 'Face Serum Vitamin C',
                'short_description' => 'Brightening face serum with Vitamin C',
                'description' => 'Brightening face serum with Vitamin C for radiant skin. Reduces dark spots and improves skin texture.',
                'price' => 1999.00,
                'stock_quantity' => 120,
                'category_id' => $beautyHealth->id,
                'sku' => 'SERUM-001',
                'image' => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=400&h=400&fit=crop',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1571875257727-256c39da42af?w=400&h=400&fit=crop'
                ]),
                'featured' => false,
                'status' => true,
                'brand' => 'BeautyCare',
                'color' => 'N/A',
                'dimension' => '30ml',
                'model' => 'FS-VC-2024',
                'warranty_period' => 'N/A',
                'return_policy' => '7 days return policy',
                'sort_order' => 21,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 