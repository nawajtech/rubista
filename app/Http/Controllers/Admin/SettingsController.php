<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'site_email' => 'required|email',
            'site_phone' => 'nullable|string|max:20',
            'site_address' => 'nullable|string|max:500',
            'currency' => 'required|string|max:3',
            'currency_symbol' => 'required|string|max:10',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'shipping_fee' => 'nullable|numeric|min:0',
            'free_shipping_threshold' => 'nullable|numeric|min:0',
            'items_per_page' => 'required|integer|min:1|max:50',
            'featured_products_count' => 'required|integer|min:1|max:20',
            'latest_products_count' => 'required|integer|min:1|max:20',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'admin_primary_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'admin_secondary_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'admin_sidebar_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'admin_sidebar_hover_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'admin_text_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'admin_background_color' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'favicon' => 'nullable|image|mimes:png,jpg,jpeg,gif,ico,svg|max:2048',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        $settings = $this->getSettings();

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if (isset($settings['favicon']) && $settings['favicon'] && Storage::disk('public')->exists($settings['favicon'])) {
                Storage::disk('public')->delete($settings['favicon']);
            }
            
            $faviconPath = $request->file('favicon')->store('site-assets', 'public');
            $settings['favicon'] = $faviconPath;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if (isset($settings['logo']) && $settings['logo'] && Storage::disk('public')->exists($settings['logo'])) {
                Storage::disk('public')->delete($settings['logo']);
            }
            
            $logoPath = $request->file('logo')->store('site-assets', 'public');
            $settings['logo'] = $logoPath;
        }

        // Update settings (excluding color text fields which are just UI helpers and files)
        foreach ($request->except(['_token', '_method', 'admin_primary_color_text', 'admin_secondary_color_text', 'admin_sidebar_color_text', 'admin_sidebar_hover_color_text', 'admin_text_color_text', 'admin_background_color_text', 'favicon', 'logo']) as $key => $value) {
            $settings[$key] = $value;
        }

        // Save settings to file
        $this->saveSettings($settings);

        // Clear cache
        Cache::forget('site_settings');

        return redirect()->route('admin.settings.index')
                        ->with('success', 'Settings updated successfully.');
    }

    private function getSettings()
    {
        return Cache::remember('site_settings', 3600, function () {
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
    }

    private function saveSettings($settings)
    {
        $settingsFile = storage_path('app/settings.json');
        file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT));
    }

    public function clearCache()
    {
        Cache::forget('site_settings');
        Cache::flush();

        return redirect()->route('admin.settings.index')
                        ->with('success', 'Cache cleared successfully.');
    }
} 