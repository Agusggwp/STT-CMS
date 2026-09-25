@extends('layouts.app')

@section('title', 'Galeri Budaya & Dokumentasi — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Dokumentasi visual terpadu aktivitas adat, pawai ogoh-ogoh, seni karawitan, dan kegiatan kepemudaan Banjar ArtDevata.')

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Arsip Dokumentasi Visual</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Galeri Foto Organisasi
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Kumpulan album dokumentasi odalan, gotong royong, lomba, karya ogoh-ogoh, dan porseni pemuda Banjar ArtDevata.
        </p>
    </div>
</section>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        {{-- Category Filter Pills --}}
        <div class="flex flex-wrap items-center gap-2 pb-6 border-b border-[#E5E5E5]">
            <a href="{{ route('gallery.index') }}"
               class="px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ !request('kategori') ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                Semua Kategori
            </a>
            @foreach(['Odalan', 'Gotong Royong', 'Lomba', 'Kegiatan Sosial', 'Olahraga', 'Budaya', 'Organisasi'] as $cat)
                <a href="{{ route('gallery.index', ['kategori' => $cat]) }}"
                   class="px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ request('kategori') == $cat ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- Album Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($albums as $alb)
                <div class="group border border-[#E5E5E5] p-3 bg-white hover:border-[#1F1F1F] transition-colors flex flex-col justify-between">
                    <div>
                        <a href="{{ route('gallery.show', $alb->slug) }}" class="block overflow-hidden">
                            <img src="{{ $alb->cover_image_url }}"
                                 alt="{{ $alb->title }}"
                                 class="w-full h-64 object-cover object-center group-hover:scale-102 transition-transform duration-300">
                        </a>
                        <div class="p-4 space-y-2">
                            <div class="flex items-center justify-between text-xs text-[#6B6B6B]">
                                <span class="font-bold text-[#8B1E24] uppercase tracking-wider">{{ $alb->category }}</span>
                                <span>{{ $alb->images->count() }} Foto</span>
                            </div>
                            <h3 class="text-base font-bold text-[#1F1F1F] group-hover:text-[#8B1E24] transition-colors">
                                <a href="{{ route('gallery.show', $alb->slug) }}">{{ $alb->title }}</a>
                            </h3>
                            @if($alb->description)
                                <p class="text-xs text-[#6B6B6B] line-clamp-2 leading-relaxed">
                                    {{ $alb->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="px-4 pb-2 pt-2 border-t border-[#E5E5E5] flex items-center justify-between text-xs text-[#6B6B6B]">
                        <span>{{ $alb->event_date ? $alb->event_date->isoFormat('D MMMM Y') : '' }}</span>
                        <a href="{{ route('gallery.show', $alb->slug) }}" class="font-semibold text-[#1F1F1F] group-hover:text-[#8B1E24]">
                            Buka Album &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Belum ada album foto untuk kategori ini.
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div>
            {{ $albums->links() }}
        </div>

        {{-- Editorial Mosaic Highlight Section --}}
        @if($highlightImages->count() > 0)
            <div class="pt-16 border-t border-[#E5E5E5] space-y-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Momen Pilihan</span>
                    <h2 class="text-2xl font-bold text-[#1F1F1F] tracking-tight mt-1">Sorotan Dokumentasi Lapangan</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($highlightImages as $hImg)
                        <div class="border border-[#E5E5E5] p-1.5 bg-white group">
                            <img src="{{ $hImg->image_url }}"
                                 alt="{{ $hImg->caption ?? 'Foto STT Bali' }}"
                                 class="w-full h-48 object-cover object-center filter grayscale-15 group-hover:grayscale-0 transition-all duration-300">
                            @if($hImg->caption)
                                <p class="text-[11px] text-[#6B6B6B] p-2 truncate">{{ $hImg->caption }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
