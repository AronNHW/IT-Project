<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses permintaan login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        // Cek user dan bandingkan password (plain text)
        if ($user && $user->password === $credentials['password']) {
            // Jika berhasil, login-kan user
            Auth::login($user);
            $request->session()->regenerate();
            
            // Alihkan ke beranda user
            return redirect()->intended('/user/beranda');
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return back()->with('error', 'Email atau Kata Sandi salah.');
    }

    /**
     * Menampilkan form registrasi.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses permintaan registrasi.
     */
    public function register(Request $request)
    {
        // Aturan validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'no_wa' => 'required|string|max:20',
        ]);

        // Jika validasi gagal, kembali dengan error
        if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Buat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Simpan sebagai plain text
            'no_wa' => $request->no_wa,
            'role' => 'user',
        ]);

        // Alihkan ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan masuk.');
    }

    /**
     * Memproses permintaan logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Alihkan ke beranda user setelah logout
        return redirect('/user/beranda');
    }
}