<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;
use App\Http\Controllers\JobController;
use App\Mail\JobPosted;

Route::get('/', function () {
    return view('home');
});

Route::get('/contact', function () {
    return view('contact');
});

// Public routes - these should be available to everyone
Route::get('/jobs', [JobController::class, 'index']);

// Routes requiring authentication
Route::middleware(['auth'])->group(function () {
    // Specific routes must come before pattern routes
    Route::get('/jobs/create', [JobController::class, 'create']);
    Route::post('/jobs', [JobController::class, 'store']);
    
    // Dynamic routes with parameters come after specific routes
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit']);
    Route::patch('/jobs/{job}', [JobController::class, 'update']);
    Route::delete('/jobs/{job}', [JobController::class, 'destroy']);
});

// This route must come after the more specific /jobs/create route
Route::get('/jobs/{job}', [JobController::class, 'show']);

// Authentication Routes
Route::get('/register', [App\Http\Controllers\RegisterUserController::class, 'create']);
Route::post('/register', [App\Http\Controllers\RegisterUserController::class, 'store']);

Route::get('/login', [App\Http\Controllers\SessionController::class, 'create'])->name('login');
Route::post('/login', [App\Http\Controllers\SessionController::class, 'store']);
Route::post('/logout', [App\Http\Controllers\SessionController::class, 'destroy'])->middleware('auth');

