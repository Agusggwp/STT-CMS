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
                             loading="lazy"
                             decoding="async"
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
                            <a href="{{ $m->social_links['instagram'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 font-semibold text-[#8B1E24] hover:underline">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                </svg>
                                <span>Instagram &rarr;</span>
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
