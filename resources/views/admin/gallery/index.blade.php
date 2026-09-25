@extends('layouts.admin')

@section('page_title', 'Kelola Galeri & Album Foto')

@section('header_actions')
<a href="{{ route('admin.gallery.create') }}" class="px-3.5 py-1.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
    + Buat Album Baru
</a>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Search & Filter --}}
    <div class="p-4 border border-[#E5E5E5] bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.gallery.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari album..."
                   class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden w-48 sm:w-64">

            <select name="category" class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden">
                <option value="">Semua Kategori</option>
                @foreach(['Odalan', 'Gotong Royong', 'Lomba', 'Kegiatan Sosial', 'Olahraga', 'Budaya', 'Organisasi'] as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-3 py-1.5 bg-neutral-100 hover:bg-neutral-200 border border-[#E5E5E5] text-xs font-semibold">
                Filter
            </button>
        </form>

        <span class="text-xs text-[#6B6B6B]">Total: {{ $albums->total() }} album</span>
    </div>

    {{-- Clean Table --}}
    <div class="border border-[#E5E5E5] bg-white overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-[#E5E5E5] bg-neutral-50/50 text-[#6B6B6B] uppercase font-bold text-[10px]">
                    <th class="py-3 px-4">Album</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Jumlah Foto</th>
                    <th class="py-3 px-4">Tanggal Dokumentasi</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @forelse($albums as $alb)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $alb->cover_image_url }}" alt="{{ $alb->title }}" class="w-12 h-10 object-cover border border-[#E5E5E5] flex-shrink-0">
                                <div>
                                    <a href="{{ route('gallery.show', $alb->slug) }}" target="_blank" class="font-bold text-[#1F1F1F] hover:text-[#8B1E24]">
                                        {{ $alb->title }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 font-semibold text-[#8B1E24]">{{ $alb->category }}</td>
                        <td class="py-3 px-4 font-bold">{{ $alb->images_count }} Foto</td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $alb->event_date ? $alb->event_date->format('d/m/Y') : '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $alb->status == 'published' ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-neutral-100 text-neutral-700 border border-neutral-300' }}">
                                {{ $alb->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.gallery.edit', $alb) }}" class="px-2.5 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F]">
                                    Kelola Foto
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $alb) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus album ini beserta seluruh fotonya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 text-xs border border-[#E5E5E5] text-[#8B1E24] hover:border-[#8B1E24]">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-[#6B6B6B]">Belum ada album galeri.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $albums->links() }}
    </div>
</div>
@endsection
