{{-- Dokumen (download link hanya untuk dokumen) --}}
@if ($isDoc && $post->category === 'docs')
    <div class="px-4 py-3 border-b flex gap-3">
        <a href="{{ route('posts.download', $post->id) }}"
           class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
            ⬇️ Download Dokumen
        </a>
        <a href="{{ asset('storage/' . $filePath) }}" target="_blank"
           class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
            🔍 Preview
        </a>
    </div>
@endif