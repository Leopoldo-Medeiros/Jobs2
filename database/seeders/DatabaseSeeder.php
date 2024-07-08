<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Job; // Ensure this line correctly references the Job model
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Leo',
            'last_name' => 'Medeiros',
            'email' => 'test@example.com',
        ]);

        // We use this for when we want to trigger the job seeder class
        $this->call(JobSeeder::class);
    }
}
