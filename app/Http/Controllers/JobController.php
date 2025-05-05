<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\Employer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Mail\JobPosted;

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
        try {
            // Eager load the employer relationship and the employer's job count
            $job->load(['employer', 'employer.jobs']);
            
            return view('jobs.show', ['job' => $job]);
        } catch (\Exception $e) {
            abort(404, 'Job not found');
        }
    }

    public function store(): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        // Get the authenticated user's employer
        $user = auth()->user();
        $employer = $user->employer;
        
        // If user doesn't have an employer record yet, create one
        if (!$employer && ($user->hasRole('admin') || $user->hasRole('employer'))) {
            $employer = Employer::create([
                'user_id' => $user->id,
                'name' => $user->first_name . ' ' . $user->last_name . '\'s Company'
            ]);
        }

        if (!$employer) {
            abort(403, 'You need an employer profile to create jobs.');
        }

        // Format the salary
        $salary = request('salary');
        // Remove any non-numeric characters except decimal point
        $salary = preg_replace('/[^0-9.]/', '', $salary);
        // Format as currency
        $salary = '$' . number_format((float)$salary, 0, '.', ',');

        $job = Job::create([
            'title' => request('title'),
            'salary' => $salary,
            'employer_id' => $employer->id,
            'is_remote' => request('is_remote', false),
            'is_featured' => request('is_featured', false),
            'employment_type' => request('employment_type', 'Full Time')
        ]);

        // Only send mail if the mail class exists
        if (class_exists(JobPosted::class)) {
            try {
                Mail::to($job->employer->user)->queue(
                    new JobPosted($job)
                );
            } catch (\Exception $e) {
                // Log the error but don't fail the job creation
                \Log::error('Failed to send job posting email: ' . $e->getMessage());
                return redirect('/jobs')->with('success', 'Job posted successfully! (Email notification could not be sent due to rate limits)');
            }
        }

        return redirect('/jobs')->with('success', 'Job posted successfully!');
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
