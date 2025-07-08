<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contents = HomepageContent::orderBy('section_type')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.homepage-content.index', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sectionTypes = [
            'hero' => 'Hero Section',
            'service' => 'Service Section',
            'banner' => 'Banner/Promotional',
            'offer' => 'Special Offer',
            'testimonial' => 'Testimonial',
            'feature' => 'Feature Section',
            'cta' => 'Call to Action',
            'gallery' => 'Gallery Section'
        ];

        return view('admin.homepage-content.create', compact('sectionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_type' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:500',
            'sort_order' => 'required|integer|min:0',
            'extra_field_keys' => 'nullable|array',
            'extra_field_values' => 'nullable|array',
        ]);

        $data = $request->only([
            'section_type',
            'title',
            'subtitle',
            'description',
            'button_text',
            'button_url',
            'sort_order'
        ]);

        // Handle is_active checkbox
        $data['is_active'] = $request->input('is_active') == '1';

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('homepage-content', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        // Handle extra data
        $extraData = [];
        if ($request->has('extra_field_keys') && $request->has('extra_field_values')) {
            $keys = $request->input('extra_field_keys', []);
            $values = $request->input('extra_field_values', []);
            
            for ($i = 0; $i < count($keys); $i++) {
                if (!empty($keys[$i]) && !empty($values[$i])) {
                    $extraData[$keys[$i]] = $values[$i];
                }
            }
        }
        $data['extra_data'] = $extraData;

        HomepageContent::create($data);

        return redirect()->route('admin.homepage-content.index')
            ->with('success', 'Homepage content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomepageContent $homepageContent)
    {
        return view('admin.homepage-content.show', compact('homepageContent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomepageContent $homepageContent)
    {
        $sectionTypes = [
            'hero' => 'Hero Section',
            'service' => 'Service Section',
            'banner' => 'Banner/Promotional',
            'offer' => 'Special Offer',
            'testimonial' => 'Testimonial',
            'feature' => 'Feature Section',
            'cta' => 'Call to Action',
            'gallery' => 'Gallery Section'
        ];

        return view('admin.homepage-content.edit', compact('homepageContent', 'sectionTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomepageContent $homepageContent)
    {
        $request->validate([
            'section_type' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|string|max:500',
            'sort_order' => 'required|integer|min:0',
            'extra_field_keys' => 'nullable|array',
            'extra_field_values' => 'nullable|array',
        ]);

        $data = $request->only([
            'section_type',
            'title',
            'subtitle',
            'description',
            'button_text',
            'button_url',
            'sort_order'
        ]);

        // Handle is_active checkbox
        $data['is_active'] = $request->input('is_active') == '1';

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($homepageContent->image_url) {
                $oldImagePath = str_replace('/storage/', '', $homepageContent->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            
            $imagePath = $request->file('image')->store('homepage-content', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        // Handle extra data
        $extraData = [];
        if ($request->has('extra_field_keys') && $request->has('extra_field_values')) {
            $keys = $request->input('extra_field_keys', []);
            $values = $request->input('extra_field_values', []);
            
            for ($i = 0; $i < count($keys); $i++) {
                if (!empty($keys[$i]) && !empty($values[$i])) {
                    $extraData[$keys[$i]] = $values[$i];
                }
            }
        }
        $data['extra_data'] = $extraData;

        $homepageContent->update($data);

        return redirect()->route('admin.homepage-content.index')
            ->with('success', 'Homepage content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomepageContent $homepageContent)
    {
        // Delete image if exists
        if ($homepageContent->image_url) {
            $imagePath = str_replace('/storage/', '', $homepageContent->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $homepageContent->delete();

        return redirect()->route('admin.homepage-content.index')
            ->with('success', 'Homepage content deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(HomepageContent $homepageContent)
    {
        $homepageContent->update(['is_active' => !$homepageContent->is_active]);

        return redirect()->back()
            ->with('success', 'Content status updated successfully.');
    }
}
