<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Upload foto profil
        if ($request->hasFile('profile_picture')) {
            // hapus foto lama
            if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                Storage::delete('public/' . $user->profile_picture);
            }

            // simpan foto baru
            $user->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui.');
    }
}