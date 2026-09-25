<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — CMS STT Bali</title>
    <meta name="robots" content="noindex, nofollow">

    {{-- Instant state restoration without any blink/flash --}}
    <script>
        (function() {
            try {
                if (localStorage.getItem('admin_sidebar_collapsed') === 'true') {
                    document.documentElement.classList.add('sidebar-collapsed');
                }
            } catch(e) {}
        })();
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        /* Animate ONLY when user manually clicks collapse toggle button, NEVER on menu navigation */
        html.sidebar-animating #admin-sidebar,
        html.sidebar-animating #admin-main-area {
            transition: width 200ms ease, padding-left 200ms ease !important;
        }

        /* Desktop Collapsed Rules applied instantly by CSS without Alpine evaluation delays */
        @media (min-width: 1024px) {
            html.sidebar-collapsed #admin-sidebar {
                width: 72px !important;
            }
            html.sidebar-collapsed #admin-main-area {
                padding-left: 72px !important;
            }
            html.sidebar-collapsed .sidebar-text,
            html.sidebar-collapsed .sidebar-brand-text,
            html.sidebar-collapsed .sidebar-group-title,
            html.sidebar-collapsed .sidebar-chevron {
                display: none !important;
            }
            html.sidebar-collapsed .sidebar-group-divider {
                display: block !important;
            }
            html.sidebar-collapsed .sidebar-item-link {
                justify-content: center !important;
                padding: 0.625rem !important;
                height: 2.5rem !important;
                width: 2.5rem !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            html.sidebar-collapsed .sidebar-item-icon-wrap {
                margin: 0 !important;
            }
            html.sidebar-collapsed .sidebar-brand-header {
                justify-content: center !important;
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
            html.sidebar-collapsed .sidebar-footer-full {
                display: none !important;
            }
            html.sidebar-collapsed .sidebar-footer-compact {
                display: flex !important;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-full bg-slate-50 text-slate-900 font-sans antialiased"
      x-data="{
          sidebarOpen: false,
          sidebarCollapsed: localStorage.getItem('admin_sidebar_collapsed') === 'true',
          logoutModal: false,
          isLoggingOut: false,
          toggleSidebar() {
              document.documentElement.classList.add('sidebar-animating');
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('admin_sidebar_collapsed', this.sidebarCollapsed);
              document.documentElement.classList.toggle('sidebar-collapsed', this.sidebarCollapsed);
              setTimeout(() => {
                  document.documentElement.classList.remove('sidebar-animating');
              }, 220);
          }
      }">

    {{-- Top subtle accent line --}}
    <div class="fixed top-0 left-0 right-0 h-0.5 bg-[#8B1E24] z-50"></div>

    <div class="min-h-screen bg-slate-50 flex">

        {{-- Mobile Backdrop --}}
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-40 lg:hidden"
             x-cloak></div>

        {{-- Sidebar: Rock-solid, zero blink, zero layout shifts --}}
        <aside
            id="admin-sidebar"
            class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85vw] lg:w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col lg:z-30 shrink-0"
            :class="sidebarOpen ? 'translate-x-0 shadow-2xl lg:shadow-none' : '-translate-x-full lg:translate-x-0'"
        >
            <div class="flex flex-col h-full overflow-hidden">
                {{-- Logo Brand Header --}}
                <div class="sidebar-brand-header h-16 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-4 shrink-0">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        {{-- Logo Mark (Always visible, frameless) --}}
                        <div
                            class="shrink-0 cursor-pointer hover:opacity-90"
                            @click="toggleSidebar()"
                            :title="sidebarCollapsed ? 'Buka / Perluas Sidebar' : '{{ $siteSettings['site_name'] ?? 'STT ArtDevata' }}'"
                        >
                            <x-site-logo size="sm" />
                        </div>

                        {{-- Brand Text --}}
                        <div class="sidebar-brand-text truncate block">
                            <h1 class="font-bold text-slate-900 dark:text-white tracking-tight text-sm leading-tight truncate">
                                {{ $siteSettings['org_short_name'] ?? ($siteSettings['site_name'] ?? 'STT ArtDevata') }}
                            </h1>
                            <p class="text-[10px] text-slate-400 dark:text-slate-400 font-semibold tracking-wider uppercase truncate">
                                Portal CMS Pemuda
                            </p>
                        </div>
                    </div>

                    {{-- Dedicated Mobile Close Button (X) --}}
                    <button @click="sidebarOpen = false"
                            type="button"
                            class="lg:hidden p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg"
                            title="Tutup Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Navigation Items (Clean, no blink, no lag) --}}
                <nav class="flex-1 overflow-y-auto overflow-x-hidden no-scrollbar p-3 space-y-5"
                     style="scrollbar-width: none; -ms-overflow-style: none;">
                    
                    {{-- GROUP 1: UTAMA --}}
                    <div>
                        <div class="sidebar-group-divider hidden my-2 mx-1 h-px bg-slate-100 dark:bg-slate-800"></div>
                        <p class="sidebar-group-title text-[10px] font-bold tracking-wider text-slate-400 dark:text-slate-500 uppercase mb-2 px-2">
                            UTAMA
                        </p>

                        <div class="space-y-1">
                            {{-- Dashboard --}}
                            @php $active = request()->routeIs('admin.dashboard'); @endphp
                            <a href="{{ route('admin.dashboard') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                                        <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                                        <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                                        <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Dashboard
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Pesan Masuk --}}
                            @php $active = request()->routeIs('admin.messages.*'); @endphp
                            <a href="{{ route('admin.messages.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <div class="relative flex items-center justify-center">
                                        <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                        </svg>
                                        @if(!empty($unreadMessagesCount) && $unreadMessagesCount > 0)
                                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                                        @endif
                                    </div>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Pesan Masuk
                                    </span>
                                </div>
                                <div class="sidebar-text flex items-center gap-1.5">
                                    @if(!empty($unreadMessagesCount) && $unreadMessagesCount > 0)
                                        <span class="px-1.5 py-0.5 text-[10px] font-bold text-white bg-red-600 rounded-full leading-none">{{ $unreadMessagesCount }}</span>
                                    @endif
                                    @if($active)
                                        <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- GROUP 2: KONTEN & PUBLIKASI --}}
                    <div>
                        <div class="sidebar-group-divider hidden my-2 mx-1 h-px bg-slate-100 dark:bg-slate-800"></div>
                        <p class="sidebar-group-title text-[10px] font-bold tracking-wider text-slate-400 dark:text-slate-500 uppercase mb-2 px-2">
                            KONTEN & PUBLIKASI
                        </p>

                        <div class="space-y-1">
                            {{-- Berita & Warta --}}
                            @php $active = request()->routeIs('admin.posts.*'); @endphp
                            <a href="{{ route('admin.posts.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path>
                                        <path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Berita & Warta
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Agenda & Acara --}}
                            @php $active = request()->routeIs('admin.events.*'); @endphp
                            <a href="{{ route('admin.events.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                                        <line x1="16" x2="16" y1="2" y2="6"></line>
                                        <line x1="8" x2="8" y1="2" y2="6"></line>
                                        <line x1="3" x2="21" y1="10" y2="10"></line>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Agenda & Acara
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Kegiatan STT --}}
                            @php $active = request()->routeIs('admin.activities.*'); @endphp
                            <a href="{{ route('admin.activities.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                        <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                        <path d="M4 22h16"></path>
                                        <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                                        <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                                        <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Kegiatan STT
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Galeri Foto --}}
                            @php $active = request()->routeIs('admin.gallery.*'); @endphp
                            <a href="{{ route('admin.gallery.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                                        <circle cx="9" cy="9" r="2"></circle>
                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Galeri Foto
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Program Kerja --}}
                            @php $active = request()->routeIs('admin.work-programs.*'); @endphp
                            <a href="{{ route('admin.work-programs.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Program Kerja
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Pengurus & Anggota --}}
                            @php $active = request()->routeIs('admin.members.*'); @endphp
                            <a href="{{ route('admin.members.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Pengurus & Anggota
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Dokumen & Berkas --}}
                            @php $active = request()->routeIs('admin.documents.*'); @endphp
                            <a href="{{ route('admin.documents.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Dokumen & Berkas
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>
                        </div>
                    </div>

                    {{-- GROUP 3: WEBSITE & SISTEM --}}
                    <div>
                        <div class="sidebar-group-divider hidden my-2 mx-1 h-px bg-slate-100 dark:bg-slate-800"></div>
                        <p class="sidebar-group-title text-[10px] font-bold tracking-wider text-slate-400 dark:text-slate-500 uppercase mb-2 px-2">
                            WEBSITE & SISTEM
                        </p>

                        <div class="space-y-1">
                            {{-- Homepage CMS --}}
                            @php $active = request()->routeIs('admin.homepage.*'); @endphp
                            <a href="{{ route('admin.homepage.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                                        <path d="M3 9h18"></path><path d="M9 21V9"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Homepage CMS
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Halaman Statis / Builder --}}
                            @php $active = request()->routeIs('admin.pages.*'); @endphp
                            <a href="{{ route('admin.pages.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M20 7h-3a2 2 0 0 1-2-2V2"></path>
                                        <path d="M9 18a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h7l4 4v10a2 2 0 0 1-2 2Z"></path>
                                        <path d="M3 7.6v12.8A1.6 1.6 0 0 0 4.6 22h10.8"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Halaman Statis
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Pustaka Media --}}
                            @php $active = request()->routeIs('admin.media.*'); @endphp
                            <a href="{{ route('admin.media.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"></path>
                                        <path d="M8 10v4"></path><path d="M12 10v2"></path><path d="M16 10v6"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Pustaka Media
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Identitas Organisasi --}}
                            @php $active = request()->routeIs('admin.settings.*'); @endphp
                            <a href="{{ route('admin.settings.index') }}"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Identitas Organisasi
                                    </span>
                                </div>
                                @if($active)
                                    <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                @endif
                            </a>

                            {{-- Super Admin Only Menus --}}
                            @if(auth()->user()->isSuperAdmin())
                                {{-- Pengguna Admin --}}
                                @php $active = request()->routeIs('admin.users.*'); @endphp
                                <a href="{{ route('admin.users.index') }}"
                                   @click="sidebarOpen = false"
                                   class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                    <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                        <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <polyline points="16 11 18 13 22 9"></polyline>
                                        </svg>
                                        <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                            Pengguna Admin
                                        </span>
                                    </div>
                                    @if($active)
                                        <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                    @endif
                                </a>

                                {{-- Log Aktivitas --}}
                                @php $active = request()->routeIs('admin.activity-logs.*'); @endphp
                                <a href="{{ route('admin.activity-logs.index') }}"
                                   @click="sidebarOpen = false"
                                   class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer {{ $active ? 'bg-slate-900 dark:bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60' }}">
                                    <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                        <svg class="h-4 w-4 shrink-0 {{ $active ? 'text-white' : 'text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                            Log Aktivitas
                                        </span>
                                    </div>
                                    @if($active)
                                        <svg class="sidebar-chevron h-3.5 w-3.5 opacity-70 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                                    @endif
                                </a>
                            @endif

                            {{-- Lihat Web Publik --}}
                            <a href="{{ route('home') }}"
                               target="_blank"
                               rel="noreferrer"
                               @click="sidebarOpen = false"
                               class="sidebar-item-link flex items-center justify-between px-3 py-2 rounded-lg group relative cursor-pointer text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/80 dark:hover:bg-slate-800/60">
                                <div class="sidebar-item-icon-wrap flex items-center space-x-3">
                                    <svg class="h-4 w-4 shrink-0 text-slate-400 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M15 3h6v6"></path>
                                        <path d="M10 14 21 3"></path>
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    </svg>
                                    <span class="sidebar-text text-sm font-medium whitespace-nowrap block">
                                        Lihat Web Publik
                                    </span>
                                </div>
                                <svg class="sidebar-chevron h-3.5 w-3.5 opacity-50 block" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path d="M7 17l10-10M17 7H7m10 0v10"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </nav>

                {{-- User Profile & Logout in Sidebar Footer --}}
                <div class="border-t border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-3 shrink-0">
                    {{-- Compact Profile for Desktop Collapsed State --}}
                    <div class="sidebar-footer-compact hidden flex-col items-center space-y-2.5">
                        <a href="{{ route('admin.profile.edit') }}"
                           class="relative group"
                           title="{{ auth()->user()->name }} ({{ auth()->user()->email }})">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="h-9 w-9 rounded-full object-cover ring-2 ring-white dark:ring-slate-800 shadow-2xs cursor-pointer">
                        </a>
                        <button
                            type="button"
                            @click="logoutModal = true"
                            class="h-9 w-9 flex items-center justify-center rounded-lg bg-red-600 text-white hover:bg-red-700 shadow-xs cursor-pointer"
                            title="Keluar"
                            :disabled="isLoggingOut"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" x2="9" y1="12" y2="12"></line>
                            </svg>
                        </button>
                    </div>

                    {{-- Full Profile on Mobile or Expanded Desktop --}}
                    <div class="sidebar-footer-full flex flex-col gap-2">
                        <a href="{{ route('admin.profile.edit') }}" class="flex items-center space-x-3 overflow-hidden min-w-0 group cursor-pointer p-1 rounded-lg hover:bg-slate-100/80 dark:hover:bg-slate-800/60">
                            <img src="{{ auth()->user()->avatar_url }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="h-9 w-9 rounded-full object-cover shrink-0 ring-2 ring-white dark:ring-slate-800 shadow-2xs">
                            <div class="truncate min-w-0">
                                <p class="text-xs font-semibold text-slate-900 dark:text-white truncate group-hover:text-[#8B1E24]">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                        </a>
                        <button
                            type="button"
                            @click="logoutModal = true"
                            title="Keluar"
                            :disabled="isLoggingOut"
                            class="w-full flex items-center justify-center gap-2 py-2 px-3 text-xs font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 shadow-xs cursor-pointer"
                        >
                            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" x2="9" y1="12" y2="12"></line>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main Area (Zero blink layout) --}}
        <div id="admin-main-area" class="flex-1 flex flex-col min-w-0 bg-slate-50 lg:pl-64">

            {{-- Top Navbar --}}
            <header class="h-16 border-b border-slate-200 dark:border-slate-800 px-3 sm:px-8 flex items-center justify-between bg-white sticky top-0 z-20">
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    {{-- Mobile menu button --}}
                    <button @click="sidebarOpen = true"
                            type="button"
                            class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100 cursor-pointer shrink-0"
                            title="Buka Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    {{-- Desktop collapse toggle button --}}
                    <button @click="toggleSidebar()"
                            type="button"
                            class="hidden lg:flex items-center justify-center p-2 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100 cursor-pointer shrink-0"
                            :title="sidebarCollapsed ? 'Perluas Sidebar' : 'Perkecil Sidebar'">
                        <svg class="w-5 h-5 transition-transform duration-200" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                        </svg>
                    </button>

                    <h1 class="text-sm sm:text-lg font-bold text-slate-900 tracking-tight truncate">@yield('page_title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 px-2.5 sm:px-3 py-1.5 border border-slate-200 rounded-lg hover:bg-slate-50">
                        <span class="hidden sm:inline">Lihat Web Publik</span>
                        <span class="sm:hidden">Web</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>

                    @yield('header_actions')
                </div>
            </header>

            {{-- Main Content View --}}
            <main class="flex-1 p-3.5 sm:p-8 bg-slate-50 max-w-7xl w-full mx-auto">
                {{-- Flash Notifications --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-white border border-emerald-200 border-l-4 border-l-emerald-600 rounded-xl shadow-2xs text-sm text-slate-900 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-white border border-red-200 border-l-4 border-l-red-600 rounded-xl shadow-2xs text-sm text-slate-900 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-white border border-red-200 border-l-4 border-l-red-600 rounded-xl shadow-2xs text-sm text-slate-900">
                        <p class="font-bold text-red-700 mb-1">Terdapat kesalahan pengisian formulir:</p>
                        <ul class="list-disc pl-5 space-y-1 text-xs text-slate-600">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Logout Confirmation Dialog (Matches ConfirmDialog) --}}
    <div x-show="logoutModal"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            {{-- Backdrop --}}
            <div x-show="logoutModal"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="if(!isLoggingOut) logoutModal = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
                 aria-hidden="true"></div>

            {{-- Dialog Card --}}
            <div x-show="logoutModal"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform sm:my-8 sm:align-middle sm:max-w-md w-full border border-slate-200 dark:border-slate-800 p-6 z-10">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-950/50 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0 border border-red-100 dark:border-red-900/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" x2="9" y1="12" y2="12"></line>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white" id="modal-title">
                            Konfirmasi Logout
                        </h3>
                        <p class="mt-2 text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Apakah Anda yakin ingin keluar dari sistem administrasi {{ $siteSettings['site_name'] ?? 'STT ArtDevata' }}?
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button"
                            @click="logoutModal = false"
                            :disabled="isLoggingOut"
                            class="px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg cursor-pointer">
                        Batal
                    </button>
                    <form action="{{ route('logout') }}" method="POST" @submit="isLoggingOut = true">
                        @csrf
                        <button type="submit"
                                :disabled="isLoggingOut"
                                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-xs cursor-pointer disabled:opacity-50">
                            <template x-if="isLoggingOut">
                                <svg class="w-4 h-4 animate-spin shrink-0" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                            </template>
                            <template x-if="!isLoggingOut">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" x2="9" y1="12" y2="12"></line>
                                </svg>
                            </template>
                            <span x-text="isLoggingOut ? 'Mengeluarkan...' : 'Keluar'"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
