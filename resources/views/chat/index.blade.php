@extends('layouts.app')

@section('title', 'Chat Rooms')

@section('content')
<div class="main-container">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-comments"></i>
                Chat Rooms
            </h1>
            <p class="page-subtitle">Communicate with your team in real-time</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createChatModal">
                <i class="fas fa-plus"></i> Create Room
            </button>
        </div>
    </div>

    <div class="content-section">
        <div class="row">
            @forelse($chatRooms as $room)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card chat-room-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title">{{ $room->name }}</h5>
                            <span class="badge badge-{{ $room->type === 'public' ? 'success' : ($room->type === 'private' ? 'warning' : 'info') }}">
                                {{ ucfirst($room->type) }}
                            </span>
                        </div>
                        
                        @if($room->description)
                        <p class="card-text text-muted">{{ Str::limit($room->description, 100) }}</p>
                        @endif
                        
                        <div class="chat-room-meta">
                            <div class="participants-count">
                                <i class="fas fa-users"></i>
                                {{ $room->participants->where('is_active', true)->count() }} participants
                            </div>
                            
                            @if($room->latestMessage->first())
                            <div class="latest-message">
                                <small class="text-muted">
                                    Last message: {{ $room->latestMessage->first()->created_at->diffForHumans() }}
                                </small>
                            </div>
                            @endif
                            
                            @php
                                $unreadCount = $room->unreadMessagesCount(auth()->id());
                            @endphp
                            @if($unreadCount > 0)
                            <div class="unread-badge">
                                <span class="badge bg-danger">{{ $unreadCount }} unread</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('chat.show', $room) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-comment"></i> Join Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-comments fa-4x"></i>
                    <h5>No Chat Rooms</h5>
                    <p>Create your first chat room to start communicating with your team.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createChatModal">
                        <i class="fas fa-plus"></i> Create Chat Room
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Create Chat Room Modal -->
<div class="modal fade" id="createChatModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Chat Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createChatForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="roomName" class="form-label">Room Name</label>
                        <input type="text" class="form-control" id="roomName" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="roomDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="roomDescription" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="roomType" class="form-label">Room Type</label>
                        <select class="form-select" id="roomType" name="type" required>
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                            <option value="support">Support</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Room</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.chat-room-card {
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    transition: all 0.3s;
}

.chat-room-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.chat-room-meta {
    border-top: 1px solid #e5e7eb;
    padding-top: 12px;
    margin-top: 12px;
}

.participants-count {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 4px;
}

.latest-message {
    margin-bottom: 8px;
}

.unread-badge {
    margin-top: 8px;
}

.badge {
    font-size: 0.75rem;
    padding: 4px 8px;
}

.badge-success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.badge-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.badge-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
}
</style>

<script>
document.getElementById('createChatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route("chat.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error creating chat room');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating chat room');
    });
});
</script>
@endsection
