<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_room_id');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->enum('message_type', ['text', 'image', 'file', 'system'])->default('text');
            $table->json('attachments')->nullable();
            $table->boolean('is_edited')->default(false);
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();

            $table->foreign('chat_room_id')->references('id')->on('chat_rooms')->onDelete('cascade');
            $table->index(['chat_room_id', 'created_at']);
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
};
