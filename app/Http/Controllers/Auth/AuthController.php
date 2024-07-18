<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Menyimpan input email ke dalam sesi
        Session::flash('email', $request->input('email'));

        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Masukkan email',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Masukkan password',
        ]);

        // Mengambil data input
        $credentials = $request->only('email', 'password');

        // Mencoba otentikasi pengguna
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role_id == '1') {
                return redirect()->route('produsen.dashboard');
            }
            elseif ($user->role_id == '2') {
                return redirect()->route('distributor.dashboard');
            }
            elseif ($user->role_id == '3') {
                return redirect()->route('agen.dashboard');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('Anda berhasil logout');
    }
}
