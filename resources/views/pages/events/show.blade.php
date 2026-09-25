@extends('layouts.app')

@section('title', $event->title . ' — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', Str::limit(strip_tags($event->description), 160))
@section('og_image', $event->poster_url)

@section('content')
<article class="py-12 sm:py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-[#6B6B6B]">
            <a href="{{ route('home') }}" class="hover:text-[#8B1E24]">Beranda</a>
            <span>/</span>
            <a href="{{ route('events.index') }}" class="hover:text-[#8B1E24]">Agenda</a>
            <span>/</span>
            <span class="text-[#1F1F1F] font-medium truncate">{{ $event->title }}</span>
        </nav>

        {{-- Event Header --}}
        <div class="space-y-4">
            <div class="flex items-center gap-3 text-xs">
                <span class="px-2.5 py-1 bg-white border border-[#8B1E24] text-[#8B1E24] font-bold uppercase tracking-wider">
                    {{ ucfirst($event->status) }}
                </span>
                <span class="text-[#6B6B6B]">{{ $event->event_date->isoFormat('dddd, D MMMM Y') }}</span>
            </div>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-[#1F1F1F] tracking-tight leading-tight">
                {{ $event->title }}
            </h1>

            <div class="w-16 h-0.5 bg-[#8B1E24]"></div>
        </div>

        {{-- Event Schedule Meta Box --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 p-6 border border-[#E5E5E5] bg-white text-xs">
            <div>
                <span class="block text-[#6B6B6B] uppercase tracking-wider font-semibold">Tanggal</span>
                <span class="block text-sm font-bold text-[#1F1F1F] mt-1">{{ $event->event_date->isoFormat('D MMMM Y') }}</span>
            </div>
            <div>
                <span class="block text-[#6B6B6B] uppercase tracking-wider font-semibold">Waktu</span>
                <span class="block text-sm font-bold text-[#1F1F1F] mt-1">{{ $event->start_time ?? '19:00 WITA' }} @if($event->end_time) - {{ $event->end_time }} @endif</span>
            </div>
            <div>
                <span class="block text-[#6B6B6B] uppercase tracking-wider font-semibold">Lokasi</span>
                <span class="block text-sm font-bold text-[#1F1F1F] mt-1">{{ $event->location }}</span>
            </div>
        </div>

        @if($event->poster)
            <div class="border border-[#E5E5E5] p-2 bg-white">
                <img src="{{ $event->poster_url }}" alt="{{ $event->title }}" class="w-full h-auto max-h-[500px] object-contain">
            </div>
        @endif

        {{-- Description --}}
        <div class="prose max-w-none text-[#1F1F1F] text-base leading-relaxed space-y-4">
            {!! nl2br(e($event->description)) !!}
        </div>

        @if($event->registration_link)
            <div class="pt-6 border-t border-[#E5E5E5] flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-[#1F1F1F]">Konfirmasi Kehadiran & Partisipasi</span>
                    <span class="block text-xs text-[#6B6B6B]">Silakan hubungi koordinator melalui link berikut</span>
                </div>
                <a href="{{ $event->registration_link }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 bg-[#8B1E24] text-white text-xs font-bold uppercase tracking-wider hover:bg-[#73171C]">
                    Konfirmasi Sekarang &rarr;
                </a>
            </div>
        @endif
    </div>
</article>
@endsection
