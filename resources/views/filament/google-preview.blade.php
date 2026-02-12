<div class="p-4 bg-white rounded-lg border border-gray-200 shadow-sm max-w-xl">
    {{-- Google Preview Mock --}}
    <div class="font-sans">
        {{-- Favicon + URL line --}}
        <div class="flex items-center gap-2 mb-1">
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center">
                <span class="text-white text-xs font-bold">IS</span>
            </div>
            <div class="text-sm">
                <div class="text-gray-700">{{ parse_url($url, PHP_URL_HOST) ?: 'insurancesell.com' }}</div>
                <div class="text-gray-500 text-xs truncate max-w-md">{{ $url }}</div>
            </div>
        </div>
        
        {{-- Title --}}
        <h3 class="text-xl text-blue-700 hover:underline cursor-pointer font-medium leading-tight mb-1">
            {{ Str::limit($title, 60) }}
        </h3>
        
        {{-- Description --}}
        <p class="text-sm text-gray-600 leading-relaxed">
            {{ Str::limit($description, 160) }}
        </p>
    </div>
    
    {{-- Character counters --}}
    <div class="mt-3 pt-3 border-t border-gray-100 flex gap-4 text-xs">
        <span class="{{ strlen($title) > 60 ? 'text-red-500' : 'text-gray-400' }}">
            Title: {{ strlen($title) }}/60
        </span>
        <span class="{{ strlen($description) > 160 ? 'text-red-500' : 'text-gray-400' }}">
            Description: {{ strlen($description) }}/160
        </span>
    </div>
</div>
