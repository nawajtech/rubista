@extends('layouts.admin')

@section('title', 'Edit Contact Us - Admin Panel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Contact Us Page</h5>
                    <a href="{{ route('admin.contact-us.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.contact-us.update', $contactUs->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Page Title</label>
                            <input type="text" name="title" id="title" class="form-control" 
                                   value="{{ old('title', $contactUs->title ?? '') }}">
                        </div>

                        <h6 class="mt-4 mb-3">Hero Section</h6>
                        <div class="mb-3">
                            <label for="hero_title" class="form-label">Hero Title</label>
                            <input type="text" name="hero_title" id="hero_title" class="form-control" 
                                   value="{{ old('hero_title', $contactUs->hero_title ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="hero_subtitle" class="form-label">Hero Subtitle</label>
                            <input type="text" name="hero_subtitle" id="hero_subtitle" class="form-control" 
                                   value="{{ old('hero_subtitle', $contactUs->hero_subtitle ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="hero_description" class="form-label">Hero Description</label>
                            <textarea name="hero_description" id="hero_description" rows="3" class="form-control">{{ old('hero_description', $contactUs->hero_description ?? '') }}</textarea>
                        </div>

                        <h6 class="mt-4 mb-3">Contact Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control" 
                                       value="{{ old('address', $contactUs->address ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" 
                                       value="{{ old('phone', $contactUs->phone ?? '') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" 
                                       value="{{ old('email', $contactUs->email ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="working_hours" class="form-label">Working Hours</label>
                                <input type="text" name="working_hours" id="working_hours" class="form-control" 
                                       value="{{ old('working_hours', $contactUs->working_hours ?? '') }}" 
                                       placeholder="e.g., Mon-Fri: 9AM-6PM">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="map_embed_code" class="form-label">Google Maps Embed Code</label>
                            <textarea name="map_embed_code" id="map_embed_code" rows="4" class="form-control" 
                                      placeholder="Paste Google Maps iframe code here">{{ old('map_embed_code', $contactUs->map_embed_code ?? '') }}</textarea>
                        </div>

                        <h6 class="mt-4 mb-3">Contact Form</h6>
                        <div class="mb-3">
                            <label for="form_title" class="form-label">Form Title</label>
                            <input type="text" name="form_title" id="form_title" class="form-control" 
                                   value="{{ old('form_title', $contactUs->form_title ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="form_description" class="form-label">Form Description</label>
                            <textarea name="form_description" id="form_description" rows="2" class="form-control">{{ old('form_description', $contactUs->form_description ?? '') }}</textarea>
                        </div>

                        <h6 class="mt-4 mb-3">SEO</h6>
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" 
                                   value="{{ old('meta_title', $contactUs->meta_title ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="2" class="form-control">{{ old('meta_description', $contactUs->meta_description ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" 
                                       {{ old('is_active', $contactUs->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active (visible on website)</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-floppy"></i> Update Contact Us
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
