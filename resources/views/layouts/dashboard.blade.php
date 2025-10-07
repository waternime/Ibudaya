<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibudaya - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/css/menu.css', 'resources/js/app.js'])
    <link rel="icon" type="image/jpg" href="{{ asset('images/logoibudaya.png') }}">
</head>
<body>
<div class="dashboard-container">

    <!-- Header Utama -->
    <header class="sticky top-0 z-50 bg-white border-b shadow-sm px-4 py-2 flex items-center justify-between">

        <!-- Kiri: Logo desktop -->
        <div class="hidden md:flex items-center">
            <a href="{{ route('posts.latest') }}">
                <img src="{{ asset('images/logoibudaya.png') }}" alt="Ibudaya Logo" class="h-14">
            </a>
        </div>

        <!-- Mobile menu toggle (hanya muncul di mobile) -->
        <button class="menu-toggle text-2xl md:hidden">☰</button>

        <!-- Tengah: Search bar -->
        <div class="flex-1 flex justify-center mx-2 md:mx-6">
            <form action="{{ route('posts.search') }}" method="GET" class="w-full max-w-full md:max-w-2xl flex">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Telusuri..."
                    class="w-full px-4 py-2 border rounded-l-full focus:ring focus:ring-blue-300">
                <button type="submit" class="px-4 bg-gray-100 border rounded-r-full hover:bg-gray-200">
                    🔍
                </button>
            </form>
        </div>

        <!-- Kanan: Theme toggle + desktop only -->
        <div class="flex items-center gap-3">
            <!-- Theme toggle selalu muncul -->
            <button id="theme-toggle"
                    class="px-3 py-1 rounded-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                🌙
            </button>

            <!-- Upload, Notifikasi, Profile desktop only -->
            <div class="hidden md:flex items-center gap-4">
                @if(Auth::check())
                    <a href="{{ route('posts.upload') }}" 
                    class="flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 hover:bg-gray-200">
                        ➕ <span class="hidden sm:inline">Buat</span>
                    </a>

                    <a href="{{ route('notifications') }}" class="text-2xl hover:text-blue-600">
                        🔔
                    </a>

                    <a href="{{ route('dashboard') }}" class="w-9 h-9 rounded-full overflow-hidden border border-gray-300">
                        <img src="{{ Auth::user()->profile_picture 
                                    ? asset('storage/'.Auth::user()->profile_picture) 
                                    : asset('images/default-avatar.png') }}" 
                            alt="Profile" class="w-full h-full object-cover">
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                    class="px-4 py-1 bg-blue-600 text-white rounded-full hover:bg-blue-700">
                    Login
                    </a>
                @endif
            </div>
        </div>
    </header>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-white shadow-sm h-screen sticky top-0 flex flex-col border-r border-gray-100">
        <!-- Scrollable content -->
        <div class="p-5 flex-1 overflow-y-auto">
        <!-- Mobile only: Upload / Notif / Profil -->
        <div class="flex flex-col gap-2 md:hidden mb-4 text-sm">
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('posts.latest') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto object-contain">
                </a>
            </div>

            <h4 class="font-semibold mb-1 text-xs text-gray-600">Akun</h4>

            @if(Auth::check())
                <a href="{{ route('posts.upload') }}" class="px-3 py-2 rounded-md bg-gray-100 hover:bg-gray-200 transition text-sm">➕ Buat</a>
                <a href="{{ route('notifications') }}" class="px-3 py-2 rounded-md bg-gray-100 hover:bg-gray-200 transition text-sm">🔔 Notifikasi</a>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-md bg-gray-100 hover:bg-gray-200 transition text-sm">
                    <img src="{{ Auth::user()->profile_picture ? asset('storage/'.Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                         alt="Profile" class="w-7 h-7 rounded-full object-cover">
                    <span class="truncate">{{ Auth::user()->name }}</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="px-3 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 text-sm text-center">Login</a>
                <a href="{{ route('register') }}" class="px-3 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 text-sm text-center">Register</a>
            @endif
        </div>

        <!-- Search (desktop & mobile) -->
        <form method="GET" action="" class="mb-5 hidden md:block">
            <div class="relative">
                <input type="text" name="search" placeholder="Telusuri..."
                       class="w-full text-sm px-3 py-2 pr-10 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-orange-400" />
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </div>
        </form>

        <!-- Jelajah -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Jelajah</h3>
            <nav class="flex flex-col gap-1 text-sm">
                <a href="{{ route('posts.popular') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md transition
                          {{ request()->routeIs('posts.popular') ? 'bg-orange-50 text-orange-600 font-semibold ring-1 ring-orange-100' : 'text-gray-700 hover:bg-gray-50' }}"
                   aria-current="{{ request()->routeIs('posts.popular') ? 'page' : '' }}">
                    <!-- star icon -->
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Populer
                </a>

                <a href="{{ route('posts.images') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md transition
                          {{ request()->routeIs('posts.images') ? 'bg-orange-50 text-orange-600 font-semibold ring-1 ring-orange-100' : 'text-gray-700 hover:bg-gray-50' }}"
                   aria-current="{{ request()->routeIs('posts.images') ? 'page' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>
                    Gambar
                </a>

                <a href="{{ route('posts.music') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md transition
                          {{ request()->routeIs('posts.music') ? 'bg-orange-50 text-orange-600 font-semibold ring-1 ring-orange-100' : 'text-gray-700 hover:bg-gray-50' }}"
                   aria-current="{{ request()->routeIs('posts.music') ? 'page' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/></svg>
                    Musik
                </a>

                <a href="{{ route('posts.videos') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md transition
                          {{ request()->routeIs('posts.videos') ? 'bg-orange-50 text-orange-600 font-semibold ring-1 ring-orange-100' : 'text-gray-700 hover:bg-gray-50' }}"
                   aria-current="{{ request()->routeIs('posts.videos') ? 'page' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/></svg>
                    Video
                </a>

                <a href="{{ route('posts.docs') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md transition
                          {{ request()->routeIs('posts.docs') ? 'bg-orange-50 text-orange-600 font-semibold ring-1 ring-orange-100' : 'text-gray-700 hover:bg-gray-50' }}"
                   aria-current="{{ request()->routeIs('posts.docs') ? 'page' : '' }}">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                    Dokumen
                </a>
            </nav>
        </div>

        <!-- Informasi -->
        <div class="mt-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Informasi</h3>
            <a href="{{ route('rules') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>
                Peraturan Pengguna
            </a>
        </div>

        <!-- Admin -->
        @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="mt-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Menu Admin</h3>
                <nav class="flex flex-col gap-1 text-sm">
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md hover:bg-gray-50">👥 Manajemen Pengguna</a>
                    <a href="{{ route('admin.posts.index') }}" class="px-3 py-2 rounded-md hover:bg-gray-50">📝 Manajemen Postingan</a>
                </nav>
            </div>
        @endif
    </div>

    <!-- Footer: Logout / Auth buttons (fixed bottom) -->
    <div class="p-5 border-t border-gray-100">
        @if(Auth::check())
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Logout</button>
            </form>
        @else
            <div class="flex flex-col gap-2">
                <a href="{{ route('login') }}" class="w-full py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-center transition">Login</a>
                <a href="{{ route('register') }}" class="w-full py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-center transition">Register</a>
            </div>
        @endif
    </div>
