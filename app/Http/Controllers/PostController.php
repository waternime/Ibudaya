<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // method index
    public function index(Request $request)
    {
        $query = $request->input('search');

        $posts = Post::when($query, function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('id', $query);
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('Posts.index', compact('posts'));
    }

    // tambahkan method search
    public function search(Request $request)
    {
        $query = $request->input('search');

        $posts = Post::when($query, function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('id', $query);
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('Posts.search', compact('posts'));
    }

    // Halaman Upload
    public function create()
    {
        return view('upload');
    }

    // Proses Simpan
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:5000',
            'category'      => 'required|in:images,music,videos,docs',
            'file_category' => 'required|string|max:255',
            'province'      => 'required|string|max:255',
            'file'          => [
                'required',
                'file',
                'max:10240', // max 10MB
                function ($attribute, $value, $fail) use ($request) {
                    $mime = $value->getMimeType();
                    $category = $request->category;

                    $validMimes = [
                        'images' => ['image/jpeg','image/png','image/gif','image/webp'],
                        'music'  => ['audio/mpeg','audio/wav','audio/ogg'],
                        'videos' => ['video/mp4','video/webm','video/ogg'],
                        'docs'   => [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'text/plain',
                        ]
                    ];

                    if (!isset($validMimes[$category]) || !in_array($mime, $validMimes[$category])) {
                        $fail("File tidak sesuai dengan kategori $category.");
                    }
                }
            ],
            'cover'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $file = $request->file('file');

        // Simpan file utama ke folder sesuai kategori
        $filePath = $file->store($request->category, 'public');

        // Simpan cover kalau ada
        $coverPath = $request->hasFile('cover') 
            ? $request->file('cover')->store('covers', 'public') 
            : null;

        // Tentukan doc_type otomatis
        $docType = null;
        if ($request->category === 'docs') {
            $ext = strtolower($file->getClientOriginalExtension());

            if (in_array($ext, ['pdf'])) {
                $docType = 'pdf';
            } elseif (in_array($ext, ['doc', 'docx'])) {
                $docType = 'word';
            } elseif (in_array($ext, ['xls', 'xlsx'])) {
                $docType = 'excel';
            } elseif (in_array($ext, ['ppt', 'pptx'])) {
                $docType = 'ppt';
            } elseif (in_array($ext, ['txt'])) {
                $docType = 'text';
            } else {
                $docType = 'other';
            }
        }

        // Simpan ke database
        Post::create([
            'title'         => $request->title,
            'file_path'     => $filePath,
            'cover_path'    => $coverPath,
            'category'      => $request->category,
            'file_category' => $request->file_category,
            'province'      => $request->province,
            'doc_type'      => $docType,
            'user_id'       => auth()->id(),
        ]);

        return redirect()->route('posts.latest')
                        ->with('success', 'Postingan berhasil diupload!');
    }

    public function latest(Request $request)
    {
        $query = \App\Models\Post::query();

        // Filter provinsi (default: semua)
        if ($request->filled('province') && $request->province !== '__none__') {
            $query->where('province', $request->province);
        }

        // Filter kategori file utama (images, music, videos, docs)
        if ($request->filled('category') && $request->category !== '__none__') {
            $query->where('category', $request->category);
        }

        // Filter kategori budaya (pakaian_adat, makanan_khas, dll.)
        if ($request->filled('file_category') && $request->file_category !== '__none__') {
            $query->where('file_category', $request->file_category);
        }

        // Urutkan terbaru
        $posts = $query->orderBy('created_at', 'desc')->get();

        return view('posts.latest', compact('posts'));
    }

    public function popular()
    {
        $posts = Post::withCount('likes')
            ->where('category', '!=', 'music') // kecuali musik
            ->where(function ($query) {
                $query->whereNotNull('cover_path')
                    ->orWhere(function ($q) {
                        $q->where('category', 'images')
                            ->where(function ($q2) {
                                $q2->where('file_path', 'like', '%.jpg')
                                    ->orWhere('file_path', 'like', '%.jpeg')
                                    ->orWhere('file_path', 'like', '%.png')
                                    ->orWhere('file_path', 'like', '%.gif')
                                    ->orWhere('file_path', 'like', '%.webp');
                            });
                    });
            })
            ->orderBy('likes_count', 'desc')
            ->take(12)
            ->get(); // ambil semua, tanpa paginate

        return view('posts.popular', compact('posts'));
    }

    public function images()
    {
        $posts = Post::where('category', 'images')
                    ->latest()
                    ->get(); // ambil semua tanpa pagination

        return view('posts.images', compact('posts'));
    }

    public function music()
    {
        // Ambil semua post yang kategorinya musik
        $posts = Post::where('category', 'music')
                    ->latest()
                    ->get();

        return view('posts.music', compact('posts'));
    }

    public function videos()
    {
        // Ambil semua post yang kategorinya videos
        $posts = Post::where('category', 'videos')
                    ->latest()
                    ->get();

        return view('posts.videos', compact('posts'));
    }

    public function docs()
    {
        $posts = Post::where('category', 'docs')
             ->latest()
             ->get();

        return view('posts.docs', compact('posts'));
    }

    public function toggleLike(Post $post)
    {
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            // kalau sudah like → unlike
            $post->likes()->where('user_id', $user->id)->delete();
        } else {
            // kalau belum like → like
            $post->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }
    // Download Dokumen
    public function download($id)
    {
        $post = Post::findOrFail($id);

        if (!$post->file_path) {
            abort(404, 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $post->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($filePath, basename($filePath));
    }
    // Preview Dokumen
    public function preview($id)
    {
        $post = Post::findOrFail($id);

        if (!$post->file_path || !Str::endsWith($post->file_path, 'pdf')) {
            abort(404, 'Preview hanya tersedia untuk PDF.');
        }

        $filePath = storage_path('app/public/' . $post->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }
    // MyFiles
    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('posts.edit', compact('post'));
    }
    // Update postingan
    public function update(Request $request, Post $post)
    {
        // Cek kepemilikan post
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        // Validasi input
        $request->validate([
            'title'         => 'required|string|max:255',
            'category'      => 'required|string|max:100',
            'file_category' => 'required|string|max:100',
            'province'      => 'required|string|max:100', // input dari form
            'file_path'     => 'nullable|file|max:10240', // 10MB
            'cover_path'    => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        // Update field dasar
        $post->title         = $request->title;
        $post->category      = $request->category;
        $post->file_category = $request->file_category;
        $post->province      = $request->province; // <- sesuai input form

        // Update file utama jika ada upload baru
        if ($request->hasFile('file_path')) {
            if ($post->file_path && Storage::exists('public/' . $post->file_path)) {
                Storage::delete('public/' . $post->file_path);
            }
            // Simpan file sesuai kategori budaya
            $post->file_path = $request->file('file_path')->store($request->file_category, 'public');
        }

        // Update cover jika ada upload baru
        if ($request->hasFile('cover_path')) {
            if ($post->cover_path && Storage::exists('public/' . $post->cover_path)) {
                Storage::delete('public/' . $post->cover_path);
            }
            $post->cover_path = $request->file('cover_path')->store('covers', 'public');
        }

        $post->save();

        return redirect()->route('profile')->with('success', 'Postingan berhasil diperbarui.');
    }

    // Hapus postingan
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        if ($post->file_path && Storage::exists('public/' . $post->file_path)) {
            Storage::delete('public/' . $post->file_path);
        }

        if ($post->cover_path && Storage::exists('public/' . $post->cover_path)) {
            Storage::delete('public/' . $post->cover_path);
        }

        $post->delete();

        return redirect()->route('profile')->with('success', 'Postingan berhasil dihapus.');
    }

    // Detail postingan
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}