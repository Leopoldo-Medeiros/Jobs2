<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\Employer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Authenticatable;

class JobController extends Controller
{
    public function __construct()
    {

    }
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        // Check if the user has permission to create jobs
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasPermissionTo('create jobs')) {
            abort(403, 'Unauthorized action. You do not have permission to create jobs.');
        }

        return view('jobs.create');
    }

    public function show(Job $job): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        // Eager load the employer relationship and the employer's job count
        $job->load(['employer', 'employer.jobs']);

        return view('jobs.show', ['job' => $job]);
    }

    public function store(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $attributes = request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required'],
            'about' => ['nullable']
        ]);

        // Check if the authenticated user exists
        $user = auth()->user();
        if (!$user) {
            return redirect('/jobs')->with('error', 'You need to be logged in to create jobs.');
        }

// Get the currently authenticated user model directly
        $userModel = auth()->user();

        // Get the employer associated with the user
        $employer = $userModel->employer;

        if (!$employer && $userModel->hasRole('admin')) {
            $employer = Employer::create([
                'user_id' => $userModel->id,
                'name' => 'Admin Company'
            ]);
        }

        // If the employer is not found, return an error
        if (!$employer) {
            return redirect('/jobs')->with('error', 'You need an employer account to create jobs. Please contact the administrator.');
        }

        // Associate the job with the current user's employer
        $attributes['employer_id'] = $employer->id;

        // Create the job
        Job::create($attributes);

        // Redirect to the jobs listing page
        return redirect('/jobs')->with('success', 'Job created successfully!');
    }

    public function edit(Job $job): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        // Admin can edit any job
        if (auth()->user()->hasRole('admin')) {
            return view('jobs.edit', ['job' => $job]);
        }

        // For non-admin users, check if they have edit permission and own this job
        if (!auth()->user()->can('edit', $job)) {
            abort(403, 'Unauthorized. You do not have permission to edit this job.');
        }

        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        // Admin can update any job
        if (!auth()->user()->hasRole('admin') && !auth()->user()->can('edit', $job)) {
            abort(403, 'Unauthorized action.');
        }

        $attributes = request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required'],
            'about' => ['nullable']
        ]);

        $job->update($attributes);

        // Redirect to the job details page with a success message
        return redirect('/jobs/' . $job->id)->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        // Admin can delete any job
        if (!auth()->user()->hasRole('admin') && !auth()->user()->can('delete', $job)) {
            abort(403, 'Unauthorized action.');
        }

        $job->delete();

        return redirect('/jobs')->with('success', 'Job deleted successfully!');
    }
}
