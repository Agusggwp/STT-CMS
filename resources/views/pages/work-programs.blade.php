@extends('layouts.app')

@section('title', 'Program Kerja — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Daftar program kerja rencana, sedang berjalan, dan telah terlaksana oleh Sekaa Teruna Teruni ArtDevata Banjar ArtDevata.')

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Transparansi & Akuntabilitas</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Program Kerja STT
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Rencana kerja strategis, progres pelaksanaan, dan evaluasi hasil kegiatan demi kemajuan Banjar ArtDevata.
        </p>
    </div>
</section>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- Statistics Row --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="p-6 border border-[#E5E5E5] bg-white text-center">
                <span class="block text-3xl sm:text-4xl font-extrabold text-[#1F1F1F]">{{ $stats['total'] }}</span>
                <span class="block text-xs font-bold text-[#6B6B6B] uppercase tracking-wider mt-1">Total Program</span>
            </div>
            <div class="p-6 border border-amber-300 bg-amber-50/20 text-center">
                <span class="block text-3xl sm:text-4xl font-extrabold text-amber-800">{{ $stats['berjalan'] }}</span>
                <span class="block text-xs font-bold text-amber-900 uppercase tracking-wider mt-1">Sedang Berjalan</span>
            </div>
            <div class="p-6 border border-emerald-300 bg-emerald-50/20 text-center">
                <span class="block text-3xl sm:text-4xl font-extrabold text-emerald-800">{{ $stats['selesai'] }}</span>
                <span class="block text-xs font-bold text-emerald-900 uppercase tracking-wider mt-1">Telah Selesai</span>
            </div>
            <div class="p-6 border border-neutral-300 bg-neutral-50/50 text-center">
                <span class="block text-3xl sm:text-4xl font-extrabold text-neutral-700">{{ $stats['rencana'] }}</span>
                <span class="block text-xs font-bold text-neutral-600 uppercase tracking-wider mt-1">Dalam Rencana</span>
            </div>
        </div>

        {{-- Filter Buttons --}}
        <div class="flex flex-wrap items-center gap-2 pb-6 border-b border-[#E5E5E5]">
            <a href="{{ route('work-programs.index') }}"
               class="px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ !request('status') ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                Semua Status ({{ $stats['total'] }})
            </a>
            <a href="{{ route('work-programs.index', ['status' => 'berjalan']) }}"
               class="px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ request('status') == 'berjalan' ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                Sedang Berjalan ({{ $stats['berjalan'] }})
            </a>
            <a href="{{ route('work-programs.index', ['status' => 'selesai']) }}"
               class="px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ request('status') == 'selesai' ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                Telah Selesai ({{ $stats['selesai'] }})
            </a>
            <a href="{{ route('work-programs.index', ['status' => 'rencana']) }}"
               class="px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ request('status') == 'rencana' ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                Dalam Rencana ({{ $stats['rencana'] }})
            </a>
        </div>

        {{-- Programs List --}}
        <div class="space-y-6">
            @forelse($programs as $prog)
                <div class="border border-[#E5E5E5] p-6 sm:p-8 bg-white space-y-4 hover:border-[#1F1F1F] transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            @php $badge = $prog->status_badge; @endphp
                            <span class="inline-block px-3 py-1 text-xs font-bold border uppercase tracking-wider {{ $badge['class'] }}">
                                {{ $badge['label'] }}
                            </span>
                            @if($prog->pic_name)
                                <span class="text-xs text-[#6B6B6B]">Penanggung Jawab: <strong class="text-[#1F1F1F]">{{ $prog->pic_name }}</strong></span>
                            @endif
                        </div>

                        <div class="text-xs text-[#6B6B6B]">
                            @if($prog->start_date)
                                <span>Periode: {{ $prog->start_date->isoFormat('MMM Y') }} @if($prog->end_date) - {{ $prog->end_date->isoFormat('MMM Y') }} @endif</span>
                            @endif
                        </div>
                    </div>

                    <h3 class="text-lg sm:text-xl font-bold text-[#1F1F1F] tracking-tight">
                        {{ $prog->name }}
                    </h3>

                    @if($prog->description)
                        <p class="text-sm text-[#6B6B6B] leading-relaxed">
                            {{ $prog->description }}
                        </p>
                    @endif

                    @if($prog->objectives)
                        <div class="p-4 bg-white border border-[#E5E5E5] space-y-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#8B1E24] block">Tujuan & Target Program:</span>
                            <div class="text-xs text-[#1F1F1F] leading-relaxed whitespace-pre-line">
                                {{ $prog->objectives }}
                            </div>
                        </div>
                    @endif

                    @if($prog->documentation_notes)
                        <div class="text-xs text-[#6B6B6B] pt-2 border-t border-[#E5E5E5]">
                            <strong>Catatan Realisasi:</strong> {{ $prog->documentation_notes }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-16 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Belum ada program kerja yang tercatat.
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
