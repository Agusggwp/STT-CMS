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

                    <div class="mt-4 pt-4 border-t border-[#E5E5E5] flex items-center gap-3">
                        @if(!empty($siteSettings['instagram']))
                            <a href="{{ $siteSettings['instagram'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-[#E5E5E5] flex items-center justify-center text-[#1F1F1F] hover:text-[#8B1E24] hover:border-[#8B1E24] transition-colors" title="Instagram">
                                <span class="text-xs font-bold">IG</span>
                            </a>
                        @endif
                        @if(!empty($siteSettings['facebook']))
                            <a href="{{ $siteSettings['facebook'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-[#E5E5E5] flex items-center justify-center text-[#1F1F1F] hover:text-[#8B1E24] hover:border-[#8B1E24] transition-colors" title="Facebook">
                                <span class="text-xs font-bold">FB</span>
                            </a>
                        @endif
                        @if(!empty($siteSettings['tiktok']))
                            <a href="{{ $siteSettings['tiktok'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-[#E5E5E5] flex items-center justify-center text-[#1F1F1F] hover:text-[#8B1E24] hover:border-[#8B1E24] transition-colors" title="TikTok">
                                <span class="text-xs font-bold">TK</span>
                            </a>
                        @endif
                        @if(!empty($siteSettings['youtube']))
                            <a href="{{ $siteSettings['youtube'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-[#E5E5E5] flex items-center justify-center text-[#1F1F1F] hover:text-[#8B1E24] hover:border-[#8B1E24] transition-colors" title="YouTube">
                                <span class="text-xs font-bold">YT</span>
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
