<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika user sudah ada, login
                Auth::login($user);
                return redirect()->intended('/user/beranda');
            } else {
                // Jika user belum ada, buat akun baru
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(16)), // Buat password acak
                    'no_wa' => null,
                    'role' => 'user', // Default role untuk pendaftaran via Google
                ]);

                Auth::login($newUser);
                return redirect()->intended('/user/beranda');
            }

        } catch (\Exception $e) {
            // Tangani error, misalnya log error atau redirect dengan pesan error
            return redirect('/login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}
