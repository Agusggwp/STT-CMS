@extends('layouts.app')

@section('title', $album->title . ' — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', Str::limit(strip_tags($album->description), 160))
@section('og_image', $album->cover_image_url)

@section('content')
<div class="py-12 sm:py-20 bg-white" x-data="{ modalOpen: false, modalImg: '', modalCaption: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-[#6B6B6B]">
            <a href="{{ route('home') }}" class="hover:text-[#8B1E24]">Beranda</a>
            <span>/</span>
            <a href="{{ route('gallery.index') }}" class="hover:text-[#8B1E24]">Galeri</a>
            <span>/</span>
            <span class="text-[#1F1F1F] font-medium truncate">{{ $album->title }}</span>
        </nav>

        {{-- Album Header --}}
        <div class="space-y-4 max-w-3xl">
            <div class="flex items-center gap-3 text-xs">
                <span class="px-2.5 py-1 bg-white border border-[#8B1E24] text-[#8B1E24] font-bold uppercase tracking-wider">
                    {{ $album->category }}
                </span>
                <span class="text-[#6B6B6B]">{{ $album->event_date ? $album->event_date->isoFormat('D MMMM Y') : '' }}</span>
                <span>•</span>
                <span class="text-[#6B6B6B]">{{ $album->images->count() }} Dokumentasi Foto</span>
            </div>

            <h1 class="text-2xl sm:text-4xl font-extrabold text-[#1F1F1F] tracking-tight leading-tight">
                {{ $album->title }}
            </h1>

            <div class="w-16 h-0.5 bg-[#8B1E24]"></div>

            @if($album->description)
                <p class="text-sm sm:text-base text-[#6B6B6B] leading-relaxed">
                    {{ $album->description }}
                </p>
            @endif
        </div>

        {{-- Photos Grid (Large, Medium, Small editorial styling) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pt-6 border-t border-[#E5E5E5]">
            @forelse($album->images as $index => $img)
                <div class="border border-[#E5E5E5] p-2 bg-white group cursor-pointer"
                     @click="modalOpen = true; modalImg = '{{ $img->image_url }}'; modalCaption = '{{ addslashes($img->caption ?? $album->title) }}'">
                    <div class="overflow-hidden">
                        <img src="{{ $img->image_url }}"
                             alt="{{ $img->caption ?? $album->title }}"
                             class="w-full h-64 sm:h-72 object-cover object-center group-hover:scale-102 transition-transform duration-300">
                    </div>
                    @if($img->caption)
                        <p class="text-xs text-[#6B6B6B] p-2 leading-relaxed">
                            {{ $img->caption }}
                        </p>
                    @endif
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-sm text-[#6B6B6B]">
                    Belum ada foto yang diunggah ke dalam album ini.
                </div>
            @endforelse
        </div>

        {{-- Lightbox Modal --}}
        <div x-show="modalOpen"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
             @keydown.escape.window="modalOpen = false"
             x-cloak>
            <div class="bg-white max-w-4xl w-full p-4 relative" @click.away="modalOpen = false">
                <button @click="modalOpen = false" class="absolute top-2 right-2 text-xl font-bold text-[#1F1F1F] hover:text-[#8B1E24] p-2">
                    &times;
                </button>
                <img :src="modalImg" :alt="modalCaption" class="w-full max-h-[80vh] object-contain mx-auto">
                <p class="text-xs text-[#6B6B6B] text-center mt-3" x-text="modalCaption"></p>
            </div>
        </div>

        {{-- Other Albums --}}
        @if($otherAlbums->count() > 0)
            <div class="pt-16 border-t border-[#E5E5E5] space-y-6">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Album Lainnya</span>
                    <a href="{{ route('gallery.index') }}" class="text-xs text-[#6B6B6B] hover:text-[#8B1E24]">Seluruh Album &rarr;</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($otherAlbums as $oa)
                        <a href="{{ route('gallery.show', $oa->slug) }}" class="border border-[#E5E5E5] p-2 bg-white block group hover:border-[#8B1E24]">
                            <img src="{{ $oa->cover_image_url }}" alt="{{ $oa->title }}" class="w-full h-40 object-cover object-center">
                            <span class="block text-[11px] text-[#8B1E24] font-semibold uppercase mt-2">{{ $oa->category }}</span>
                            <h4 class="text-xs font-bold text-[#1F1F1F] mt-1 group-hover:text-[#8B1E24] truncate">{{ $oa->title }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
