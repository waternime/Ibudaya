@extends('layouts.dashboard')

@section('title', 'Postingan Terbaru')

@section('content')

<h2 class="text-2xl font-bold mb-6 text-center">🆕 Postingan Terbaru</h2>
{{-- 🔹 Versi Mobile: Tombol Filter --}}
    <div class="sm:hidden mb-4 text-center">
        <button type="button" 
                onclick="document.getElementById('mobileFilter').classList.toggle('hidden')"
                class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-semibold">
            Filter Provinsi & Budaya
        </button>
    </div>

<div id="post-container" class="max-w-2xl mx-auto">

    {{-- 🔹 Filter Form --}}
    <form method="GET" action="{{ route('posts.latest') }}" 
          class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-3">

        {{-- Wrapper agar bisa toggle di mobile --}}
        <div id="mobileFilter" class="sm:contents hidden sm:block">

            {{-- Provinsi --}}
            <select name="province" onchange="this.form.submit()" 
                    class="px-3 py-2 border rounded bg-white text-sm w-full">
                <option value="">📌 Provinsi</option>
                <option value="Umum" {{ request('province') == 'Umum' ? 'selected' : '' }}>Umum</option>
                <option value="Aceh" {{ request('province') == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                <option value="Sumatera Utara" {{ request('province') == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                <option value="Sumatera Barat" {{ request('province') == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                <option value="Riau" {{ request('province') == 'Riau' ? 'selected' : '' }}>Riau</option>
                <option value="Kepulauan Riau" {{ request('province') == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                <option value="Jambi" {{ request('province') == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                <option value="Sumatera Selatan" {{ request('province') == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                <option value="Bangka Belitung" {{ request('province') == 'Bangka Belitung' ? 'selected' : '' }}>Bangka Belitung</option>
                <option value="Bengkulu" {{ request('province') == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                <option value="Lampung" {{ request('province') == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                <option value="DKI Jakarta" {{ request('province') == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                <option value="Jawa Barat" {{ request('province') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                <option value="Banten" {{ request('province') == 'Banten' ? 'selected' : '' }}>Banten</option>
                <option value="Jawa Tengah" {{ request('province') == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                <option value="DI Yogyakarta" {{ request('province') == 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                <option value="Jawa Timur" {{ request('province') == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                <option value="Bali" {{ request('province') == 'Bali' ? 'selected' : '' }}>Bali</option>
                <option value="Nusa Tenggara Barat" {{ request('province') == 'Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                <option value="Nusa Tenggara Timur" {{ request('province') == 'Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                <option value="Kalimantan Barat" {{ request('province') == 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                <option value="Kalimantan Tengah" {{ request('province') == 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                <option value="Kalimantan Selatan" {{ request('province') == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                <option value="Kalimantan Timur" {{ request('province') == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                <option value="Kalimantan Utara" {{ request('province') == 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                <option value="Sulawesi Utara" {{ request('province') == 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                <option value="Gorontalo" {{ request('province') == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                <option value="Sulawesi Tengah" {{ request('province') == 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                <option value="Sulawesi Barat" {{ request('province') == 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                <option value="Sulawesi Selatan" {{ request('province') == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                <option value="Sulawesi Tenggara" {{ request('province') == 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                <option value="Maluku" {{ request('province') == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                <option value="Maluku Utara" {{ request('province') == 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                <option value="Papua" {{ request('province') == 'Papua' ? 'selected' : '' }}>Papua</option>
                <option value="Papua Barat" {{ request('province') == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                <option value="Papua Selatan" {{ request('province') == 'Papua Selatan' ? 'selected' : '' }}>Papua Selatan</option>
                <option value="Papua Tengah" {{ request('province') == 'Papua Tengah' ? 'selected' : '' }}>Papua Tengah</option>
                <option value="Papua Pegunungan" {{ request('province') == 'Papua Pegunungan' ? 'selected' : '' }}>Papua Pegunungan</option>
            </select>

            {{-- Kategori Budaya --}}
            <select name="file_category" onchange="this.form.submit()" 
                    class="px-3 py-2 border rounded bg-white text-sm w-full">
                <option value="">🎭 Budaya</option>
                <option value="pakaian_adat" {{ request('file_category') == 'pakaian_adat' ? 'selected' : '' }}>👘 Pakaian Adat</option>
                <option value="upacara_adat" {{ request('file_category') == 'upacara_adat' ? 'selected' : '' }}>🙏 Upacara Adat</option>
                <option value="makanan_khas" {{ request('file_category') == 'makanan_khas' ? 'selected' : '' }}>🍲 Makanan Khas</option>
                <option value="lagu_daerah" {{ request('file_category') == 'lagu_daerah' ? 'selected' : '' }}>🎶 Lagu Daerah</option>
                <option value="alat_musik" {{ request('file_category') == 'alat_musik' ? 'selected' : '' }}>🥁 Alat Musik Tradisional</option>
                <option value="senjata_tradisional" {{ request('file_category') == 'senjata_tradisional' ? 'selected' : '' }}>⚔️ Senjata Tradisional</option>
                <option value="alam" {{ request('file_category') == 'alam' ? 'selected' : '' }}>⛰️ Alam</option>
                <option value="rumah_tradisional" {{ request('file_category') == 'rumah_tradisional' ? 'selected' : '' }}>🏠 Rumah Tradisional</option>
                <option value="tari_tradisional" {{ request('file_category') == 'tari_tradisional' ? 'selected' : '' }}>💃 Tari Tradisional</option>
                <option value="permainan_tradisional" {{ request('file_category') == 'permainan_tradisional' ? 'selected' : '' }}>🎮 Permainan Tradisional</option>
                <option value="pertunjukan_daerah" {{ request('file_category') == 'pertunjukan_daerah' ? 'selected' : '' }}>👯‍♀️ Pertunjukan Daerah</option>
                <option value="profil_daerah" {{ request('file_category') == 'profil_daerah' ? 'selected' : '' }}>📜 Profil Daerah</option>
                <option value="cerita_rakyat" {{ request('file_category') == 'cerita_rakyat' ? 'selected' : '' }}>📖 Cerita Rakyat</option>
                <option value="sejarah" {{ request('file_category') == 'sejarah' ? 'selected' : '' }}>📚 Sejarah</option>
                <option value="event" {{ request('file_category') == 'event' ? 'selected' : '' }}>🎉 Kegiatan/Event</option>
            </select>

            {{-- Jenis File --}}
            <select name="category" onchange="this.form.submit()" 
                    class="px-3 py-2 border rounded bg-white text-sm w-full">
                <option value="">📁 Kategori</option>
                <option value="images" {{ request('category') == 'images' ? 'selected' : '' }}>🖼️ Gambar</option>
                <option value="music" {{ request('category') == 'music' ? 'selected' : '' }}>🎵 Musik</option>
                <option value="videos" {{ request('category') == 'videos' ? 'selected' : '' }}>🎬 Video</option>
                <option value="docs" {{ request('category') == 'docs' ? 'selected' : '' }}>📄 Dokumen</option>
            </select>
        </div>
    </form>

    {{-- Daftar Postingan --}}
    @forelse($posts as $post)
        @php
            $coverPath = $post->cover_path;
            $filePath  = $post->file_path;
            $isImage   = $filePath && Str::endsWith($filePath, ['jpg','jpeg','png','gif','webp']);
            $isMusic   = $filePath && Str::endsWith($filePath, ['mp3','wav','ogg']);
            $isVideo   = $filePath && Str::endsWith($filePath, ['mp4','webm']);
            $isDoc     = $filePath && Str::endsWith($filePath, ['pdf','doc','docx','xls','xlsx','ppt','pptx']);
        @endphp

        {{-- DITAMBAHKAN efek hover dan transisi biar interaktif --}}
        <div class="mb-10 border rounded-lg shadow bg-white overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-200">

            {{-- DITAMBAHKAN: Bungkus seluruh isi kartu dengan link ke halaman detail --}}
            <a href="{{ route('posts.show', $post->id) }}" class="block">

                {{-- Header --}}
                <div class="flex items-center justify-between px-4 py-3 border-b">
                    <div>
                        <p class="font-semibold">{{ $post->title }}</p>
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

                {{-- Konten Media --}}
                @if ($coverPath && !$isVideo)
                    {{-- DITAMBAHKAN: "onclick" tetap di sini agar klik gambar buka modal, bukan pindah halaman --}}
                    <div class="w-full bg-gray-100" onclick="event.preventDefault(); openModal('{{ asset('storage/' . $coverPath) }}')">
                        <img src="{{ asset('storage/' . $coverPath) }}" 
                            alt="Cover {{ $post->title }}" 
                            loading="lazy"
                            class="w-full object-contain cursor-pointer">
                    </div>
                @endif

                @if ($isImage)
                    <div class="w-full bg-gray-100" onclick="event.preventDefault(); openModal('{{ asset('storage/' . $filePath) }}')">
                        <img src="{{ asset('storage/' . $filePath) }}" 
                            alt="{{ $post->title }}" 
                            loading="lazy"
                            class="w-full object-contain cursor-pointer">
                    </div>
                @endif

                @if ($isMusic)
                    <div class="px-4 py-3 border-b">
                        <button 
                            class="music-track w-full text-center px-3 py-2 bg-purple-600 text-white text-sm rounded hover:bg-purple-700"
                            data-src="{{ asset('storage/' . $filePath) }}"
                            data-title="{{ $post->title }}">
                            🎵 Putar Musik
                        </button>
                    </div>
                @endif

                @if ($isVideo)
                    <div class="w-full bg-black border-b">
                        <video controls class="w-full" style="max-height:400px;" preload="none" poster="{{ $coverPath ? asset('storage/'.$coverPath) : '' }}">
                            <source src="{{ asset('storage/' . $filePath) }}" type="video/mp4">
                            Browser Anda tidak mendukung pemutar video.
                        </video>
                    </div>
                @endif

                @if ($isDoc && $post->category === 'docs')
                    <div class="px-4 py-3 border-b flex gap-3">
                        <a href="{{ route('posts.download', $post->id) }}"
                        class="flex-1 text-center px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700"
                        onclick="event.stopPropagation()"> {{-- DITAMBAHKAN agar klik download tidak ikut buka halaman --}}
                            ⬇️ Download Dokumen
                        </a>
                        @if (Str::endsWith($filePath, 'pdf'))
                            <a href="{{ route('posts.preview', $post->id) }}" target="_blank"
                            class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700"
                            onclick="event.stopPropagation()"> {{-- DITAMBAHKAN --}}
                                🔍 Preview
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Konten --}}
                @if($post->content)
                    <div class="px-4 py-3 text-sm text-gray-700 border-b">
                        {{ Str::limit($post->content, 200) }}
                    </div>
                @endif
            </a>

            {{-- Like & Comment --}}
            <div class="px-4 py-3 text-lg">
                <p class="text-gray-400 text-xs mb-2">Dibuat: {{ $post->created_at->diffForHumans() }}</p>
                <div class="flex items-center gap-6">
                    <form action="{{ route('posts.like', $post->id) }}" method="POST">@csrf
                        <button type="submit" class="flex items-center gap-2 hover:text-red-600">❤️ 
                            <span>{{ $post->likes()->count() }}</span>
                        </button>
                    </form>
                    <a href="{{ route('posts.show', $post->id) }}" 
                    class="flex items-center gap-2 hover:text-green-600 transition-colors duration-200">
                        💬 <span>{{ $post->comments()->count() }}</span>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-center">Belum ada posting.</p>
    @endforelse
</div>

{{-- Loader kecil --}}
    <div id="loader" class="text-center py-4 hidden text-gray-500">
        ⏳ Memuat postingan...
    </div>
</div>

{{-- Modal Preview Gambar --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 p-4">
    <button class="absolute top-5 right-8 text-white text-3xl font-bold" onclick="closeModal()">❌</button>
    <img id="modalImage" class="max-w-full max-h-[80vh] rounded shadow-lg object-contain" loading="lazy">
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