<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     * Show the about us page
     */
    public function about()
    {
        $aboutUs = \App\Models\AboutUs::active()->first();
        // If no active page, get any page (for preview purposes)
        if (!$aboutUs) {
            $aboutUs = \App\Models\AboutUs::first();
        }
        return view('frontend.pages.about', compact('aboutUs'));
    }
    
    /**
     * Show the contact us page
     */
    public function contact()
    {
        $contactUs = \App\Models\ContactUs::active()->first();
        return view('frontend.pages.contact', compact('contactUs'));
    }
    
    /**
     * Show the FAQ page
     */
    public function faq()
    {
        $faqs = \App\Models\Faq::active()->ordered()->get();
        $faqsByCategory = $faqs->groupBy('category');
        return view('frontend.pages.faq', compact('faqs', 'faqsByCategory'));
    }
    
    /**
     * Show the categories page with products
     */
    public function categories()
    {
        $categories = \App\Models\Category::with(['products' => function($query) {
            $query->take(8); // Limit to 8 products per category
        }])->get();
        
        return view('frontend.pages.categories', compact('categories'));
    }
    
    /**
     * Handle contact form submission
     */
    public function contactSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Save the contact message to database
        \App\Models\ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Here you can add email sending logic if needed
        
        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
    
    /**
     * Show CMS page by slug
     */
    public function cmsPage($slug)
    {
        // Get the page by slug - prioritize published pages
        $page = \App\Models\CmsPage::where('slug', $slug)
            ->where('status', true)
            ->first();
        
        // If not found with status=true, try any page (for admin preview)
        if (!$page) {
            $page = \App\Models\CmsPage::where('slug', $slug)->first();
        }
        
        if (!$page) {
            // Check if any CMS pages exist at all
            $totalPages = \App\Models\CmsPage::count();
            if ($totalPages == 0) {
                abort(404, "No CMS pages found in database. Please run: php artisan db:seed --class=CmsPageSeeder");
            }
            
            // List available slugs for debugging
            $availableSlugs = \App\Models\CmsPage::pluck('slug')->implode(', ');
            abort(404, "Page with slug '{$slug}' not found. Available slugs: {$availableSlugs}");
        }
        
        return view('frontend.pages.cms-page', compact('page'));
    }
} 