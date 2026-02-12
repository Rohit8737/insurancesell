@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-primary mb-4">No Posts Available</h1>
        <p class="text-gray-400 mb-6">Check back soon for exciting content!</p>
        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-pink-600 transition-colors">
            Refresh
        </a>
    </div>
</div>
@endsection
