<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    public function edit(User $user, Job $job): bool 
    {
        // Allow admins to do everything
        if ($user->hasRole('admin')) {
            return true;
        }

        // Check if the user is the owner of the job
        if ($user->hasPermissionTo('edit jobs')) {
            return $job->employer->user->is($user);
        }

        return false;
    }

    public function delete(User $user, Job $job): bool
    {
        // Allow admins to delete jobs
        if ($user->hasPermissionTo('delete jobs')) {
            return $job->employer->user->is($user);
        }

        return false;
    }
}
