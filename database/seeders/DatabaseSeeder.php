<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Job;
use App\Models\Employer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user with a known email and password
        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password') // Setting a known password for easy login
        ]);

        // Create an employer linked to this user
        $employer = Employer::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Company'
        ]);

        // Create some jobs belonging to this employer
        Job::factory(5)->create([
            'employer_id' => $employer->id
        ]);

        // Create some additional random users with employers and jobs
        User::factory(3)->create()->each(function($user) {
            $employer = Employer::factory()->create([
                'user_id' => $user->id
            ]);
            
            Job::factory(2)->create([
                'employer_id' => $employer->id
            ]);
        });
    }
}
