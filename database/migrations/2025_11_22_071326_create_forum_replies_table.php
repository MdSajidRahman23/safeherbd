<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forum_replies', function (Blueprint $table) {
            $table->id();

            // Link reply to post
            $table->foreignId('post_id')
                  ->constrained('forum_posts')
                  ->onDelete('cascade');

            // Link reply to user
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->text('reply_text');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_replies');
    }
};
