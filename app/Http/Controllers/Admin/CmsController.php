<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    public function index()
    {
        $pages = CmsPage::orderBy('created_at', 'desc')->get();
        return view('admin.cms.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.cms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_pages,slug',
            'content' => 'required|string',
            'status' => 'required|in:0,1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $pdfUrl = null;
        if ($request->hasFile('pdf_file')) {
            $pdfPath = $request->file('pdf_file')->store('cms/pdfs', 'public');
            $pdfUrl = Storage::url($pdfPath);
        }

        CmsPage::create([
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title),
            'content' => $request->content,
            'status' => (bool) $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'pdf_url' => $pdfUrl,
        ]);

        return redirect()->route('admin.cms.index')->with('success', 'Content created successfully!');
    }

    public function show($id)
    {
        $page = CmsPage::findOrFail($id);
        return view('admin.cms.show', compact('page'));
    }

    public function edit($id)
    {
        $cmsPage = CmsPage::findOrFail($id);
        return view('admin.cms.edit', compact('cmsPage'));
    }

    public function update(Request $request, $id)
    {
        $page = CmsPage::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_pages,slug,' . $id,
            'content' => 'required|string',
            'status' => 'required|in:0,1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'remove_pdf' => 'nullable|in:0,1',
        ]);

        $pdfUrl = $page->pdf_url;
        
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
            if ($page->pdf_url && Storage::disk('public')->exists(str_replace('/storage/', '', $page->pdf_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $page->pdf_url));
            }
            
            // Store new PDF
            $pdfPath = $request->file('pdf_file')->store('cms/pdfs', 'public');
            $pdfUrl = Storage::url($pdfPath);
        }

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title),
            'content' => $request->content,
            'status' => (bool) $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'pdf_url' => $pdfUrl,
        ]);

        return redirect()->route('admin.cms.index')->with('success', 'Content updated successfully!');
    }

    public function destroy($id)
    {
        $page = CmsPage::findOrFail($id);
        
        // Delete PDF if exists
        if ($page->pdf_url && Storage::disk('public')->exists(str_replace('/storage/', '', $page->pdf_url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $page->pdf_url));
        }
        
        $page->delete();
        
        return redirect()->route('admin.cms.index')->with('success', 'Content deleted successfully!');
    }
} 