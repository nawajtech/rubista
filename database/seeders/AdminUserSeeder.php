<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@rubista.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create Regular User
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@rubista.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create Categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Latest electronic gadgets and devices',
            'status' => true,
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'slug' => 'clothing',
            'description' => 'Fashion and apparel for all occasions',
            'status' => true,
        ]);

        // Create Sample Products
        Product::create([
            'name' => 'Smartphone Pro',
            'slug' => 'smartphone-pro',
            'description' => 'Latest smartphone with advanced features',
            'short_description' => 'Latest smartphone with advanced features',
            'price' => 899.99,
            'sale_price' => 799.99,
            'sku' => 'SP-001',
            'stock_quantity' => 50,
            'status' => true,
            'featured' => true,
            'category_id' => $electronics->id,
        ]);

        Product::create([
            'name' => 'Designer T-Shirt',
            'slug' => 'designer-t-shirt',
            'description' => 'Comfortable and stylish designer t-shirt',
            'short_description' => 'Comfortable designer t-shirt',
            'price' => 49.99,
            'sku' => 'TS-003',
            'stock_quantity' => 100,
            'status' => true,
            'featured' => false,
            'category_id' => $clothing->id,
        ]);
    }
}
