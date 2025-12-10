<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * (This runs when you type: php artisan migrate)
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user'); // Adds the 'role' column
            $table->boolean('is_blocked')->default(false); // Adds the 'is_blocked' column
        });
    }

    /**
     * Reverse the migrations.
     * (This runs when you type: php artisan migrate:rollback)
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_blocked']); // Removes columns if you roll back
        });
    }
};