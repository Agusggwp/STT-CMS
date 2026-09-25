@extends('layouts.app')

@section('title', ($siteSettings['meta_title'] ?? 'STT ArtDevata — Generasi Muda Bali Berkarya untuk Banjar dan Budaya'))
@section('meta_description', ($siteSettings['meta_description'] ?? 'Situs resmi Sekaa Teruna Teruni ArtDevata Banjar ArtDevata. Wadah pemuda adat Bali berlandaskan Tri Hita Karana.'))

@section('content')
{{-- 1. HERO SECTION --}}
@php
    $heroBadge = $siteSettings['hero_badge'] ?? 'Sekaa Teruna Teruni • Banjar ArtDevata';
    $heroTitlePrefix = $siteSettings['hero_title_prefix'] ?? 'SEKAA TERUNA TERUNI';
    $heroHeadline = $siteSettings['hero_headline'] ?? 'Generasi Muda Bali, Berkarya untuk Banjar dan Budaya';
    $heroDescription = $siteSettings['hero_description'] ?? 'Wadah kebersamaan pemuda adat dalam merawat keluhuran tradisi, ngayah tulus ikhlas, dan menyalakan api kreativitas generasi muda tanpa kehilangan jati diri kearifan lokal Bali.';
    $heroCtaPrimaryText = $siteSettings['hero_cta_primary_text'] ?? 'Lihat Kegiatan';
    $heroCtaPrimaryUrl = $siteSettings['hero_cta_primary_url'] ?? '/kegiatan';
    $heroCtaSecondaryText = $siteSettings['hero_cta_secondary_text'] ?? 'Kenali STT';
    $heroCtaSecondaryUrl = $siteSettings['hero_cta_secondary_url'] ?? '/tentang';
    $heroImage = $siteSettings['hero_image'] ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=85';
@endphp

<section class="bg-white border-b border-[#E5E5E5] py-10 sm:py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-12 lg:gap-16 items-center">
            {{-- Left: Identity, Headline & CTAs --}}
            <div class="lg:col-span-7 space-y-4 sm:space-y-6">
                {{-- Cultural Accent Badge --}}
                <div class="inline-flex items-center gap-2 px-3 py-1.5 border border-[#E5E5E5] bg-white text-[11px] sm:text-xs font-semibold tracking-wider uppercase text-[#8B1E24]">
                    <span class="w-1.5 h-1.5 bg-[#8B1E24]"></span>
                    <span>{{ $heroBadge }}</span>
                </div>

                <div>
                    <span class="block text-xs sm:text-sm font-bold tracking-widest text-[#8B1E24] uppercase mb-1.5 sm:mb-2">
                        {{ $heroTitlePrefix }}
                    </span>
                    <h1 class="text-2xl sm:text-4xl lg:text-6xl font-extrabold text-[#1F1F1F] tracking-tight leading-[1.2] sm:leading-[1.12]">
                        {{ $heroHeadline }}
                    </h1>
                </div>

                <div class="w-16 sm:w-20 h-0.5 bg-[#8B1E24]"></div>

                <p class="text-sm sm:text-lg text-[#6B6B6B] leading-relaxed max-w-2xl font-normal">
                    {{ $heroDescription }}
                </p>

                {{-- Action Buttons --}}
                <div class="pt-2 sm:pt-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                    <a href="{{ $heroCtaPrimaryUrl }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs sm:text-sm font-bold tracking-wider uppercase transition-colors shadow-xs">
                        <span>{{ $heroCtaPrimaryText }}</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ $heroCtaSecondaryUrl }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-white border border-[#E5E5E5] hover:border-[#1F1F1F] text-[#1F1F1F] text-xs sm:text-sm font-bold tracking-wider uppercase transition-colors">
                        <span>{{ $heroCtaSecondaryUrl ? $heroCtaSecondaryText : 'Kenali STT' }}</span>
                    </a>
                </div>

                {{-- Quick metadata highlight --}}
                <div class="pt-6 sm:pt-8 border-t border-[#E5E5E5] grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6 text-xs text-[#6B6B6B]">
                    <div>
                        <span class="block font-bold text-xs sm:text-sm text-[#1F1F1F]">Banjar ArtDevata</span>
                        <span>Desa Adat ArtDevata</span>
                    </div>
                    <div>
                        <span class="block font-bold text-xs sm:text-sm text-[#1F1F1F]">Tri Hita Karana</span>
                        <span>Falsafah Organisasi</span>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <span class="block font-bold text-xs sm:text-sm text-[#1F1F1F]">Periode 2024–2027</span>
                        <span>Kepengurusan Aktif</span>
                    </div>
                </div>
            </div>

            {{-- Right: Natural Photography (Standard Image Element, Not BG) --}}
            <div class="lg:col-span-5">
                <div class="relative">
                    {{-- Minimal decorative border frame --}}
                    <div class="p-2 border border-[#E5E5E5] bg-white">
                        <img src="{{ $heroImage }}"
                             alt="Pemuda STT Bali dalam kegiatan tradisi"
                             fetchpriority="high"
                             decoding="async"
                             class="w-full h-[280px] sm:h-[420px] lg:h-[480px] object-cover object-center filter grayscale-20 contrast-105">
                    </div>
                    {{-- Caption below photo --}}
                    <div class="mt-2.5 flex items-center justify-between text-[11px] sm:text-xs text-[#6B6B6B]">
                        <span>Dokumentasi Pemuda Banjar ArtDevata</span>
                        <span class="text-[#8B1E24] font-medium">Ngayah & Pasikian</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 2. TENTANG STT & STATISTIK SECTION --}}
