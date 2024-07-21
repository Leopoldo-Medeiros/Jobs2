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
    $job = Job::find($id);

    return view('jobs.edit', ['job' => $job]);
});

// UPDATE
// Process:
// #1. It'll submit the form to the server
// #2. It'll update the job in the database
// #3. It'll redirect the user to the job page
Route::put('/jobs/{id}', function ($id) {
    // validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);
    // authorize (On hold ...)
    $job = Job::findOrFail($id); // null (In the scenario the job doesn't exist in the database)

    $job->update([
        'title' => request('title'),
        'salary' => request('salary')
    ]);
    // redirect the job page
    return redirect('/jobs/' . $job->id);
});

// DESTROY
Route::delete('/jobs/{id}', function ($id) {
    // authorize (On hold...)
    Job::findOrFail($id)->delete();

    return redirect('/jobs');
});

// This route shows the contact page
Route::get('/contact', function () {
    return view('contact');
});
