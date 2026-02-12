@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4">
    <div class="max-w-3xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <a href="{{ route('home') }}" class="inline-block mb-6">
                @if(setting('logo_path'))
                    <img src="{{ asset('storage/' . setting('logo_path')) }}" alt="{{ setting('site_name') }}" class="h-12 mx-auto">
                @else
                    <h1 class="text-2xl font-bold text-primary">{{ setting('site_name', 'InsuranceSell') }}</h1>
                @endif
            </a>
        </div>
        
        <!-- Page Content Card -->
        <div class="glass-card rounded-2xl p-8 mb-8">
            <h1 class="text-3xl font-bold text-white mb-6 text-center">{{ $page->title }}</h1>
            
            <div class="content-wrapper text-gray-300 prose prose-invert max-w-none">
                {!! $page->content !!}
            </div>
        </div>
        
        <!-- Contact Form (only on contact page) -->
        @if($page->slug === 'contact')
            <div class="glass-card rounded-2xl p-8">
                <h2 class="text-xl font-bold text-white mb-6">Send Us a Message</h2>
                
                @if(session('success'))
                    <div class="bg-green-600/20 border border-green-500 text-green-400 p-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-600/20 border border-red-500 text-red-400 p-4 rounded-lg mb-6">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Name *</label>
                        <input 
                            type="text" 
                            name="name" 
                            required 
                            class="w-full bg-darker/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-primary focus:outline-none"
                            value="{{ old('name') }}"
                        >
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Email *</label>
                        <input 
                            type="email" 
                            name="email" 
                            required 
                            class="w-full bg-darker/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-primary focus:outline-none"
                            value="{{ old('email') }}"
                        >
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Subject</label>
                        <input 
                            type="text" 
                            name="subject" 
                            class="w-full bg-darker/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-primary focus:outline-none"
                            value="{{ old('subject') }}"
                        >
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm mb-2">Message *</label>
                        <textarea 
                            name="message" 
                            required 
                            rows="5"
                            class="w-full bg-darker/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-primary focus:outline-none resize-none"
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full py-3 bg-gradient-to-r from-primary to-pink-500 text-white font-bold rounded-lg hover:opacity-90 transition-opacity"
                    >
                        Send Message
                    </button>
                </form>
            </div>
        @endif
        
        <!-- Footer Links -->
        <div class="mt-10 flex flex-wrap justify-center gap-4 text-sm text-gray-500">
            <a href="{{ route('page.show', 'about') }}" class="hover:text-primary">About</a>
            <a href="{{ route('page.show', 'contact') }}" class="hover:text-primary">Contact</a>
            <a href="{{ route('page.show', 'privacy-policy') }}" class="hover:text-primary">Privacy Policy</a>
            <a href="{{ route('page.show', 'terms') }}" class="hover:text-primary">Terms</a>
            <a href="{{ route('page.show', 'disclaimer') }}" class="hover:text-primary">Disclaimer</a>
            <a href="{{ route('page.show', 'dmca') }}" class="hover:text-primary">DMCA</a>
        </div>
        
    </div>
</div>
@endsection
