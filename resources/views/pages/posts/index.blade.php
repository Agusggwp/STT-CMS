@extends('layouts.app')

@section('title', 'Berita & Warta Organisasi — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', 'Kumpulan berita, artikel budaya, prestasi, dan warta seputar kegiatan krama teruna Banjar ArtDevata.')

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Kabar & Artikel</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            Warta STT ArtDevata
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
        <p class="text-base sm:text-lg text-[#6B6B6B] max-w-3xl leading-relaxed">
            Pusat publikasi informasi, artikel kepemudaan, kajian budaya, serta kabar gotong royong warga banjar.
        </p>
    </div>
</section>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- Filter & Search --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 pb-6 border-b border-[#E5E5E5]">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('posts.index') }}"
                   class="px-3 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ !request('kategori') ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('posts.index', ['kategori' => $cat->slug]) }}"
                       class="px-3 py-1.5 text-xs font-semibold uppercase tracking-wider border {{ request('kategori') == $cat->slug ? 'bg-[#8B1E24] text-white border-[#8B1E24]' : 'bg-white text-[#1F1F1F] border-[#E5E5E5] hover:border-[#1F1F1F]' }}">
                        {{ $cat->name }} ({{ $cat->posts_count }})
                    </a>
                @endforeach
            </div>

            <form action="{{ route('posts.index') }}" method="GET" class="w-full md:w-72">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <div class="relative">
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Cari berita..."
                           class="w-full pl-3 pr-9 py-2 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden">
                    <button type="submit" class="absolute right-2.5 top-2.5 text-[#6B6B6B] hover:text-[#8B1E24]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Featured Post (if on first page without search) --}}
        @if($featuredPost && !request('q') && !request('kategori') && $posts->currentPage() == 1)
            <div class="border border-[#E5E5E5] p-6 sm:p-8 bg-white grid grid-cols-1 lg:grid-cols-12 gap-8 items-center group hover:border-[#1F1F1F] transition-colors">
                <div class="lg:col-span-7 overflow-hidden">
                    <img src="{{ $featuredPost->thumbnail_url }}"
                         alt="{{ $featuredPost->title }}"
                         class="w-full h-80 sm:h-96 object-cover object-center group-hover:scale-102 transition-transform duration-300">
                </div>
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-3 text-xs">
                        <span class="px-2.5 py-1 bg-[#8B1E24] text-white font-bold uppercase tracking-wider text-[10px]">
                            Berita Utama
                        </span>
                        <span class="text-[#6B6B6B]">{{ $featuredPost->category->name ?? 'Kabar' }}</span>
                        <span>•</span>
                        <span class="text-[#6B6B6B]">{{ $featuredPost->published_at ? $featuredPost->published_at->isoFormat('D MMM Y') : '' }}</span>
                    </div>

                    <h2 class="text-xl sm:text-2xl font-extrabold text-[#1F1F1F] group-hover:text-[#8B1E24] transition-colors leading-snug">
                        <a href="{{ route('posts.show', $featuredPost->slug) }}">{{ $featuredPost->title }}</a>
                    </h2>

                    <p class="text-xs sm:text-sm text-[#6B6B6B] leading-relaxed line-clamp-3">
                        {{ $featuredPost->summary }}
                    </p>

                    <div class="pt-2 flex items-center justify-between text-xs text-[#6B6B6B]">
                        <span>Oleh {{ $featuredPost->author_name ?? 'Redaksi' }}</span>
                        <a href="{{ route('posts.show', $featuredPost->slug) }}" class="font-bold text-[#8B1E24] hover:underline">
                            Baca Artikel Lengkap &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- News Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article class="flex flex-col border border-[#E5E5E5] bg-white group hover:border-[#1F1F1F] transition-colors">
                    <a href="{{ route('posts.show', $post->slug) }}" class="overflow-hidden">
                        <img src="{{ $post->thumbnail_url }}"
                             alt="{{ $post->title }}"
                             class="w-full h-48 object-cover object-center group-hover:scale-102 transition-transform duration-300">
                    </a>
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs text-[#6B6B6B]">
                                <span class="font-semibold text-[#8B1E24]">{{ $post->category->name ?? 'Warta' }}</span>
                                <span>{{ $post->published_at ? $post->published_at->isoFormat('D MMM Y') : '' }}</span>
                            </div>
                            <h3 class="text-base font-bold text-[#1F1F1F] group-hover:text-[#8B1E24] transition-colors leading-snug">
                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-xs text-[#6B6B6B] line-clamp-2 leading-relaxed">
                                {{ $post->summary }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-[#E5E5E5] flex items-center justify-between text-xs text-[#6B6B6B]">
                            <span>{{ $post->author_name ?? 'Redaksi STT' }}</span>
                            <span class="font-semibold text-[#1F1F1F] group-hover:text-[#8B1E24]">Baca &rarr;</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-3 text-center py-16 text-sm text-[#6B6B6B] border border-[#E5E5E5]">
                    Tidak ada berita ditemukan.
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div>
            {{ $posts->links() }}
        </div>

    </div>
</div>
@endsection
