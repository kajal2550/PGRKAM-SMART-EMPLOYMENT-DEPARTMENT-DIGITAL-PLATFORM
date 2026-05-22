<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            // Fix: controller saves these as flat text — add them if missing
            $table->text('objective')->nullable()->after('user_id');
            $table->text('certifications')->nullable()->after('languages');
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn(['objective', 'certifications']);
        });
    }
};
