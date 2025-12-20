@extends('layouts.admin')

@section('title', 'Contact Messages - Admin Panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="bi bi-envelope"></i> Contact Messages</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if($unreadCount > 0)
            <span class="badge bg-danger me-2">{{ $unreadCount }} Unread</span>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Contact Form Messages</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr class="{{ !$message->is_read ? 'table-warning' : '' }}">
                        <td><strong>{{ $message->name }}</strong></td>
                        <td>{{ $message->email }}</td>
                        <td>{{ Str::limit($message->subject, 40) }}</td>
                        <td>{{ Str::limit($message->message, 60) }}</td>
                        <td>
                            @if($message->is_read)
                                <span class="badge bg-success">Read</span>
                            @else
                                <span class="badge bg-warning">Unread</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $message->created_at->format('M d, Y H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.contact-messages.show', $message->id) }}" class="btn btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($message->is_read)
                                    <form method="POST" action="{{ route('admin.contact-messages.mark-unread', $message->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning" title="Mark as Unread">
                                            <i class="bi bi-envelope"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.contact-messages.mark-read', $message->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-success" title="Mark as Read">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.contact-messages.destroy', $message->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No contact messages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($messages->hasPages())
            <div class="mt-3">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
