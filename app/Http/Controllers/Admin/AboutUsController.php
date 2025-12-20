<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    /**
     * Display the about us page (singleton - only one record)
     */
    public function index()
    {
        $aboutUs = AboutUs::first();
        return view('admin.about-us.index', compact('aboutUs'));
    }

    /**
     * Show the form for editing the about us page
     */
    public function edit($id)
    {
        $aboutUs = AboutUs::findOrFail($id);
        return view('admin.about-us.edit', compact('aboutUs'));
    }

    /**
     * Update the about us page
     */
    public function update(Request $request, $id)
    {
        $aboutUs = AboutUs::findOrFail($id);
        
        $request->validate([
            'title' => 'nullable|string|max:255',
            'hero_title' => 'nullable|string',
            'hero_subtitle' => 'nullable|string',
            'hero_description' => 'nullable|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'nullable|string',
            'our_story_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mission' => 'nullable|string',
            'mission_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'vision' => 'nullable|string',
            'vision_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'values' => 'nullable|string',
            'features' => 'nullable|array',
            'stats' => 'nullable|array',
            'team' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'remove_hero_image' => 'nullable|in:0,1',
            'remove_our_story_image' => 'nullable|in:0,1',
            'remove_mission_image' => 'nullable|in:0,1',
            'remove_vision_image' => 'nullable|in:0,1',
        ]);

        // Process JSON fields
        $features = [];
        if ($request->has('feature_titles')) {
            $titles = $request->input('feature_titles', []);
            $descriptions = $request->input('feature_descriptions', []);
            $icons = $request->input('feature_icons', []);
            
            foreach ($titles as $index => $title) {
                if (!empty($title)) {
                    $features[] = [
                        'title' => $title,
                        'description' => $descriptions[$index] ?? '',
                        'icon' => $icons[$index] ?? 'fas fa-star',
                    ];
                }
            }
        }

        $stats = [];
        if ($request->has('stat_numbers')) {
            $numbers = $request->input('stat_numbers', []);
            $labels = $request->input('stat_labels', []);
            
            foreach ($numbers as $index => $number) {
                if (!empty($number)) {
                    $stats[] = [
                        'number' => $number,
                        'label' => $labels[$index] ?? '',
                    ];
                }
            }
        }

        $team = [];
        if ($request->has('team_names')) {
            $names = $request->input('team_names', []);
            $positions = $request->input('team_positions', []);
            $descriptions = $request->input('team_descriptions', []);
            
            foreach ($names as $index => $name) {
                if (!empty($name)) {
                    $team[] = [
                        'name' => $name,
                        'position' => $positions[$index] ?? '',
                        'description' => $descriptions[$index] ?? '',
                    ];
                }
            }
        }

        $data = [
            'title' => $request->title,
            'hero_title' => $request->hero_title,
            'hero_subtitle' => $request->hero_subtitle,
            'hero_description' => $request->hero_description,
            'content' => $request->content,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'values' => $request->values,
            'features' => !empty($features) ? $features : null,
            'stats' => !empty($stats) ? $stats : null,
            'team' => !empty($team) ? $team : null,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ];

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            // Delete old image if exists
            if ($aboutUs->hero_image_url) {
                $oldImagePath = str_replace('/storage/', '', $aboutUs->hero_image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            $imagePath = $request->file('hero_image')->store('about-us', 'public');
            $data['hero_image_url'] = Storage::url($imagePath);
        } elseif ($request->input('remove_hero_image') == '1') {
            if ($aboutUs->hero_image_url) {
                $oldImagePath = str_replace('/storage/', '', $aboutUs->hero_image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            $data['hero_image_url'] = null;
        }

        // Handle our story image upload
        if ($request->hasFile('our_story_image')) {
            // Delete old image if exists
            if ($aboutUs->our_story_image_url) {
                $oldImagePath = str_replace('/storage/', '', $aboutUs->our_story_image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            $imagePath = $request->file('our_story_image')->store('about-us', 'public');
            $data['our_story_image_url'] = Storage::url($imagePath);
        } elseif ($request->input('remove_our_story_image') == '1') {
            if ($aboutUs->our_story_image_url) {
                $oldImagePath = str_replace('/storage/', '', $aboutUs->our_story_image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            $data['our_story_image_url'] = null;
        }

        // Handle mission image upload
        if ($request->hasFile('mission_image')) {
            // Delete old image if exists
            if ($aboutUs->mission_image_url) {
                $oldImagePath = str_replace('/storage/', '', $aboutUs->mission_image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            $imagePath = $request->file('mission_image')->store('about-us', 'public');
            $data['mission_image_url'] = Storage::url($imagePath);
        } elseif ($request->input('remove_mission_image') == '1') {
            if ($aboutUs->mission_image_url) {
                $oldImagePath = str_replace('/storage/', '', $aboutUs->mission_image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            $data['mission_image_url'] = null;
        }

        // Handle vision image upload
        if ($request->hasFile('vision_image')) {
            // Delete old image if exists
            if ($aboutUs->vision_image_url) {
                $oldImagePath = str_replace('/storage/', '', $aboutUs->vision_image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            $imagePath = $request->file('vision_image')->store('about-us', 'public');
            $data['vision_image_url'] = Storage::url($imagePath);
        } elseif ($request->input('remove_vision_image') == '1') {
            if ($aboutUs->vision_image_url) {
                $oldImagePath = str_replace('/storage/', '', $aboutUs->vision_image_url);
                Storage::disk('public')->delete($oldImagePath);
            }
            $data['vision_image_url'] = null;
        }

        $aboutUs->update($data);

        return redirect()->route('admin.about-us.index')->with('success', 'About Us page updated successfully!');
    }

    /**
     * Create the initial about us page if it doesn't exist
     */
    public function create()
    {
        if (AboutUs::count() > 0) {
            return redirect()->route('admin.about-us.index')
                ->with('info', 'About Us page already exists. You can edit it instead.');
        }
        
        AboutUs::create([
            'title' => 'About Us',
            'is_active' => true,
        ]);

        return redirect()->route('admin.about-us.index')->with('success', 'About Us page created!');
    }
}
