<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("chat_id")->constrained("chats")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("member_id")->constrained("chat_members")->cascadeOnDelete()->cascadeOnUpdate();
            $table->text("message");
            $table->enum("message_type", ["text", "image", "video", "audio", "document"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
