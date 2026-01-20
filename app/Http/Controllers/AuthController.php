<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Anggota;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function loginSiswa(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('anggota')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/siswa/dashboard');
        }

        return back()->withErrors([
            'username_siswa' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:anggota,nis',
            'nama_anggota' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'username' => 'required|unique:anggota,username',
            'password' => 'required|min:4',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Anggota::create($validated);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('anggota')->check()) {
            Auth::guard('anggota')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
