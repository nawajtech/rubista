@extends('layouts.admin')

@section('title', 'View Contact Message - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-envelope-open"></i> View Contact Message</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Messages
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Message Details</h5>
                <div>
                    @if($message->is_read)
                        <span class="badge bg-success me-2">Read</span>
                        <form method="POST" action="{{ route('admin.contact-messages.mark-unread', $message->id) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-envelope"></i> Mark as Unread
                            </button>
                        </form>
                    @else
                        <span class="badge bg-warning me-2">Unread</span>
                        <form method="POST" action="{{ route('admin.contact-messages.mark-read', $message->id) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-check"></i> Mark as Read
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label fw-bold text-muted">From</label>
                    <p class="mb-1"><strong>{{ $message->name }}</strong></p>
                    <p class="text-muted mb-0">{{ $message->email }}</p>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-muted">Subject</label>
                    <p class="mb-0">{{ $message->subject }}</p>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-muted">Message</label>
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Received</label>
                        <p class="mb-0">{{ $message->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    @if($message->is_read && $message->read_at)
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted">Read At</label>
                        <p class="mb-0">{{ $message->read_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn-primary">
                        <i class="bi bi-reply"></i> Reply via Email
                    </a>
                    <form method="POST" action="{{ route('admin.contact-messages.destroy', $message->id) }}" onsubmit="return confirm('Are you sure you want to delete this message?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
