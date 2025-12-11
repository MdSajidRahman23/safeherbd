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
        Schema::table('safe_routes', function (Blueprint $table) {
            $table->integer('theft_count')->default(0)->after('total_score');
            $table->integer('robbery_count')->default(0)->after('theft_count');
            $table->integer('kidnapping_count')->default(0)->after('robbery_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('safe_routes', function (Blueprint $table) {
            $table->dropColumn(['theft_count', 'robbery_count', 'kidnapping_count']);
        });
    }
};
