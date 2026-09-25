@extends('layouts.app')

@section('title', ($page->meta_title ?? $page->title) . ' — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))
@section('meta_description', $page->meta_description ?? Str::limit(strip_tags($page->content ?? $page->subtitle), 160))

@section('content')
<section class="bg-white border-b border-[#E5E5E5] py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($page->subtitle)
            <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24]">{{ $page->subtitle }}</span>
        @endif
        <h1 class="text-3xl sm:text-5xl font-extrabold text-[#1F1F1F] tracking-tight mt-2">
            {{ $page->title }}
        </h1>
        <div class="w-16 h-0.5 bg-[#8B1E24] mt-4 mb-4"></div>
    </div>
</section>

<div class="py-12 sm:py-20 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        @if($page->content)
            <div class="prose max-w-none text-base text-[#1F1F1F] leading-relaxed">
                {!! $page->content !!}
            </div>
        @endif

        {{-- Modular Page Sections --}}
        @foreach($page->sections as $sec)
            <section class="border-t border-[#E5E5E5] pt-12 space-y-6">
                @if($sec->subtitle)
                    <span class="text-xs font-bold uppercase tracking-widest text-[#8B1E24] block">{{ $sec->subtitle }}</span>
                @endif

                @if($sec->title)
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1F1F1F] tracking-tight">{{ $sec->title }}</h2>
                @endif

                @if($sec->type === 'text')
                    <div class="prose max-w-none text-[#1F1F1F] leading-relaxed">
                        {!! $sec->content !!}
                    </div>
                @elseif($sec->type === 'image')
                    @if(!empty($sec->data['image']))
                        <div class="border border-[#E5E5E5] p-2 bg-white">
                            <img src="{{ $sec->data['image'] }}" alt="{{ $sec->title }}" class="w-full h-auto">
                        </div>
                    @endif
                @elseif($sec->type === 'text_image')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div class="prose max-w-none text-[#1F1F1F] leading-relaxed">
                            {!! $sec->content !!}
                        </div>
                        @if(!empty($sec->data['image']))
                            <div class="border border-[#E5E5E5] p-2 bg-white">
                                <img src="{{ $sec->data['image'] }}" alt="{{ $sec->title }}" class="w-full h-auto">
                            </div>
                        @endif
                    </div>
                @elseif($sec->type === 'cta')
                    <div class="border border-[#E5E5E5] p-8 text-center space-y-4 bg-white">
                        <h3 class="text-xl font-bold text-[#1F1F1F]">{{ $sec->title }}</h3>
                        <p class="text-sm text-[#6B6B6B] max-w-xl mx-auto">{{ $sec->content }}</p>
                        @if(!empty($sec->data['cta_button_text']))
                            <div class="pt-2">
                                <a href="{{ $sec->data['cta_button_url'] ?? '#' }}" class="inline-block px-6 py-3 bg-[#8B1E24] text-white text-xs font-bold uppercase tracking-wider hover:bg-[#73171C]">
                                    {{ $sec->data['cta_button_text'] }}
                                </a>
                            </div>
                        @endif
                    </div>
                @elseif($sec->type === 'faq')
                    @if(!empty($sec->data['faqs']))
                        <div class="space-y-4 divide-y divide-[#E5E5E5] border border-[#E5E5E5] p-6">
                            @foreach($sec->data['faqs'] as $faq)
                                <div class="pt-4 first:pt-0">
                                    <h4 class="text-sm font-bold text-[#1F1F1F]">{{ $faq['question'] ?? '' }}</h4>
                                    <p class="text-xs text-[#6B6B6B] mt-1 leading-relaxed">{{ $faq['answer'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="prose max-w-none text-[#1F1F1F]">
                        {!! $sec->content !!}
                    </div>
                @endif
            </section>
        @endforeach
    </div>
</div>
@endsection
