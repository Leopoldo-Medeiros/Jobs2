<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;
use App\Http\Controllers\JobController;

Route::get('/', function () {
    return view('home');
});

Route::get('/contact', function () {
    return view('contact');
});

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/jobs/create', [JobController::class, 'create']);
    Route::post('/jobs', [JobController::class, 'store']);
});

// Public routes - these should be after the more specific /jobs/create route
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{job}', [JobController::class, 'show']);

// These routes will check the Gate::authorize in the controller methods
// and return 403 when unauthorized, regardless of authentication status
Route::get('/jobs/{job}/edit', [JobController::class, 'edit']);
Route::patch('/jobs/{job}', [JobController::class, 'update']);
Route::delete('/jobs/{job}', [JobController::class, 'destroy']);

// Authentication Routes
Route::get('/register', [App\Http\Controllers\RegisterUserController::class, 'create']);
Route::post('/register', [App\Http\Controllers\RegisterUserController::class, 'store']);

Route::get('/login', [App\Http\Controllers\SessionController::class, 'create'])->name('login');
Route::post('/login', [App\Http\Controllers\SessionController::class, 'store']);
Route::post('/logout', [App\Http\Controllers\SessionController::class, 'destroy'])->middleware('auth');

