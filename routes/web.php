<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

// This route shows all jobs
Route::get('/jobs', function () {

    // Basically, it's asking to return all jobs WITH the employer for each job
    // This is the equivalent of a SQL query like:
    // SELECT * FROM jobs in SQL
    $jobs = Job::with('employer')->latest()->paginate(3);

    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

// This route shows the form to create a job
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// This route shows a single job
Route::get('/jobs/{id}', function ($id) {
//    $job = Arr::first(Job::all(), fn($job) => $job['id'] == $id);
    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});

Route::post('/jobs', function () {
//    dd(request('title'));
    // Validation...
    Job::create([
      'title' => request('title'),
      'salary' => request('salary'),
      'employer_id' => 1
    ]);

    return redirect('/jobs');
});

// This route shows the contact page
Route::get('/contact', function () {
    return view('contact');
});
