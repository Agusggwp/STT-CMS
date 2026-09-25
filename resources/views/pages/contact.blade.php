@extends('layouts.app')

@section('title', 'Kontak & Sekretariat — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Hubungi pengurus Sekaa Teruna Teruni ArtDevata Banjar ArtDevata melalui formulir kontak, WhatsApp, telepon, atau kunjungi balai banjar.')

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Sekretariat & Hubungan Masyarakat</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Hubungi Pengurus STT
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Sampaikan pertanyaan, usulan kegiatan, kolaborasi kemasyarakatan, atau pendaftaran anggota melalui kanal resmi kami.
        </p>
    </div>
</section>

<div class="py-16 sm:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">

            {{-- Left column: Contact Info & Channels --}}
            <div class="lg:col-span-5 space-y-8">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Informasi Resmi</span>
                    <h2 class="text-2xl font-bold text-[#1F1F1F] mt-1">Sekretariat Banjar ArtDevata</h2>
                    <div class="w-12 h-0.5 bg-[#8B1E24] mt-3 mb-4"></div>
                    <p class="text-sm text-[#6B6B6B] leading-relaxed">
                        Kami mengundang krama banjar dan rekan pemuda untuk bersinergi dan berdiskusi langsung di wantilan Balai Banjar ArtDevata.
                    </p>
                </div>

                {{-- Detail items --}}
                <div class="space-y-6 text-sm">
                    <div class="flex items-start gap-4 p-4 border border-[#E5E5E5] bg-white">
                        <div class="w-10 h-10 border border-[#8B1E24] flex items-center justify-center text-[#8B1E24] flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <strong class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider">Alamat Balai Banjar</strong>
                            <p class="text-xs text-[#6B6B6B] mt-1 leading-relaxed">{{ $siteSettings['address'] ?? 'Balai Banjar ArtDevata, Jl. ArtDevata No. 1, Denpasar, Bali 80223' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 border border-[#E5E5E5] bg-white">
                        <div class="w-10 h-10 border border-[#8B1E24] flex items-center justify-center text-[#8B1E24] flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <strong class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider">Telepon & WhatsApp</strong>
                            <p class="text-xs text-[#6B6B6B] mt-1">{{ $siteSettings['phone'] ?? '+62 812-3456-7890' }}</p>
                            @if(!empty($siteSettings['whatsapp']))
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp']) }}?text=Om%20Swastyastu%20Pengurus%20STT"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-block mt-2 text-xs font-bold text-[#8B1E24] hover:underline">
                                    Kirim Pesan WhatsApp &rarr;
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 border border-[#E5E5E5] bg-white">
                        <div class="w-10 h-10 border border-[#8B1E24] flex items-center justify-center text-[#8B1E24] flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <strong class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider">Email Resmi</strong>
                            <p class="text-xs text-[#6B6B6B] mt-1">{{ $siteSettings['email'] ?? 'kontak@artdevata.net' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Social Media links --}}
                <div class="pt-4 border-t border-[#E5E5E5]">
                    <span class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-3">Media Sosial Resmi</span>
                    <div class="flex items-center gap-3">
                        @if(!empty($siteSettings['instagram']))
                            <a href="{{ $siteSettings['instagram'] }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#8B1E24] hover:text-[#8B1E24] transition-colors">
                                Instagram
                            </a>
                        @endif
                        @if(!empty($siteSettings['facebook']))
                            <a href="{{ $siteSettings['facebook'] }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#8B1E24] hover:text-[#8B1E24] transition-colors">
                                Facebook
                            </a>
                        @endif
                        @if(!empty($siteSettings['tiktok']))
                            <a href="{{ $siteSettings['tiktok'] }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#8B1E24] hover:text-[#8B1E24] transition-colors">
                                TikTok
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right column: Interactive Form --}}
            <div class="lg:col-span-7">
                <div class="border border-[#E5E5E5] p-8 sm:p-10 bg-white">
                    <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Kirim Pesan</span>
                    <h2 class="text-xl sm:text-2xl font-bold text-[#1F1F1F] tracking-tight mt-1 mb-2">Formulir Komunikasi</h2>
                    <p class="text-xs text-[#6B6B6B] mb-6">Pesan yang Anda kirimkan akan langsung masuk ke inbox dashboard admin pengurus.</p>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-white border border-[#E5E5E5] border-l-4 border-l-[#8B1E24] text-xs text-[#1F1F1F]">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                                    Nama Lengkap *
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                                       placeholder="Contoh: ArtDevata">
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                                    Alamat Email *
                                </label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                                       placeholder="email@anda.com">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                                    Nomor Telepon / WhatsApp
                                </label>
                                <input type="text"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                                       placeholder="0812xxxxxxxx">
                            </div>

                            <div>
                                <label for="subject" class="block text-xs font-semibold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                                    Subjek Pesan
                                </label>
                                <input type="text"
                                       id="subject"
                                       name="subject"
                                       value="{{ old('subject') }}"
                                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                                       placeholder="Pertanyaan / Kolaborasi">
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-semibold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                                Isi Pesan *
                            </label>
                            <textarea id="message"
                                      name="message"
                                      rows="5"
                                      required
                                      class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                                      placeholder="Tuliskan pesan, tanggapan, atau aspirasi Anda...">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit"
                                class="w-full py-3.5 px-6 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                            Kirim Pesan Sekarang &rarr;
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Google Maps Embed Section --}}
        @if(!empty($siteSettings['google_maps_embed']))
            <div class="mt-20 pt-12 border-t border-[#E5E5E5] space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Lokasi Fisik</span>
                        <h3 class="text-xl font-bold text-[#1F1F1F] mt-1">Peta Lokasi Balai Banjar ArtDevata</h3>
                    </div>
                </div>
                <div class="border border-[#E5E5E5] p-2 bg-white w-full overflow-hidden">
                    <iframe src="{{ $siteSettings['google_maps_embed'] }}"
                            class="w-full h-80 sm:h-96 border-0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
