@extends('layouts.admin')

@section('title', 'Contact Us - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-telephone"></i> Contact Us Page</h1>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Contact Us Content</h5>
    </div>
    <div class="card-body">
        @if($contactUs)
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Contact Us page exists. Click Edit to modify the content.
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-envelope"></i> View Contact Messages
                </a>
                <!-- <a href="{{ route('admin.contact-us.edit', $contactUs->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit Contact Us Page
                </a> -->
            </div>
        @else
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> Contact Us page does not exist yet.
            </div>
            <form method="POST" action="{{ route('admin.contact-us.create') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Create Contact Us Page
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
