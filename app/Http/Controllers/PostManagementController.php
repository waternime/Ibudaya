<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%$search%")
                ->orWhere('id', $search);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts', compact('posts'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus!');
    }
}
