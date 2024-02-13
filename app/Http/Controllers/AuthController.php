<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.'
        ]);

        if (Auth::attempt($credentials)) {
            // cek user status active
            if (Auth::user()->status != 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('login')->with('status', 'Akun Anda Belum Aktif, Silahkan Hubungi Admin atau Petugas!');
            }

            $request->session()->regenerate();
            if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
                return redirect('dashboard')->with('success', 'Login Berhasil');
            }

            // if (Auth::user()->role_id == 2) {
            //     return redirect('dashboard')->with('success', 'Login Berhasil');
            // }

            if (Auth::user()->role_id == 3) {
                return redirect('log-peminjaman-anggota')->with('success', 'Login Berhasil');
            }
        }

        return redirect('login')->with('invalid', 'Username atau Password yang Anda masukkan Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register_proses(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'password' => 'required|max:255',
            'phone' => 'max:255',
            'address' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'address.required' => 'Address wajib diisi.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => 3,
        ]);

        return redirect('register')->with('status_sukses', 'Register Berhasil. Tunggu Admin atau Petugas Untuk Persetujuan');
    }
}
