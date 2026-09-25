@extends('layouts.admin')

@section('page_title', 'Kelola Kegiatan Organisasi')

@section('header_actions')
<a href="{{ route('admin.activities.create') }}" class="px-3.5 py-1.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
    + Tambah Kegiatan
</a>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Search & Filter --}}
    <div class="p-4 border border-[#E5E5E5] bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.activities.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari kegiatan..."
                   class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden w-48 sm:w-64">

            <select name="category_id" class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-3 py-1.5 bg-neutral-100 hover:bg-neutral-200 border border-[#E5E5E5] text-xs font-semibold">
                Filter
            </button>

            @if(request()->hasAny(['q', 'category_id']))
                <a href="{{ route('admin.activities.index') }}" class="text-xs text-[#8B1E24] hover:underline">Reset</a>
            @endif
        </form>

        <span class="text-xs text-[#6B6B6B]">Total: {{ $activities->total() }} kegiatan</span>
    </div>

    {{-- Clean Table --}}
    <div class="border border-[#E5E5E5] bg-white overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-[#E5E5E5] bg-neutral-50/50 text-[#6B6B6B] uppercase font-bold text-[10px]">
                    <th class="py-3 px-4">Kegiatan</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Tanggal Pelaksanaan</th>
                    <th class="py-3 px-4">Lokasi</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Unggulan</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @forelse($activities as $act)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $act->thumbnail_url }}" alt="{{ $act->title }}" class="w-10 h-10 object-cover border border-[#E5E5E5] flex-shrink-0">
                                <div>
                                    <a href="{{ route('activities.show', $act->slug) }}" target="_blank" class="font-bold text-[#1F1F1F] hover:text-[#8B1E24]">
                                        {{ $act->title }}
                                    </a>
                                    <span class="block text-[11px] text-[#6B6B6B]">{{ $act->author_name ?? 'Pengurus' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">{{ $act->category->name ?? '-' }}</td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $act->event_date ? $act->event_date->format('d/m/Y') : '-' }}</td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $act->location ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $act->status == 'published' ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-neutral-100 text-neutral-700 border border-neutral-300' }}">
                                {{ $act->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @if($act->is_featured)
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase text-[#8B1E24] border border-[#8B1E24]">Ya</span>
                            @else
                                <span class="text-neutral-400">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.activities.edit', $act) }}" class="px-2.5 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F]">
                                    Ubah
                                </a>
                                <form action="{{ route('admin.activities.destroy', $act) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">
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
                        <td colspan="7" class="py-8 text-center text-[#6B6B6B]">Tidak ada data kegiatan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $activities->links() }}
    </div>
</div>
@endsection
