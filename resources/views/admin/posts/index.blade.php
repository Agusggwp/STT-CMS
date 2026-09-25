@extends('layouts.admin')

@section('page_title', 'Kelola Berita & Warta')

@section('header_actions')
<a href="{{ route('admin.posts.create') }}" class="px-3.5 py-1.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
    + Tulis Berita Baru
</a>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Search & Filter --}}
    <div class="p-4 border border-[#E5E5E5] bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari judul..."
                   class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden w-48 sm:w-64">

            <select name="status" class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

            <button type="submit" class="px-3 py-1.5 bg-neutral-100 hover:bg-neutral-200 border border-[#E5E5E5] text-xs font-semibold">
                Filter
            </button>

            @if(request()->hasAny(['q', 'status', 'category_id']))
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-[#8B1E24] hover:underline">Reset</a>
            @endif
        </form>

        <span class="text-xs text-[#6B6B6B]">Total: {{ $posts->total() }} berita</span>
    </div>

    {{-- Clean Table --}}
    <div class="border border-[#E5E5E5] bg-white overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-[#E5E5E5] bg-neutral-50/50 text-[#6B6B6B] uppercase font-bold text-[10px]">
                    <th class="py-3 px-4">Artikel</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Penulis</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Unggulan</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @forelse($posts as $post)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-10 h-10 object-cover border border-[#E5E5E5] flex-shrink-0">
                                <div>
                                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="font-bold text-[#1F1F1F] hover:text-[#8B1E24]">
                                        {{ $post->title }}
                                    </a>
                                    <span class="block text-[11px] text-[#6B6B6B]">{{ $post->views_count }} views</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">{{ $post->category->name ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $post->author_name ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $post->status == 'published' ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-neutral-100 text-neutral-700 border border-neutral-300' }}">
                                {{ $post->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            @if($post->is_featured)
                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase text-[#8B1E24] border border-[#8B1E24]">Ya</span>
                            @else
                                <span class="text-neutral-400">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $post->published_at ? $post->published_at->format('d/m/Y') : '-' }}</td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="px-2.5 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F]">
                                    Ubah
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
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
                        <td colspan="7" class="py-8 text-center text-[#6B6B6B]">Tidak ada data berita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $posts->links() }}
    </div>
</div>
@endsection
