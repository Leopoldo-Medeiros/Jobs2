<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Job;
use App\Models\Employer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call(RolesAndPermissionsSeeder::class);
        
        // Create a test user with a known email and password
        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password') // Setting a known password for easy login
        ]);

        // Assign employer role
        $user->assignrole('employer');
        Log::info("Assigned employer role to user: " . $user->email);

        // Create an employer linked to this user
        $employer = Employer::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Company'
        ]);

        // Create some jobs belonging to this employer
        Job::factory(5)->create([
            'employer_id' => $employer->id
        ]);

        // Create an admin user
        $adminUser = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);

        // Assign admin role
        $adminUser->assignRole('admin');
        Log::info("Assigned admin role to user: " . $adminUser->email);

        // Create an employer for the admin as well so they can create jobs
        Employer::factory()->create([
            'user_id' => $adminUser->id,
            'name' => 'Admin Company'
        ]);

        // Create some additional random users with employers and jobs
        User::factory(3)->create()->each(function($user) {

            // Assign employer role
            $user->assignRole('employer');

            // Create an employer for the user
            $employer = Employer::factory()->create([
                'user_id' => $user->id
            ]);
            
            Job::factory(2)->create([
                'employer_id' => $employer->id
            ]);
        });
    }
}
