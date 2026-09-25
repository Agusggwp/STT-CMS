@extends('layouts.admin')

@section('title', 'Pengaturan Website - Admin CMS')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between pb-6 border-b border-[#E5E5E5]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#1F1F1F]">Pengaturan Website</h1>
            <p class="text-sm text-[#6B6B6B] mt-1">Kelola identitas organisasi, info kontak, media sosial, dan konfigurasi SEO global.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-white border-l-4 border-green-600 border border-[#E5E5E5] text-sm text-[#1F1F1F]">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="space-y-8">
            <!-- Identitas Organisasi -->
            <div class="p-6 bg-white border border-[#E5E5E5]">
                <div class="border-b border-[#E5E5E5] pb-4 mb-6">
                    <h2 class="text-lg font-bold text-[#1F1F1F]">1. Identitas Organisasi</h2>
                    <p class="text-xs text-[#6B6B6B] mt-0.5">Nama STT, banjar, desa adat, dan tagline resmi.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Nama Website / Organisasi</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Sekaa Teruna Teruni Bali') }}" required class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Tagline</label>
                        <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Generasi Muda Bali, Berkarya untuk Banjar dan Budaya') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Nama Banjar</label>
                        <input type="text" name="banjar_name" value="{{ old('banjar_name', $settings['banjar_name'] ?? 'Banjar ArtDevata') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Desa Adat / Kelurahan</label>
                        <input type="text" name="village_name" value="{{ old('village_name', $settings['village_name'] ?? 'Desa Adat ArtDevata') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Nama Singkat Organisasi</label>
                        <input type="text" name="org_short_name" value="{{ old('org_short_name', $settings['org_short_name'] ?? ($settings['site_short_name'] ?? 'STT ArtDevata')) }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Inisial / Monogram Logo Teks</label>
                        <input type="text" name="logo_monogram" maxlength="6" value="{{ old('logo_monogram', $settings['logo_monogram'] ?? ($settings['logo_text'] ?? 'AD')) }}" placeholder="cth: AD atau STT" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                        <p class="text-[11px] text-[#6B6B6B] mt-1">Teks inisial dalam bingkai kotak merah jika belum mengunggah gambar logo.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Deskripsi Singkat Footer</label>
                        <textarea name="site_description" rows="2" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                    </div>

                    {{-- Upload Logo Organisasi --}}
                    <div class="p-4 border border-[#E5E5E5] bg-neutral-50/30 space-y-3">
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider">Logo Utama Organisasi</label>
                        @php
                            $currentLogo = $settings['logo'] ?? ($settings['site_logo'] ?? null);
                        @endphp

                        @if(!empty($currentLogo))
                            <div class="flex items-center gap-4 p-3 bg-white border border-[#E5E5E5]">
                                <div class="w-12 h-12 bg-white flex items-center justify-center">
                                    <img src="{{ Str::startsWith($currentLogo, 'http') ? $currentLogo : asset('storage/' . $currentLogo) }}" alt="Logo" class="max-h-full max-w-full object-contain">
                                </div>
                                <div class="text-xs space-y-1">
                                    <span class="font-bold text-[#1F1F1F] block">Logo Gambar Aktif</span>
                                    <label class="inline-flex items-center gap-1.5 text-xs text-red-600 cursor-pointer">
                                        <input type="checkbox" name="remove_logo" value="1" class="text-[#8B1E24]">
                                        <span>Hapus logo ini & gunakan monogram teks ("{{ $settings['logo_monogram'] ?? 'ST' }}")</span>
                                    </label>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3 p-3 bg-white border border-[#E5E5E5]">
                                <div class="w-10 h-10 bg-slate-100 flex items-center justify-center text-[#1F1F1F] font-bold text-base rounded-md">
                                    {{ $settings['logo_monogram'] ?? 'ST' }}
                                </div>
                                <span class="text-xs text-[#6B6B6B]">Saat ini menggunakan monogram teks bawaan ("{{ $settings['logo_monogram'] ?? 'ST' }}"). Unggah berkas gambar di bawah jika ingin mengganti logo grafis.</span>
                            </div>
                        @endif

                        <div>
                            <input type="file" name="site_logo" accept="image/*" class="w-full text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border file:border-[#E5E5E5] file:text-xs file:font-semibold file:bg-white hover:file:border-[#8B1E24]">
                            <p class="text-[11px] text-[#6B6B6B] mt-1">Mendukung format PNG transparan, JPG, WEBP, atau SVG. Rasio 1:1 disarankan.</p>
                        </div>
                    </div>

                    {{-- Upload Favicon --}}
                    <div class="p-4 border border-[#E5E5E5] bg-neutral-50/30 space-y-3">
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider">Favicon Website</label>
                        @php
                            $currentFavicon = $settings['favicon'] ?? ($settings['site_favicon'] ?? null);
                        @endphp

                        @if(!empty($currentFavicon))
                            <div class="flex items-center gap-3 p-3 bg-white border border-[#E5E5E5]">
                                <img src="{{ Str::startsWith($currentFavicon, 'http') ? $currentFavicon : asset('storage/' . $currentFavicon) }}" alt="Favicon" class="w-6 h-6 border border-[#E5E5E5] p-0.5 object-contain">
                                <label class="inline-flex items-center gap-1.5 text-xs text-red-600 cursor-pointer">
                                    <input type="checkbox" name="remove_favicon" value="1" class="text-[#8B1E24]">
                                    <span>Hapus favicon kustom</span>
                                </label>
                            </div>
                        @endif

                        <div>
                            <input type="file" name="site_favicon" accept="image/*,.ico" class="w-full text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border file:border-[#E5E5E5] file:text-xs file:font-semibold file:bg-white hover:file:border-[#8B1E24]">
                            <p class="text-[11px] text-[#6B6B6B] mt-1">Ikon tab peramban (.ico atau .png 32x32px).</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak & Lokasi -->
            <div class="p-6 bg-white border border-[#E5E5E5]">
                <div class="border-b border-[#E5E5E5] pb-4 mb-6">
                    <h2 class="text-lg font-bold text-[#1F1F1F]">2. Kontak & Lokasi</h2>
                    <p class="text-xs text-[#6B6B6B] mt-0.5">Informasi kontak banjar untuk memudahkan masyarakat dan rekanan terhubung.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Alamat Lengkap Banjar</label>
                        <input type="text" name="contact_address" value="{{ old('contact_address', $settings['contact_address'] ?? 'Balai Banjar ArtDevata, Jl. ArtDevata No. 1, Denpasar, Bali 80223') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Email Resmi</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'sekretariat@artdevata.net') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Nomor Telepon / Hotline</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '+62 361 720188') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">WhatsApp Official</label>
                        <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp'] ?? '6281234567890') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                        <p class="text-[11px] text-[#6B6B6B] mt-1">Gunakan format internasional tanpa simbol (cth: 6281234567890)</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Jam Buka Sekretariat</label>
                        <input type="text" name="contact_hours" value="{{ old('contact_hours', $settings['contact_hours'] ?? 'Senin - Sabtu: 18.00 - 22.00 WITA') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Google Maps Embed URL</label>
                        <input type="text" name="contact_maps" value="{{ old('contact_maps', $settings['contact_maps'] ?? '') }}" placeholder="https://www.google.com/maps/embed?..." class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>
                </div>
            </div>

            <!-- Media Sosial -->
            <div class="p-6 bg-white border border-[#E5E5E5]">
                <div class="border-b border-[#E5E5E5] pb-4 mb-6">
                    <h2 class="text-lg font-bold text-[#1F1F1F]">3. Media Sosial</h2>
                    <p class="text-xs text-[#6B6B6B] mt-0.5">Tautan akun resmi Sekaa Teruna Teruni di berbagai platform digital.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Instagram URL</label>
                        <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? 'https://instagram.com/artdevata') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">YouTube URL</label>
                        <input type="url" name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? 'https://youtube.com/@artdevata') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">TikTok URL</label>
                        <input type="url" name="social_tiktok" value="{{ old('social_tiktok', $settings['social_tiktok'] ?? 'https://tiktok.com/@artdevata') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Facebook URL</label>
                        <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>
                </div>
            </div>

            <!-- SEO & Meta Default -->
            <div class="p-6 bg-white border border-[#E5E5E5]">
                <div class="border-b border-[#E5E5E5] pb-4 mb-6">
                    <h2 class="text-lg font-bold text-[#1F1F1F]">4. Konfigurasi SEO Global</h2>
                    <p class="text-xs text-[#6B6B6B] mt-0.5">Optimasi mesin pencari dan visibilitas saat dibagikan ke media sosial.</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Meta Title Default</label>
                        <input type="text" name="seo_meta_title" value="{{ old('seo_meta_title', $settings['seo_meta_title'] ?? 'Sekaa Teruna Teruni ArtDevata - Banjar ArtDevata Bali') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Meta Description Default</label>
                        <textarea name="seo_meta_description" rows="3" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">{{ old('seo_meta_description', $settings['seo_meta_description'] ?? 'Platform informasi resmi Sekaa Teruna Teruni (STT) Bali, wadah persatuan, kreativitas, seni budaya, dan pengabdian pemuda adat Banjar ArtDevata.') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Meta Keywords (Pisahkan dengan koma)</label>
                        <input type="text" name="seo_meta_keywords" value="{{ old('seo_meta_keywords', $settings['seo_meta_keywords'] ?? 'STT Bali, Sekaa Teruna Teruni, Pemuda Banjar, Budaya Bali, Ogoh-ogoh, Ngayah') }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex items-center justify-end gap-4 p-6 bg-white border border-[#E5E5E5]">
                <button type="submit" class="px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#6e171c] transition-colors shadow-sm">
                    Simpan Seluruh Pengaturan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
