@extends('layouts.app')

@section('title', 'Dokumentasi Kegiatan — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Arsip dokumentasi seluruh kegiatan pemuda adat Sekaa Teruna Teruni ArtDevata Banjar ArtDevata.')

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Arsip Aksi & Karya</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Kegiatan Pemuda
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Dokumentasi komprehensif gotong royong, ngayah, karya seni ogoh-ogoh, dan kegiatan sosial pemuda banjar.
        </p>
    </div>
</section>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Search & Category Filter Bar --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 pb-8 mb-8 border-b border-[#E5E5E5]">
            {{-- Category Filter Pills --}}
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('activities.index') }}"
                   class="px-3 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ !request('kategori') ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('activities.index', ['kategori' => $cat->slug]) }}"
                       class="px-3 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ request('kategori') == $cat->slug ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                        {{ $cat->name }} ({{ $cat->activities_count }})
                    </a>
                @endforeach
            </div>

            {{-- Search Box --}}
            <form action="{{ route('activities.index') }}" method="GET" class="w-full md:w-72">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <div class="relative">
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Cari kegiatan..."
                           class="w-full pl-3 pr-9 py-2 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden">
                    <button type="submit" class="absolute right-2.5 top-2.5 text-[#6B6B6B] hover:text-[#8B1E24]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Activities Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($activities as $act)
                <article class="flex flex-col bg-white border border-[#E5E5E5] hover:border-[#1F1F1F] transition-colors group">
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
                            <span class="font-semibold text-[#1F1F1F] group-hover:text-[#8B1E24]">Selengkapnya &rarr;</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-16 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Tidak ada kegiatan yang sesuai dengan pencarian Anda.
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
