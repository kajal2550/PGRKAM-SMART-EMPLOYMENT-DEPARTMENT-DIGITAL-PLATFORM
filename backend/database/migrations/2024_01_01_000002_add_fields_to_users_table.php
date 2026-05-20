<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Extends the default users table with PGRKAM-specific columns.
 * Run after the default create_users_table migration.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 15)->nullable()->after('email');
            $table->enum('role', ['user', 'admin'])->default('user')->after('phone');
            $table->string('district')->nullable()->after('role');
            $table->string('qualification')->nullable();
            $table->string('skills')->nullable();
            $table->string('profile_photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'role', 'district', 'qualification',
                'skills', 'profile_photo', 'is_active', 'last_login_at',
            ]);
        });
    }
};