<section class="bg-white py-12 sm:py-20 border-b border-[#E5E5E5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-12 items-center">
            <div class="lg:col-span-6 space-y-3.5 sm:space-y-4">
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Tentang Organisasi</span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-[#1F1F1F] tracking-tight">
                    Merajut Semangat Pemuda Berlandaskan Nilai Luhur Bali
                </h2>
                <div class="w-12 h-0.5 bg-[#8B1E24]"></div>
                <p class="text-sm sm:text-base text-[#6B6B6B] leading-relaxed">
                    Sekaa Teruna Teruni (STT) ArtDevata adalah wadah kepemudaan adat tingkat banjar yang berdiri kokoh sebagai garda terdepan dalam menjaga keharmonisan hubungan manusia dengan Tuhan (Parahyangan), sesama warga (Pawongan), dan kelestarian alam (Palemahan).
                </p>
                <p class="text-sm sm:text-base text-[#6B6B6B] leading-relaxed">
                    Kami memadukan disiplin tradisi adat Bali dengan wawasan modern, membekali teruna teruni dengan kepemimpinan, kepedulian sosial, keterampilan seni karawitan, serta literasi digital.
                </p>
                <div class="pt-2">
                    <a href="{{ route('about') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#8B1E24] hover:underline">
                        <span>Pelajari Sejarah & Visi Misi STT</span>
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            {{-- 4 Big Clean Statistics Numbers --}}
            <div class="lg:col-span-6 grid grid-cols-2 gap-4 sm:gap-8">
                <div class="p-4 sm:p-6 border border-[#E5E5E5] bg-white">
                    <span class="block text-3xl sm:text-5xl font-extrabold text-[#8B1E24] tracking-tight mb-1 sm:mb-2">120+</span>
                    <span class="block text-xs sm:text-sm font-bold text-[#1F1F1F]">Krama Teruna Teruni</span>
                    <span class="block text-[11px] sm:text-xs text-[#6B6B6B] mt-1">Anggota aktif Banjar ArtDevata</span>
                </div>
                <div class="p-4 sm:p-6 border border-[#E5E5E5] bg-white">
                    <span class="block text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mb-1 sm:mb-2">34+</span>
                    <span class="block text-xs sm:text-sm font-bold text-[#1F1F1F]">Program Terlaksana</span>
                    <span class="block text-[11px] sm:text-xs text-[#6B6B6B] mt-1">Sosial, adat, keolahragaan</span>
                </div>
                <div class="p-4 sm:p-6 border border-[#E5E5E5] bg-white">
                    <span class="block text-3xl sm:text-5xl font-extrabold text-[#C49A3A] tracking-tight mb-1 sm:mb-2">18+</span>
                    <span class="block text-xs sm:text-sm font-bold text-[#1F1F1F]">Apresiasi & Prestasi</span>
                    <span class="block text-[11px] sm:text-xs text-[#6B6B6B] mt-1">Ogoh-ogoh, tabuh, olahraga</span>
                </div>
                <div class="p-4 sm:p-6 border border-[#E5E5E5] bg-white">
                    <span class="block text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mb-1 sm:mb-2">100%</span>
                    <span class="block text-xs sm:text-sm font-bold text-[#1F1F1F]">Gotong Royong</span>
                    <span class="block text-[11px] sm:text-xs text-[#6B6B6B] mt-1">Kebersamaan banjar</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. KEGIATAN UNGGULAN (EDITORIAL CARDS WITH REAL PHOTOS) --}}
