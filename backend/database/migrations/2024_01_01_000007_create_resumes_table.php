<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->json('personal')->nullable();        // {name, email, phone, address, objective}
            $table->json('education')->nullable();       // array of education entries
            $table->json('experience')->nullable();      // array of experience entries
            $table->text('skills')->nullable();
            $table->string('languages')->nullable();
            $table->integer('score')->nullable();        // auto-computed resume score (0-100)
            $table->string('pdf_path')->nullable();      // path to generated PDF
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
