@extends('frontend.layouts.app')

@section('title', ($page->meta_title ?? $page->title) . ' - Rubista')

@section('meta')
@if($page->meta_description)
<meta name="description" content="{{ $page->meta_description }}">
@endif
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="cms-page-header mb-4">
                <h1 class="display-4 fw-bold mb-3">{{ $page->title }}</h1>
                @if($page->created_at)
                <p class="text-muted">
                    <small>Last updated: {{ $page->updated_at->format('F d, Y') }}</small>
                </p>
                @endif
            </div>
            
            @if($page->pdf_url)
            <div class="alert alert-info mb-4">
                <i class="fas fa-file-pdf text-danger"></i>
                <strong>PDF Document Available:</strong>
                <a href="{{ $page->pdf_url }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2" download>
                    <i class="fas fa-download"></i> Download PDF
                </a>
            </div>
            @endif
            
            <div class="cms-page-content">
                <div class="content-body">
                    @php
                        // Simple markdown-like rendering for headers and bold
                        $content = $page->content;
                        // Convert ## headers to h2
                        $content = preg_replace('/^##\s+(.+)$/m', '<h2>$1</h2>', $content);
                        // Convert ### headers to h3
                        $content = preg_replace('/^###\s+(.+)$/m', '<h3>$1</h3>', $content);
                        // Convert **bold** to <strong>
                        $content = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $content);
                        // Convert line breaks
                        $content = nl2br($content);
                    @endphp
                    {!! $content !!}
                </div>
            </div>
            
            @if($page->pdf_url)
            <div class="mt-4 text-center">
                <a href="{{ $page->pdf_url }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> View Full Document (PDF)
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.cms-page-header {
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 20px;
}

.cms-page-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.content-body {
    color: #333;
}

.content-body p {
    margin-bottom: 1.5rem;
}

.content-body h2 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #667eea;
    font-weight: 700;
}

.content-body h3 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
    color: #764ba2;
    font-weight: 600;
}

.content-body ul, .content-body ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.content-body li {
    margin-bottom: 0.5rem;
}

.content-body strong {
    color: #333;
    font-weight: 600;
}
</style>
@endsection
