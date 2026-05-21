<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('training_user', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('status');
            $table->string('qualification')->nullable()->after('phone');
            $table->text('notes')->nullable()->after('qualification');
            $table->string('preferred_timing', 50)->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('training_user', function (Blueprint $table) {
            $table->dropColumn(['phone', 'qualification', 'notes', 'preferred_timing']);
        });
    }
};
