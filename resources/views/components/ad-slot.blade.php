{{-- Reusable Ad Slot Component --}}
@php
    $slotKey = $slot ?? 'ad_slot_1';
    $adCode = setting($slotKey . '_code', '');
    $adEnabled = setting($slotKey . '_enabled', 'true') !== 'false';
@endphp

@if($adEnabled && $adCode)
<div class="my-4">
    <div class="ad-slot rounded-xl overflow-hidden">
        {!! $adCode !!}
    </div>
</div>
@endif
