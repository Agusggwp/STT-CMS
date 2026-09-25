@extends('layouts.app')

@section('title', 'Masuk ke Dashboard CMS — ' . ($siteSettings['org_short_name'] ?? 'STT ArtDevata'))

@section('content')
<div class="py-16 sm:py-24 bg-white">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="border border-[#E5E5E5] p-8 sm:p-10 bg-white shadow-xs">
            {{-- Organization Badge & Header --}}
            <div class="text-center mb-8">
                <x-site-logo size="lg" class="mx-auto mb-3" />
                <h1 class="text-xl font-bold tracking-tight text-[#1F1F1F]">Masuk ke Admin CMS</h1>
                <p class="text-xs text-[#6B6B6B] mt-1">{{ $siteSettings['org_name'] ?? 'Sekaa Teruna Teruni ArtDevata' }}</p>
                <div class="mt-4 flex justify-center">
                    <div class="w-12 h-0.5 bg-[#8B1E24]"></div>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-white border border-[#E5E5E5] border-l-4 border-l-[#8B1E24] text-xs text-[#1F1F1F]">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Alamat Email
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', 'admin@sttbali.id') }}"
                           required
                           autocomplete="email"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden transition-colors"
                           placeholder="nama@sttbali.id">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-[#1F1F1F]">
                            Kata Sandi
                        </label>
                    </div>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden transition-colors"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="accent-[#8B1E24]">
                        <span class="text-[#6B6B6B]">Ingat sesi saya</span>
                    </label>
                    <span class="text-[#6B6B6B]">Default: password123</span>
                </div>

                <button type="submit"
                        class="w-full py-3 px-4 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors shadow-xs">
                    Masuk ke Sistem
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-[#E5E5E5] text-center">
                <a href="{{ route('home') }}" class="text-xs text-[#6B6B6B] hover:text-[#8B1E24] transition-colors">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
