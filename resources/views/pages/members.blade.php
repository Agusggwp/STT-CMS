@extends('layouts.app')

@section('title', 'Pengurus Aktif — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Profil seluruh pengurus dan kader aktif Sekaa Teruna Teruni ArtDevata Banjar ArtDevata Bali.')

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Kaderisasi & Kepengurusan</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Pengurus Aktif STT
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Mengenal lebih dekat para pengurus teruna dan teruni yang mendedikasikan waktu dan tenaga untuk banjar.
        </p>
    </div>
</section>

<div class="py-16 sm:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($members as $m)
                <div class="border border-[#E5E5E5] p-4 bg-white flex flex-col justify-between space-y-4 hover:border-[#1F1F1F] transition-colors">
                    <div>
                        <img src="{{ $m->photo_url }}"
                             alt="{{ $m->name }}"
                             class="w-full h-64 object-cover object-center filter grayscale-15">
                        <div class="mt-4 space-y-1">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#8B1E24]">{{ $m->position_title }}</span>
                            <h3 class="text-base font-bold text-[#1F1F1F]">{{ $m->name }}</h3>
                            <span class="block text-xs text-[#6B6B6B]">{{ $m->period }}</span>
                            @if($m->bio)
                                <p class="text-xs text-[#6B6B6B] pt-2 leading-relaxed border-t border-[#E5E5E5] mt-2">
                                    {{ $m->bio }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if(!empty($m->social_links['instagram']))
                        <div class="pt-3 border-t border-[#E5E5E5] flex items-center justify-between text-xs">
                            <a href="{{ $m->social_links['instagram'] }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-[#8B1E24] hover:underline">
                                Instagram &rarr;
                            </a>
                            @if($m->email)
                                <a href="mailto:{{ $m->email }}" class="text-[#6B6B6B] hover:text-[#1F1F1F]">Email</a>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Belum ada data pengurus yang aktif.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