<section class="bg-white py-20 border-b border-[#E5E5E5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Aktivitas Nyata</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F1F1F] tracking-tight mt-1">
                    Kegiatan Terkini Pemuda Banjar
                </h2>
                <div class="w-12 h-0.5 bg-[#8B1E24] mt-2"></div>
            </div>
            <a href="{{ route('activities.index') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#1F1F1F] hover:text-[#8B1E24] transition-colors">
                <span>Lihat Seluruh Kegiatan ({{ \App\Models\Activity::published()->count() }})</span>
                <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($featuredActivities as $act)
                <article class="group flex flex-col bg-white border border-[#E5E5E5] hover:border-[#1F1F1F] transition-colors">
                    <a href="{{ route('activities.show', $act->slug) }}" class="overflow-hidden">
                        <img src="{{ $act->thumbnail_url }}"
                             alt="{{ $act->title }}"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-56 object-cover object-center group-hover:scale-102 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs text-[#6B6B6B]">
                                <span class="font-semibold text-[#8B1E24] uppercase tracking-wider">{{ $act->category->name ?? 'Kegiatan' }}</span>
                                <span>{{ $act->event_date ? $act->event_date->isoFormat('D MMMM Y') : '' }}</span>
                            </div>
                            <h3 class="text-base font-bold text-[#1F1F1F] group-hover:text-[#8B1E24] transition-colors leading-snug">
                                <a href="{{ route('activities.show', $act->slug) }}">{{ $act->title }}</a>
                            </h3>
                            <p class="text-xs text-[#6B6B6B] line-clamp-2 leading-relaxed">
                                {{ $act->description }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-[#E5E5E5] flex items-center justify-between text-xs text-[#6B6B6B]">
                            <span class="truncate max-w-[180px]">{{ $act->location ?? 'Banjar ArtDevata' }}</span>
                            <span class="font-semibold text-[#1F1F1F] group-hover:text-[#8B1E24]">Detail &rarr;</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-12 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Belum ada kegiatan yang dipublikasikan.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- 4. AGENDA / EVENT MENDATANG --}}
<section class="bg-white py-20 border-b border-[#E5E5E5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Agenda & Paruman</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F1F1F] tracking-tight mt-1">
                    Jadwal Kegiatan Mendatang
                </h2>
                <div class="w-12 h-0.5 bg-[#8B1E24] mt-2"></div>
            </div>
            <a href="{{ route('events.index') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#1F1F1F] hover:text-[#8B1E24] transition-colors">
                <span>Semua Agenda &rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($upcomingEvents as $ev)
                <div class="p-6 border border-[#E5E5E5] bg-white flex flex-col justify-between space-y-4 hover:border-[#8B1E24] transition-colors">
                    <div>
                        {{-- Date Badge --}}
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 border border-[#8B1E24] bg-white flex flex-col items-center justify-center text-center">
                                <span class="text-base font-extrabold text-[#8B1E24] leading-none">{{ $ev->event_date->format('d') }}</span>
                                <span class="text-[10px] font-bold text-[#1F1F1F] uppercase tracking-wider">{{ $ev->event_date->isoFormat('MMM') }}</span>
                            </div>
                            <div class="text-xs text-[#6B6B6B]">
                                <span class="block font-semibold text-[#1F1F1F]">{{ $ev->start_time ?? 'Waktu Paruman' }}</span>
                                <span>{{ $ev->location }}</span>
                            </div>
                        </div>

                        <h3 class="text-base font-bold text-[#1F1F1F] hover:text-[#8B1E24] transition-colors">
                            <a href="{{ route('events.show', $ev->slug) }}">{{ $ev->title }}</a>
                        </h3>
                        <p class="text-xs text-[#6B6B6B] mt-2 line-clamp-2 leading-relaxed">
                            {{ $ev->description }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-[#E5E5E5] flex items-center justify-between text-xs">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#8B1E24]">Mendatang</span>
                        <a href="{{ route('events.show', $ev->slug) }}" class="font-semibold text-[#1F1F1F] hover:text-[#8B1E24]">
                            Informasi Lengkap &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Tidak ada agenda mendatang saat ini.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- 5. EDITORIAL GALLERY PREVIEW (ASYMMETRIC CLEAN PHOTO MOSAIC) --}}
<section class="bg-white py-20 border-b border-[#E5E5E5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Dokumentasi Visual</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F1F1F] tracking-tight mt-1">
                    Galeri & Momen Bersejarah
                </h2>
                <div class="w-12 h-0.5 bg-[#8B1E24] mt-2"></div>
            </div>
            <a href="{{ route('gallery.index') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#1F1F1F] hover:text-[#8B1E24] transition-colors">
                <span>Koleksi Album Lengkap &rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($galleryAlbums as $alb)
                <div class="group border border-[#E5E5E5] bg-white p-2">
                    <a href="{{ route('gallery.show', $alb->slug) }}" class="block overflow-hidden">
                        <img src="{{ $alb->cover_image_url }}"
                             alt="{{ $alb->title }}"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-64 object-cover object-center group-hover:scale-102 transition-transform duration-300">
                    </a>
                    <div class="p-3">
                        <div class="flex items-center justify-between text-[11px] text-[#6B6B6B]">
                            <span class="font-semibold text-[#8B1E24] uppercase tracking-wider">{{ $alb->category }}</span>
                            <span>{{ $alb->images_count ?? $alb->images->count() }} Foto</span>
                        </div>
                        <h3 class="text-sm font-bold text-[#1F1F1F] mt-1 group-hover:text-[#8B1E24] transition-colors truncate">
                            <a href="{{ route('gallery.show', $alb->slug) }}">{{ $alb->title }}</a>
                        </h3>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-10 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Belum ada album foto dalam galeri.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- 6. BERITA & WARTA ORGANISASI --}}
