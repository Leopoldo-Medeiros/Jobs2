<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// INDEX
Route::get('/jobs', [JobController::class, 'index']);

// CREATE
Route::get('/jobs/create', [JobController::class, 'create']);

// SHOW
Route::get('/jobs/{job}', [JobController::class, 'show']);

// STORE
Route::post('/jobs', [JobController::class, 'store']);

// EDIT
Route::get('/jobs/{job}/edit', [JobController::class, 'edit']);

// UPDATE
Route::put('/jobs/{job}', [JobController::class, 'update']);

// DESTROY
Route::delete('/jobs/{job}', [JobController::class, 'destroy']);

// This route shows the contact page
Route::get('/contact', function () {
    return view('contact');
});
