@extends('layouts.dashboard')

@section('title', 'Posting Gambar')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">🖼️ Feed Gambar</h2>

    @foreach($posts as $post)
        <div class="mb-10 border rounded-lg shadow bg-white overflow-hidden">
            {{-- Header post --}}
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <div>
                    <p class="font-semibold">{{ $post->title ?? 'Tanpa Judul' }}</p>
                    <span class="text-xs text-gray-500 block">
                        📌 {{ ucfirst($post->province) ?? 'Umum' }}
                    </span>
                    <span class="text-xs text-gray-500">
                        🎭 {{ ucfirst($post->file_category) ?? 'Tidak ada kategori' }}
                    </span>
                </div>
                <span class="text-xs px-2 py-1 bg-gray-200 rounded">
                    {{ ucfirst($post->category) }}
                </span>
            </div>

            {{-- Gambar utama (klik untuk buka modal) --}}
            <div class="w-full bg-gray-100">
                <img src="{{ asset('storage/' . $post->file_path) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full object-contain cursor-pointer"
                     onclick="openModal('{{ asset('storage/' . $post->file_path) }}')">
            </div>

            {{-- Caption --}}
            @if($post->description)
                <div class="px-4 py-3 text-sm text-gray-700 border-b">
                    {{ $post->description }}
                </div>
            @endif

            {{-- Like & Komentar --}}
            <div class="flex items-center gap-6 px-4 py-3 text-lg">
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 hover:text-red-600">
                        ❤️ <span>{{ $post->likes()->count() }}</span>
                    </button>
                </form>

                <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-2 hover:text-green-600">
                    💬 <span>{{ $post->comments()->count() }}</span>
                </a>
            </div>
        </div>
    @endforeach

    @if($posts->isEmpty())
        <p class="text-muted text-center">Belum ada postingan gambar.</p>
    @endif
</div>

{{-- Modal Preview Gambar (sama dengan latest.blade.php) --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 p-4">
    <button class="absolute top-5 right-8 text-white text-3xl font-bold" onclick="closeModal()">❌</button>
    <img id="modalImage" class="max-w-full max-h-[80vh] rounded shadow-lg object-contain">
</div>

{{-- Script Modal --}}
<script>
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
</script>
@endsection