<section class="bg-white py-20 border-b border-[#E5E5E5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Kabar Banjar</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F1F1F] tracking-tight mt-1">
                    Warta & Berita Terkini
                </h2>
                <div class="w-12 h-0.5 bg-[#8B1E24] mt-2"></div>
            </div>
            <a href="{{ route('posts.index') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#1F1F1F] hover:text-[#8B1E24] transition-colors">
                <span>Lihat Arsip Berita &rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($latestNews as $post)
                <article class="flex flex-col border border-[#E5E5E5] bg-white group hover:border-[#1F1F1F] transition-colors">
                    <a href="{{ route('posts.show', $post->slug) }}" class="overflow-hidden">
                        <img src="{{ $post->thumbnail_url }}"
                             alt="{{ $post->title }}"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-48 object-cover object-center group-hover:scale-102 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs text-[#6B6B6B]">
                                <span class="font-semibold text-[#8B1E24]">{{ $post->category->name ?? 'Warta' }}</span>
                                <span>{{ $post->published_at ? $post->published_at->isoFormat('D MMM Y') : '' }}</span>
                            </div>
                            <h3 class="text-base font-bold text-[#1F1F1F] group-hover:text-[#8B1E24] transition-colors leading-snug">
                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-xs text-[#6B6B6B] line-clamp-2 leading-relaxed">
                                {{ $post->summary }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-[#E5E5E5] flex items-center justify-between text-xs text-[#6B6B6B]">
                            <span>Oleh {{ $post->author_name ?? 'Redaksi STT' }}</span>
                            <span class="font-semibold text-[#1F1F1F] group-hover:text-[#8B1E24]">Baca &rarr;</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-10 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Belum ada artikel berita.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- 7. PROGRAM KERJA SUMMARY --}}
<section class="bg-white py-20 border-b border-[#E5E5E5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Rencana & Realisasi</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F1F1F] tracking-tight mt-1">
                    Sorotan Program Kerja STT
                </h2>
                <div class="w-12 h-0.5 bg-[#8B1E24] mt-2"></div>
            </div>
            <a href="{{ route('work-programs.index') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-[#1F1F1F] hover:text-[#8B1E24] transition-colors">
                <span>Seluruh Program Kerja &rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($workPrograms as $wp)
                <div class="p-6 border border-[#E5E5E5] bg-white space-y-3">
                    <div class="flex items-center justify-between">
                        @php $badge = $wp->status_badge; @endphp
                        <span class="inline-block px-2.5 py-1 text-[11px] font-bold border uppercase tracking-wider {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                        <span class="text-xs text-[#6B6B6B]">PIC: {{ $wp->pic_name ?? 'Pengurus' }}</span>
                    </div>
                    <h3 class="text-base font-bold text-[#1F1F1F]">{{ $wp->name }}</h3>
                    <p class="text-xs text-[#6B6B6B] line-clamp-2 leading-relaxed">{{ $wp->description }}</p>
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Belum ada program kerja terdaftar.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- 8. CALL TO ACTION / PASIKIAN BANJAR --}}
<section class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border border-[#E5E5E5] p-8 sm:p-14 bg-white text-center space-y-6">
            <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Pasikian & Kerjasama</span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-[#1F1F1F] tracking-tight max-w-2xl mx-auto">
                Bersama Menjaga Marwah Budaya dan Memajukan Banjar
            </h2>
            <div class="w-12 h-0.5 bg-[#8B1E24] mx-auto"></div>
            <p class="text-sm sm:text-base text-[#6B6B6B] max-w-xl mx-auto leading-relaxed">
                Pintu kami senantiasa terbuka untuk sinergi, kolaborasi kegiatan sosial, pelatihan keterampilan, maupun partisipasi krama teruna teruni Banjar ArtDevata.
            </p>
            <div class="pt-2 flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    <span>Hubungi Pengurus STT</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="{{ route('documents.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-[#E5E5E5] hover:border-[#1F1F1F] text-[#1F1F1F] text-xs font-bold uppercase tracking-wider transition-colors">
                    <span>Unduh AD/ART & Dokumen</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
