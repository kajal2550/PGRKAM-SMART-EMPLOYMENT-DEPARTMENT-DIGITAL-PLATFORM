<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_id')->constrained('job_listings')->cascadeOnDelete();
            $table->string('applicant_name');
            $table->string('applicant_email');
            $table->string('phone', 20);
            $table->string('experience')->default('Fresher');
            $table->string('qualification');
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected'])->default('pending');
            $table->timestamps();
            $table->unique(['user_id', 'job_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
