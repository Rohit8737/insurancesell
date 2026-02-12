@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <a href="{{ route('home') }}" class="inline-block">
                @if(setting('logo_path'))
                    <img src="{{ asset('storage/' . setting('logo_path')) }}" alt="{{ setting('site_name') }}" class="h-12 mx-auto">
                @else
                    <h1 class="text-3xl font-bold text-primary">{{ setting('site_name', 'InsuranceSell') }}</h1>
                @endif
            </a>
            <p class="text-gray-400 mt-2">{{ setting('site_description', 'Your Insurance Guide') }}</p>
        </div>
        
        <!-- Posts Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($posts as $post)
                <a href="{{ route('post.show', $post->slug) }}" class="glass-card rounded-xl overflow-hidden hover:border-primary transition-colors">
                    @if($post->featured_image)
                        <img 
                            src="{{ asset('storage/' . $post->featured_image) }}" 
                            alt="{{ $post->title }}"
                            class="w-full h-48 object-cover"
                            loading="lazy"
                        >
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="p-4">
                        <h2 class="font-semibold text-white line-clamp-2">{{ $post->title }}</h2>
                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                            <span>👁️ {{ number_format($post->views) }}</span>
                            <span>{{ $post->published_at?->diffForHumans() ?? 'Draft' }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400">No posts available yet.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        {{ $posts->links() }}
        
    </div>
</div>
@endsection
