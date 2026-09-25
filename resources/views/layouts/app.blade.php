<!DOCTYPE html>
<html lang="id" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', $siteSettings['meta_title'] ?? 'STT ArtDevata — Sekaa Teruna Teruni Bali')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Situs resmi Sekaa Teruna Teruni ArtDevata Banjar ArtDevata. Wadah pemuda adat Bali berlandaskan Tri Hita Karana.')">
    <meta name="keywords" content="Sekaa Teruna Teruni Bali, STT Bali, organisasi pemuda Bali, pemuda banjar, kegiatan pemuda Bali, adat Bali, ArtDevata, Denpasar">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $siteSettings['meta_title'] ?? 'STT ArtDevata')">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Wadah generasi muda Bali berkarya untuk banjar dan budaya.')">
    <meta property="og:image" content="@yield('og_image', $siteSettings['hero_image'] ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80')">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $siteSettings['meta_title'] ?? 'STT ArtDevata')">
    <meta name="twitter:description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Wadah generasi muda Bali berkarya untuk banjar dan budaya.')">
    <meta name="twitter:image" content="@yield('og_image', $siteSettings['hero_image'] ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=80')">

    {{-- Favicon --}}
    @if(!empty($siteSettings['favicon']))
        <link rel="icon" href="{{ $siteSettings['favicon'] }}">
    @else
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏛️</text></svg>">
    @endif

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- JSON-LD Schema Structured Data --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "Organization",
      "name": "{{ $siteSettings['org_name'] ?? 'Sekaa Teruna Teruni ArtDevata' }}",
      "alternateName": "{{ $siteSettings['org_short_name'] ?? 'STT ArtDevata' }}",
      "url": "{{ url('/') }}",
      "logo": "{{ $siteSettings['logo'] ?? asset('images/logo.png') }}",
      "description": "{{ $siteSettings['description'] ?? 'Organisasi pemuda adat Bali di lingkungan Banjar ArtDevata' }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ $siteSettings['address'] ?? 'Balai Banjar ArtDevata' }}",
        "addressLocality": "Denpasar",
        "addressRegion": "Bali",
        "addressCountry": "ID"
      },
      "sameAs": [
        "{{ $siteSettings['instagram'] ?? '' }}",
        "{{ $siteSettings['facebook'] ?? '' }}",
        "{{ $siteSettings['tiktok'] ?? '' }}"
      ]
    }
    </script>
    @stack('schema')
