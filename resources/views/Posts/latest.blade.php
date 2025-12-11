@extends('layouts.dashboard')

@section('title', 'Postingan Terbaru')

@section('content')

<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">🆕 Postingan Terbaru</h2>
    {{-- 🔹 Filter Form --}}
    <div id="filter-wrapper" class="mb-6">
        <div class="sm:hidden mb-4 text-center">
            <button type="button" 
                    onclick="document.getElementById('mobileFilter').classList.toggle('hidden')"
                    class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-semibold">
                Filter Provinsi & Budaya
            </button>
        </div>

        <form id="filterForm" method="GET" action="{{ route('posts.latest') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div id="mobileFilter" class="sm:contents hidden sm:block">

                {{-- Provinsi --}}
                <select name="province" class="px-3 py-2 border rounded bg-white text-sm w-full">
                    <option value="">📌 Provinsi</option>
                    @foreach(['Umum','Aceh','Sumatera Utara','Sumatera Barat','Sumatera Selatan','Riau','Kepulauan Riau','Jambi','Bangka Belitung','Bengkulu','Lampung','DKI Jakarta','Jawa Barat','Banten','Jawa Tengah','DI Yogyakarta','Jawa Timur','Bali','Nusa Tenggara Barat','Nusa Tenggara Timur','Kalimantan Barat','Kalimantan Tengah','Kalimantan Selatan','Kalimantan Timur','Kalimantan Utara','Gorontalo','Sulawesi Utara','Sulawesi Tengah','Sulawesi Barat','Sulawesi Selatan','Sulawesi Tenggara','Maluku','Maluku Utara','Papua','Papua Barat','Papua Selatan','Papua Tengah','Papua Pegunungan'] as $prov)
                        <option value="{{ $prov }}" {{ request('province') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                    @endforeach
                </select>

                {{-- Kategori Budaya --}}
                <select name="file_category" class="px-3 py-2 border rounded bg-white text-sm w-full">
                    <option value="">🎭 Budaya</option>
                    @foreach(['pakaian_adat'=>'👘 Pakaian Adat','upacara_adat'=>'🙏 Upacara Adat','makanan_khas'=>'🍲 Makanan Khas','lagu_daerah'=>'🎶 Lagu Daerah','alat_musik'=>'🥁 Alat Musik Tradisional','senjata_tradisional'=>'⚔️ Senjata Tradisional','alam'=>'⛰️ Alam','rumah_tradisional'=>'🏠 Rumah Tradisional','tari_tradisional'=>'💃 Tari Tradisional','permainan_tradisional'=>'🎮 Permainan Tradisional','pertunjukan_daerah'=>'👯‍♀️ Pertunjukan Daerah','profil_daerah'=>'📜 Profil Daerah','cerita_rakyat'=>'📖 Cerita Rakyat','sejarah'=>'📚 Sejarah','event'=>'🎉 Kegiatan/Event'] as $key=>$label)
                        <option value="{{ $key }}" {{ request('file_category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                {{-- Jenis File --}}
                <select name="category" class="px-3 py-2 border rounded bg-white text-sm w-full">
                    <option value="">📁 Kategori</option>
                    @foreach(['images'=>'🖼️ Gambar','music'=>'🎵 Musik','videos'=>'🎬 Video','docs'=>'📄 Dokumen'] as $key=>$label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

            </div>
        </form>
    </div>

    {{-- 🔹 Post Container --}}
    <div id="post-container">
        @forelse($posts as $post)
            <div class="post-card mb-10 border rounded-lg shadow bg-white overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-200">
                
                {{-- Header --}}
                <div class="flex items-center justify-between px-4 py-3 border-b">
                    <div>
                        {{-- Judul dengan read more (berdasarkan jumlah karakter) --}}
                        @php
                            $maxLength = 50; // batas karakter sebelum Read more muncul
                            $isLongTitle = strlen($post->title) > $maxLength;
                            $shortTitle = Str::limit($post->title, $maxLength, '');
                        @endphp

                        <p class="font-semibold break-title">
                            <span id="short-title-{{ $post->id }}">{{ $shortTitle }}</span>
                            @if($isLongTitle)
                                <span id="full-title-{{ $post->id }}" class="hidden">{{ $post->title }}</span>
                                ... <button onclick="toggleTitle({{ $post->id }})" class="text-red-500 hover:underline text-sm">Read more</button>
                            @endif
                        </p>

                        {{-- Info tambahan di bawah judul --}}
                        <div class="text-xs text-gray-500 space-x-2">
                            <span>📌 {{ ucfirst($post->province) ?? 'Umum' }}</span>
                            <span>🎭 {{ ucfirst($post->file_category) ?? 'Tidak ada kategori' }}</span>
                            <span class="px-2 py-1 bg-gray-200 rounded">{{ ucfirst($post->category) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Media / File --}}
                @php
                    $coverPath = $post->cover_path;
                    $filePath  = $post->file_path;
                    $isImage   = $filePath && Str::endsWith($filePath, ['jpg','jpeg','png','gif','webp']);
                    $isMusic   = $filePath && Str::endsWith($filePath, ['mp3','wav','ogg']);
                    $isVideo   = $filePath && Str::endsWith($filePath, ['mp4','webm']);
                    $isDoc     = $filePath && Str::endsWith($filePath, ['pdf','doc','docx','xls','xlsx','ppt','pptx']);
                @endphp

                @if ($coverPath && !$isVideo)
                    <div class="w-full bg-gray-100" onclick="event.preventDefault(); openModal('{{ asset('storage/' . $post->cover_path) }}')">
                        <img src="{{ asset('storage/' . $coverPath) }}" class="w-full object-contain" loading="lazy">
                    </div>
                @endif

                @if ($isImage)
                    <div class="w-full bg-gray-100" onclick="event.preventDefault(); openModal('{{ asset('storage/' . $post->file_path) }}')">
                        <img src="{{ asset('storage/' . $filePath) }}" class="w-full object-contain" loading="lazy">
                    </div>
                @endif

                {{-- Musik --}}
                @if ($isMusic)
                    <div class="px-4 py-3 border-b">
                        <button class="music-track w-full px-3 py-2 bg-purple-600 text-white rounded hover:bg-purple-700"
                            data-src="{{ route('audio.stream', basename($post->file_path)) }}"
                            data-title="{{ $post->title }}">
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
                            preload="none" 
                            playsinline 
                            class="video-player max-h-[500px] object-contain w-full rounded-b cursor-pointer transition-transform duration-200 group-hover:scale-[1.02]" 
                            poster="{{ $coverPath ? asset('storage/' . $coverPath) : '' }}"
                            loading="lazy"
                            onclick="event.preventDefault(); event.stopPropagation();"
                            controlslist="nodownload"
                            controls
                        >
                            <source src="{{ route('video.stream', basename($post->file_path)) }}" type="video/mp4">
                            Browser kamu tidak mendukung video.
                        </video>

                        {{-- Overlay ▶️ tampil sebelum video diputar, lalu hilang permanen --}}
                        <div class="video-overlay absolute inset-0 flex items-center justify-center bg-black/30 transition-opacity duration-500 opacity-0 group-hover:opacity-100 pointer-events-none">
                            <span class="text-white text-5xl">▶︎</span>
                        </div>
                    </div>
                @endif

                @if ($isDoc && $post->category === 'docs')
                    <div class="px-4 py-3 border-b flex gap-3">
                        <a href="{{ route('posts.download', $post->id) }}" class="flex-1 text-center px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">⬇️ Download</a>
                        @if(Str::endsWith($filePath,'pdf'))
                            <a href="{{ route('posts.preview', $post->id) }}" target="_blank" class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">🔍 Preview</a>
                        @endif
                    </div>
                @endif

                @if($post->content)
                    <div class="px-4 py-3 text-sm text-gray-700 border-b">{!! nl2br(e($post->content)) !!}</div>
                @endif

                {{-- Like & Comment --}}
                <div class="px-4 py-3 text-lg">
                    <p class="text-gray-400 text-xs mb-2">Dibuat: {{ $post->created_at->diffForHumans() }}</p>
                    <div class="flex items-center gap-6">
                        <form action="{{ route('posts.like', $post->id) }}" method="POST">@csrf
                            <button type="submit" class="flex items-center gap-2 hover:text-red-600">❤️ <span>{{ $post->likes()->count() }}</span></button>
                        </form>
                        <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-2 hover:text-green-600 transition-colors duration-200">💬 <span>{{ $post->comments()->count() }}</span></a>
                    </div>
                </div>

            </div>
        @empty
            <p class="text-gray-500 text-center">Belum ada posting.</p>
        @endforelse
    </div>

    {{-- Loader --}}
    <div id="loader" class="text-center py-4 hidden text-gray-500">⏳ Memuat postingan...</div>

    {{-- Modal Preview Gambar --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 p-4 transition-opacity duration-300">
    <button class="absolute top-5 right-8 text-white text-3xl font-bold hover:text-red-400" onclick="closeModal()">❌</button>
    <img id="modalImage" class="max-w-full max-h-[80vh] rounded shadow-lg object-contain transform transition-transform duration-300 scale-95 opacity-0" loading="lazy">
</div>
</div>
@endsection