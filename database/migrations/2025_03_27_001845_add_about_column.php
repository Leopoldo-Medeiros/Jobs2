<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First add the column to the table
        Schema::table('job_listings', function (Blueprint $table) {
            $table->text('about')->nullable();
        });
        
        // Then reposition it after the salary column
        DB::statement('ALTER TABLE job_listings MODIFY about TEXT NULL AFTER salary');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn('about');
        });
    }
};
