<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\HomepageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Display the frontend homepage
     */
    public function index()
    {
        // Get categories with products, sorted by name
        $categories = Category::where('status', true)
            ->withCount(['products' => function($query) {
                $query->where('status', true);
            }])
            ->with(['products' => function($query) {
                $query->where('status', true)
                      ->orderBy('sort_order', 'asc')
                      ->orderBy('featured', 'desc')
                      ->orderBy('created_at', 'desc');
            }])
            ->orderBy('name', 'asc')
            ->get();
        
        // Get featured products with proper sorting
        $featuredProducts = Product::where('featured', true)
            ->where('status', true)
            ->withCount(['reviews as total_reviews' => function($query) {
                $query->where('status', true);
            }])
            ->with(['reviews' => function($query) {
                $query->where('status', true);
            }])
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Get trending/latest products with proper sorting
        $trendingProducts = Product::where('status', true)
            ->withCount(['reviews as total_reviews' => function($query) {
                $query->where('status', true);
            }])
            ->with(['reviews' => function($query) {
                $query->where('status', true);
            }])
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Calculate average ratings
        foreach ($featuredProducts as $product) {
            $product->average_rating = $product->reviews->avg('rating') ?? 0;
        }
        foreach ($trendingProducts as $product) {
            $product->average_rating = $product->reviews->avg('rating') ?? 0;
        }
        
        // Check wishlist status for all products
        $wishlist = session()->get('wishlist', []);
        foreach ($featuredProducts as $product) {
            $product->is_in_wishlist = isset($wishlist[$product->id]);
        }
        foreach ($trendingProducts as $product) {
            $product->is_in_wishlist = isset($wishlist[$product->id]);
        }
        
        // Get dynamic homepage content with proper sorting (already sorted by sort_order in model)
        $heroContent = HomepageContent::getBySection('hero')->first();
        $serviceContent = HomepageContent::getBySection('service');
        $offerContent = HomepageContent::getBySection('offer');
        $bannerContent = HomepageContent::getBySection('banner');
        $featureContent = HomepageContent::getBySection('feature');
        $galleryContent = HomepageContent::getBySection('gallery');
        $flashDealContent = HomepageContent::getBySection('flash_deal')->first();
        $featuredProductsContent = HomepageContent::getBySection('featured_products')->first();
        $bestSellersContent = HomepageContent::getBySection('best_sellers')->first();
        $brandsContent = HomepageContent::getBySection('brands')->first();
        $testimonialsContent = HomepageContent::getBySection('testimonial');
        $latestProductsContent = HomepageContent::getBySection('latest_products')->first();
        
        // Get latest products for latest products section
        $latestProducts = Product::where('status', true)
            ->withCount(['reviews as total_reviews' => function($query) {
                $query->where('status', true);
            }])
            ->with(['reviews' => function($query) {
                $query->where('status', true);
            }])
            ->orderBy('created_at', 'desc')
            ->orderBy('sort_order', 'asc')
            ->take(8)
            ->get();
        
        // Calculate average ratings for latest products
        foreach ($latestProducts as $product) {
            $product->average_rating = $product->reviews->avg('rating') ?? 0;
        }
        
        // Check wishlist status for latest products
        $wishlist = session()->get('wishlist', []);
        foreach ($latestProducts as $product) {
            $product->is_in_wishlist = isset($wishlist[$product->id]);
        }
        
        // Get settings for contact and shipping info
        $settings = Cache::remember('site_settings', 3600, function () {
            $settingsFile = storage_path('app/settings.json');
            
            if (file_exists($settingsFile)) {
                return json_decode(file_get_contents($settingsFile), true);
            }

            // Default settings
            return [
                'site_email' => 'info@rubista.com',
                'site_phone' => '+1 234 567 8900',
                'site_address' => '123 Commerce Street, Business District',
                'free_shipping_threshold' => 500,
            ];
        });
        
        return view('frontend.home', compact(
            'categories', 
            'featuredProducts', 
            'trendingProducts',
            'latestProducts',
            'heroContent',
            'serviceContent',
            'offerContent',
            'bannerContent',
            'featureContent',
            'galleryContent',
            'flashDealContent',
            'featuredProductsContent',
            'bestSellersContent',
            'brandsContent',
            'testimonialsContent',
            'latestProductsContent',
            'settings'
        ));
    }
    
    /**
     * Display products by category
     */
    public function categoryProducts($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $products = Product::where('category_id', $categoryId)
            ->withCount(['reviews as total_reviews' => function($query) {
                $query->where('status', true);
            }])
            ->with(['reviews' => function($query) {
                $query->where('status', true);
            }])
            ->paginate(12);
        
        // Calculate average ratings for each product
        foreach ($products as $product) {
            $product->average_rating = $product->reviews->avg('rating') ?? 0;
        }
        
        // Check wishlist status for all products
        $wishlist = session()->get('wishlist', []);
        foreach ($products as $product) {
            $product->is_in_wishlist = isset($wishlist[$product->id]);
        }
        
        return view('frontend.category-products', compact('category', 'products'));
    }
    
    /**
     * Display single product
     */
    public function productDetail($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $id)
                                ->where('status', true)
                                ->take(8)
                                ->get();
        
        // Load reviews - show all if admin, only approved if regular user
        $reviewsQuery = $product->reviews()->with('user:id,name')->orderBy('created_at', 'desc');
        
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            $reviewsQuery->where('status', true);
        }
        
        $reviews = $reviewsQuery->get();
        $averageRating = $product->getAverageRatingAttribute();
        $totalReviews = $product->getTotalReviewsAttribute();
        
        // Check if current user has already reviewed
        $userReview = null;
        if (auth()->check()) {
            $userReview = $product->reviews()->where('user_id', auth()->id())->first();
        }
        
        // Check if product is in wishlist
        $wishlist = session()->get('wishlist', []);
        $isInWishlist = isset($wishlist[$id]);
        
        return view('frontend.product-detail', compact('product', 'relatedProducts', 'reviews', 'averageRating', 'totalReviews', 'userReview', 'isInWishlist'));
    }
    
    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('name', 'like', '%' . $query . '%')
                          ->orWhere('description', 'like', '%' . $query . '%')
                          ->withCount(['reviews as total_reviews' => function($q) {
                              $q->where('status', true);
                          }])
                          ->with(['reviews' => function($q) {
                              $q->where('status', true);
                          }])
                          ->paginate(12);
        
        // Calculate average ratings for each product
        foreach ($products as $product) {
            $product->average_rating = $product->reviews->avg('rating') ?? 0;
        }
        
        // Check wishlist status for all products
        $wishlist = session()->get('wishlist', []);
        foreach ($products as $product) {
            $product->is_in_wishlist = isset($wishlist[$product->id]);
        }
        
        return view('frontend.search', compact('products', 'query'));
    }
} 