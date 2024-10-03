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
            $table->unsignedBigInteger('employer_id'); // Foreign key for employer
            $table->string('title');
            $table->string('salary');
            $table->timestamps(); // This creates created_at and updated_at columns
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
