<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a user without the 'name' field
        User::factory()->create([
            'first_name' => 'Leo', // Add first name if needed
            'last_name' => 'Medeiros',   // Add last name if needed
            'email' => 'test@email.com',
            'password' => bcrypt('password'), // Ensure you hash passwords
        ]);
    }
}
