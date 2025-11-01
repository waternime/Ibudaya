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

        {{-- Cover (kalau bukan video) --}}
        @if ($coverPath && !$isVideo)
            <img src="{{ asset('storage/' . $coverPath) }}" 
                 class="w-full object-contain cursor-pointer"
                 alt="Cover"
                 onclick="openModal('{{ asset('storage/' . $coverPath) }}')">
        @endif

        {{-- Gambar --}}
        @if ($isImage)
            <img src="{{ asset('storage/' . $filePath) }}" 
                 class="w-full object-contain cursor-pointer"
                 alt="Image"
                 onclick="openModal('{{ asset('storage/' . $filePath) }}')">
        @endif

        {{-- Musik --}}
        @if ($isMusic)
            <div class="px-4 py-3 border-b">
                <button class="music-track w-full px-3 py-2 bg-purple-600 text-white rounded hover:bg-purple-700"
                    data-src="{{ asset('storage/' . $filePath) }}" data-title="{{ $post->title }}">
                    🎵 Putar Musik
                </button>
            </div>
        @endif

        {{-- Video dengan cover (thumbnail) --}}
        @if ($isVideo)
            {{-- Wrapper video interaktif --}}
            <div class="w-full bg-black flex justify-center relative overflow-hidden group rounded-b-lg">
                
                {{-- Video --}}
                <video 
                    preload="metadata" 
                    playsinline 
                    class="video-player max-h-[500px] object-contain w-full rounded-b cursor-pointer transition-transform duration-200 group-hover:scale-[1.02]" 
                    poster="{{ $coverPath ? asset('storage/' . $coverPath) : '' }}"
                    onclick="event.preventDefault(); event.stopPropagation();"
                    controlslist="nodownload"
                >
                    <source src="{{ asset('storage/' . $filePath) }}" type="video/mp4">
                    Browser kamu tidak mendukung video.
                </video>

                {{-- Overlay ▶️ tampil sebelum video diputar, lalu hilang permanen --}}
                <div class="video-overlay absolute inset-0 flex items-center justify-center bg-black/30 transition-opacity duration-500 opacity-0 group-hover:opacity-100 pointer-events-none">
                    <span class="text-white text-5xl">▶️</span>
                </div>
            </div>
        @endif

        {{-- Dokumen --}}
        @if ($isDoc && $post->category === 'docs')
            <div class="px-4 py-3 border-b flex gap-3">
                <a href="{{ route('posts.download', $post->id) }}" class="flex-1 text-center px-3 py-2 bg-red-600 text-white text-sm rounded">⬇️ Download</a>
                @if (\Illuminate\Support\Str::endsWith($filePath, 'pdf'))
                    <a href="{{ route('posts.preview', $post->id) }}" target="_blank" class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded">🔍 Preview</a>
                @endif
            </div>
        @endif

        {{-- Konten teks --}}
        @if($post->content)
            <div class="px-4 py-3 text-sm text-gray-700 border-b">{{ $post->content }}</div>
        @endif

        {{-- Like & Comment --}}
        <div class="px-4 py-3 text-lg">
            <p class="text-gray-400 text-xs mb-2">Dibuat: {{ $post->created_at->diffForHumans() }}</p>
            <div class="flex items-center gap-6">
                <form action="{{ route('posts.like', $post->id) }}" method="POST">@csrf
                    <button type="submit" class="flex items-center gap-2 hover:text-red-600">❤️ <span>{{ $post->likes()->count() }}</span></button>
                </form>
                <div class="flex items-center gap-2">💬 <span>{{ $post->comments()->count() }}</span></div>
            </div>
        </div>
    </div>

    {{-- Komentar --}}
    <div class="mb-10">
        <h3 class="text-lg font-semibold mb-3">💬 Komentar</h3>

        {{-- Form tambah komentar --}}
        @auth
        <form action="{{ route('posts.comments.store', $post->id) }}" method="POST" class="mb-6 flex gap-2">
            @csrf
            <input type="text" name="content"
                class="flex-1 px-3 py-2 border rounded comment-input dark:bg-gray-700 dark:text-white text-sm"
                placeholder="Tulis komentar...">
            <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Kirim</button>
        </form>
        @else
            <p class="text-gray-500 mb-4">Silakan
                <a href="{{ route('login') }}" class="text-red-500">login</a> untuk berkomentar.
            </p>
        @endauth

        {{-- Fungsi render replies --}}
        @php
        function renderReplies($comment, $postId) {
            foreach ($comment->replies as $reply) {
                echo '<div class="ml-4 mt-3 p-3 rounded-lg border shadow-sm comment-reply">';
                    echo '<div class="flex items-start gap-3">';
                        if ($reply->user->profile_picture) {
                            echo '<img src="'.asset('storage/'.$reply->user->profile_picture).'" class="w-8 h-8 rounded-full object-cover border">';
                        } else {
                            echo '<div class="w-8 h-8 flex items-center justify-center bg-gray-300 dark:bg-gray-600 rounded-full text-sm">👤</div>';
                        }
                        echo '<div class="flex-1">';
                            echo '<p class="font-semibold text-sm">'.e($reply->user->name).'</p>';
                            echo '<p class="text-sm">'.e($reply->content).'</p>';
                            echo '<div class="flex items-center gap-3 text-xs mt-1">';
                                echo $reply->created_at->diffForHumans();
                                echo ' <button onclick="toggleElement(\'reply-form-'.$reply->id.'\')" class="text-green-600 dark:text-green-400">Balas</button>';
                                if(auth()->id() === $reply->user_id) {
                                    echo '<button onclick="toggleElement(\'edit-form-'.$reply->id.'\')" class="text-yellow-600 dark:text-yellow-400">Edit</button>';
                                    echo '<form action="'.route('comments.destroy',$reply->id).'" method="POST" class="inline">'.csrf_field().method_field('DELETE').'<button class="text-red-600 dark:text-red-400">Hapus</button></form>';
                                }
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';

                    if(auth()->check()) {
                        echo '<form id="reply-form-'.$reply->id.'" action="'.route('posts.comments.store',$postId).'" method="POST" class="hidden mt-2 flex gap-2 ml-4 items-center">';
                        echo csrf_field();
                        echo '<input type="hidden" name="parent_id" value="'.$comment->id.'">';
                        echo '<input type="text" name="content" class="flex-1 px-3 py-2 border rounded comment-input dark:bg-gray-700 dark:text-white text-sm" placeholder="Balas komentar...">';
                        echo '<button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Kirim</button>';
                        echo '</form>';

                        echo '<form id="edit-form-'.$reply->id.'" action="'.route('comments.update',$reply->id).'" method="POST" class="hidden mt-2 flex gap-2 ml-4 items-center">';
                        echo csrf_field().method_field('PUT');
                        echo '<input type="text" name="content" value="'.e($reply->content).'" class="flex-1 px-3 py-2 border rounded comment-input dark:bg-gray-700 dark:text-white text-sm">';
                        echo '<button class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 text-sm">Simpan</button>';
                        echo '</form>';
                    }

                echo '</div>';
            }
        }
        @endphp

        {{-- Komentar utama --}}
        @forelse($post->comments->whereNull('parent_id') as $comment)
            <div class="mb-4 p-4 rounded-lg border shadow-sm comment-box">
                <div class="flex items-start gap-3">
                    @if($comment->user->profile_picture)
                        <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" class="w-10 h-10 rounded-full object-cover border">
                    @else
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-300 dark:bg-gray-600 rounded-full text-lg">👤</div>
                    @endif

                    <div class="flex-1">
                        <p class="font-semibold">{{ $comment->user->name }}</p>
                        <p class="text-sm">{{ $comment->content }}</p>
                        <div class="flex items-center gap-3 text-xs mt-1">
                            {{ $comment->created_at->diffForHumans() }}
                            <button onclick="toggleElement('reply-form-{{ $comment->id }}')" class="text-green-600 dark:text-green-400">Balas</button>
                            @if(auth()->id() === $comment->user_id)
                                <button onclick="toggleElement('edit-form-{{ $comment->id }}')" class="text-yellow-600 dark:text-yellow-400">Edit</button>
                                <form action="{{ route('comments.destroy',$comment->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 dark:text-red-400">Hapus</button>
                                </form>
                            @endif
                        </div>

                        {{-- Reply form --}}
                        @auth
                        <form id="reply-form-{{ $comment->id }}" action="{{ route('posts.comments.store',$post->id) }}" method="POST" class="hidden mt-2 flex gap-2 ml-4 items-center">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <input type="text" name="content"
                                class="flex-1 px-3 py-2 border rounded comment-input dark:bg-gray-700 dark:text-white text-sm"
                                placeholder="Balas komentar...">
                            <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Kirim</button>
                        </form>

                        <form id="edit-form-{{ $comment->id }}" action="{{ route('comments.update',$comment->id) }}" method="POST" class="hidden mt-2 flex gap-2 ml-4 items-center">
                            @csrf @method('PUT')
                            <input type="text" name="content" value="{{ $comment->content }}"
                                class="flex-1 px-3 py-2 border rounded comment-input dark:bg-gray-700 dark:text-white text-sm">
                            <button class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 text-sm">Simpan</button>
                        </form>
                        @endauth

                        {{-- Nested replies --}}
                        @if($comment->replies->count() > 0)
                            <button onclick="toggleElement('replies-{{ $comment->id }}')" class="text-xs text-red-600 dark:text-red-400 mt-2">Lihat Balasan ({{ $comment->replies->count() }})</button>
                            <div id="replies-{{ $comment->id }}" class="hidden mt-2">
                                @php renderReplies($comment, $post->id); @endphp
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada komentar.</p>
        @endforelse
    </div>

    {{-- Modal Preview Gambar --}}
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 p-4">
        <button class="absolute top-5 right-8 text-white text-3xl font-bold" onclick="closeModal()">❌</button>
        <img id="modalImage" class="max-w-full max-h-[80vh] rounded shadow-lg object-contain">
    </div>

    <script>
        function toggleElement(id) {
            const el = document.getElementById(id);
            if (el) el.classList.toggle('hidden');
        }

        function openModal(src) {
            document.getElementById('modalImage').src = src;
            const modal = document.getElementById('imageModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function playVideo() {
            const cover = document.getElementById('videoCover');
            const video = document.getElementById('videoPlayer');
            if (cover && video) {
                cover.classList.add('hidden');
                video.classList.remove('hidden');
                video.play();
            }
        }
    </script>
</div>
@endsection