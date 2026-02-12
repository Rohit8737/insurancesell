<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- Primary SEO --}}
    <title>@yield('title', setting('site_name', 'InsuranceSell'))</title>
    <meta name="description" content="@yield('description', setting('site_description', 'Your Insurance Guide'))">
    <link rel="canonical" href="{{ url()->current() }}">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', setting('site_name'))">
    <meta property="og:description" content="@yield('description', setting('site_description'))">
    @if(View::hasSection('og_image'))
    <meta property="og:image" content="@yield('og_image')">
    @endif
    
    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', setting('site_name'))">
    <meta name="twitter:description" content="@yield('description', setting('site_description'))">
    
    {{-- Google Site Verification --}}
    @if(setting('google_verification'))
    <meta name="google-site-verification" content="{{ setting('google_verification') }}">
    @endif
    
    {{-- Bing Site Verification --}}
    @if(setting('bing_verification'))
    <meta name="msvalidate.01" content="{{ setting('bing_verification') }}">
    @endif
    
    {{-- Favicon --}}
    @if(setting('favicon_path'))
    <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('favicon_path')) }}">
    @else
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💰</text></svg>">
    @endif
    
    {{-- Google Fonts (Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- TailwindCSS CDN with Config --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Google AdSense Script (auto-loaded if publisher ID is set) --}}
    @if(setting('adsense_publisher_id'))
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ setting('adsense_publisher_id') }}" crossorigin="anonymous"></script>
    @endif
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Inter', 'system-ui', 'sans-serif'],
                },
                animation: {
                    'bounce-slow': 'bounce 2s infinite',
                    'shimmer': 'shimmer 2s infinite',
                    'pulse-glow': 'pulseGlow 2s infinite',
                    'fade-in': 'fadeIn 0.5s ease-out',
                },
                keyframes: {
                    shimmer: {
                        '0%': { transform: 'translateX(-100%) skewX(-15deg)' },
                        '100%': { transform: 'translateX(200%) skewX(-15deg)' },
                    },
                    pulseGlow: {
                        '0%, 100%': { boxShadow: '0 0 5px rgba(249,115,22,0.5)' },
                        '50%': { boxShadow: '0 0 20px rgba(249,115,22,0.8), 0 0 40px rgba(239,68,68,0.4)' },
                    },
                    fadeIn: {
                        '0%': { opacity: '0', transform: 'translateY(10px)' },
                        '100%': { opacity: '1', transform: 'translateY(0)' },
                    },
                },
            },
        },
    }
    </script>
    
    {{-- Custom Styles --}}
    <style>
        [x-cloak] { display: none !important; }
        
        /* Smooth scrolling */
        html { scroll-behavior: smooth; }
        
        /* Remove tap highlight on mobile */
        * { -webkit-tap-highlight-color: transparent; }
        
        /* Prose styling for articles */
        .prose p { margin-bottom: 1rem; }
        .prose h2 { font-size: 1.5rem; font-weight: 700; margin: 1.5rem 0 1rem; color: #f97316; }
        .prose h3 { font-size: 1.25rem; font-weight: 600; margin: 1.25rem 0 0.75rem; color: #fb923c; }
        .prose ul, .prose ol { margin: 1rem 0; padding-left: 1.5rem; }
        .prose li { margin-bottom: 0.5rem; }
        .prose a { color: #60a5fa; text-decoration: underline; }
        .prose blockquote { 
            border-left: 4px solid #f97316; 
            padding-left: 1rem; 
            margin: 1rem 0; 
            font-style: italic;
            color: #9ca3af;
        }
        
        /* Ad slot styling */
        .ad-slot { 
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Video player responsive */
        video { max-width: 100%; height: auto; }
    </style>
    
    {{-- Header Scripts (Analytics, Facebook Pixel, etc) --}}
    @if(setting('header_scripts'))
    {!! base64_decode(setting('header_scripts')) !!}
    @endif
    
    {{-- JSON-LD / Structured Data --}}
    @yield('seo')

    {{-- Global Schema: Organization + WebSite + SitelinksSearchBox --}}
    {!! \App\Helpers\SchemaHelper::generateForLayout() !!}
</head>
<body class="font-sans antialiased bg-slate-900 text-white selection:bg-orange-500 selection:text-white">
    
    {{-- Main Content --}}
    @yield('content')
    
    {{-- Footer Navigation --}}
    <footer class="bg-slate-950 border-t border-slate-800 py-8 pb-24">
        <div class="max-w-lg mx-auto px-4">
            {{-- Logo / Site Name --}}
            <div class="text-center mb-6">
                @if(setting('logo_path'))
                <img src="{{ asset('storage/' . setting('logo_path')) }}" alt="{{ setting('site_name') }}" class="h-10 mx-auto mb-2">
                @else
                <h2 class="text-xl font-bold text-white">{{ setting('site_name', 'InsuranceSell') }}</h2>
                @endif
                <p class="text-gray-500 text-sm">{{ setting('site_description', 'Your Insurance Guide') }}</p>
            </div>
            
            {{-- Policy Links --}}
            <nav class="flex flex-wrap justify-center gap-4 mb-6 text-sm">
                <a href="{{ url('/about') }}" class="text-gray-400 hover:text-orange-400 transition">About</a>
                <a href="{{ url('/contact') }}" class="text-gray-400 hover:text-orange-400 transition">Contact</a>
                <a href="{{ url('/privacy-policy') }}" class="text-gray-400 hover:text-orange-400 transition">Privacy</a>
                <a href="{{ url('/terms') }}" class="text-gray-400 hover:text-orange-400 transition">Terms</a>
                <a href="{{ url('/disclaimer') }}" class="text-gray-400 hover:text-orange-400 transition">Disclaimer</a>
                <a href="{{ url('/dmca') }}" class="text-gray-400 hover:text-orange-400 transition">DMCA</a>
            </nav>
            
            {{-- Social Links --}}
            @if(setting('social_facebook') || setting('social_instagram') || setting('social_twitter') || setting('social_youtube'))
            <div class="flex justify-center gap-4 mb-6">
                @if(setting('social_facebook'))
                <a href="{{ setting('social_facebook') }}" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 hover:bg-blue-600 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                @endif
                @if(setting('social_instagram'))
                <a href="{{ setting('social_instagram') }}" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-500 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                @endif
                @if(setting('social_twitter'))
                <a href="{{ setting('social_twitter') }}" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 hover:bg-black transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                @endif
                @if(setting('social_youtube'))
                <a href="{{ setting('social_youtube') }}" target="_blank" rel="noopener" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-800 hover:bg-red-600 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
                @endif
            </div>
            @endif
            
            {{-- Copyright --}}
            <p class="text-center text-gray-600 text-xs">
                © {{ date('Y') }} {{ setting('site_name', 'InsuranceSell') }}. All rights reserved.
            </p>
        </div>
    </footer>
    
    {{-- Footer Scripts --}}
    @if(setting('footer_scripts'))
    {!! base64_decode(setting('footer_scripts')) !!}
    @endif

</body>
</html>
