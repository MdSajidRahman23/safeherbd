<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure users table has role and is_admin
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'role')) {
                    $table->string('role')->default('user')->after('email');
                }

                if (!Schema::hasColumn('users', 'is_admin')) {
                    $table->boolean('is_admin')->default(false)->after('role');
                }
            });
        }

        // Ensure sos_alerts table exists with required columns
        if (!Schema::hasTable('sos_alerts')) {
            Schema::create('sos_alerts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->double('latitude');
                $table->double('longitude');
                $table->text('message')->nullable();
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        } else {
            // Ensure columns exist if table is present
            Schema::table('sos_alerts', function (Blueprint $table) {
                if (!Schema::hasColumn('sos_alerts', 'latitude')) {
                    $table->double('latitude');
                }
                if (!Schema::hasColumn('sos_alerts', 'longitude')) {
                    $table->double('longitude');
                }
                if (!Schema::hasColumn('sos_alerts', 'message')) {
                    $table->text('message')->nullable();
                }
                if (!Schema::hasColumn('sos_alerts', 'status')) {
                    $table->string('status')->default('pending');
                }
            });
        }
    }

    public function down(): void
    {
        // noop - do not drop columns/tables on rollback to avoid data loss
    }
};
