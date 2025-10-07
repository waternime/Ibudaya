@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">🎬 Video</h2>

    @if ($posts->count() > 0)
        @foreach ($posts as $post)
            @if ($post->category === 'videos' && $post->file_path)
                <div class="mb-10 border rounded-lg shadow bg-white">
                    {{-- Header Post --}}
                    <div class="flex items-center justify-between px-4 py-3 border-b">
                        <p class="font-semibold">{{ $post->title }}</p>
                    </div>

                    {{-- Menampilkan Video --}}
                    <div class="w-full bg-black flex justify-center">
                        <video controls class="max-h-[500px] object-contain w-full">
                            <source src="{{ asset('storage/' . $post->file_path) }}" type="video/mp4">
                            Browser kamu tidak mendukung video.
                        </video>
                    </div>

                    {{-- Thumbnail / Cover disembunyikan --}}
                    @if ($post->cover_path)
                        <div class="text-center hidden" id="thumbnail-{{ $post->id }}">
                            <img src="{{ asset('storage/' . $post->cover_path) }}" 
                                 alt="Cover Video {{ $post->title }}" 
                                 class="max-h-[500px] object-contain w-full mt-2">
                        </div>
                    @endif

                    {{-- Like & Komentar (sejajar seperti di dokumen) --}}
                    <div class="flex items-center gap-6 px-4 py-3 text-lg">
                        <form action="{{ route('posts.like', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 hover:text-red-600">
                                ❤️ <span>{{ $post->likes()->count() }}</span>
                            </button>
                        </form>

                        <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-2 hover:text-green-600">
                            💬 <span>{{ $post->comments_count ?? 0 }}</span>
                        </a>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <p class="text-gray-600 text-center">Belum ada video yang diupload.</p>
    @endif
</div>
@endsection