</aside>


    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>
</div>

<!-- Mini Audio Player -->
<div id="audio-player" class="fixed bottom-0 left-0 w-full bg-gray-900 text-white flex items-center justify-between p-3 z-50 shadow-lg hidden">
    <div class="flex items-center space-x-3 w-full">
        <button id="prev-btn" class="px-2 py-1 bg-gray-700 rounded hover:bg-gray-600">⏮️</button>
        <button id="play-btn" class="px-2 py-1 bg-gray-700 rounded hover:bg-gray-600">▶️</button>
        <button id="next-btn" class="px-2 py-1 bg-gray-700 rounded hover:bg-gray-600">⏭️</button>

        <div class="flex-1 mx-3 flex items-center space-x-2">
            <span id="current-time" class="text-xs">0:00</span>
            <input type="range" id="progress-bar" min="0" max="100" value="0" class="w-full h-1 rounded-lg bg-gray-600 accent-purple-500">
            <span id="duration" class="text-xs">0:00</span>
        </div>

        <span id="track-title" class="truncate ml-2 text-sm md:text-base">Belum ada musik</span>
    </div>
    <audio id="main-audio" class="hidden"></audio>
</div>

<!-- JS untuk musik -->
<script>
const audioPlayer = document.getElementById('audio-player');
const tracks = Array.from(document.querySelectorAll('.music-track'));
let currentIndex = -1;