</head>
<body class="min-h-full flex flex-col bg-white text-[#1F1F1F] font-sans antialiased selection:bg-[#8B1E24] selection:text-white" x-data="{ mobileMenuOpen: false }">

    {{-- Thin Top Cultural Accent Hairline --}}
    <div class="w-full h-1 bg-[#8B1E24]"></div>

    {{-- Header / Navbar --}}
    <header class="sticky top-0 z-40 w-full bg-white border-b border-[#E5E5E5] transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo and Org Name --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 group flex-shrink-0">
                    <x-site-logo size="md" />
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#8B1E24] leading-tight">Sekaa Teruna Teruni</span>
                        <span class="text-base font-bold text-[#1F1F1F] tracking-tight group-hover:text-[#8B1E24] transition-colors leading-snug">
                            {{ $siteSettings['org_short_name'] ?? ($siteSettings['site_name'] ?? 'STT ArtDevata') }}
                        </span>
                        <span class="text-[11px] text-[#6B6B6B] leading-none mt-0.5">{{ $siteSettings['banjar_name'] ?? 'Banjar ArtDevata' }} • {{ $siteSettings['desa_adat'] ?? 'Desa Adat ArtDevata' }}</span>
                    </div>
                </a>

                {{-- Desktop Nav: Clean, Spacious, Grouped with Dropdowns --}}
                <nav class="hidden lg:flex items-center gap-4 xl:gap-7 text-sm">
                    {{-- 1. Beranda --}}
                    <a href="{{ route('home') }}" class="py-2 font-medium tracking-tight whitespace-nowrap transition-colors {{ request()->routeIs('home') ? 'text-[#8B1E24] font-semibold border-b-2 border-[#8B1E24]' : 'text-[#1F1F1F] hover:text-[#8B1E24]' }}">
                        Beranda
                    </a>

                    {{-- 2. Profil Dropdown --}}
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 py-2 font-medium tracking-tight whitespace-nowrap transition-colors {{ request()->routeIs(['about', 'structure', 'members']) ? 'text-[#8B1E24] font-semibold border-b-2 border-[#8B1E24]' : 'text-[#1F1F1F] hover:text-[#8B1E24]' }}">
                            <span>Profil STT</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-0.5 w-56 bg-white border border-[#E5E5E5] shadow-lg py-1.5 z-50 divide-y divide-[#E5E5E5]/50"
                             style="display: none;"
                             x-cloak>
                            <a href="{{ route('about') }}" class="block px-4 py-2.5 text-xs font-medium text-[#1F1F1F] hover:text-[#8B1E24] hover:bg-neutral-50 transition-colors {{ request()->routeIs('about') ? 'text-[#8B1E24] font-semibold bg-neutral-50 border-l-2 border-[#8B1E24]' : '' }}">
                                Tentang STT & Nilai Luhur
                            </a>
                            <a href="{{ route('structure') }}" class="block px-4 py-2.5 text-xs font-medium text-[#1F1F1F] hover:text-[#8B1E24] hover:bg-neutral-50 transition-colors {{ request()->routeIs('structure') ? 'text-[#8B1E24] font-semibold bg-neutral-50 border-l-2 border-[#8B1E24]' : '' }}">
                                Struktur Organisasi
                            </a>
                            <a href="{{ route('members') }}" class="block px-4 py-2.5 text-xs font-medium text-[#1F1F1F] hover:text-[#8B1E24] hover:bg-neutral-50 transition-colors {{ request()->routeIs('members') ? 'text-[#8B1E24] font-semibold bg-neutral-50 border-l-2 border-[#8B1E24]' : '' }}">
                                Pengurus Aktif
                            </a>
                        </div>
                    </div>

                    {{-- 3. Aktivitas Dropdown --}}
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 py-2 font-medium tracking-tight whitespace-nowrap transition-colors {{ request()->routeIs(['activities.*', 'events.*']) ? 'text-[#8B1E24] font-semibold border-b-2 border-[#8B1E24]' : 'text-[#1F1F1F] hover:text-[#8B1E24]' }}">
                            <span>Aktivitas</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-0.5 w-56 bg-white border border-[#E5E5E5] shadow-lg py-1.5 z-50 divide-y divide-[#E5E5E5]/50"
                             style="display: none;"
                             x-cloak>
                            <a href="{{ route('activities.index') }}" class="block px-4 py-2.5 text-xs font-medium text-[#1F1F1F] hover:text-[#8B1E24] hover:bg-neutral-50 transition-colors {{ request()->routeIs('activities.*') ? 'text-[#8B1E24] font-semibold bg-neutral-50 border-l-2 border-[#8B1E24]' : '' }}">
                                Dokumentasi Kegiatan
                            </a>
                            <a href="{{ route('events.index') }}" class="block px-4 py-2.5 text-xs font-medium text-[#1F1F1F] hover:text-[#8B1E24] hover:bg-neutral-50 transition-colors {{ request()->routeIs('events.*') ? 'text-[#8B1E24] font-semibold bg-neutral-50 border-l-2 border-[#8B1E24]' : '' }}">
                                Agenda & Paruman Banjar
                            </a>
                        </div>
                    </div>

                    {{-- 4. Galeri --}}
                    <a href="{{ route('gallery.index') }}" class="py-2 font-medium tracking-tight whitespace-nowrap transition-colors {{ request()->routeIs('gallery.*') ? 'text-[#8B1E24] font-semibold border-b-2 border-[#8B1E24]' : 'text-[#1F1F1F] hover:text-[#8B1E24]' }}">
                        Galeri
                    </a>

                    {{-- 5. Berita --}}
                    <a href="{{ route('posts.index') }}" class="py-2 font-medium tracking-tight whitespace-nowrap transition-colors {{ request()->routeIs('posts.*') ? 'text-[#8B1E24] font-semibold border-b-2 border-[#8B1E24]' : 'text-[#1F1F1F] hover:text-[#8B1E24]' }}">
                        Berita
                    </a>

                    {{-- 6. Program & Dokumen Dropdown --}}
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open" class="flex items-center gap-1 py-2 font-medium tracking-tight whitespace-nowrap transition-colors {{ request()->routeIs(['work-programs.*', 'documents.*']) ? 'text-[#8B1E24] font-semibold border-b-2 border-[#8B1E24]' : 'text-[#1F1F1F] hover:text-[#8B1E24]' }}">
                            <span>Program & Dokumen</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-0.5 w-56 bg-white border border-[#E5E5E5] shadow-lg py-1.5 z-50 divide-y divide-[#E5E5E5]/50"
                             style="display: none;"
                             x-cloak>
                            <a href="{{ route('work-programs.index') }}" class="block px-4 py-2.5 text-xs font-medium text-[#1F1F1F] hover:text-[#8B1E24] hover:bg-neutral-50 transition-colors {{ request()->routeIs('work-programs.*') ? 'text-[#8B1E24] font-semibold bg-neutral-50 border-l-2 border-[#8B1E24]' : '' }}">
                                Program Kerja
                            </a>
                            <a href="{{ route('documents.index') }}" class="block px-4 py-2.5 text-xs font-medium text-[#1F1F1F] hover:text-[#8B1E24] hover:bg-neutral-50 transition-colors {{ request()->routeIs('documents.*') ? 'text-[#8B1E24] font-semibold bg-neutral-50 border-l-2 border-[#8B1E24]' : '' }}">
                                Dokumen Publik & AD/ART
                            </a>
                        </div>
                    </div>

                    {{-- 7. Kontak --}}
                    <a href="{{ route('contact') }}" class="py-2 font-medium tracking-tight whitespace-nowrap transition-colors {{ request()->routeIs('contact') ? 'text-[#8B1E24] font-semibold border-b-2 border-[#8B1E24]' : 'text-[#1F1F1F] hover:text-[#8B1E24]' }}">
                        Kontak
                    </a>
                </nav>

                {{-- Action button / Mobile toggle --}}
                <div class="flex items-center gap-2.5 sm:gap-3.5 flex-shrink-0">
                    <a href="{{ route('contact') }}" class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#73171C] transition-colors whitespace-nowrap shadow-xs">
                        Hubungi STT
                    </a>

                    @if(auth()->check())
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-[#8B1E24] border border-[#8B1E24] hover:bg-[#8B1E24] hover:text-white transition-colors whitespace-nowrap">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            CMS
                        </a>
                    @endif

                    {{-- Mobile menu button --}}
                    <button @click="mobileMenuOpen = true"
                            type="button"
                            class="lg:hidden p-2 rounded-lg border border-slate-200 text-[#1F1F1F] hover:text-[#8B1E24] hover:bg-slate-50 transition active:scale-95 cursor-pointer"
                            aria-label="Buka menu navigasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Modern Mobile Slide-over Drawer --}}
        <div x-show="mobileMenuOpen"
             class="fixed inset-0 z-50 lg:hidden"
             role="dialog"
             aria-modal="true"
             x-cloak>
            
            {{-- Backdrop --}}
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileMenuOpen = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

            {{-- Slide-over Drawer Panel --}}
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="fixed inset-y-0 right-0 z-50 w-full max-w-xs sm:max-w-sm bg-white shadow-2xl flex flex-col justify-between border-l border-slate-200"
                 x-data="{
                     profilOpen: false,
                     aktivitasOpen: false,
                     programOpen: false
                 }">
                
                {{-- Drawer Header --}}
                <div class="h-16 px-4 border-b border-slate-200 flex items-center justify-between shrink-0 bg-white">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <x-site-logo size="sm" />
                        <div class="truncate">
                            <span class="block text-[9px] font-bold uppercase tracking-widest text-[#8B1E24] leading-tight">Sekaa Teruna Teruni</span>
                            <span class="text-xs font-bold text-slate-900 truncate leading-tight block">
                                {{ $siteSettings['org_short_name'] ?? ($siteSettings['site_name'] ?? 'STT ArtDevata') }}
                            </span>
                        </div>
                    </div>
                    <button @click="mobileMenuOpen = false"
                            type="button"
                            class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition cursor-pointer"
                            aria-label="Tutup menu navigasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Drawer Navigation Links --}}
                <div class="flex-1 overflow-y-auto no-scrollbar p-4 space-y-2">
                    {{-- 1. Beranda --}}
                    <a href="{{ route('home') }}"
                       @click="mobileMenuOpen = false"
                       class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('home') ? 'bg-[#8B1E24] text-white shadow-xs' : 'text-slate-800 hover:bg-slate-100' }}">
                        <span>Beranda</span>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    {{-- 2. Profil STT (Accordion) --}}
                    <div class="rounded-lg border border-slate-100 overflow-hidden">
                        <button @click="profilOpen = !profilOpen"
                                type="button"
                                class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs(['about', 'structure', 'members']) ? 'text-[#8B1E24] bg-red-50/50' : 'text-slate-800 hover:bg-slate-50' }}">
                            <span>Profil STT</span>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': profilOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="profilOpen" x-collapse class="bg-slate-50/80 px-3 py-2 space-y-1 border-t border-slate-100">
                            <a href="{{ route('about') }}" @click="mobileMenuOpen = false" class="block px-2.5 py-1.5 text-xs font-medium rounded-md {{ request()->routeIs('about') ? 'text-[#8B1E24] font-bold bg-white' : 'text-slate-600 hover:text-slate-900' }}">
                                Tentang STT & Nilai Luhur
                            </a>
                            <a href="{{ route('structure') }}" @click="mobileMenuOpen = false" class="block px-2.5 py-1.5 text-xs font-medium rounded-md {{ request()->routeIs('structure') ? 'text-[#8B1E24] font-bold bg-white' : 'text-slate-600 hover:text-slate-900' }}">
                                Struktur Organisasi
                            </a>
                            <a href="{{ route('members') }}" @click="mobileMenuOpen = false" class="block px-2.5 py-1.5 text-xs font-medium rounded-md {{ request()->routeIs('members') ? 'text-[#8B1E24] font-bold bg-white' : 'text-slate-600 hover:text-slate-900' }}">
                                Pengurus Aktif
                            </a>
                        </div>
                    </div>

                    {{-- 3. Aktivitas & Acara (Accordion) --}}
                    <div class="rounded-lg border border-slate-100 overflow-hidden">
                        <button @click="aktivitasOpen = !aktivitasOpen"
                                type="button"
                                class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs(['activities.*', 'events.*']) ? 'text-[#8B1E24] bg-red-50/50' : 'text-slate-800 hover:bg-slate-50' }}">
                            <span>Aktivitas & Acara</span>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': aktivitasOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="aktivitasOpen" x-collapse class="bg-slate-50/80 px-3 py-2 space-y-1 border-t border-slate-100">
                            <a href="{{ route('activities.index') }}" @click="mobileMenuOpen = false" class="block px-2.5 py-1.5 text-xs font-medium rounded-md {{ request()->routeIs('activities.*') ? 'text-[#8B1E24] font-bold bg-white' : 'text-slate-600 hover:text-slate-900' }}">
                                Dokumentasi Kegiatan
                            </a>
                            <a href="{{ route('events.index') }}" @click="mobileMenuOpen = false" class="block px-2.5 py-1.5 text-xs font-medium rounded-md {{ request()->routeIs('events.*') ? 'text-[#8B1E24] font-bold bg-white' : 'text-slate-600 hover:text-slate-900' }}">
                                Agenda & Paruman Banjar
                            </a>
                        </div>
                    </div>

                    {{-- 4. Galeri Foto --}}
                    <a href="{{ route('gallery.index') }}"
                       @click="mobileMenuOpen = false"
                       class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('gallery.*') ? 'bg-[#8B1E24] text-white shadow-xs' : 'text-slate-800 hover:bg-slate-100' }}">
                        <span>Galeri Foto</span>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    {{-- 5. Berita & Warta --}}
                    <a href="{{ route('posts.index') }}"
                       @click="mobileMenuOpen = false"
                       class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('posts.*') ? 'bg-[#8B1E24] text-white shadow-xs' : 'text-slate-800 hover:bg-slate-100' }}">
                        <span>Berita & Warta</span>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    {{-- 6. Program & Dokumen (Accordion) --}}
                    <div class="rounded-lg border border-slate-100 overflow-hidden">
                        <button @click="programOpen = !programOpen"
                                type="button"
                                class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-semibold transition-colors {{ request()->routeIs(['work-programs.*', 'documents.*']) ? 'text-[#8B1E24] bg-red-50/50' : 'text-slate-800 hover:bg-slate-50' }}">
                            <span>Program & Dokumen</span>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': programOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="programOpen" x-collapse class="bg-slate-50/80 px-3 py-2 space-y-1 border-t border-slate-100">
                            <a href="{{ route('work-programs.index') }}" @click="mobileMenuOpen = false" class="block px-2.5 py-1.5 text-xs font-medium rounded-md {{ request()->routeIs('work-programs.*') ? 'text-[#8B1E24] font-bold bg-white' : 'text-slate-600 hover:text-slate-900' }}">
                                Program Kerja
                            </a>
                            <a href="{{ route('documents.index') }}" @click="mobileMenuOpen = false" class="block px-2.5 py-1.5 text-xs font-medium rounded-md {{ request()->routeIs('documents.*') ? 'text-[#8B1E24] font-bold bg-white' : 'text-slate-600 hover:text-slate-900' }}">
                                Dokumen Publik & AD/ART
                            </a>
                        </div>
                    </div>

                    {{-- 7. Kontak --}}
                    <a href="{{ route('contact') }}"
                       @click="mobileMenuOpen = false"
                       class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('contact') ? 'bg-[#8B1E24] text-white shadow-xs' : 'text-slate-800 hover:bg-slate-100' }}">
                        <span>Kontak & Lokasi</span>
                        <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Drawer Footer Actions --}}
                <div class="p-4 border-t border-slate-200 bg-slate-50/80 space-y-3 shrink-0">
                    <a href="{{ route('contact') }}"
                       @click="mobileMenuOpen = false"
                       class="w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-[#8B1E24] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-xs hover:bg-[#73171C] transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Hubungi STT</span>
                    </a>

                    @if(auth()->check())
                        <a href="{{ route('admin.dashboard') }}"
                           class="w-full flex items-center justify-center gap-2 py-2 px-4 border border-slate-300 text-slate-700 hover:text-[#8B1E24] hover:border-[#8B1E24] bg-white text-xs font-semibold rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span>Dashboard Admin CMS</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full flex items-center justify-center gap-1.5 py-1.5 text-center text-xs text-slate-500 hover:text-[#8B1E24] transition font-medium">
                            <span>Login Pengurus STT &rarr;</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content Slot --}}
    <main class="flex-grow bg-white">
        {{-- Flash Alerts --}}
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="p-4 bg-white border border-[#E5E5E5] border-l-4 border-l-emerald-600 text-sm text-[#1F1F1F] flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="p-4 bg-white border border-[#E5E5E5] border-l-4 border-l-[#8B1E24] text-sm text-[#1F1F1F] flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#8B1E24] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-[#E5E5E5] mt-24">
        {{-- Top Hairline Accent --}}
        <div class="w-full h-0.5 bg-[#8B1E24]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-8">
                {{-- Column 1: Organization & Identity --}}
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <x-site-logo size="sm" />
                        <div>
                            <span class="block text-xs font-semibold uppercase tracking-wider text-[#8B1E24]">Sekaa Teruna Teruni</span>
                            <h3 class="text-base font-bold text-[#1F1F1F] tracking-tight">
                                {{ $siteSettings['org_name'] ?? 'Sekaa Teruna Teruni ArtDevata' }}
                            </h3>
                        </div>
                    </div>
                    <p class="text-sm text-[#6B6B6B] leading-relaxed max-w-md">
                        {{ $siteSettings['footer_about'] ?? ($siteSettings['description'] ?? 'Platform resmi Sekaa Teruna Teruni Banjar ArtDevata sebagai wadah informasi kepemudaan, tradisi adat, serta pengabdian masyarakat Bali.') }}
                    </p>
                    <div class="pt-2 flex items-center gap-4 text-xs text-[#6B6B6B]">
                        <span>{{ $siteSettings['banjar_name'] ?? 'Banjar ArtDevata' }}</span>
                        <span>•</span>
                        <span>{{ $siteSettings['desa_adat'] ?? 'Desa Adat ArtDevata' }}</span>
                        <span>•</span>
                        <span>Denpasar, Bali</span>
                    </div>
                </div>

                {{-- Column 2: Navigasi Cepat --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-4">Navigasi</h4>
                    <ul class="space-y-2.5 text-sm text-[#6B6B6B]">
                        <li><a href="{{ route('about') }}" class="hover:text-[#8B1E24] transition-colors">Tentang STT</a></li>
                        <li><a href="{{ route('structure') }}" class="hover:text-[#8B1E24] transition-colors">Struktur Organisasi</a></li>
                        <li><a href="{{ route('members') }}" class="hover:text-[#8B1E24] transition-colors">Pengurus Aktif</a></li>
                        <li><a href="{{ route('work-programs.index') }}" class="hover:text-[#8B1E24] transition-colors">Program Kerja</a></li>
                        <li><a href="{{ route('documents.index') }}" class="hover:text-[#8B1E24] transition-colors">Dokumen Publik</a></li>
                    </ul>
                </div>

                {{-- Column 3: Informasi & Publikasi --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-4">Publikasi</h4>
                    <ul class="space-y-2.5 text-sm text-[#6B6B6B]">
                        <li><a href="{{ route('activities.index') }}" class="hover:text-[#8B1E24] transition-colors">Dokumentasi Kegiatan</a></li>
                        <li><a href="{{ route('events.index') }}" class="hover:text-[#8B1E24] transition-colors">Agenda & Paruman</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-[#8B1E24] transition-colors">Galeri Budaya</a></li>
                        <li><a href="{{ route('posts.index') }}" class="hover:text-[#8B1E24] transition-colors">Warta & Berita</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[#8B1E24] transition-colors">Kontak & Sekretariat</a></li>
                    </ul>
                </div>

                {{-- Column 4: Kontak & Jejaring --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-4">Kontak & Alamat</h4>
                    <div class="space-y-2 text-xs text-[#6B6B6B] leading-relaxed">
                        <p class="text-[#1F1F1F] font-medium">{{ $siteSettings['address'] ?? 'Balai Banjar ArtDevata, Jl. ArtDevata No. 1, Denpasar' }}</p>
                        <p>Telepon: {{ $siteSettings['phone'] ?? '+62 812-3456-7890' }}</p>
                        <p>Email: {{ $siteSettings['email'] ?? 'kontak@artdevata.net' }}</p>
                    </div>

                    <div class="mt-4 pt-4 border-t border-[#E5E5E5] flex items-center gap-2.5">
                        @if(!empty($siteSettings['instagram']))
                            <a href="{{ $siteSettings['instagram'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-[#E5E5E5] bg-white flex items-center justify-center text-[#1F1F1F] hover:text-[#8B1E24] hover:border-[#8B1E24] hover:bg-[#FAF9F6] transition-all" title="Instagram" aria-label="Instagram">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                        @if(!empty($siteSettings['facebook']))
                            <a href="{{ $siteSettings['facebook'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-[#E5E5E5] bg-white flex items-center justify-center text-[#1F1F1F] hover:text-[#8B1E24] hover:border-[#8B1E24] hover:bg-[#FAF9F6] transition-all" title="Facebook" aria-label="Facebook">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                        @if(!empty($siteSettings['tiktok']))
                            <a href="{{ $siteSettings['tiktok'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-[#E5E5E5] bg-white flex items-center justify-center text-[#1F1F1F] hover:text-[#8B1E24] hover:border-[#8B1E24] hover:bg-[#FAF9F6] transition-all" title="TikTok" aria-label="TikTok">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </a>
                        @endif
                        @if(!empty($siteSettings['youtube']))
                            <a href="{{ $siteSettings['youtube'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-[#E5E5E5] bg-white flex items-center justify-center text-[#1F1F1F] hover:text-[#8B1E24] hover:border-[#8B1E24] hover:bg-[#FAF9F6] transition-all" title="YouTube" aria-label="YouTube">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bottom copyright and developer credits --}}
            <div class="mt-16 pt-8 border-t border-[#E5E5E5] flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#6B6B6B]">
                <p>{{ $siteSettings['footer_copyright'] ?? '© 2026 STT ArtDevata Banjar ArtDevata. Seluruh Hak Cipta Dilindungi.' }}</p>
                <p class="flex items-center gap-1.5">
                    <span>{{ $siteSettings['footer_dev_credit'] ?? 'Website dikembangkan oleh ArtDevata' }}</span>
                    <span>•</span>
                    <a href="{{ $siteSettings['footer_dev_url'] ?? 'https://artdevata.net' }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-[#8B1E24] hover:underline">
                        ArtDevata
                    </a>
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
