<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Menampilkan halaman profil untuk pengguna yang sedang login
    public function index()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));  // Menggunakan data pengguna yang sedang login
    }

    // Menampilkan form untuk membuat profil baru
    public function create()
    {
        return view('profile.create');
    }

    // Menyimpan data profil baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Mengarahkan ke halaman edit dengan ID pengguna baru yang dibuat
        return redirect()->route('profile.edit', $user->id)->with('success', 'Profil berhasil ditambahkan');
    }

    // Menampilkan form edit profil pengguna yang sedang login
    public function edit($id = null)
    {
        // Jika ID tidak diberikan, ambil pengguna yang sedang login
        if (!$id) {
            $user = Auth::user();
        } else {
            $user = User::findOrFail($id);  // Hanya untuk admin atau keperluan khusus
        }

        return view('profile.edit', compact('user'));
    }

    // Menyimpan perubahan profil
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Update informasi pengguna
    $user->name = $request->name;
    $user->email = $request->email;

    // Update password hanya jika diisi
    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    // Simpan perubahan
    $user->save();

    // Tambahkan session sukses
    return redirect()->route('profile.edit', $user->id)->with('success', 'Profil berhasil diperbarui');
    }

    // Menghapus profil
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil dihapus');
    }
}
