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
        return view('frontend.pages.about');
    }
    
    /**
     * Show the contact us page
     */
    public function contact()
    {
        return view('frontend.pages.contact');
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

        // Here you can add email sending logic
        // For now, we'll just show a success message
        
        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
} 