const audio = document.getElementById('main-audio');
const playBtn = document.getElementById('play-btn');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const titleSpan = document.getElementById('track-title');
const progressBar = document.getElementById('progress-bar');
const currentTimeEl = document.getElementById('current-time');
const durationEl = document.getElementById('duration');

function formatTime(sec){
    const m = Math.floor(sec / 60);
    const s = Math.floor(sec % 60);
    return `${m}:${s < 10 ? '0'+s : s}`;
}

function playTrack(index){
    if(index < 0 || index >= tracks.length) return;
    const track = tracks[index];
    audio.src = track.dataset.src;
    titleSpan.textContent = track.dataset.title;
    audioPlayer.classList.remove('hidden');
    audio.play();
    currentIndex = index;
    playBtn.textContent = '⏸️';
}

function togglePlay(){
    if(audio.paused){ audio.play(); playBtn.textContent='⏸️'; }
    else { audio.pause(); playBtn.textContent='▶️'; }
}

function playNext(){ playTrack((currentIndex+1)%tracks.length); }
function playPrev(){ playTrack((currentIndex-1+tracks.length)%tracks.length); }

tracks.forEach((el,i)=> el.addEventListener('click', ()=> playTrack(i)));
playBtn.addEventListener('click', togglePlay);
nextBtn.addEventListener('click', playNext);
prevBtn.addEventListener('click', playPrev);
audio.addEventListener('ended', playNext);

audio.addEventListener('timeupdate', ()=>{
    if(audio.duration){
        const percent = (audio.currentTime/audio.duration)*100;
        progressBar.value = percent;
        currentTimeEl.textContent = formatTime(audio.currentTime);
        durationEl.textContent = formatTime(audio.duration);
    }
});

progressBar.addEventListener('input', ()=>{
    if(audio.duration) audio.currentTime = (progressBar.value/100)*audio.duration;
});

audio.addEventListener('loadedmetadata', ()=>{
    durationEl.textContent = formatTime(audio.duration);
});
</script>

<!-- JS Sidebar -->
<script>
const menuToggle = document.querySelector('.menu-toggle');
const sidebar = document.querySelector('.sidebar');
const overlay = document.querySelector('.overlay');
const sidebarLinks = document.querySelectorAll('.sidebar a');

menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
});

sidebarLinks.forEach(link => {
    link.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    });
});
</script>
<!-- JS untuk musik -->
<script>
// Toggle Dark/Light Mode
const toggleBtn = document.getElementById('theme-toggle');
const body = document.body;

// cek preferensi dari localStorage
if(localStorage.getItem('theme') === 'dark'){
    body.classList.add('dark-mode');
    toggleBtn.textContent = '☀️';
}

toggleBtn.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    if(body.classList.contains('dark-mode')){
        toggleBtn.textContent = '☀️';
        localStorage.setItem('theme','dark');
    } else {
        toggleBtn.textContent = '🌙';
        localStorage.setItem('theme','light');
    }
});
</script>
</body>
</html>