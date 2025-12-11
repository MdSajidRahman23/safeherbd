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
         if (Schema::hasTable('forum_replies')) {
            return;
        }
        Schema::create('forum_replies', function (Blueprint $table) {
        $table->id();
        // post id
        $table->foreignId('post_id')->constrained('forum_posts')->onDelete('cascade'); 
        // user id
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
        $table->text('reply_text');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_replies');
    }
};
