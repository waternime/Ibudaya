@extends('layouts.dashboard')

@section('title', 'Manajemen Postingan')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800">📑 Manajemen Postingan</h1>
    <p class="text-gray-600 mb-4">Daftar semua postingan yang diunggah oleh pengguna.</p>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('admin.posts.index') }}" class="mb-4 flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari postingan berdasarkan judul atau ID..."
            class="w-full sm:flex-1 px-4 py-2 border rounded-lg focus:ring focus:ring-red-300">
        <div class="flex gap-2">
            <button type="submit"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 w-full sm:w-auto">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.posts.index') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 w-full sm:w-auto text-center">
                    Reset
                </a>
            @endif
        </div>
    </form>

    @if($posts->count() > 0)
        {{-- Versi Desktop (Tabel) --}}
        <div class="overflow-x-auto shadow rounded-lg border border-gray-200 dark:border-gray-700 hidden sm:block">
            <table class="min-w-full bg-white dark:bg-gray-900">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800 text-left text-gray-700 dark:text-gray-200">
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700">ID</th>
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700">Judul</th>
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700">Gambar</th>
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700">Kategori</th>
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700">Pemilik</th>
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700 text-center font-semibold text-gray-700 dark:text-gray-200">
                                {{ $post->id }}
                            </td>
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-gray-200">
                                <a href="{{ route('posts.show', $post->id) }}" 
                                   class="font-medium hover:underline">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700">
                                @php 
                                    $imgPath = $post->cover_path 
                                        ? asset('storage/' . $post->cover_path) 
                                        : (\Illuminate\Support\Str::endsWith($post->file_path ?? '', ['jpg','jpeg','png','gif','webp']) 
                                            ? asset('storage/' . $post->file_path) 
                                            : null);
                                @endphp
                                @if($imgPath)
                                    <img src="{{ $imgPath }}" 
                                        alt="{{ $post->title }}" 
                                        class="w-20 h-14 object-cover rounded shadow cursor-pointer"
                                        onclick="openModal('{{ $imgPath }}')">
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 italic">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700">
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-sm rounded">
                                    {{ ucfirst($post->category) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700">
                                {{ $post->user->name ?? 'Tidak diketahui' }}
                            </td>
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700 text-center">
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" 
                                    onsubmit="return confirm('Yakin mau hapus postingan ini?');" 
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm rounded">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Versi Mobile (Card) --}}
        <div class="border rounded-lg p-4 shadow-sm sm:hidden">
            @foreach ($posts as $post)
                @php 
                    $imgPath = $post->cover_path 
                        ? asset('storage/' . $post->cover_path) 
                        : (\Illuminate\Support\Str::endsWith($post->file_path ?? '', ['jpg','jpeg','png','gif','webp']) 
                            ? asset('storage/' . $post->file_path) 
                            : null);
                @endphp
                <div class="border rounded-lg p-4 shadow-sm bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700">
                    <div class="flex items-start justify-between gap-3">
                        <a href="{{ route('posts.show', $post->id) }}" class="font-medium hover:underline">
                            {{ $post->title }}
                        </a>
                        <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded whitespace-nowrap">
                            {{ ucfirst($post->category) }}
                        </span>
                    </div>

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Oleh: <span class="font-medium text-gray-700 dark:text-gray-200">{{ $post->user->name ?? 'Tidak diketahui' }}</span>
                        <span class="ml-1 text-gray-400 dark:text-gray-500">#{{ $post->id }}</span>
                    </p>

                    @if($imgPath)
                        <img src="{{ $imgPath }}" 
                            alt="{{ $post->title }}" 
                            class="w-full h-44 object-cover rounded mt-3 cursor-pointer"
                            onclick="openModal('{{ $imgPath }}')">
                    @else
                        <div class="w-full h-32 bg-gray-100 dark:bg-gray-800 rounded mt-3 flex items-center justify-center text-gray-400 dark:text-gray-500">
                            Tidak ada gambar
                        </div>
                    @endif

                    <div class="mt-3">
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                            onsubmit="return confirm('Yakin mau hapus postingan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white w-full py-2 rounded">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $posts->links('pagination::tailwind') }}
        </div>

    @else
        <p class="text-gray-500 italic">Belum ada postingan.</p>
    @endif
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