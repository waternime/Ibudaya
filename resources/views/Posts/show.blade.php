@extends('layouts.dashboard')

@section('title', $post->title ?? 'Detail Postingan')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Postingan --}}
    <div class="mb-10 border rounded-lg shadow bg-white overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b">
            <p class="font-semibold">{{ $post->title }}</p>
            <span class="text-xs px-2 py-1 bg-gray-200 rounded">
                {{ ucfirst($post->category) }}
            </span>
        </div>

        {{-- Media --}}
        @php
            $coverPath = $post->cover_path;
            $filePath  = $post->file_path;
            $isImage   = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['jpg','jpeg','png','gif','webp']);
            $isMusic   = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['mp3','wav','ogg']);
            $isVideo   = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['mp4','webm']);
            $isDoc     = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['pdf','doc','docx','xls','xlsx','ppt','pptx']);
        @endphp

        @if ($coverPath && !$isVideo)
            <div class="w-full bg-gray-100">
                <img src="{{ asset('storage/' . $coverPath) }}" alt="Cover {{ $post->title }}" class="w-full object-contain">
            </div>
        @endif

        @if ($isImage)
            <div class="w-full bg-gray-100">
                <img src="{{ asset('storage/' . $filePath) }}" alt="{{ $post->title }}" class="w-full object-contain">
            </div>
        @endif

        @if ($isMusic)
            <div class="px-4 py-3 border-b">
                <button class="music-track w-full text-center px-3 py-2 bg-purple-600 text-white text-sm rounded hover:bg-purple-700"
                        data-src="{{ asset('storage/' . $filePath) }}" data-title="{{ $post->title }}">
                    🎵 Putar Musik
                </button>
            </div>
        @endif

        @if ($isVideo)
            <div class="w-full bg-black border-b">
                <video controls class="w-full" style="max-height:400px;">
                    <source src="{{ asset('storage/' . $filePath) }}" type="video/mp4">
                    Browser Anda tidak mendukung pemutar video.
                </video>
            </div>
        @endif

        @if ($isDoc && $post->category === 'docs')
            <div class="px-4 py-3 border-b flex gap-3">
                <a href="{{ route('posts.download', $post->id) }}" class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">⬇️ Download Dokumen</a>
                @if (\Illuminate\Support\Str::endsWith($filePath, 'pdf'))
                    <a href="{{ route('posts.preview', $post->id) }}" target="_blank" class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">🔍 Preview</a>
                @endif
            </div>
        @endif

        @if($post->content)
            <div class="px-4 py-3 text-sm text-gray-700 border-b">
                {{ $post->content }}
            </div>
        @endif

        {{-- Like & Comment --}}
        <div class="px-4 py-3 text-lg">
            <p class="text-gray-400 text-xs mb-2">Dibuat: {{ $post->created_at->diffForHumans() }}</p>
            <div class="flex items-center gap-6">
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 hover:text-red-600">❤️ <span>{{ $post->likes()->count() }}</span></button>
                </form>
                <div class="flex items-center gap-2">💬 <span>{{ $post->comments()->count() }}</span></div>
            </div>
        </div>
    </div>

    {{-- Komentar --}}
    <div class="mb-10">
        <h3 class="text-lg font-semibold mb-3">💬 Komentar</h3>

        @php
            function renderReplies($comment) {
                foreach($comment->replies as $reply) {
                    echo '<div class="ml-8 mt-2 p-2 bg-gray-200 rounded">';
                    echo '<strong>'.$reply->user->name.'</strong>';
                    echo '<p class="text-sm">'.$reply->content.'</p>';
                    echo '<small class="text-gray-400">'.$reply->created_at->diffForHumans().'</small>';

                    echo '<div class="flex items-center gap-3 mt-1">';
                    if(auth()->check()) {
                        echo '<button onclick="document.getElementById(\'reply-form-'.$reply->id.'\').classList.toggle(\'hidden\')" class="text-green-600 text-sm hover:underline">Balas</button>';
                        if(auth()->id() === $reply->user_id) {
                            echo '<button onclick="document.getElementById(\'edit-form-'.$reply->id.'\').classList.toggle(\'hidden\')" class="text-yellow-600 text-sm hover:underline">Edit</button>';
                            echo '<form action="'.route('comments.destroy', $reply->id).'" method="POST" class="inline">';
                            echo csrf_field();
                            echo method_field('DELETE');
                            echo '<button type="submit" class="text-red-600 text-sm hover:underline">Hapus</button></form>';
                        }
                    }
                    echo '</div>';

                    // Form Reply
                    if(auth()->check()) {
                        echo '<form id="reply-form-'.$reply->id.'" action="'.route('posts.comments.reply', [$reply->post_id, $reply->id]).'" method="POST" class="mt-2 flex gap-2 ml-4 hidden">';
                        echo csrf_field();
                        echo '<input type="text" name="content" class="flex-1 px-2 py-1 border rounded" placeholder="Balas komentar...">';
                        echo '<button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Kirim</button></form>';

                        if(auth()->id() === $reply->user_id) {
                            echo '<form id="edit-form-'.$reply->id.'" action="'.route('comments.update', $reply->id).'" method="POST" class="mt-2 flex gap-2 ml-4 hidden">';
                            echo csrf_field();
                            echo method_field('PUT');
                            echo '<input type="text" name="content" value="'.$reply->content.'" class="flex-1 px-2 py-1 border rounded">';
                            echo '<button type="submit" class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700">Simpan</button></form>';
                        }
                    }

                    if($reply->replies->count() > 0) {
                        renderReplies($reply);
                    }

                    echo '</div>';
                }
            }
        @endphp

        @if ($post->comments->whereNull('parent_id')->count() > 0)
            @foreach($post->comments->whereNull('parent_id') as $comment)
                <div class="mb-2 p-3 rounded bg-gray-100">
                    <strong>{{ $comment->user->name }}</strong>
                    <p class="text-sm">{{ $comment->content }}</p>
                    <small class="text-gray-400">{{ $comment->created_at->diffForHumans() }}</small>

                    <div class="flex items-center gap-3 mt-1">
                        @auth
                            @if($comment->replies->count() > 0)
                                <button onclick="document.getElementById('replies-{{ $comment->id }}').classList.toggle('hidden')" class="text-blue-600 text-sm hover:underline">
                                    Lihat Balasan ({{ $comment->replies->count() }})
                                </button>
                            @endif
                            <button onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')" class="text-green-600 text-sm hover:underline">Balas</button>

                            @if(auth()->id() === $comment->user_id)
                                <button onclick="document.getElementById('edit-form-{{ $comment->id }}').classList.toggle('hidden')" class="text-yellow-600 text-sm hover:underline">Edit</button>
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm hover:underline">Hapus</button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    {{-- Form Reply --}}
                    @auth
                        <form id="reply-form-{{ $comment->id }}" action="{{ route('posts.comments.reply', [$post->id, $comment->id]) }}" method="POST" class="mt-2 flex gap-2 ml-4 hidden">
                            @csrf
                            <input type="text" name="content" class="flex-1 px-2 py-1 border rounded" placeholder="Balas komentar...">
                            <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Kirim</button>
                        </form>

                        {{-- Form Edit --}}
                        @if(auth()->id() === $comment->user_id)
                            <form id="edit-form-{{ $comment->id }}" action="{{ route('comments.update', $comment->id) }}" method="POST" class="mt-2 flex gap-2 ml-4 hidden">
                                @csrf
                                @method('PUT')
                                <input type="text" name="content" value="{{ $comment->content }}" class="flex-1 px-2 py-1 border rounded">
                                <button type="submit" class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700">Simpan</button>
                            </form>
                        @endif
                    @endauth

                    {{-- Balasan --}}
                    <div id="replies-{{ $comment->id }}" class="ml-8 mt-2 hidden">
                        @php renderReplies($comment); @endphp
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">Belum ada komentar.</p>
        @endif

        {{-- Form komentar utama --}}
        @auth
            <form action="{{ route('posts.comments.store', $post->id) }}" method="POST" class="mt-3 flex gap-2">
                @csrf
                <input type="text" name="content" class="flex-1 px-3 py-2 border rounded" placeholder="Tulis komentar...">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Kirim</button>
            </form>
        @else
            <p class="text-gray-500 mt-2">Silakan <a href="{{ route('login') }}">login</a> untuk berkomentar.</p>
        @endauth
    </div>
</div>
@endsection