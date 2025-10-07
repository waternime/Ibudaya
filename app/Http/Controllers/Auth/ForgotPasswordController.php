<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'nullable|min:6|confirmed', // hanya valid kalau user input password
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Email tidak ditemukan'])->withInput();
            }

            // Jika ada input password, update langsung
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->route('login')->with('status', 'Password berhasil diubah.');
            }

            // Tampilkan form ganti password
            return view('auth.forgot-password', [
                'showPasswordForm' => true,
                'email' => $user->email
            ]);
        }

        // GET = tampil form email
        return view('auth.forgot-password');
    }
}