@extends('layouts.dashboard')

@section('title', 'Dokumen')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">📄 Feed Dokumen</h2>

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
                    {{ $post->doc_type ? strtoupper($post->doc_type) : ucfirst($post->category) }}
                </span>
            </div>

            {{-- Thumbnail / Cover (klik untuk modal) --}}
            @if($post->cover_path)
                <div class="w-full bg-gray-100">
                    <img src="{{ asset('storage/' . $post->cover_path) }}" 
                         alt="Cover {{ $post->title }}" 
                         class="w-full object-contain cursor-pointer"
                         onclick="openModal('{{ asset('storage/' . $post->cover_path) }}')">
                </div>
            @endif

            {{-- Tombol aksi (Download kiri, Preview kanan) --}}
            <div class="flex flex-col sm:flex-row gap-2 px-4 py-3 border-b">
                {{-- Tombol Download --}}
                <a href="{{ route('posts.download', $post->id) }}" 
                   class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                    ⬇️ Download Dokumen
                </a>

                {{-- Tombol Preview hanya untuk PDF --}}
                @if($post->doc_type === 'pdf')
                    <a href="{{ route('posts.preview', $post->id) }}" target="_blank" 
                       class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                        🔍 Preview PDF
                    </a>
                @endif
            </div>

            {{-- Like & Comment --}}
            <div class="px-4 py-3 text-lg">
                <p class="text-gray-400 text-xs mb-2">Dibuat: {{ $post->created_at->diffForHumans() }}</p>
                <div class="flex items-center gap-6">
                    <form action="{{ route('posts.like', $post->id) }}" method="POST">@csrf
                        <button type="submit" class="flex items-center gap-2 hover:text-red-600">❤️ <span>{{ $post->likes()->count() }}</span></button>
                    </form>
                    <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-2 hover:text-green-600 transition-colors duration-200">
                    💬 <span>{{ $post->comments()->count() }}</span>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Modal Preview Gambar --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 p-4">
    <button class="absolute top-5 right-8 text-white text-3xl font-bold" onclick="closeModal()">❌</button>
    <img id="modalImage" class="max-w-full max-h-[80vh] rounded shadow-lg object-contain">
</div>

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