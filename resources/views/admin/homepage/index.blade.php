@extends('layouts.admin')

@section('page_title', 'Homepage Visual CMS')

@section('header_actions')
<a href="{{ route('home') }}" target="_blank" class="px-3.5 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    Pratinjau Beranda &rarr;
</a>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-12">

    {{-- 1. HERO CMS CONFIGURATION --}}
    <div class="border border-[#E5E5E5] bg-white p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-[#E5E5E5]">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Hero Bagian Utama</span>
                <h2 class="text-lg font-bold text-[#1F1F1F] mt-0.5">Konfigurasi Hero Beranda</h2>
            </div>
            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-800 text-[10px] font-bold uppercase tracking-wider border border-emerald-300">
                Wajib Aktif
            </span>
        </div>

        <form action="{{ route('admin.homepage.hero') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Badge Teks Kecil di Atas
                    </label>
                    <input type="text"
                           name="hero_badge"
                           value="{{ old('hero_badge', $heroSettings['hero_badge'] ?? 'Sekaa Teruna Teruni • Banjar ArtDevata') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Nama Awalan Organisasi
                    </label>
                    <input type="text"
                           name="hero_title_prefix"
                           value="{{ old('hero_title_prefix', $heroSettings['hero_title_prefix'] ?? 'SEKAA TERUNA TERUNI') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Headline Utama (Judul Besar) *
                </label>
                <input type="text"
                       name="hero_headline"
                       value="{{ old('hero_headline', $heroSettings['hero_headline'] ?? 'Generasi Muda Bali, Berkarya untuk Banjar dan Budaya') }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm font-bold text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Deskripsi Ringkas Hero *
                </label>
                <textarea name="hero_description"
                          rows="3"
                          required
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm leading-relaxed focus:border-[#8B1E24] focus:outline-hidden">{{ old('hero_description', $heroSettings['hero_description'] ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 border border-[#E5E5E5] bg-white">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tombol CTA Utama (Teks)
                    </label>
                    <input type="text"
                           name="hero_cta_primary_text"
                           value="{{ old('hero_cta_primary_text', $heroSettings['hero_cta_primary_text'] ?? 'Lihat Kegiatan') }}"
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden">
                    <input type="text"
                           name="hero_cta_primary_url"
                           value="{{ old('hero_cta_primary_url', $heroSettings['hero_cta_primary_url'] ?? '/kegiatan') }}"
                           placeholder="Link URL (contoh: /kegiatan)"
                           class="w-full px-3 py-1.5 bg-white border border-[#E5E5E5] text-xs mt-2 focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tombol CTA Kedua (Teks)
                    </label>
                    <input type="text"
                           name="hero_cta_secondary_text"
                           value="{{ old('hero_cta_secondary_text', $heroSettings['hero_cta_secondary_text'] ?? 'Kenali STT') }}"
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden">
                    <input type="text"
                           name="hero_cta_secondary_url"
                           value="{{ old('hero_cta_secondary_url', $heroSettings['hero_cta_secondary_url'] ?? '/tentang') }}"
                           placeholder="Link URL (contoh: /tentang)"
                           class="w-full px-3 py-1.5 bg-white border border-[#E5E5E5] text-xs mt-2 focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            {{-- Hero Image --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 border border-[#E5E5E5] bg-white">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Foto Hero Kegiatan (Unggah Baru)
                    </label>
                    @if(!empty($heroSettings['hero_image']))
                        <div class="mb-2">
                            <img src="{{ $heroSettings['hero_image'] }}" alt="Hero current" class="w-32 h-20 object-cover border border-[#E5E5E5]">
                        </div>
                    @endif
                    <input type="file"
                           name="hero_image"
                           accept="image/*"
                           class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-[#1F1F1F] hover:file:bg-neutral-200">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Atau URL Foto Eksternal
                    </label>
                    <input type="url"
                           name="hero_image_url"
                           value="{{ old('hero_image_url', str_starts_with($heroSettings['hero_image'] ?? '', 'http') ? $heroSettings['hero_image'] : '') }}"
                           placeholder="https://..."
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    Simpan Konfigurasi Hero
                </button>
            </div>
        </form>
    </div>

    {{-- 2. HOMEPAGE SECTIONS ORCHESTRATION (ENABLE/DISABLE & REORDER) --}}
    <div class="border border-[#E5E5E5] bg-white p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-[#E5E5E5]">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Susunan Bagian Halaman</span>
                <h2 class="text-lg font-bold text-[#1F1F1F] mt-0.5">Kelola & Urutan Bagian Beranda</h2>
            </div>
            <span class="text-xs text-[#6B6B6B]">Total {{ $sections->count() }} Bagian</span>
        </div>

        <div class="space-y-3">
            @foreach($sections as $sec)
                <div class="p-4 border border-[#E5E5E5] bg-white flex items-center justify-between gap-4 hover:border-[#1F1F1F] transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 border border-[#E5E5E5] bg-white flex items-center justify-center text-xs font-bold text-[#8B1E24]">
                            {{ $sec->order }}
                        </span>
                        <div>
                            <span class="text-[10px] font-mono uppercase tracking-wider text-[#8B1E24] block">{{ $sec->section_key }}</span>
                            <h3 class="text-sm font-bold text-[#1F1F1F]">{{ $sec->title ?? ucfirst($sec->section_key) }}</h3>
                            <span class="text-xs text-[#6B6B6B]">{{ $sec->subtitle ?? $sec->type }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <form action="{{ route('admin.page-sections.toggle', $sec) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-1 text-xs border uppercase tracking-wider font-bold {{ $sec->is_active ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-neutral-100 text-neutral-600 border-neutral-300' }}">
                                {{ $sec->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 3. FOOTER CMS CONFIGURATION --}}
    <div class="border border-[#E5E5E5] bg-white p-6 sm:p-8 space-y-6">
        <div class="pb-4 border-b border-[#E5E5E5]">
            <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Footer Halaman</span>
            <h2 class="text-lg font-bold text-[#1F1F1F] mt-0.5">Konfigurasi Footer & Kredit Pengembang</h2>
        </div>

        <form action="{{ route('admin.homepage.footer') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Deskripsi Ringkas Footer
                </label>
                <textarea name="footer_about"
                          rows="3"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">{{ old('footer_about', $footerSettings['footer_about'] ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Teks Hak Cipta (Copyright)
                    </label>
                    <input type="text"
                           name="footer_copyright"
                           value="{{ old('footer_copyright', $footerSettings['footer_copyright'] ?? '© 2026 STT ArtDevata Banjar ArtDevata. Seluruh Hak Cipta Dilindungi.') }}"
                           class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Kredit Pengembang
                    </label>
                    <input type="text"
                           name="footer_dev_credit"
                           value="{{ old('footer_dev_credit', $footerSettings['footer_dev_credit'] ?? 'Website dikembangkan oleh ArtDevata') }}"
                           class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        URL Pengembang
                    </label>
                    <input type="text"
                           name="footer_dev_url"
                           value="{{ old('footer_dev_url', $footerSettings['footer_dev_url'] ?? 'https://artdevata.net') }}"
                           class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    Simpan Pengaturan Footer
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
