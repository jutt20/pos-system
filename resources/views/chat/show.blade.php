@extends('layouts.app')

@section('title', $chatRoom->name)

@section('content')
<div class="main-container">
    <div class="page-header">
        <div class="page-header-content">
            <h1 class="page-title">
                <i class="fas fa-comment"></i>
                {{ $chatRoom->name }}
            </h1>
            <p class="page-subtitle">{{ $chatRoom->description ?? 'Chat with your team' }}</p>
        </div>
        <div class="header-actions">
            <span class="badge badge-{{ $chatRoom->type === 'public' ? 'success' : ($chatRoom->type === 'private' ? 'warning' : 'info') }}">
                {{ ucfirst($chatRoom->type) }}
            </span>
            <a href="{{ route('chat.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Rooms
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9">
            <div class="chat-container">
                <div class="chat-messages" id="chatMessages">
                    @foreach($messages as $message)
                    <div class="message {{ $message->user_id === auth()->id() ? 'message-own' : 'message-other' }}">
                        <div class="message-avatar">
                            <div class="avatar">
                                {{ strtoupper(substr($message->user->name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="message-author">{{ $message->user->name }}</span>
                                <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                                @if($message->is_edited)
                                <span class="message-edited">(edited)</span>
                                @endif
                            </div>
                            <div class="message-text">{{ $message->message }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="chat-input">
                    <form id="messageForm">
                        <div class="input-group">
                            <input type="text" class="form-control" id="messageInput" placeholder="Type your message..." required>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3">
            <div class="participants-panel">
                <h6>Participants ({{ $participants->count() }})</h6>
                <div class="participants-list">
                    @foreach($participants as $participant)
                    <div class="participant-item">
                        <div class="participant-avatar">
                            {{ strtoupper(substr($participant->user->name, 0, 2)) }}
                        </div>
                        <div class="participant-info">
                            <div class="participant-name">{{ $participant->user->name }}</div>
                            <div class="participant-role">{{ ucfirst($participant->role) }}</div>
                        </div>
                        <div class="participant-status online"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chat-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    height: 600px;
    display: flex;
    flex-direction: column;
}

.chat-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f8fafc;
}

.message {
    display: flex;
    margin-bottom: 20px;
    align-items: flex-start;
}

.message-own {
    flex-direction: row-reverse;
}

.message-avatar {
    margin: 0 12px;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
}

.message-content {
    max-width: 70%;
    background: white;
    border-radius: 12px;
    padding: 12px 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.message-own .message-content {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.message-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
    font-size: 0.75rem;
}

.message-author {
    font-weight: 600;
}

.message-time {
    opacity: 0.7;
}

.message-edited {
    opacity: 0.6;
    font-style: italic;
}

.message-text {
    line-height: 1.4;
}

.chat-input {
    padding: 20px;
    background: white;
    border-top: 1px solid #e5e7eb;
}

.participants-panel {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.participants-panel h6 {
    margin-bottom: 16px;
    color: #374151;
    font-weight: 600;
}

.participant-item {
    display: flex;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
}

.participant-item:last-child {
    border-bottom: none;
}

.participant-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981, #059669);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 0.75rem;
    margin-right: 12px;
}

.participant-info {
    flex: 1;
}

.participant-name {
    font-weight: 500;
    font-size: 0.875rem;
    color: #374151;
}

.participant-role {
    font-size: 0.75rem;
    color: #6b7280;
}

.participant-status {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
}

.participant-status.offline {
    background: #6b7280;
}
</style>

<script>
const chatMessages = document.getElementById('chatMessages');
const messageForm = document.getElementById('messageForm');
const messageInput = document.getElementById('messageInput');

// Scroll to bottom
function scrollToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Send message
messageForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const message = messageInput.value.trim();
    if (!message) return;
    
    fetch('{{ route("chat.send-message", $chatRoom) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            addMessageToChat(data.message, true);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// Add message to chat
function addMessageToChat(message, isOwn = false) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${isOwn ? 'message-own' : 'message-other'}`;
    
    messageDiv.innerHTML = `
        <div class="message-avatar">
            <div class="avatar">
                ${message.user.name.substring(0, 2).toUpperCase()}
            </div>
        </div>
        <div class="message-content">
            <div class="message-header">
                <span class="message-author">${message.user.name}</span>
                <span class="message-time">${new Date().toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'})}</span>
            </div>
            <div class="message-text">${message.message}</div>
        </div>
    `;
    
    chatMessages.appendChild(messageDiv);
    scrollToBottom();
}

// Initialize
scrollToBottom();

// Laravel Echo for real-time messaging (if using Laravel Reverb)
@if(config('broadcasting.default') === 'reverb')
window.Echo.private('chat-room.{{ $chatRoom->id }}')
    .listen('.message.sent', (e) => {
        addMessageToChat(e);
    });
@endif
</script>
@endsection
