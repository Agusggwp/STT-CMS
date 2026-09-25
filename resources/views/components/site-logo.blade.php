@props([
    'size' => 'md',
    'class' => '',
])

@php
    $logoUrl = $siteSettings['logo'] ?? ($siteSettings['site_logo'] ?? null);
    $logoText = $siteSettings['logo_monogram'] ?? ($siteSettings['logo_text'] ?? 'ST');

    $sizeClasses = match($size) {
        'xs' => 'w-7 h-7 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-10 h-10 text-lg',
        'lg' => 'w-12 h-12 text-xl',
        'xl' => 'w-16 h-16 text-2xl',
        default => 'w-10 h-10 text-lg',
    };
@endphp

@if(!empty($logoUrl))
    <div class="flex items-center justify-center flex-shrink-0 {{ $sizeClasses }} {{ $class }}">
        <img src="{{ Str::startsWith($logoUrl, 'http') ? $logoUrl : asset('storage/' . $logoUrl) }}" 
             alt="{{ $siteSettings['org_short_name'] ?? ($siteSettings['site_name'] ?? 'Logo') }}" 
             class="h-full w-full object-contain">
    </div>
@else
    <div class="flex items-center justify-center text-[#1F1F1F] font-bold flex-shrink-0 transition-transform group-hover:scale-105 {{ $sizeClasses }} {{ $class }}">
        {{ $logoText }}
    </div>
@endif
