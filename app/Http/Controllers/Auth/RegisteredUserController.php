<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
{
    // Validasi data input
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    // Tentukan apakah pengguna pertama kali
    $isFirstUser = User::count() == 0;

    // Membuat pengguna baru
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $isFirstUser ? 'admin' : 'user', // Menetapkan role admin untuk pengguna pertama
    ]);

    // Menyimpan event registrasi
    event(new Registered($user));

    // Melakukan login otomatis
    Auth::login($user);

    // Redirect ke halaman sesuai role atau dashboard
    return redirect()->route('user.transaksi'); // Atau route lainnya sesuai kebutuhan
}
}