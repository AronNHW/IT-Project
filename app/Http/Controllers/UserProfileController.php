<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function showProfile()
    {
        $settings = Setting::all()->keyBy('key');
        return view('user.profil', compact('settings'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.profil-settings', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_wa' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'no_wa']);

        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->update($data);

        return redirect()->route('user.profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}