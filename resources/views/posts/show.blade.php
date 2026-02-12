<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>{{ $post->meta_title ?? $post->title }} | {{ setting('site_name', 'InsuranceSell') }}</title>
    <meta name="description" content="{{ $post->meta_description ?? Str::limit(strip_tags($post->description), 160) }}">
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Anti-Scraping Meta Tags --}}
    <meta name="robots" content="noarchive, noimageindex">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none';">
    
    {{-- Favicon --}}
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💰</text></svg>">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- TailwindCSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Google AdSense Script (auto-loaded if publisher ID is set) --}}
    @if(setting('adsense_publisher_id'))
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ setting('adsense_publisher_id') }}" crossorigin="anonymous"></script>
    @endif
    
    {{-- Alpine.js CDN --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
            },
        },
    }
    </script>
    
    <style>
        html { scroll-behavior: smooth; }
        * { -webkit-tap-highlight-color: transparent; }
        .prose p { margin-bottom: 1rem; }
        .prose h2 { font-size: 1.5rem; font-weight: 700; margin: 1.5rem 0 1rem; color: #f97316; }
        .prose h3 { font-size: 1.25rem; font-weight: 600; margin: 1.25rem 0 0.75rem; color: #fb923c; }
        .prose ul, .prose ol { margin: 1rem 0; padding-left: 1.5rem; }
        .prose li { margin-bottom: 0.5rem; }
        .ad-slot { min-height: 100px; display: flex; align-items: center; justify-content: center; }
        video { max-width: 100%; height: auto; }
        .shimmer { animation: shimmer 2s infinite; }
        @@keyframes shimmer {
            0% { transform: translateX(-100%) skewX(-15deg); }
            100% { transform: translateX(200%) skewX(-15deg); }
        }
        .glow { animation: glow 2s infinite; }
        @@keyframes glow {
            0%, 100% { box-shadow: 0 0 5px rgba(249,115,22,0.5); }
            50% { box-shadow: 0 0 20px rgba(249,115,22,0.8), 0 0 40px rgba(239,68,68,0.4); }
        }
        
        /* ===== ANTI-SCRAPING PROTECTION ===== */
        /* Disable text selection on content */
        .protected-content {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        /* Disable image dragging */
        img {
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            user-drag: none;
            pointer-events: auto;
        }
        /* Disable printing */
        @@media print {
            body * { display: none !important; }
            body::after {
                content: 'Printing is disabled. Content is protected.';
                display: block;
                font-size: 24px;
                text-align: center;
                padding: 50px;
                color: #333;
            }
        }
    </style>

    {{-- SEO SCHEMA MARKUP (All 13 Types) --}}
    {!! \App\Helpers\SchemaHelper::generateForPost($post) !!}

    {{-- Open Graph Tags --}}
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->meta_title ?? $post->title }}">
    <meta property="og:description" content="{{ $post->meta_description ?? Str::limit(strip_tags($post->description), 160) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if($post->featured_image)
    <meta property="og:image" content="{{ asset('storage/' . $post->featured_image) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    @endif
    <meta property="og:site_name" content="{{ setting('site_name', 'InsuranceSell') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->meta_title ?? $post->title }}">
    <meta name="twitter:description" content="{{ $post->meta_description ?? Str::limit(strip_tags($post->description), 160) }}">
    @if($post->featured_image)
    <meta name="twitter:image" content="{{ asset('storage/' . $post->featured_image) }}">
    @endif

</head>
<body class="font-sans antialiased bg-slate-900 text-white selection:bg-orange-500 selection:text-white" oncontextmenu="return false;">

{{-- HEADER --}}
<header class="sticky top-0 z-40 bg-gradient-to-r from-slate-900/95 via-slate-800/95 to-slate-900/95 backdrop-blur-xl border-b border-orange-500/20 shadow-2xl shadow-orange-500/10">
    <div class="max-w-lg mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                <span class="text-2xl">💰</span>
                <span class="text-xl font-bold bg-gradient-to-r from-orange-400 via-red-400 to-pink-400 bg-clip-text text-transparent">
                    {{ setting('site_name', 'InsuranceSell') }}
                </span>
            </a>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1.5 bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/30 rounded-full text-green-400 text-xs font-semibold animate-pulse">
                    🔴 LIVE
                </span>
            </div>
        </div>
    </div>
</header>

{{-- READING PROGRESS BAR --}}
<div 
    x-data="{ progress: 0 }"
    x-init="
        window.addEventListener('scroll', () => {
            const article = document.querySelector('main');
            const scrollTop = window.scrollY;
            const docHeight = article.scrollHeight - window.innerHeight;
            progress = Math.min(100, Math.max(0, (scrollTop / docHeight) * 100));
        })
    "
    class="fixed top-16 left-0 right-0 z-30 h-1 bg-slate-800/50"
>
    <div 
        class="h-full bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 transition-all duration-150 ease-out"
        :style="'width: ' + progress + '%'"
    ></div>
</div>

{{-- MAIN CONTENT --}}
<main class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
    <div class="max-w-lg mx-auto px-4 pt-8 pb-36">
        
        {{-- AD SLOT 1: Top of Page --}}
        @include('components.ad-slot', ['slot' => 'ad_slot_1'])
        
        {{-- Featured Image (Lazy Loaded) --}}
        @if($post->featured_image)
        <div class="relative rounded-2xl overflow-hidden shadow-2xl mb-6 ring-2 ring-orange-500/30 glow">
            <img 
                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='450'%3E%3Crect fill='%231e293b' width='800' height='450'/%3E%3C/svg%3E"
                data-src="{{ asset('storage/' . $post->featured_image) }}" 
                alt="{{ $post->title }}"
                class="w-full h-auto object-cover lazy-img"
                loading="lazy"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
        </div>
        @endif

        {{-- AD SLOT 2: After Featured Image --}}
        @include('components.ad-slot', ['slot' => 'ad_slot_2'])

        {{-- Bridge Text --}}
        <div class="bg-gradient-to-r from-yellow-900/40 to-orange-900/40 border border-yellow-500/30 rounded-2xl p-5 mb-6 backdrop-blur-sm shadow-xl">
            <p class="text-yellow-300 text-center text-lg font-medium leading-relaxed">
                {{ $post->bridge_text ?? '💡 Discover why smart financial planning can change your life...' }}
            </p>
        </div>

        {{-- Title --}}
        <h1 class="text-2xl md:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-100 to-gray-300 mb-5 leading-tight">
            {{ $post->title }}
        </h1>

        {{-- Meta with Reading Time & View Counter --}}
        @php
            // Calculate reading time (avg 200 words per minute)
            $wordCount = str_word_count(strip_tags($post->description));
            $readingTime = max(1, ceil($wordCount / 200));
        @endphp
        <div class="flex flex-wrap items-center gap-3 mb-6">
            {{-- Reading Time Badge --}}
            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-blue-500/20 to-cyan-500/20 border border-blue-500/30 rounded-full text-blue-300 text-xs font-medium">
                ⏱️ {{ $readingTime }} min read
            </span>
            
            {{-- View Counter Badge --}}
            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/30 rounded-full text-green-300 text-xs font-medium">
                👁️ {{ number_format($post->views) }} views
            </span>
            
            {{-- Date Badge --}}
            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-purple-500/20 to-pink-500/20 border border-purple-500/30 rounded-full text-purple-300 text-xs font-medium">
                📅 {{ $post->created_at->format('M d, Y') }}
            </span>
        </div>

        {{-- Article Content --}}
        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 mb-6 border border-white/10 shadow-xl">
            <div class="prose prose-invert prose-orange max-w-none text-gray-300 leading-relaxed">
                {!! $content !!}
            </div>
        </div>

        {{-- AD SLOT 3: Before Video --}}
        @include('components.ad-slot', ['slot' => 'ad_slot_3'])

        {{-- GOD-LEVEL Video Player (Click-to-Play + JS Rendered) --}}
        @if($post->video_path)
        {{-- 
            PERFORMANCE OPTIMIZATION:
            - Video element is NOT in the initial HTML (bots see only a thumbnail image)
            - Video is injected via JavaScript only when user clicks play
            - This is a standard click-to-play UX pattern for performance
        --}}
        <div 
            x-data="{
                videoLoaded: false,
                playing: false,
                muted: false,
                progress: 0,
                currentTime: '0:00',
                duration: '0:00',
                showControls: true,
                controlsTimer: null,
                volume: 1,
                showVolume: false,
                playbackRate: 1,
                showSpeed: false,
                buffered: 0,
                isFullscreen: false,
                doubleTapTimer: null,
                seekIndicator: null,
                
                formatTime(seconds) {
                    const mins = Math.floor(seconds / 60);
                    const secs = Math.floor(seconds % 60);
                    return mins + ':' + secs.toString().padStart(2, '0');
                },
                
                loadAndPlay() {
                    if (!this.videoLoaded) {
                        // Create video element via JavaScript (not in source HTML)
                        const container = this.$refs.videoContainer;
                        const video = document.createElement('video');
                        video.className = 'relative z-10 w-full h-auto max-h-[80vh] object-contain bg-black cursor-pointer';
                        video.setAttribute('playsinline', '');
                        video.setAttribute('preload', 'auto');
                        const poster = this.$refs.thumbnail?.src || '';
                        if (poster) video.setAttribute('poster', poster);
                        
                        const source = document.createElement('source');
                        source.src = this.$refs.videoContainer.dataset.videoSrc;
                        source.type = 'video/mp4';
                        video.appendChild(source);
                        
                        container.innerHTML = '';
                        container.appendChild(video);
                        this.$refs.video = video;
                        
                        // Attach event listeners
                        video.addEventListener('loadedmetadata', () => {
                            this.duration = this.formatTime(video.duration);
                        });
                        video.addEventListener('timeupdate', () => {
                            this.progress = (video.currentTime / video.duration) * 100;
                            this.currentTime = this.formatTime(video.currentTime);
                        });
                        video.addEventListener('progress', () => {
                            if (video.buffered.length > 0) {
                                this.buffered = (video.buffered.end(video.buffered.length - 1) / video.duration) * 100;
                            }
                        });
                        video.addEventListener('ended', () => {
                            this.playing = false;
                            this.showControls = true;
                        });
                        video.addEventListener('click', (e) => this.handleDoubleTap(e));
                        
                        this.videoLoaded = true;
                    }
                    // Play the video
                    const v = this.$refs.video;
                    if (v) {
                        v.play();
                        this.playing = true;
                        this.resetControlsTimer();
                    }
                },
                
                togglePlay() {
                    if (!this.videoLoaded) { this.loadAndPlay(); return; }
                    const video = this.$refs.video;
                    if (video.paused) {
                        video.play();
                        this.playing = true;
                    } else {
                        video.pause();
                        this.playing = false;
                    }
                    this.resetControlsTimer();
                },
                
                toggleMute() {
                    if (!this.$refs.video) return;
                    this.$refs.video.muted = !this.$refs.video.muted;
                    this.muted = this.$refs.video.muted;
                },
                
                setVolume(val) {
                    if (!this.$refs.video) return;
                    this.$refs.video.volume = val;
                    this.volume = val;
                    if (val === 0) this.muted = true;
                    else this.muted = false;
                },
                
                seek(e) {
                    if (!this.$refs.video) return;
                    const rect = e.target.getBoundingClientRect();
                    const pos = (e.clientX - rect.left) / rect.width;
                    this.$refs.video.currentTime = pos * this.$refs.video.duration;
                },
                
                setSpeed(rate) {
                    if (!this.$refs.video) return;
                    this.$refs.video.playbackRate = rate;
                    this.playbackRate = rate;
                    this.showSpeed = false;
                },
                
                toggleFullscreen() {
                    const container = this.$refs.container;
                    if (!document.fullscreenElement) {
                        container.requestFullscreen();
                        this.isFullscreen = true;
                    } else {
                        document.exitFullscreen();
                        this.isFullscreen = false;
                    }
                },
                
                handleDoubleTap(e) {
                    if (!this.$refs.video) return;
                    const video = this.$refs.video;
                    const rect = this.$refs.container.getBoundingClientRect();
                    const clickX = e.clientX - rect.left;
                    const isLeft = clickX < rect.width / 2;
                    
                    if (this.doubleTapTimer) {
                        clearTimeout(this.doubleTapTimer);
                        this.doubleTapTimer = null;
                        video.currentTime += isLeft ? -10 : 10;
                        this.seekIndicator = isLeft ? 'left' : 'right';
                        setTimeout(() => this.seekIndicator = null, 400);
                    } else {
                        this.doubleTapTimer = setTimeout(() => {
                            this.doubleTapTimer = null;
                            this.togglePlay();
                        }, 250);
                    }
                },
                
                resetControlsTimer() {
                    this.showControls = true;
                    clearTimeout(this.controlsTimer);
                    if (this.playing) {
                        this.controlsTimer = setTimeout(() => this.showControls = false, 3000);
                    }
                }
            }"
            x-ref="container"
            x-on:mousemove="resetControlsTimer()"
            x-on:touchstart="resetControlsTimer()"
            class="relative rounded-3xl overflow-hidden shadow-2xl mb-8 bg-gradient-to-br from-slate-900 via-black to-slate-900 ring-2 ring-orange-500/30 mx-auto"
            style="max-width: 100%; aspect-ratio: auto;"
        >
            {{-- Ambient Glow Effect --}}
            <div class="absolute -inset-1 bg-gradient-to-r from-orange-500/20 via-pink-500/20 to-purple-500/20 blur-2xl opacity-60 pointer-events-none"></div>
            
            {{-- Video Container: Initially shows thumbnail, video injected via JS on click --}}
            <div x-ref="videoContainer" data-video-src="{{ asset('storage/' . $post->video_path) }}" class="relative z-10">
                {{-- Click-to-Play Thumbnail (what bots see - just an image!) --}}
                <img 
                    x-ref="thumbnail"
                    src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%27800%27 height=%27450%27%3E%3Crect fill=%27%23000%27 width=%27800%27 height=%27450%27/%3E%3Ctext x=%2750%25%27 y=%2750%25%27 fill=%27%23666%27 font-size=%2724%27 text-anchor=%27middle%27 dy=%27.3em%27%3EClick to Play Video%3C/text%3E%3C/svg%3E' }}"
                    alt="{{ $post->title }} - Video Thumbnail"
                    class="w-full h-auto max-h-[80vh] object-contain bg-black"
                    loading="lazy"
                >
            </div>
            
            {{-- Double Tap Seek Indicators --}}
            <div 
                x-show="seekIndicator === 'left'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-75"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-30 flex items-center gap-1 bg-black/60 backdrop-blur-md rounded-full px-4 py-3"
            >
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.333 4zM4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path></svg>
                <span class="text-white font-bold text-sm">10s</span>
            </div>
            <div 
                x-show="seekIndicator === 'right'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-75"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-30 flex items-center gap-1 bg-black/60 backdrop-blur-md rounded-full px-4 py-3"
            >
                <span class="text-white font-bold text-sm">10s</span>
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.933 12.8a1 1 0 000-1.6L6.6 7.2A1 1 0 005 8v8a1 1 0 001.6.8l5.333-4zM19.933 12.8a1 1 0 000-1.6l-5.333-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.333-4z"></path></svg>
            </div>
            
            {{-- Play/Pause Center Overlay --}}
            <div 
                x-show="showControls || !playing"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none"
            >
                <button 
                    x-on:click.stop="togglePlay()"
                    class="pointer-events-auto w-20 h-20 flex items-center justify-center rounded-full bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 shadow-2xl shadow-orange-500/50 transform transition-all duration-300 hover:scale-110 active:scale-95"
                    :class="{ 'opacity-0': playing && !showControls }"
                >
                    <svg x-show="!playing" class="w-10 h-10 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    <svg x-show="playing" class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                    </svg>
                </button>
            </div>
            
            {{-- Gradient Overlay for Controls --}}
            <div 
                x-show="showControls"
                x-transition
                class="absolute bottom-0 left-0 right-0 z-20 bg-gradient-to-t from-black via-black/80 to-transparent pt-20 pb-4 px-4"
            >
                {{-- Progress Bar --}}
                <div 
                    x-on:click="seek($event)"
                    class="relative w-full h-1.5 bg-white/20 rounded-full cursor-pointer group mb-4 overflow-hidden"
                >
                    {{-- Buffered --}}
                    <div 
                        class="absolute inset-y-0 left-0 bg-white/30 rounded-full transition-all"
                        :style="'width: ' + buffered + '%'"
                    ></div>
                    {{-- Progress --}}
                    <div 
                        class="absolute inset-y-0 left-0 bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 rounded-full transition-all duration-100"
                        :style="'width: ' + progress + '%'"
                    ></div>
                    {{-- Scrubber Handle --}}
                    <div 
                        class="absolute top-1/2 -translate-y-1/2 w-4 h-4 bg-white rounded-full shadow-lg transform scale-0 group-hover:scale-100 transition-transform duration-200"
                        :style="'left: calc(' + progress + '% - 8px)'"
                    ></div>
                </div>
                
                {{-- Controls Row --}}
                <div class="flex items-center justify-between gap-2">
                    {{-- Left Controls --}}
                    <div class="flex items-center gap-2">
                        {{-- Play/Pause --}}
                        <button x-on:click="togglePlay()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition">
                            <svg x-show="!playing" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <svg x-show="playing" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                        </button>
                        
                        {{-- Volume --}}
                        <div class="relative" x-on:mouseenter="showVolume = true" x-on:mouseleave="showVolume = false">
                            <button x-on:click="toggleMute()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition">
                                <svg x-show="!muted && volume > 0.5" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>
                                <svg x-show="!muted && volume <= 0.5 && volume > 0" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M18.5 12c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM5 9v6h4l5 5V4L9 9H5z"/></svg>
                                <svg x-show="muted || volume === 0" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/></svg>
                            </button>
                            {{-- Volume Slider --}}
                            <div 
                                x-show="showVolume"
                                x-transition
                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 p-2 bg-black/80 backdrop-blur-md rounded-xl"
                            >
                                <input 
                                    type="range" 
                                    min="0" 
                                    max="1" 
                                    step="0.1" 
                                    x-model="volume" 
                                    x-on:input="setVolume(parseFloat($event.target.value))"
                                    class="w-20 h-1 accent-orange-500"
                                    style="writing-mode: horizontal-tb;"
                                >
                            </div>
                        </div>
                        
                        {{-- Time --}}
                        <span class="text-white/80 text-xs font-medium tabular-nums" x-text="currentTime + ' / ' + duration"></span>
                    </div>
                    
                    {{-- Right Controls --}}
                    <div class="flex items-center gap-2">
                        {{-- Playback Speed --}}
                        <div class="relative">
                            <button x-on:click="showSpeed = !showSpeed" class="flex items-center gap-1 px-3 h-8 rounded-full bg-white/10 hover:bg-white/20 transition text-white text-xs font-semibold">
                                <span x-text="playbackRate + 'x'"></span>
                            </button>
                            <div 
                                x-show="showSpeed"
                                x-transition
                                x-on:click.outside="showSpeed = false"
                                class="absolute bottom-full right-0 mb-2 p-2 bg-black/90 backdrop-blur-md rounded-xl shadow-xl"
                            >
                                <template x-for="rate in [0.5, 0.75, 1, 1.25, 1.5, 2]" :key="rate">
                                    <button 
                                        x-on:click="setSpeed(rate)"
                                        class="block w-full px-4 py-2 text-left text-white text-sm hover:bg-white/10 rounded-lg transition"
                                        :class="{ 'text-orange-400 font-bold': playbackRate === rate }"
                                        x-text="rate + 'x'"
                                    ></button>
                                </template>
                            </div>
                        </div>
                        
                        {{-- Fullscreen --}}
                        <button x-on:click="toggleFullscreen()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition">
                            <svg x-show="!isFullscreen" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
                            <svg x-show="isFullscreen" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Loading Spinner --}}
            <div 
                x-show="false"
                class="absolute inset-0 z-30 flex items-center justify-center bg-black/50"
            >
                <div class="w-12 h-12 border-4 border-orange-500/30 border-t-orange-500 rounded-full animate-spin"></div>
            </div>
        </div>
        
        {{-- Video Features Badge --}}
        <div class="flex flex-wrap justify-center gap-2 mb-6">
            <span class="px-3 py-1 bg-gradient-to-r from-orange-500/20 to-red-500/20 border border-orange-500/30 rounded-full text-orange-300 text-xs font-medium">
                🎬 HD Quality
            </span>
            <span class="px-3 py-1 bg-gradient-to-r from-purple-500/20 to-pink-500/20 border border-purple-500/30 rounded-full text-purple-300 text-xs font-medium">
                ⏱️ Speed Control
            </span>
            <span class="px-3 py-1 bg-gradient-to-r from-blue-500/20 to-cyan-500/20 border border-blue-500/30 rounded-full text-blue-300 text-xs font-medium">
                📱 Portrait Mode
        </div>
        @endif
        
        {{-- Next Video Button (Below Video) --}}
        @if($nextPost)
        <a 
            href="{{ route('post.show', $nextPost->slug) }}"
            class="block w-full py-4 px-6 mb-8 bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 rounded-2xl text-center text-white font-bold text-lg shadow-2xl relative overflow-hidden transition-transform hover:scale-[1.02] active:scale-95"
        >
            <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent shimmer"></span>
            <span class="relative flex items-center justify-center gap-3">
                <span class="text-lg">अगला वीडियो देखें</span>
                <span class="text-orange-200 text-xl">|</span>
                <span class="text-lg">▶ Next Video</span>
            </span>
        </a>
        @endif

        {{-- AD SLOT 4: After Video/Next Button --}}
        @include('components.ad-slot', ['slot' => 'ad_slot_4'])

        {{-- Share Buttons --}}
        <div class="flex justify-center gap-3 mb-8">
            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-green-600 hover:bg-green-500 transition shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-600 hover:bg-blue-500 transition shadow-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full bg-black hover:bg-gray-800 transition shadow-lg border border-gray-700">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
        </div>

        {{-- AUTHOR BOX --}}
        <div class="bg-gradient-to-br from-slate-800/50 to-slate-900/50 rounded-2xl p-6 mb-8 border border-slate-700/50 backdrop-blur-sm">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center text-2xl font-bold text-white shadow-xl">
                    {{ setting('author_avatar', '👨‍💼') }}
                </div>
                <div class="flex-1">
                    <h4 class="text-white font-bold text-lg">{{ setting('author_name', 'Insurance Expert') }}</h4>
                    <p class="text-gray-400 text-sm">{{ setting('author_bio', 'Certified financial advisor with 10+ years of experience in insurance planning.') }}</p>
                </div>
            </div>
            <div class="flex gap-3 mt-4 pt-4 border-t border-slate-700/50">
                @if(setting('social_facebook'))
                <a href="{{ setting('social_facebook') }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600/20 hover:bg-blue-600/40 border border-blue-500/30 text-blue-400 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                @endif
                @if(setting('social_instagram'))
                <a href="{{ setting('social_instagram') }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-pink-600/20 hover:bg-pink-600/40 border border-pink-500/30 text-pink-400 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                @endif
                @if(setting('social_youtube'))
                <a href="{{ setting('social_youtube') }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-red-600/20 hover:bg-red-600/40 border border-red-500/30 text-red-400 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
                @endif
                @if(setting('social_twitter'))
                <a href="{{ setting('social_twitter') }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-600/20 hover:bg-gray-600/40 border border-gray-500/30 text-gray-400 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                @endif
            </div>
        </div>

        {{-- RELATED POSTS WIDGET --}}
        @php
            $relatedPosts = \App\Models\Post::active()
                ->published()
                ->where('id', '!=', $post->id)
                ->inRandomOrder()
                ->limit(3)
                ->get();
        @endphp
        
        @if($relatedPosts->count() > 0)
        <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                <span class="text-2xl">📚</span> Related Articles
            </h3>
            <div class="space-y-3">
                @foreach($relatedPosts as $related)
                <a href="{{ route('post.show', $related->slug) }}" class="block bg-gradient-to-r from-slate-800/50 to-slate-900/50 rounded-xl p-4 border border-slate-700/30 hover:border-orange-500/50 transition group">
                    <div class="flex gap-4 items-center">
                        @if($related->featured_image)
                        <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                        @else
                        <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-orange-500/20 to-red-500/20 flex items-center justify-center flex-shrink-0">
                            <span class="text-2xl">📄</span>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h4 class="text-white font-semibold text-sm group-hover:text-orange-400 transition line-clamp-2">{{ $related->title }}</h4>
                            <p class="text-gray-500 text-xs mt-1">{{ number_format($related->views) }} views</p>
                        </div>
                        <span class="text-orange-400 group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- Sticky Footer Ad (Admin Managed) --}}
    @php
        $stickyAdCode = setting('sticky_ad_code', '');
        $stickyAdEnabled = setting('sticky_ad_enabled', 'true') !== 'false';
        $stickyBannerText = setting('sticky_banner_text', '✨ Get the best insurance quotes today!');
    @endphp
    
    @if($stickyAdEnabled)
    <div 
        x-data="{ closed: false }"
        x-show="!closed"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-full opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-full opacity-0"
        class="fixed bottom-0 left-0 right-0 z-50 bg-gradient-to-t from-slate-900 via-slate-900/98 to-slate-900/95 backdrop-blur-xl border-t border-orange-500/20 shadow-2xl shadow-black/50"
    >
        {{-- Close Button --}}
        <button 
            x-on:click="closed = true"
            class="absolute -top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-gradient-to-br from-slate-700 to-slate-800 border border-slate-600 text-white shadow-xl hover:scale-110 transition-transform z-10"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        {{-- Ad Content Container --}}
        <div class="max-w-lg mx-auto p-3">
            <div class="ad-slot rounded-xl overflow-hidden">
                @if($stickyAdCode)
                    {!! $stickyAdCode !!}
                @else
                    <div class="bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 rounded-xl p-4 text-center">
                        <span class="text-white font-semibold text-sm">{{ $stickyBannerText }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif

</main>

{{-- FOOTER --}}
<footer class="bg-gradient-to-b from-slate-950 to-black border-t border-slate-800/50 py-10 pb-28">
    <div class="max-w-lg mx-auto px-4">
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-2 mb-3">
                <span class="text-3xl">💰</span>
                <span class="text-2xl font-bold bg-gradient-to-r from-orange-400 to-red-400 bg-clip-text text-transparent">
                    {{ setting('site_name', 'InsuranceSell') }}
                </span>
            </div>
            <p class="text-gray-400 text-sm">{{ setting('site_description', 'Your Trusted Insurance Guide') }}</p>
        </div>
        
        <nav class="flex flex-wrap justify-center gap-x-5 gap-y-2 mb-8 text-sm">
            <a href="{{ url('/about') }}" class="text-gray-400 hover:text-orange-400 transition">About</a>
            <a href="{{ url('/contact') }}" class="text-gray-400 hover:text-orange-400 transition">Contact</a>
            <a href="{{ url('/privacy-policy') }}" class="text-gray-400 hover:text-orange-400 transition">Privacy</a>
            <a href="{{ url('/terms') }}" class="text-gray-400 hover:text-orange-400 transition">Terms</a>
            <a href="{{ url('/disclaimer') }}" class="text-gray-400 hover:text-orange-400 transition">Disclaimer</a>
        </nav>
        
        <div class="flex justify-center gap-4 mb-8">
            <a href="#" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-800 hover:bg-blue-600 transition border border-slate-700">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="#" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-800 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-500 transition border border-slate-700">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            <a href="#" class="w-11 h-11 flex items-center justify-center rounded-full bg-slate-800 hover:bg-red-600 transition border border-slate-700">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
        </div>
        
        <p class="text-center text-gray-600 text-xs">
            © {{ date('Y') }} {{ setting('site_name', 'InsuranceSell') }}
        </p>
    </div>
</footer>

{{-- COOKIE CONSENT BANNER --}}
<div 
    x-data="{ 
        show: false,
        init() {
            if (!localStorage.getItem('cookieConsent')) {
                setTimeout(() => this.show = true, 1500);
            }
        },
        accept() {
            localStorage.setItem('cookieConsent', 'accepted');
            this.show = false;
        },
        decline() {
            localStorage.setItem('cookieConsent', 'declined');
            this.show = false;
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="translate-y-full opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-full opacity-0"
    class="fixed bottom-20 left-4 right-4 z-40 max-w-lg mx-auto"
    style="display: none;"
>
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-5 border border-slate-700/50 shadow-2xl backdrop-blur-xl">
        <div class="flex items-start gap-4">
            <span class="text-3xl flex-shrink-0">🍪</span>
            <div class="flex-1">
                <h4 class="text-white font-bold text-sm mb-1">Cookie Notice</h4>
                <p class="text-gray-400 text-xs leading-relaxed">
                    We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies for analytics and personalized ads.
                </p>
            </div>
        </div>
        <div class="flex gap-3 mt-4">
            <button 
                x-on:click="accept()"
                class="flex-1 py-2.5 px-4 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl text-white text-sm font-semibold hover:opacity-90 transition shadow-lg"
            >
                ✓ Accept All
            </button>
            <button 
                x-on:click="decline()"
                class="py-2.5 px-4 bg-slate-700 hover:bg-slate-600 rounded-xl text-gray-300 text-sm font-medium transition"
            >
                Decline
            </button>
        </div>
    </div>
</div>

{{-- Lazy Loading Script (IntersectionObserver) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lazy load all images with data-src attribute
    const lazyImages = document.querySelectorAll('img.lazy-img, img[data-src]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        img.classList.remove('lazy-img');
                        img.classList.add('lazy-loaded');
                    }
                    imageObserver.unobserve(img);
                }
            });
        }, { rootMargin: '200px 0px' });
        
        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
    } else {
        // Fallback: load all images immediately
        lazyImages.forEach(function(img) {
            if (img.dataset.src) {
                img.src = img.dataset.src;
            }
        });
    }
    
    // Also lazy-load images inside article content
    const contentImages = document.querySelectorAll('.prose img');
    contentImages.forEach(function(img) {
        img.setAttribute('loading', 'lazy');
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.3s ease';
        img.addEventListener('load', function() {
            img.style.opacity = '1';
        });
        if (img.complete) img.style.opacity = '1';
    });
});
</script>
{{-- ===== ANTI-SCRAPING PROTECTION SYSTEM ===== --}}
<script>
(function() {
    'use strict';
    
    // 1. DISABLE KEYBOARD SHORTCUTS
    document.addEventListener('keydown', function(e) {
        // Disable F12 (DevTools)
        if (e.key === 'F12' || e.keyCode === 123) {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+U (View Source)
        if (e.ctrlKey && (e.key === 'u' || e.key === 'U')) {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+S (Save Page)
        if (e.ctrlKey && (e.key === 's' || e.key === 'S')) {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+C (Copy)
        if (e.ctrlKey && (e.key === 'c' || e.key === 'C')) {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+A (Select All)
        if (e.ctrlKey && (e.key === 'a' || e.key === 'A')) {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+P (Print)
        if (e.ctrlKey && (e.key === 'p' || e.key === 'P')) {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+Shift+I (DevTools)
        if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+Shift+J (Console)
        if (e.ctrlKey && e.shiftKey && (e.key === 'J' || e.key === 'j')) {
            e.preventDefault();
            return false;
        }
        
        // Disable Ctrl+Shift+C (Inspect Element)
        if (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c')) {
            e.preventDefault();
            return false;
        }
    });
    
    // 2. DISABLE COPY/CUT/PASTE EVENTS
    ['copy', 'cut', 'paste'].forEach(function(evt) {
        document.addEventListener(evt, function(e) {
            e.preventDefault();
            return false;
        });
    });
    
    // 3. DISABLE TEXT SELECTION
    document.addEventListener('selectstart', function(e) {
        e.preventDefault();
        return false;
    });
    
    // 4. DISABLE DRAG & DROP (prevent image saving)
    document.addEventListener('dragstart', function(e) {
        e.preventDefault();
        return false;
    });
    
    // 5. DEVTOOLS DETECTION
    var devToolsOpen = false;
    var threshold = 160;
    
    setInterval(function() {
        var widthDiff = window.outerWidth - window.innerWidth > threshold;
        var heightDiff = window.outerHeight - window.innerHeight > threshold;
        
        if (widthDiff || heightDiff) {
            if (!devToolsOpen) {
                devToolsOpen = true;
                // Blur/hide content when DevTools detected
                document.body.style.filter = 'blur(10px)';
                document.body.style.pointerEvents = 'none';
            }
        } else {
            if (devToolsOpen) {
                devToolsOpen = false;
                document.body.style.filter = 'none';
                document.body.style.pointerEvents = 'auto';
            }
        }
    }, 500);
    
    // 6. CONSOLE DETECTION (debugger trap)
    (function detect() {
        var startTime = performance.now();
        debugger;
        var endTime = performance.now();
        if (endTime - startTime > 100) {
            document.body.innerHTML = '<div style="text-align:center;padding:50px;font-size:24px;color:#f97316;">⚠️ Content Protected - Developer Tools Detected</div>';
        }
        setTimeout(detect, 3000);
    })();
    
    // 7. DISABLE RIGHT-CLICK CONTEXT MENU
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });
    
    // 8. PROTECT IMAGES - disable save image
    document.querySelectorAll('img').forEach(function(img) {
        img.addEventListener('contextmenu', function(e) { e.preventDefault(); });
        img.addEventListener('dragstart', function(e) { e.preventDefault(); });
        img.addEventListener('mousedown', function(e) {
            if (e.button === 2) e.preventDefault();
        });
    });
    
    // 9. ANTI-IFRAME (prevent embedding on other sites)
    if (window.top !== window.self) {
        window.top.location = window.self.location;
    }
    
    // 10. DISABLE SAVE AS (additional protection)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            return false;
        }
    });
    
})();
</script>

</body>
</html>
