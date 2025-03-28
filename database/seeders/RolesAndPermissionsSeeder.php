<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Job permissions
            'view jobs',
            'create jobs',
            'edit jobs',
            'delete jobs',
            
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Add other permissions as needed
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Employer role
        $employerRole = Role::create(['name' => 'employer']);
        $employerRole->givePermissionTo([
            'view jobs',
            'create jobs',
            'edit jobs',
            'delete jobs',
        ]);
        
        // Job seeker role
        $jobSeekerRole = Role::create(['name' => 'job_seeker']);
        $jobSeekerRole->givePermissionTo([
            'view jobs',
        ]);
        
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
} 