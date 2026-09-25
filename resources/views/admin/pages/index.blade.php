@extends('layouts.admin')

@section('page_title', 'Kelola Halaman & Page Builder')

@section('header_actions')
<a href="{{ route('admin.pages.create') }}" class="px-3.5 py-1.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
    + Buat Halaman Baru
</a>
@endsection

@section('content')
<div class="space-y-6">
    <div class="p-4 border border-[#E5E5E5] bg-white flex items-center justify-between">
        <p class="text-xs text-[#6B6B6B]">
            Kelola halaman statis dan halaman dinamis yang disusun menggunakan komponen modular Page Builder.
        </p>
        <span class="text-xs text-[#6B6B6B]">Total: {{ $pages->count() }} halaman</span>
    </div>

    {{-- Clean Table --}}
    <div class="border border-[#E5E5E5] bg-white overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-[#E5E5E5] bg-neutral-50/50 text-[#6B6B6B] uppercase font-bold text-[10px]">
                    <th class="py-3 px-4">Judul Halaman</th>
                    <th class="py-3 px-4">Slug URL</th>
                    <th class="py-3 px-4">Jumlah Bagian (Sections)</th>
                    <th class="py-3 px-4">Tipe Halaman</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @forelse($pages as $p)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3 px-4">
                            <span class="font-bold text-[#1F1F1F] block">{{ $p->title }}</span>
                            @if($p->subtitle)
                                <span class="text-[11px] text-[#6B6B6B]">{{ $p->subtitle }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-mono text-neutral-600">
                            @if($p->slug === 'home')
                                <a href="{{ route('home') }}" target="_blank" class="text-[#8B1E24] hover:underline font-bold">/ (Beranda)</a>
                            @else
                                <a href="{{ route('pages.show', $p->slug) }}" target="_blank" class="text-[#8B1E24] hover:underline">/halaman/{{ $p->slug }}</a>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-bold">{{ $p->sections_count }} bagian</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $p->is_system ? 'bg-amber-50 text-amber-800 border border-amber-300' : 'bg-neutral-100 text-neutral-700 border border-neutral-300' }}">
                                {{ $p->is_system ? 'Sistem' : 'Kustom' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $p->status == 'published' ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-neutral-100 text-neutral-700 border border-neutral-300' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.pages.builder', $p) }}" class="px-2.5 py-1 text-xs bg-[#8B1E24] text-white hover:bg-[#73171C] font-semibold">
                                    Page Builder
                                </a>
                                <a href="{{ route('admin.pages.edit', $p) }}" class="px-2.5 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F]">
                                    Ubah
                                </a>
                                @if(!$p->is_system)
                                    <form action="{{ route('admin.pages.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus halaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 text-xs border border-[#E5E5E5] text-[#8B1E24] hover:border-[#8B1E24]">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-[#6B6B6B]">Tidak ada data halaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
