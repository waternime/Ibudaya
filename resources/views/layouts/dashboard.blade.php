<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibudaya - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/css/comment.css', 'resources/css/menu.css', 'resources/js/app.js'])
    <link rel="icon" type="image/jpg" href="{{ asset('images/icon.jpg') }}">
</head>
<body>
<div class="dashboard-container">

    <!-- Header Utama -->
    <header class="sticky top-0 z-50 bg-white border-b shadow-sm px-4 py-2 flex items-center justify-between">

        <!-- Kiri: Logo desktop -->
        <div class="hidden md:flex items-center">
            <a href="{{ route('posts.latest') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Ibudya" class="h-8">
            </a>
        </div>

        <!-- Mobile menu toggle (hanya muncul di mobile) -->
        <button class="menu-toggle text-2xl md:hidden">☰</button>

        <!-- Tengah: Search bar -->
        <div class="flex-1 flex justify-center mx-2 md:mx-6">
            <form action="{{ route('posts.search') }}" method="GET" class="w-full max-w-full md:max-w-2xl flex">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Telusuri..."
                    class="w-full px-4 py-2 border rounded-l-full focus:ring-[1.5px] focus:ring-red-200 focus:outline-none">
                <button type="submit" class="px-4 bg-gray-100 border rounded-r-full hover:bg-gray-200 ">
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

                    <a href="{{ route('notifications') }}" class="text-2xl hover:text-red-600">
                        🔔
                    </a>

                    <a href="{{ route('profile') }}" class="w-9 h-9 rounded-full overflow-hidden border border-gray-300">
                        <img src="{{ Auth::user()->profile_picture 
                                    ? asset('storage/'.Auth::user()->profile_picture) 
                                    : asset('images/default-avatar.png') }}" 
                            alt="Profile" class="w-full h-full object-cover">
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                    class="px-4 py-1 bg-red-600 text-white rounded-full hover:bg-red-700">
                    Login
                    </a>
                @endif
            </div>
        </div>
    </header>
        
        <!-- Sidebar -->
        <aside class="sidebar">
        <!-- Upload, Notifikasi, Profil (mobile only) -->
        <div class="flex flex-col gap-2 md:hidden mb-3 text-sm">
            <!-- Logo khusus mobile -->
            <div class="flex items-center gap-2 mb-3">
                <a href="{{ route('posts.latest') }}">
                    <img src="{{ asset('images/logo.png') }}" 
                        alt="Logo" 
                        class="h-10 w-auto object-contain">
                </a>
            </div>

            <hr class="my-4 md:hidden">
            <h4 class="font-semibold mb-1 text-xs text-white-400 uppercase tracking-wide">Akun</h4>
            @if(Auth::check())
                <ul class="space-y-1 text-base">
                    <li>
                        <a href="{{ route('posts.upload') }}" 
                        class="flex items-center gap-2 text-gray-200 hover:text-white transition-all duration-150">
                            ➕ <span>Buat</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('notifications') }}" 
                        class="flex items-center gap-2 text-gray-200 hover:text-white transition-all duration-150">
                            🔔 <span>Notifikasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile') }}" 
                        class="flex items-center gap-2 text-gray-200 hover:text-white transition-all duration-150">
                            <img src="{{ Auth::user()->profile_picture 
                                        ? asset('storage/'.Auth::user()->profile_picture) 
                                        : asset('images/default-avatar.png') }}" 
                                alt="Profile" 
                                class="w-5 h-5 rounded-full object-cover inline-block align-middle">
                            <span class="inline-block align-middle">{{ Auth::user()->name }}</span>
                        </a>
                    </li>
                </ul>
            @else
                <a href="{{ route('login') }}" 
                class="block text-center bg-red-600 hover:bg-red-700 text-white py-1.5 rounded text-sm">
                    Login
                </a>
            @endif
        </div>

        <hr class="my-4 md:hidden">
        <h4>Jelajah</h4>
        <ul>
            <li><a href="{{ route('posts.images') }}">🖼️ Gambar</a></li>
            <li><a href="{{ route('posts.music') }}">🎵 Musik</a></li>
            <li><a href="{{ route('posts.videos') }}">🎬 Video</a></li>
            <li><a href="{{ route('posts.docs') }}">📄 Dokumen</a></li>
        </ul>

        <hr class="my-4">
        <h4>Lainnya</h4>
        <ul>
            <li><a href="{{ route('posts.popular') }}">⭐ Populer</a></li>
            <li><a href="{{ route('rules') }}">📜 Peraturan</a></li>
        </ul>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <hr class="my-4">
            <h4>Pusat Kontrol</h4>
            <ul>
                <li><a href="{{ route('admin.users.index') }}">👥 Pengguna</a></li>
                <li><a href="{{ route('admin.posts.index') }}">📝 Postingan</a></li>
            </ul>
        @endif
        <hr class="my-4">
        @if(Auth::check())
            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="logout-btn py-2 bg-red-600 text-white rounded hover:bg-red-700 w-full text-center">
                    Logout
                </button>
            </form>
        @endif
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>
</div>

