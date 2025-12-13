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
        $categories = Category::with('products')->get();
        $featuredProducts = Product::where('featured', true)->take(10)->get();
        $trendingProducts = Product::orderBy('created_at', 'desc')->take(10)->get();
        
        // Get dynamic homepage content
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
        $products = Product::where('category_id', $categoryId)->paginate(12);
        
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
                                ->take(4)
                                ->get();
        
        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }
    
    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('name', 'like', '%' . $query . '%')
                          ->orWhere('description', 'like', '%' . $query . '%')
                          ->paginate(12);
        
        return view('frontend.search', compact('products', 'query'));
    }
} 