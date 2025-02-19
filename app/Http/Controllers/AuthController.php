<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login()
    {
        return view('auth.login');
    }
    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Respons JSON jika login berhasil
            return response()->json([
                'success' => true,
                'redirect' => url('/'), // Ganti URL sesuai kebutuhan
            ]);
        } else {
            // Respons JSON jika login gagal
            return response()->json([
                'success' => false,
                'message' => "Wrong Email or Password",
            ], 401); // Status 401 untuk login gagal
        }
    }
    public function register()
    {
        return view('auth.register');
    }
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
