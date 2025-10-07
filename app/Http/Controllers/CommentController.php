<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;

class CommentController extends Controller
{
    /**
     * Simpan komentar baru atau balasan
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content'   => 'required|string|max:500',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = $post->comments()->create([
            'user_id'   => auth()->id(),
            'content'   => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        // Notifikasi ke pemilik post
        if ($post->user_id !== auth()->id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'post_id' => $post->id,
                'type'    => 'comment',
                'message' => auth()->user()->name . ' berkomentar di postingan kamu',
            ]);
        }

        // Notifikasi ke pemilik komentar induk
        if ($request->parent_id) {
            $parent = Comment::find($request->parent_id);
            if ($parent && $parent->user_id !== auth()->id()) {
                Notification::create([
                    'user_id' => $parent->user_id,
                    'post_id' => $post->id,
                    'type'    => 'reply',
                    'message' => auth()->user()->name . ' membalas komentar kamu',
                ]);
            }
        }

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Update komentar
     */
    public function update(Request $request, Comment $comment)
    {
        abort_if($comment->user_id !== auth()->id(), 403);

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update(['content' => $request->content]);

        return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    /**
     * Hapus komentar + semua reply
     */
    public function destroy(Comment $comment)
    {
        abort_if($comment->user_id !== auth()->id(), 403);

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}