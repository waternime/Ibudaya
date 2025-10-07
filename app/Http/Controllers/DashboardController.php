<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan user login
        $this->middleware('auth');

        // Ambil semua postingan milik user, termasuk kategori musik
        $posts = Post::where('user_id', Auth::id())
                     ->latest()
                     ->get();

        return view('profile', compact('posts'));
    }
}