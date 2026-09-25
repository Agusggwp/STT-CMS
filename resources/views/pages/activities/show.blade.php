@extends('layouts.app')

@section('title', $activity->title . ' — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', Str::limit(strip_tags($activity->description ?? $activity->content), 160))
@section('og_image', $activity->thumbnail_url)

@section('content')
<article class="py-12 sm:py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-[#6B6B6B]">
            <a href="{{ route('home') }}" class="hover:text-[#8B1E24]">Beranda</a>
            <span>/</span>
            <a href="{{ route('activities.index') }}" class="hover:text-[#8B1E24]">Kegiatan</a>
            <span>/</span>
            <span class="text-[#1F1F1F] font-medium truncate">{{ $activity->title }}</span>
        </nav>

        {{-- Meta Badges & Title --}}
        <div class="space-y-4">
            <div class="flex items-center gap-3 text-xs">
                <span class="px-2.5 py-1 bg-white border border-[#8B1E24] text-[#8B1E24] font-bold uppercase tracking-wider">
                    {{ $activity->category->name ?? 'Kegiatan Adat' }}
                </span>
                <span class="text-[#6B6B6B]">{{ $activity->event_date ? $activity->event_date->isoFormat('dddd, D MMMM Y') : '' }}</span>
            </div>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-[#1F1F1F] tracking-tight leading-tight">
                {{ $activity->title }}
            </h1>

            <div class="w-16 h-0.5 bg-[#8B1E24]"></div>

            {{-- Location & Author bar --}}
            <div class="flex flex-wrap items-center gap-6 py-3 border-y border-[#E5E5E5] text-xs text-[#6B6B6B]">
                @if($activity->location)
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-[#8B1E24]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $activity->location }}</span>
                    </div>
                @endif
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#6B6B6B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Penulis: {{ $activity->author_name ?? 'Pengurus STT' }}</span>
                </div>
            </div>
        </div>

        {{-- Featured Thumbnail --}}
        <div class="border border-[#E5E5E5] p-2 bg-white">
            <img src="{{ $activity->thumbnail_url }}"
                 alt="{{ $activity->title }}"
                 class="w-full h-[360px] sm:h-[480px] object-cover object-center">
        </div>

        {{-- Main Narrative Content --}}
        <div class="prose max-w-none text-[#1F1F1F] leading-relaxed space-y-4 text-base">
            @if($activity->description && !$activity->content)
                <p class="text-lg text-[#6B6B6B] leading-relaxed">{{ $activity->description }}</p>
            @endif
            {!! $activity->content !!}
        </div>

        {{-- Gallery Images for Activity --}}
        @if(!empty($activity->gallery_images) && count($activity->gallery_images) > 0)
            <div class="pt-8 border-t border-[#E5E5E5] space-y-4">
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Foto Dokumentasi Terkait</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($activity->gallery_images as $img)
                        <div class="border border-[#E5E5E5] p-2 bg-white">
                            <img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}"
                                 alt="Dokumentasi {{ $activity->title }}"
                                 class="w-full h-64 object-cover object-center">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Related Activities --}}
        @if($relatedActivities->count() > 0)
            <div class="pt-12 border-t border-[#E5E5E5] space-y-6">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Kegiatan Terkait Lainnya</span>
                    <a href="{{ route('activities.index') }}" class="text-xs text-[#6B6B6B] hover:text-[#8B1E24]">Semua Kegiatan &rarr;</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedActivities as $rel)
                        <a href="{{ route('activities.show', $rel->slug) }}" class="border border-[#E5E5E5] p-3 bg-white block group hover:border-[#8B1E24]">
                            <img src="{{ $rel->thumbnail_url }}" alt="{{ $rel->title }}" class="w-full h-36 object-cover object-center">
                            <span class="block text-[11px] text-[#8B1E24] font-semibold uppercase mt-2">{{ $rel->category->name ?? 'Kegiatan' }}</span>
                            <h4 class="text-xs font-bold text-[#1F1F1F] mt-1 group-hover:text-[#8B1E24] line-clamp-2">{{ $rel->title }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>
@endsection
