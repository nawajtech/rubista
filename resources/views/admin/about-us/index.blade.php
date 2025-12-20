@extends('layouts.admin')

@section('title', 'About Us - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-info-circle"></i> About Us Page</h1>
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
        <h5 class="mb-0">About Us Content</h5>
    </div>
    <div class="card-body">
        @if($aboutUs)
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> About Us page exists. Click Edit to modify the content.
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.about-us.edit', $aboutUs->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit About Us Page
                </a>
            </div>
        @else
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> About Us page does not exist yet.
            </div>
            <form method="POST" action="{{ route('admin.about-us.create') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Create About Us Page
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