<!-- Mini Audio Player -->
<div id="audio-player" class="fixed bottom-0 left-0 w-full bg-gray-900 text-white flex items-center justify-between p-3 z-50 shadow-lg hidden">
    <div class="flex items-center space-x-3 w-full">
        <!-- Play/Pause -->
        <button id="play-btn" class="px-2 py-1 bg-gray-700 rounded hover:bg-gray-600">▶️</button>

        <!-- Progress & Time -->
        <div class="flex-1 mx-3 flex items-center space-x-2">
            <span id="current-time" class="text-xs">0:00</span>
            <input type="range" id="progress-bar" min="0" max="100" value="0" class="w-full h-1 rounded-lg bg-gray-600 accent-purple-500">
            <span id="duration" class="text-xs">0:00</span>
        </div>

        <!-- Track title -->
        <span id="track-title" class="truncate max-w-[150px] md:max-w-xs text-sm md:text-base">Belum ada musik</span>

        <!-- Volume slider -->
        <input type="range" id="volume-slider" min="0" max="1" step="0.01" value="0.5" class="w-24 h-1 rounded-lg bg-gray-600 accent-purple-500">
    </div>

    <!-- Audio element -->
    <audio id="main-audio" class="hidden"></audio>
</div>

<script>
// --- JS untuk musik ---
const audioPlayer = document.getElementById('audio-player');
const tracks = Array.from(document.querySelectorAll('.music-track'));
let currentIndex = -1;

const audio = document.getElementById('main-audio');
const playBtn = document.getElementById('play-btn');
const volumeSlider = document.getElementById('volume-slider');
const titleSpan = document.getElementById('track-title');
const progressBar = document.getElementById('progress-bar');
const currentTimeEl = document.getElementById('current-time');
const durationEl = document.getElementById('duration');

// set default volume
audio.volume = volumeSlider.value;

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

// --- Volume control via slider ---
volumeSlider.addEventListener('input', ()=>{
    audio.volume = volumeSlider.value;
});

// Event listeners
tracks.forEach((el,i)=> el.addEventListener('click', ()=> playTrack(i)));
playBtn.addEventListener('click', togglePlay);

audio.addEventListener('ended', ()=>{}); // tidak pindah track otomatis

// Update progress bar & times
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

// --- FIX: klik tombol Like/Comment tidak memicu musik ---
document.querySelectorAll('.like-btn, .comment-link').forEach(btn=>{
    btn.addEventListener('click', e=>{
        e.stopPropagation();
    });
});
</script>

