@extends('layouts.dashboard')

@section('title', 'Musik')

@section('content')
<div id="post-container" class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">🎵 Daftar Postingan Musik</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($posts as $post)
            <div class="music-track p-4 border rounded-lg hover:bg-gray-100 cursor-pointer"
                 data-src="{{ asset('storage/' . $post->file_path) }}"
                 data-title="{{ $post->title }}">
                <h3 class="font-semibold text-lg">{{ $post->title }}</h3>
                <p class="text-gray-500 text-sm mt-1">Klik untuk memutar</p>
            </div>
        @endforeach
    </div>

    {{-- Loader kecil --}}
    <div id="loader" class="text-center py-4 hidden text-gray-500">
        ⏳ Memuat postingan...
    </div>
</div>
{{-- Script Infinite Scroll --}}
<script>
let page = 1;
let loading = false;

window.addEventListener('scroll', () => {
    const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 100;

    if (nearBottom && !loading) {
        loadMore();
    }
});

function loadMore() {
    loading = true;
    page++;
    document.getElementById('loader').classList.remove('hidden');

    fetch(`?page=${page}`)
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const newPosts = parser.parseFromString(html, 'text/html').querySelectorAll('#post-container > div');

            if (newPosts.length > 0) {
                newPosts.forEach(post => document.getElementById('post-container').appendChild(post));
            } else {
                window.removeEventListener('scroll', loadMore);
            }
        })
        .finally(() => {
            document.getElementById('loader').classList.add('hidden');
            loading = false;
        });
}
</script>
@endsection