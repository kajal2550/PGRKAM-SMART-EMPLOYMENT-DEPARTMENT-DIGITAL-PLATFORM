<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('department');
            $table->string('location');
            $table->enum('type', ['government', 'private'])->default('government');
            $table->string('salary_range')->nullable();
            $table->text('description')->nullable();
            $table->json('qualifications')->nullable();    // array of required qualifications
            $table->integer('vacancies')->default(1);
            $table->date('application_deadline');
            $table->date('posted_on')->useCurrent();
            $table->string('apply_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
