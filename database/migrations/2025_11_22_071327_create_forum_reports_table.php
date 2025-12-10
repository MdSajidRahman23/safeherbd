<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forum_reports', function (Blueprint $table) {
            $table->id();

            // Which post is being reported
            $table->foreignId('post_id')
                  ->constrained('forum_posts')
                  ->onDelete('cascade');

            // Who reported it
            $table->foreignId('user_id')
                  ->constrained();  // No cascade so reports remain for review

            $table->string('reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_reports');
    }
};
