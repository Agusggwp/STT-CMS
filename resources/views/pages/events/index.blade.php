@extends('layouts.app')

@section('title', 'Agenda & Event — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Jadwal paruman, upacara adat, latihan kesenian, dan agenda kegiatan Sekaa Teruna Teruni ArtDevata.')

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Jadwal & Agenda</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Agenda Kegiatan
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Informasi lengkap agenda paruman, ngayah, latihan seni, dan kalender kegiatan pemuda Banjar ArtDevata.
        </p>
    </div>
</section>

<div class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">

        {{-- 1. AGENDA MENDATANG --}}
        <div>
            <div class="flex items-center gap-3 mb-8 pb-4 border-b border-[#E5E5E5]">
                <div class="w-3 h-3 bg-[#8B1E24]"></div>
                <h2 class="text-xl sm:text-2xl font-bold text-[#1F1F1F] tracking-tight">Agenda Mendatang</h2>
                <span class="text-xs text-[#6B6B6B]">({{ $upcomingEvents->count() }} kegiatan terencana)</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($upcomingEvents as $ev)
                    <div class="border border-[#E5E5E5] p-6 bg-white flex flex-col justify-between space-y-6 hover:border-[#8B1E24] transition-colors">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 border border-[#8B1E24] bg-white flex flex-col items-center justify-center text-center">
                                    <span class="text-xl font-extrabold text-[#8B1E24] leading-none">{{ $ev->event_date->format('d') }}</span>
                                    <span class="text-[10px] font-bold text-[#1F1F1F] uppercase tracking-wider">{{ $ev->event_date->isoFormat('MMM Y') }}</span>
                                </div>
                                <div class="text-xs text-[#6B6B6B] space-y-0.5">
                                    <span class="block font-semibold text-[#1F1F1F]">{{ $ev->start_time ?? 'Waktu Paruman' }}</span>
                                    <span class="block text-[11px] truncate max-w-[180px]">{{ $ev->location }}</span>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-base font-bold text-[#1F1F1F] hover:text-[#8B1E24] transition-colors leading-snug">
                                    <a href="{{ route('events.show', $ev->slug) }}">{{ $ev->title }}</a>
                                </h3>
                                <p class="text-xs text-[#6B6B6B] mt-2 line-clamp-3 leading-relaxed">
                                    {{ $ev->description }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-[#E5E5E5] flex items-center justify-between text-xs">
                            @if($ev->registration_link)
                                <a href="{{ $ev->registration_link }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 bg-[#8B1E24] text-white font-bold text-[10px] uppercase tracking-wider hover:bg-[#73171C]">
                                    Konfirmasi Hadir
                                </a>
                            @else
                                <span class="text-[#6B6B6B] text-[11px]">Terbuka untuk Anggota</span>
                            @endif
                            <a href="{{ route('events.show', $ev->slug) }}" class="font-semibold text-[#1F1F1F] hover:text-[#8B1E24]">
                                Detail &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                        Saat ini belum ada agenda kegiatan mendatang.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- 2. AGENDA SEBELUMNYA --}}
        <div>
            <div class="flex items-center gap-3 mb-8 pb-4 border-b border-[#E5E5E5]">
                <div class="w-3 h-3 bg-[#E5E5E5]"></div>
                <h2 class="text-xl sm:text-2xl font-bold text-[#1F1F1F] tracking-tight">Agenda Sebelumnya</h2>
                <span class="text-xs text-[#6B6B6B]">({{ $pastEvents->total() }} kegiatan terlaksana)</span>
            </div>

            <div class="border border-[#E5E5E5] divide-y divide-[#E5E5E5] bg-white">
                @forelse($pastEvents as $ev)
                    <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-neutral-50 transition-colors">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 border border-[#E5E5E5] bg-white flex flex-col items-center justify-center text-center flex-shrink-0">
                                <span class="text-base font-bold text-[#6B6B6B] leading-none">{{ $ev->event_date->format('d') }}</span>
                                <span class="text-[9px] font-bold text-[#6B6B6B] uppercase tracking-wider">{{ $ev->event_date->isoFormat('MMM') }}</span>
                            </div>
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-neutral-100 text-neutral-600 border border-neutral-200">
                                        Selesai
                                    </span>
                                    <span class="text-xs text-[#6B6B6B]">{{ $ev->location }}</span>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-[#1F1F1F]">
                                    <a href="{{ route('events.show', $ev->slug) }}" class="hover:text-[#8B1E24]">{{ $ev->title }}</a>
                                </h3>
                                <p class="text-xs text-[#6B6B6B] line-clamp-1 max-w-2xl">{{ $ev->description }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('events.show', $ev->slug) }}" class="text-xs font-semibold text-[#8B1E24] hover:underline">
                                Arsip Acara &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm text-[#6B6B6B]">
                        Belum ada arsip agenda sebelumnya.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $pastEvents->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
