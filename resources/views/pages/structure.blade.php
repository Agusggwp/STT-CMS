@extends('layouts.app')

@section('title', 'Struktur Organisasi — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Bagan struktur kepengurusan Sekaa Teruna Teruni ArtDevata Banjar ArtDevata periode 2024 - 2027.')

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Bagan Kepengurusan</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Struktur Organisasi
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Hierarki kepengurusan Sekaa Teruna Teruni ArtDevata Banjar ArtDevata masa bakti 2024 – 2027.
        </p>
    </div>
</section>

<div class="py-16 sm:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        {{-- Level 1: Ketua & Wakil Ketua --}}
        <div>
            <div class="text-center mb-8">
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Pimpinan Tertinggi</span>
                <div class="w-8 h-0.5 bg-[#8B1E24] mx-auto mt-2"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-3xl mx-auto">
                @if($ketua)
                    <div class="border border-[#8B1E24] p-4 bg-white text-center space-y-4">
                        <img src="{{ $ketua->photo_url }}" alt="{{ $ketua->name }}" class="w-40 h-48 mx-auto object-cover object-center filter grayscale-10">
                        <div>
                            <span class="inline-block px-3 py-1 bg-[#8B1E24] text-white text-[10px] font-bold uppercase tracking-wider">
                                {{ $ketua->position_title }}
                            </span>
                            <h3 class="text-base font-bold text-[#1F1F1F] mt-2">{{ $ketua->name }}</h3>
                            <span class="text-xs text-[#6B6B6B] block mt-0.5">{{ $ketua->period }}</span>
                            @if($ketua->bio)
                                <p class="text-xs text-[#6B6B6B] mt-2 px-4 leading-relaxed">{{ $ketua->bio }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($wakil)
                    <div class="border border-[#E5E5E5] p-4 bg-white text-center space-y-4">
                        <img src="{{ $wakil->photo_url }}" alt="{{ $wakil->name }}" class="w-40 h-48 mx-auto object-cover object-center filter grayscale-10">
                        <div>
                            <span class="inline-block px-3 py-1 bg-neutral-100 text-[#1F1F1F] text-[10px] font-bold uppercase tracking-wider border border-[#E5E5E5]">
                                {{ $wakil->position_title }}
                            </span>
                            <h3 class="text-base font-bold text-[#1F1F1F] mt-2">{{ $wakil->name }}</h3>
                            <span class="text-xs text-[#6B6B6B] block mt-0.5">{{ $wakil->period }}</span>
                            @if($wakil->bio)
                                <p class="text-xs text-[#6B6B6B] mt-2 px-4 leading-relaxed">{{ $wakil->bio }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Level 2: Sekretaris & Bendahara --}}
        <div>
            <div class="text-center mb-8">
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Badan Pengurus Harian</span>
                <div class="w-8 h-0.5 bg-[#8B1E24] mx-auto mt-2"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-3xl mx-auto">
                @if($sekretaris)
                    <div class="border border-[#E5E5E5] p-4 bg-white text-center space-y-4">
                        <img src="{{ $sekretaris->photo_url }}" alt="{{ $sekretaris->name }}" class="w-36 h-44 mx-auto object-cover object-center filter grayscale-10">
                        <div>
                            <span class="inline-block px-3 py-1 bg-neutral-100 text-[#1F1F1F] text-[10px] font-bold uppercase tracking-wider border border-[#E5E5E5]">
                                {{ $sekretaris->position_title }}
                            </span>
                            <h3 class="text-base font-bold text-[#1F1F1F] mt-2">{{ $sekretaris->name }}</h3>
                            <span class="text-xs text-[#6B6B6B] block mt-0.5">{{ $sekretaris->period }}</span>
                            @if($sekretaris->bio)
                                <p class="text-xs text-[#6B6B6B] mt-2 px-2 leading-relaxed">{{ $sekretaris->bio }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($bendahara)
                    <div class="border border-[#E5E5E5] p-4 bg-white text-center space-y-4">
                        <img src="{{ $bendahara->photo_url }}" alt="{{ $bendahara->name }}" class="w-36 h-44 mx-auto object-cover object-center filter grayscale-10">
                        <div>
                            <span class="inline-block px-3 py-1 bg-neutral-100 text-[#1F1F1F] text-[10px] font-bold uppercase tracking-wider border border-[#E5E5E5]">
                                {{ $bendahara->position_title }}
                            </span>
                            <h3 class="text-base font-bold text-[#1F1F1F] mt-2">{{ $bendahara->name }}</h3>
                            <span class="text-xs text-[#6B6B6B] block mt-0.5">{{ $bendahara->period }}</span>
                            @if($bendahara->bio)
                                <p class="text-xs text-[#6B6B6B] mt-2 px-2 leading-relaxed">{{ $bendahara->bio }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Level 3: Koordinator Bidang --}}
        <div>
            <div class="text-center mb-8">
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Koordinator Bidang & Seksi</span>
                <div class="w-8 h-0.5 bg-[#8B1E24] mx-auto mt-2"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($koordinators as $koor)
                    <div class="border border-[#E5E5E5] p-4 bg-white space-y-3">
                        <img src="{{ $koor->photo_url }}" alt="{{ $koor->name }}" class="w-full h-52 object-cover object-center filter grayscale-10">
                        <div>
                            <span class="block text-xs font-semibold text-[#8B1E24]">{{ $koor->position_title }}</span>
                            <h3 class="text-sm font-bold text-[#1F1F1F] mt-1">{{ $koor->name }}</h3>
                            <p class="text-xs text-[#6B6B6B] mt-1.5 leading-relaxed line-clamp-3">{{ $koor->bio }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
