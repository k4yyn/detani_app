<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // Menampilkan halaman profil pengguna
    public function index()
    {
        $users = User::where('is_approved', false)->get();
        return view('admin.users.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'User disetujui.');
    }


    // Menampilkan halaman untuk mengedit profil pengguna
    public function edit()
    {
        return view('user.profile.edit', [
            'user' => Auth::user() // Mengambil data pengguna yang sedang login untuk diedit
        ]);
    }

    // Memperbarui data profil pengguna
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password diubah, update password
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    // Menghapus akun pengguna
    public function destroy()
    {
        $user = Auth::user();
        $user->delete();

        Auth::logout();

        return redirect()->route('login')->with('success', 'Akun Anda berhasil dihapus.');
    }
}
