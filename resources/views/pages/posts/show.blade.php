@extends('layouts.app')

@section('title', $post->title . ' — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', Str::limit(strip_tags($post->summary ?? $post->content), 160))
@section('og_image', $post->thumbnail_url)
@section('og_type', 'article')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ $post->title }}",
  "image": ["{{ $post->thumbnail_url }}"],
  "datePublished": "{{ $post->published_at ? $post->published_at->toIso8601String() : $post->created_at->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": [{
      "@type": "Person",
      "name": "{{ $post->author_name ?? 'Redaksi STT ArtDevata' }}"
  }]
}
</script>
@endpush

@section('content')
<article class="py-12 sm:py-20 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-[#6B6B6B]">
            <a href="{{ route('home') }}" class="hover:text-[#8B1E24]">Beranda</a>
            <span>/</span>
            <a href="{{ route('posts.index') }}" class="hover:text-[#8B1E24]">Berita</a>
            <span>/</span>
            <span class="text-[#1F1F1F] font-medium truncate">{{ $post->title }}</span>
        </nav>

        {{-- Post Header --}}
        <div class="space-y-4">
            <div class="flex items-center gap-3 text-xs">
                <span class="px-2.5 py-1 bg-white border border-[#8B1E24] text-[#8B1E24] font-bold uppercase tracking-wider">
                    {{ $post->category->name ?? 'Warta Organisasi' }}
                </span>
                <span class="text-[#6B6B6B]">{{ $post->published_at ? $post->published_at->isoFormat('dddd, D MMMM Y') : '' }}</span>
            </div>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold text-[#1F1F1F] tracking-tight leading-tight">
                {{ $post->title }}
            </h1>

            <div class="w-16 h-0.5 bg-[#8B1E24]"></div>

            {{-- Author & Views bar --}}
            <div class="flex items-center justify-between py-3 border-y border-[#E5E5E5] text-xs text-[#6B6B6B]">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-[#1F1F1F]">{{ $post->author_name ?? 'Redaksi STT' }}</span>
                    <span>•</span>
                    <span>{{ $post->views_count }} x dibaca</span>
                </div>

                {{-- Share link --}}
                <div class="flex items-center gap-3">
                    <span class="text-[11px] font-semibold uppercase">Bagikan:</span>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="text-[#8B1E24] hover:underline font-semibold">
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>

        {{-- Lead summary --}}
        @if($post->summary)
            <p class="text-base sm:text-lg text-[#1F1F1F] font-medium leading-relaxed italic border-l-2 border-[#8B1E24] pl-4">
                {{ $post->summary }}
            </p>
        @endif

        {{-- Featured Thumbnail --}}
        <div class="border border-[#E5E5E5] p-2 bg-white">
            <img src="{{ $post->thumbnail_url }}"
                 alt="{{ $post->title }}"
                 fetchpriority="high"
                 decoding="async"
                 class="w-full h-[360px] sm:h-[480px] object-cover object-center">
        </div>

        {{-- Article Content --}}
        <div class="prose max-w-none text-[#1F1F1F] text-base leading-relaxed space-y-4">
            {!! $post->content !!}
        </div>

        {{-- Related Articles --}}
        @if($relatedPosts->count() > 0)
            <div class="pt-12 border-t border-[#E5E5E5] space-y-6">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">Berita Terkait</span>
                    <a href="{{ route('posts.index') }}" class="text-xs text-[#6B6B6B] hover:text-[#8B1E24]">Semua Berita &rarr;</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $rel)
                        <a href="{{ route('posts.show', $rel->slug) }}" class="border border-[#E5E5E5] p-3 bg-white block group hover:border-[#8B1E24]">
                            <img src="{{ $rel->thumbnail_url }}" alt="{{ $rel->title }}" loading="lazy" decoding="async" class="w-full h-36 object-cover object-center">
                            <span class="block text-[11px] text-[#8B1E24] font-semibold uppercase mt-2">{{ $rel->category->name ?? 'Warta' }}</span>
                            <h4 class="text-xs font-bold text-[#1F1F1F] mt-1 group-hover:text-[#8B1E24] line-clamp-2">{{ $rel->title }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>
@endsection
