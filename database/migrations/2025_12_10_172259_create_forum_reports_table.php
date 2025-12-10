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
        if (Schema::hasTable('forum_reports')) {
            return;
        }

       Schema::create('forumreports', function (Blueprint $table) {
         $table->id();
         $table->foreignId('post_id')->constrained('forum_posts')->onDelete('cascade');
         $table->foreignId('forumreporter_id')->constrained('users')->onDelete('cascade');
         $table->text('reason')->nullable();
         $table->string('status')->default('pending'); // pending, reviewed, dismissed
         $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_reports');
    }
};
