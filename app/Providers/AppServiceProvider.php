<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share cart count and settings with all views
        View::composer('*', function ($view) {
            $cart = Session::get('cart', []);
            $cartCount = count($cart);
            $view->with('cartCount', $cartCount);
            
            $wishlist = Session::get('wishlist', []);
            $wishlistCount = count($wishlist);
            $view->with('wishlistCount', $wishlistCount);
            
            // Share settings data
            $settings = Cache::remember('site_settings', 3600, function () {
                $settingsFile = storage_path('app/settings.json');
                
                if (file_exists($settingsFile)) {
                    return json_decode(file_get_contents($settingsFile), true);
                }

                // Default settings
                return [
                    'site_name' => 'Rubista',
                    'site_description' => 'Your Premier E-commerce Destination',
                    'site_email' => 'info@rubista.com',
                    'site_phone' => '+1 234 567 8900',
                    'site_address' => '123 Commerce Street, Business District',
                    'currency' => 'USD',
                    'currency_symbol' => '$',
                    'tax_rate' => 10,
                    'shipping_fee' => 5.99,
                    'free_shipping_threshold' => 50,
                    'items_per_page' => 12,
                    'featured_products_count' => 8,
                    'latest_products_count' => 12,
                    'meta_title' => 'Rubista - Your Premier E-commerce Destination',
                    'meta_description' => 'Discover amazing products at Rubista. Quality items, great prices, and excellent service.',
                    'meta_keywords' => 'ecommerce, shopping, products, online store',
                    'facebook_url' => '',
                    'twitter_url' => '',
                    'instagram_url' => '',
                    'youtube_url' => '',
                    'admin_primary_color' => '#667eea',
                    'admin_secondary_color' => '#5a67d8',
                    'admin_sidebar_color' => '#1a202c',
                    'admin_sidebar_hover_color' => '#2d3748',
                    'admin_text_color' => '#2d3748',
                    'admin_background_color' => '#f7fafc',
                    'favicon' => '',
                    'logo' => '',
                ];
            });
            
            $view->with('settings', $settings);
        });
    }
}
