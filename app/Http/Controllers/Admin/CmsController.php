<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('admin.cms.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|boolean',
        ]);

        return redirect()->route('admin.cms.index')->with('success', 'Content updated successfully!');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.cms.index')->with('success', 'Content deleted successfully!');
    }
} 