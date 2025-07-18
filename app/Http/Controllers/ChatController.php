<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $chatRooms = ChatRoom::whereHas('participants', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('is_active', true);
        })->with(['latestMessage.user', 'participants.user'])->get();

        return view('chat.index', compact('chatRooms'));
    }

    public function show(ChatRoom $chatRoom): View
    {
        $user = auth()->user();
        
        // Check if user is participant
        $participant = $chatRoom->participants()->where('user_id', $user->id)->first();
        if (!$participant) {
            abort(403, 'You are not a participant in this chat room.');
        }

        // Mark messages as read
        $participant->markAsRead();

        $messages = $chatRoom->messages()
                           ->with('user')
                           ->orderBy('created_at', 'asc')
                           ->paginate(50);

        $participants = $chatRoom->participants()
                                ->with('user')
                                ->where('is_active', true)
                                ->get();

        return view('chat.show', compact('chatRoom', 'messages', 'participants'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:public,private,support',
            'participants' => 'array',
            'participants.*' => 'exists:users,id'
        ]);

        $chatRoom = ChatRoom::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'created_by' => auth()->id(),
        ]);

        // Add creator as admin
        ChatParticipant::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => auth()->id(),
            'role' => 'admin',
            'joined_at' => now(),
        ]);

        // Add other participants
        if ($request->participants) {
            foreach ($request->participants as $userId) {
                if ($userId != auth()->id()) {
                    ChatParticipant::create([
                        'chat_room_id' => $chatRoom->id,
                        'user_id' => $userId,
                        'role' => 'member',
                        'joined_at' => now(),
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'chat_room' => $chatRoom->load('participants.user')
        ]);
    }

    public function sendMessage(Request $request, ChatRoom $chatRoom): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'message_type' => 'in:text,image,file,system'
        ]);

        $user = auth()->user();
        
        // Check if user is participant
        $participant = $chatRoom->participants()->where('user_id', $user->id)->first();
        if (!$participant) {
            return response()->json(['error' => 'You are not a participant in this chat room.'], 403);
        }

        $message = ChatMessage::create([
            'chat_room_id' => $chatRoom->id,
            'user_id' => $user->id,
            'message' => $request->message,
            'message_type' => $request->message_type ?? 'text',
        ]);

        $message->load('user');

        // Broadcast message using Laravel Reverb
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function getMessages(ChatRoom $chatRoom): JsonResponse
    {
        $user = auth()->user();
        
        // Check if user is participant
        $participant = $chatRoom->participants()->where('user_id', $user->id)->first();
        if (!$participant) {
            return response()->json(['error' => 'You are not a participant in this chat room.'], 403);
        }

        $messages = $chatRoom->messages()
                           ->with('user')
                           ->orderBy('created_at', 'desc')
                           ->paginate(20);

        return response()->json($messages);
    }

    public function joinRoom(Request $request, ChatRoom $chatRoom): JsonResponse
    {
        $user = auth()->user();
        
        $existingParticipant = $chatRoom->participants()->where('user_id', $user->id)->first();
        
        if ($existingParticipant) {
            $existingParticipant->update(['is_active' => true]);
        } else {
            ChatParticipant::create([
                'chat_room_id' => $chatRoom->id,
                'user_id' => $user->id,
                'role' => 'member',
                'joined_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function leaveRoom(ChatRoom $chatRoom): JsonResponse
    {
        $user = auth()->user();
        
        $participant = $chatRoom->participants()->where('user_id', $user->id)->first();
        
        if ($participant) {
            $participant->update(['is_active' => false]);
        }

        return response()->json(['success' => true]);
    }
}
