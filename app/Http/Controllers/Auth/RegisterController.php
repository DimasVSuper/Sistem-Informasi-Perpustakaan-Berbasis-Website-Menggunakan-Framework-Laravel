<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the form data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,pustakawan,anggota',
        ]);

        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect()->intended('/dashboard');
        } elseif ($user->role === 'pustakawan') {
            return redirect()->intended('/pustakawan/dashboard');
        } elseif ($user->role === 'anggota') {
            return redirect()->intended('/anggota/dashboard');
        }
    }
}
