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
    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs.index', ['jobs' => $jobs]);
});

// CREATE
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// SHOW
Route::get('/jobs/{id}', function ($id) {
//    $job = Arr::first(Job::all(), fn($job) => $job['id'] == $id);
    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});

// STORE
Route::post('/jobs', function () {
    // dd(request('title'));
    // Validation...
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    Job::create([
      'title' => request('title'),
      'salary' => request('salary'),
      'employer_id' => 1
    ]);

    return redirect('/jobs');
});

// EDIT
Route::get('/jobs/{id}/edit', function ($id) {
//    $job = Arr::first(Job::all(), fn($job) => $job['id'] == $id);
    $job = Job::find($id);

    return view('jobs.edit', ['job' => $job]);
});

// This route shows the contact page
Route::get('/contact', function () {
    return view('contact');
});
