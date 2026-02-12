<div class="space-y-4">
    {{-- Sender Info --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <span class="text-sm text-gray-500 dark:text-gray-400">From</span>
            <p class="font-medium">{{ $record->name }}</p>
        </div>
        <div>
            <span class="text-sm text-gray-500 dark:text-gray-400">Email</span>
            <p class="font-medium">
                <a href="mailto:{{ $record->email }}" class="text-primary-600 hover:underline">
                    {{ $record->email }}
                </a>
            </p>
        </div>
    </div>

    {{-- Subject --}}
    <div>
        <span class="text-sm text-gray-500 dark:text-gray-400">Subject</span>
        <p class="font-medium">{{ $record->subject ?: 'No subject' }}</p>
    </div>

    {{-- Message Content --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
        <span class="text-sm text-gray-500 dark:text-gray-400 block mb-2">Message</span>
        <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap leading-relaxed">{{ $record->message }}</p>
    </div>

    {{-- Meta Info --}}
    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 pt-2 border-t border-gray-200 dark:border-gray-700">
        <span>Received: {{ $record->created_at->format('d M Y, H:i') }}</span>
        <span>IP: {{ $record->ip_address ?? 'Unknown' }}</span>
    </div>

    {{-- Reply Button --}}
    <div class="pt-2">
        <a 
            href="mailto:{{ $record->email }}?subject=Re: {{ urlencode($record->subject ?? 'Your message') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Reply via Email
        </a>
    </div>
</div>
