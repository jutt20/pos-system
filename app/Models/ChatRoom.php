<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'created_by',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ChatParticipant::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_participants')
                    ->withPivot(['role', 'joined_at', 'last_read_at', 'is_active'])
                    ->withTimestamps();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function latestMessage(): HasMany
    {
        return $this->messages()->latest();
    }

    public function unreadMessagesCount($userId): int
    {
        $participant = $this->participants()->where('user_id', $userId)->first();
        
        if (!$participant || !$participant->last_read_at) {
            return $this->messages()->count();
        }

        return $this->messages()
                    ->where('created_at', '>', $participant->last_read_at)
                    ->where('user_id', '!=', $userId)
                    ->count();
    }
}
