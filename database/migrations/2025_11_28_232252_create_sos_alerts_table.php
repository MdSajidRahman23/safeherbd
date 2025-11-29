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
        Schema::create('sos_alerts', function (Blueprint $table) {
            $table->id();
            // এই লাইনগুলো যোগ করুন
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // কে অ্যালার্ট দিল
            $table->string('latitude');
            $table->string('longitude');
            $table->string('status')->default('pending');
            $table->text('message')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sos_alerts');
    }
};
