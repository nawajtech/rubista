<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display the contact us page (singleton - only one record)
     */
    public function index()
    {
        $contactUs = ContactUs::first();
        return view('admin.contact-us.index', compact('contactUs'));
    }

    /**
     * Show the form for editing the contact us page
     */
    public function edit($id)
    {
        $contactUs = ContactUs::findOrFail($id);
        return view('admin.contact-us.edit', compact('contactUs'));
    }

    /**
     * Update the contact us page
     */
    public function update(Request $request, $id)
    {
        $contactUs = ContactUs::findOrFail($id);
        
        $request->validate([
            'title' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string',
            'hero_subtitle' => 'nullable|string',
            'hero_description' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'working_hours' => 'nullable|string|max:255',
            'map_embed_code' => 'nullable|string',
            'contact_info' => 'nullable|array',
            'form_title' => 'nullable|string',
            'form_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Process contact info cards
        $contactInfo = [];
        if ($request->has('contact_info_titles')) {
            $titles = $request->input('contact_info_titles', []);
            $descriptions = $request->input('contact_info_descriptions', []);
            $icons = $request->input('contact_info_icons', []);
            
            foreach ($titles as $index => $title) {
                if (!empty($title)) {
                    $contactInfo[] = [
                        'title' => $title,
                        'description' => $descriptions[$index] ?? '',
                        'icon' => $icons[$index] ?? 'fas fa-info-circle',
                    ];
                }
            }
        }

        $contactUs->update([
            'title' => $request->title,
            'hero_title' => $request->hero_title,
            'hero_subtitle' => $request->hero_subtitle,
            'hero_description' => $request->hero_description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'working_hours' => $request->working_hours,
            'map_embed_code' => $request->map_embed_code,
            'contact_info' => !empty($contactInfo) ? $contactInfo : null,
            'form_title' => $request->form_title,
            'form_description' => $request->form_description,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        return redirect()->route('admin.contact-us.index')->with('success', 'Contact Us page updated successfully!');
    }

    /**
     * Create the initial contact us page if it doesn't exist
     */
    public function create()
    {
        if (ContactUs::count() > 0) {
            return redirect()->route('admin.contact-us.index')
                ->with('info', 'Contact Us page already exists. You can edit it instead.');
        }
        
        ContactUs::create([
            'title' => 'Contact Us',
            'is_active' => true,
        ]);

        return redirect()->route('admin.contact-us.index')->with('success', 'Contact Us page created!');
    }
}
