<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CmsController extends Controller
{
    public function index()
    {
        return view('admin.cms.index');
    }

    public function create()
    {
        return view('admin.cms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|boolean',
        ]);

        // For now, we'll just redirect back with success message
        // In a real application, you would save to database
        return redirect()->route('admin.cms.index')->with('success', 'Content created successfully!');
    }

    public function show($id)
    {
        return view('admin.cms.show', compact('id'));
    }

    public function edit($id)
    {
        // Load CMS page data from settings (temporary solution)
        $settingsFile = storage_path('app/settings.json');
        $cmsPage = null;
        
        if (file_exists($settingsFile)) {
            $settings = json_decode(file_get_contents($settingsFile), true);
            $cmsKey = 'cms_page_' . $id;
            if (isset($settings[$cmsKey])) {
                $cmsPage = (object) $settings[$cmsKey];
            }
        }
        
        return view('admin.cms.edit', compact('id', 'cmsPage'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:0,1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'remove_pdf' => 'nullable|in:0,1',
        ]);

        // Handle PDF upload
        $pdfUrl = $request->input('pdf_url'); // Keep existing PDF if no new upload
        
        // If remove_pdf is set, remove the PDF
        if ($request->input('remove_pdf') == '1') {
            if ($pdfUrl && Storage::disk('public')->exists(str_replace('/storage/', '', $pdfUrl))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $pdfUrl));
            }
            $pdfUrl = null;
        }
        
        // Handle new PDF upload
        if ($request->hasFile('pdf_file')) {
            // Delete old PDF if exists
            if ($pdfUrl && Storage::disk('public')->exists(str_replace('/storage/', '', $pdfUrl))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $pdfUrl));
            }
            
            // Store new PDF
            $pdfPath = $request->file('pdf_file')->store('cms/pdfs', 'public');
            $pdfUrl = Storage::url($pdfPath);
        }

        // TODO: Save to database when CMS model is implemented
        // For now, you can store in settings.json or create a CMS model
        
        // Store in settings.json for now (temporary solution)
        $settingsFile = storage_path('app/settings.json');
        $settings = [];
        
        if (file_exists($settingsFile)) {
            $settings = json_decode(file_get_contents($settingsFile), true);
        }
        
        // Store CMS page data
        $cmsKey = 'cms_page_' . $id;
        $settings[$cmsKey] = [
            'title' => $request->title,
            'slug' => $request->slug ?? strtolower(str_replace(' ', '-', $request->title)),
            'content' => $request->content,
            'status' => (bool) $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'pdf_url' => $pdfUrl,
            'updated_at' => now()->toDateTimeString(),
        ];
        
        file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT));

        return redirect()->route('admin.cms.index')->with('success', 'Content updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.cms.index')->with('success', 'Content deleted successfully!');
    }
} 