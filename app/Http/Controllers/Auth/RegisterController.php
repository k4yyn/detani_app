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
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $isFirstUser = User::count() == 0;

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $isFirstUser ? 'admin' : 'user',
    ]);

    event(new Registered($user));

    Auth::login($user);

    // Redirect dengan intended untuk menghindari masalah redirect
    return redirect()->intended(
        $user->role === 'admin' 
            ? route('admin.dashboard')
            : route('transaksi.index')
    );
}
}