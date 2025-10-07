<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Notification;

class LikeController extends Controller
{
    public function toggleLike(Post $post)
    {
        $user = auth()->user();

        // cek apakah sudah like
        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->where('user_id', $user->id)->delete(); // unlike
        } else {
            $post->likes()->create(['user_id' => $user->id]); // like

            // buat notifikasi ke pemilik post
            Notification::create([
                'user_id' => $post->user_id,   // pemilik post
                'post_id' => $post->id,        // id postingan
                'type'    => 'like',
                'message' => $user->name . ' menyukai postingan kamu',
            ]);
        }

        return back();
    }
}