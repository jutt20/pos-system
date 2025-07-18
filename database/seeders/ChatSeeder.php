<?php

namespace Database\Seeders;

use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        if ($users->count() < 2) {
            return; // Need at least 2 users for chat
        }

        // Create General chat room
        $generalRoom = ChatRoom::create([
            'name' => 'General Discussion',
            'description' => 'General chat for all team members',
            'type' => 'public',
            'created_by' => $users->first()->id,
        ]);

        // Add all users to general room
        foreach ($users as $index => $user) {
            ChatParticipant::create([
                'chat_room_id' => $generalRoom->id,
                'user_id' => $user->id,
                'role' => $index === 0 ? 'admin' : 'member',
                'joined_at' => now(),
            ]);
        }

        // Create some sample messages
        $sampleMessages = [
            'Welcome to the team chat!',
            'How is everyone doing today?',
            'Don\'t forget about the meeting at 3 PM',
            'Great work on the latest project!',
            'Anyone available for a quick call?'
        ];

        foreach ($sampleMessages as $index => $messageText) {
            ChatMessage::create([
                'chat_room_id' => $generalRoom->id,
                'user_id' => $users->random()->id,
                'message' => $messageText,
                'message_type' => 'text',
                'created_at' => now()->subMinutes(rand(1, 60)),
            ]);
        }

        // Create Support chat room
        $supportRoom = ChatRoom::create([
            'name' => 'Customer Support',
            'description' => 'Customer support and help desk',
            'type' => 'support',
            'created_by' => $users->first()->id,
        ]);

        // Add first 3 users to support room
        foreach ($users->take(3) as $index => $user) {
            ChatParticipant::create([
                'chat_room_id' => $supportRoom->id,
                'user_id' => $user->id,
                'role' => $index === 0 ? 'admin' : 'member',
                'joined_at' => now(),
            ]);
        }

        // Create Private chat room
        if ($users->count() >= 2) {
            $privateRoom = ChatRoom::create([
                'name' => 'Management Team',
                'description' => 'Private discussion for management',
                'type' => 'private',
                'created_by' => $users->first()->id,
            ]);

            // Add first 2 users to private room
            foreach ($users->take(2) as $index => $user) {
                ChatParticipant::create([
                    'chat_room_id' => $privateRoom->id,
                    'user_id' => $user->id,
                    'role' => $index === 0 ? 'admin' : 'member',
                    'joined_at' => now(),
                ]);
            }
        }
    }
}