{{-- Script Video Player --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.video-player').forEach(video => {
        const container = video.closest('.group');
        const overlay = container?.querySelector('.video-overlay');
        let hasPlayed = false;

        // Awalnya sembunyikan kontrol video
        video.controls = false;

        video.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (video.paused) {
                // Pause semua video lain
                document.querySelectorAll('.video-player').forEach(v => {
                    if (v !== video) {
                        v.pause();
                        v.controls = false;
                    }
                });

                // Aktifkan kontrol & mainkan video
                video.controls = true;
                video.play();

                // Hilangkan overlay dengan animasi halus
                if (overlay) overlay.classList.add('opacity-0');
                hasPlayed = true;
            } else {
                video.pause();
            }
        });

        // Saat video selesai
        video.addEventListener('ended', () => {
            // Setelah selesai, sembunyikan kembali kontrol
            video.controls = false;
        });

        // Saat video pertama kali diputar
        video.addEventListener('playing', () => {
            if (overlay) {
                overlay.style.opacity = '0';
                setTimeout(() => {
                    overlay.style.display = 'none';
                }, 400); // tunggu animasi fade-out
            }
        });
    });
});
</script>

{{-- Script Video Player + Infinite Scroll + Virtual Scroll Khusus Latest --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const postContainer = document.getElementById('post-container');
    const loader = document.getElementById('loader');
    const filterForm = document.getElementById('filterForm');

    let page = 2;
    let loading = false;
    const maxPostsInDOM = 100;
    let allPosts = Array.from(postContainer.querySelectorAll('div'));
    let filterTimeout = null;

    // Ambil semua filter params
    function getFilterParams() {
        const params = new URLSearchParams();
        Array.from(filterForm.elements).forEach(el => {
            if(el.name && el.value) params.append(el.name, el.value);
        });
        return params.toString();
    }

    // Virtual Scroll Cleanup
    function virtualScrollCleanup(){
        const windowHeight = window.innerHeight;
        while(allPosts.length > maxPostsInDOM){
            const firstPost = allPosts[0];
            const lastPost = allPosts[allPosts.length-1];
            const firstRect = firstPost.getBoundingClientRect();
            const lastRect = lastPost.getBoundingClientRect();

            if(firstRect.bottom < -windowHeight){
                postContainer.removeChild(firstPost);
                allPosts.shift();
            } else if(lastRect.top > windowHeight * 2){
                postContainer.removeChild(lastPost);
                allPosts.pop();
            } else break;
        }
    }

    // Inisialisasi Video & Musik untuk post
    function initPost(post){
        // Musik
        post.querySelectorAll('.music-track').forEach(el=>{
            el.onclick = ()=>{
                const audio = document.getElementById('main-audio');
                audio.src = el.dataset.src;
                document.getElementById('track-title').textContent = el.dataset.title;
                audio.play();
                document.getElementById('audio-player').classList.remove('hidden');
                document.getElementById('play-btn').textContent = '⏸️';
            }
        });

        // Video
        post.querySelectorAll('.video-player').forEach(video=>{
            const overlay = video.closest('.group')?.querySelector('.video-overlay');
            video.controls = false;

            video.addEventListener('click', e=>{
                e.stopPropagation();
                if(video.paused){
                    // pause semua video lain
                    document.querySelectorAll('#post-container .video-player').forEach(v=>{
                        if(v !== video){
                            v.pause();
                            v.controls = false;
                        }
                    });

                    // play current
                    video.play();
                    video.controls = true;
                    if(overlay){
                        overlay.style.transition = 'opacity 0.4s';
                        overlay.style.opacity = '0';
                        setTimeout(()=> overlay.style.display='none', 400);
                    }
                } else {
                    video.pause();
                }
            });

            video.addEventListener('ended', ()=>{
                video.controls = false;
                if(overlay) overlay.style.display = '';
            });

            video.addEventListener('playing', ()=>{
                if(overlay){
                    overlay.style.transition = 'opacity 0.4s';
                    overlay.style.opacity = '0';
                    setTimeout(()=> overlay.style.display='none', 400);
                }
            });
        });
    }

    // Init post awal
    allPosts.forEach(post=>initPost(post));

    // Load more
    function loadMore(){
        if(loading) return;
        loading = true;
        loader.classList.remove('hidden');

        fetch(`?page=${page}&${getFilterParams()}`, {headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(res=>res.text())
            .then(html=>{
                const parser = new DOMParser();
                const newPosts = parser.parseFromString(html,'text/html').querySelectorAll('#post-container > div');
                if(newPosts.length===0) window.removeEventListener('scroll', handleScroll);

                newPosts.forEach(post=>{
                    postContainer.appendChild(post);
                    allPosts.push(post);
                    initPost(post);
                });

                virtualScrollCleanup();
            })
            .finally(()=>{
                loader.classList.add('hidden');
                loading = false;
                page++;
            });
    }

    // Scroll listener
    function handleScroll(){
        if(window.innerHeight + window.scrollY >= document.body.offsetHeight - 100 && !loading){
            loadMore();
        }
        virtualScrollCleanup();
    }
    window.addEventListener('scroll', handleScroll);

    // Filter change
    filterForm.addEventListener('change', ()=>{
        if(filterTimeout) clearTimeout(filterTimeout);
        filterTimeout = setTimeout(()=>{
            page = 1;
            allPosts = [];
            postContainer.innerHTML = '';
            window.addEventListener('scroll', handleScroll);
            loadMore();
        }, 800);
    });
});
</script>

{{-- Script Infinite Scroll + Virtual Scroll Semua Halaman --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const postContainer = document.getElementById('post-container-all');
    const loader = document.getElementById('loader');

    if (!postContainer) return; // aman kalau elemen ga ada

    let page = 2; // halaman pertama sudah di-load dari server
    let loading = false;
    const maxPostsInDOM = 100;
    let allPosts = Array.from(postContainer.querySelectorAll('div')); // semua post awal

    function virtualScrollCleanup() {
        const windowHeight = window.innerHeight;
        while (allPosts.length > maxPostsInDOM) {
            const firstPost = allPosts[0];
            const lastPost = allPosts[allPosts.length - 1];
            const firstRect = firstPost.getBoundingClientRect();
            const lastRect = lastPost.getBoundingClientRect();

            if (firstRect.bottom < -windowHeight) {
                postContainer.removeChild(firstPost);
                allPosts.shift();
            } else if (lastRect.top > windowHeight * 2) {
                postContainer.removeChild(lastPost);
                allPosts.pop();
            } else break;
        }
    }

    function loadMore() {
        if (loading) return;
        loading = true;
        loader.classList.remove('hidden');

        const url = `?page=${page}`;
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const newPosts = parser
                    .parseFromString(html, 'text/html')
                    .querySelectorAll('#post-container-all > div');

                if (newPosts.length === 0) {
                    window.removeEventListener('scroll', handleScroll);
                }

                newPosts.forEach(post => {
                    postContainer.appendChild(post);
                    allPosts.push(post);
                });

                virtualScrollCleanup();
            })
            .finally(() => {
                loader.classList.add('hidden');
                loading = false;
                page++;
            });
    }

    function handleScroll() {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100 && !loading) {
            loadMore();
        }
        virtualScrollCleanup();
    }

    window.addEventListener('scroll', handleScroll);
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

{{-- Script Modal --}}
<script>
    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const image = document.getElementById('modalImage');
        image.src = src;

        // animasi fade in
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            image.classList.remove('scale-95', 'opacity-0');
            image.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        const image = document.getElementById('modalImage');
        // animasi fade out
        image.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
</script>

{{-- Script Read More Postingan --}}
<script>
function toggleTitle(id) {
    const shortEl = document.getElementById(`short-title-${id}`);
    const fullEl = document.getElementById(`full-title-${id}`);
    const btn = event.target;

    if (shortEl.classList.contains('hidden')) {
        shortEl.classList.remove('hidden');
        fullEl.classList.add('hidden');
        btn.textContent = 'Read more';
    } else {
        shortEl.classList.add('hidden');
        fullEl.classList.remove('hidden');
        btn.textContent = 'Show less';
    }
}
</script>
</body>
</html>