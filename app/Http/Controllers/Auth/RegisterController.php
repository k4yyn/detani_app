<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller 
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // app/Http/Controllers/Auth/RegisterController.php

public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:6',
        'role' => 'required|in:user,admin',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => $validated['role'],
        'is_approved' => false, // belum disetujui
    ]);

    return redirect()->route('login')->with('status', 'Registration successful, waiting for admin approval');
}
}