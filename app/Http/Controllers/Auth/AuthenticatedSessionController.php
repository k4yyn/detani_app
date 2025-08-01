<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   
   public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Cek apakah sudah ada admin
    $adminExists = \App\Models\User::where('role', 'admin')->exists();

    // Kalau sudah ada admin, cek apakah user disetujui
    if ($adminExists && !$user->is_approved) {
        return back()->withErrors([
            'email' => 'Akun Anda belum disetujui oleh admin.',
        ]);
    }


    Auth::login($user, $request->boolean('remember'));

    $request->session()->regenerate();

    return redirect()->intended(
        $user->role === 'admin'
            ? route('admin.dashboard')
            : route('user.transaksi.index')
    );
}

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
