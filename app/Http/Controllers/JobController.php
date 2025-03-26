<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Authenticatable;

class JobController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('jobs.create');
    }

    public function show(Job $job): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function store(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $attributes = request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required'],
            'about' => ['nullable']
        ]);

// Check if the authenticated user exists and has employer relationship
        $user = auth()->user();
        if (!$user) {
            return redirect('/jobs')->with('error', 'You need to be logged in to create jobs.');
        }

// Get the employer associated with the user
        // Cast to User model to access the employer relationship
        $userModel = User::find($user->id);
        $employer = $userModel->employer;
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
        // Skip auth check and go directly to 403 error
        // This will now return 403 even for unauthenticated users
        abort_unless(Gate::allows('edit', $job), 403, 'Unauthorized. You do not have permission to edit this job.');

        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        // Skip auth check and go directly to 403 error
        abort_unless(Gate::allows('edit', $job), 403, 'Unauthorized action.');

        $attributes = request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required'],
            'about' => ['nullable']
        ]);

        $job->update($attributes);

        // Redirect to the jobs listing page
        return redirect('/jobs')->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        if (Gate::denies('edit', $job)) {
            abort(403, 'Unauthorized action.');
        }

        $job->delete();

        return redirect('/jobs')->with('success', 'Job deleted successfully!');
    }
}
