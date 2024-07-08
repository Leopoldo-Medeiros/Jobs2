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
        Schema::create('job_listing', function (Blueprint $table) {
            $table->id();
            // foreign key called employer_id
            // The reason I am using unsignedBigInteger is because whenever I call the id above in a migration, it will be unsignedBigInteger
            // So when you generate your foreign key, you want to make sure that the type of foreign key matches the type of the primary key
            $table->unsignedBigInteger('employer_id');
            $table->string('title');
            $table->string('salary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listing');
    }
};
