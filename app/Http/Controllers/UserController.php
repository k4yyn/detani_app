<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // Menampilkan semua user untuk admin
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Approve user
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'User berhasil disetujui.');
    }

    // Hapus user
    public function destroy($id)
    {
        // Prevent admin from deleting themselves
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    // Edit user role (fitur tambahan)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update user role
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Role user berhasil diupdate.');
    }

    // Menampilkan halaman untuk mengedit profil pengguna
    public function editProfile()
    {
        return view('user.profile.edit', [
            'user' => Auth::user()
        ]);
    }

    // Memperbarui data profil pengguna
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    // Menghapus akun pengguna
    public function destroyProfile()
    {
        $user = Auth::user();
        $user->delete();

        Auth::logout();

        return redirect()->route('login')->with('success', 'Akun Anda berhasil dihapus.');
    }
}