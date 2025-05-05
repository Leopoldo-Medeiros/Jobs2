<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'first_name' => 'required|min:2|max:255',
            'last_name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:255|confirmed',
        ]);

        $user = User::create([
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
        ]);

        // Assign the default 'job_seeker' role to the newly registered user
        $user->assignRole('job_seeker');

        // Log in the user and regenerate the session
        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')->with('success', 'Your account has been created!');
    }
}

