@extends('layouts.app')

@section('title', 'Dokumen & Publikasi — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Pusat unduhan berkas AD/ART, proposal, laporan pertanggungjawaban, dan panduan organisasi STT ArtDevata.')

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Arsip Digital Organisasi</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Dokumen & Berkas Resmi
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Akses dan unduh dokumen anggaran dasar, laporan pertanggungjawaban, proposal kegiatan, dan panduan keorganisasian.
        </p>
    </div>
</section>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        {{-- Filter & Search --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 pb-6 border-b border-[#E5E5E5]">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('documents.index') }}"
                   class="px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ !request('kategori') ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                    Semua Berkas
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('documents.index', ['kategori' => $cat]) }}"
                       class="px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ request('kategori') == $cat ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <form action="{{ route('documents.index') }}" method="GET" class="w-full md:w-72">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <div class="relative">
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Cari dokumen..."
                           class="w-full pl-3 pr-9 py-2 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden">
                    <button type="submit" class="absolute right-2.5 top-2.5 text-[#6B6B6B] hover:text-[#8B1E24]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Documents Table List --}}
        <div class="border border-[#E5E5E5] divide-y divide-[#E5E5E5] bg-white">
            @forelse($documents as $doc)
                <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 hover:bg-neutral-50/50 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 border border-[#8B1E24] bg-white flex items-center justify-center text-[#8B1E24] flex-shrink-0 font-bold text-xs uppercase">
                            PDF
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-white border border-[#8B1E24] text-[#8B1E24]">
                                    {{ $doc->category }}
                                </span>
                                <span class="text-xs text-[#6B6B6B]">{{ $doc->published_at ? $doc->published_at->isoFormat('D MMM Y') : '' }}</span>
                                <span class="text-xs text-[#6B6B6B]">• {{ $doc->file_size ?? 'PDF' }}</span>
                            </div>
                            <h3 class="text-base font-bold text-[#1F1F1F]">
                                {{ $doc->title }}
                            </h3>
                            @if($doc->description)
                                <p class="text-xs text-[#6B6B6B] max-w-2xl leading-relaxed">
                                    {{ $doc->description }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-4 flex-shrink-0">
                        <span class="text-xs text-[#6B6B6B] hidden sm:inline">{{ $doc->downloads_count }}x diunduh</span>
                        <a href="{{ route('documents.download', $doc->slug) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#8B1E24] text-white hover:bg-[#73171C] text-xs font-bold uppercase tracking-wider transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh PDF</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-sm text-[#6B6B6B]">
                    Tidak ada dokumen ditemukan.
                </div>
            @endforelse
        </div>

        <div>
            {{ $documents->links() }}
        </div>

    </div>
</div>
@endsection
