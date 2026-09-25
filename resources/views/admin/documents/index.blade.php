@extends('layouts.admin')

@section('page_title', 'Kelola Dokumen Publik')

@section('header_actions')
<a href="{{ route('admin.documents.create') }}" class="px-3.5 py-1.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
    + Unggah Dokumen Baru
</a>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Search & Filter --}}
    <div class="p-4 border border-[#E5E5E5] bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.documents.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari judul berkas..."
                   class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden w-48 sm:w-64">

            <select name="category" class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden">
                <option value="">Semua Kategori</option>
                @foreach(['AD/ART', 'Proposal', 'Laporan Kegiatan', 'Surat', 'Jadwal', 'Panduan', 'Dokumen Organisasi'] as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-3 py-1.5 bg-neutral-100 hover:bg-neutral-200 border border-[#E5E5E5] text-xs font-semibold">
                Filter
            </button>
        </form>

        <span class="text-xs text-[#6B6B6B]">Total: {{ $documents->total() }} dokumen</span>
    </div>

    {{-- Clean Table --}}
    <div class="border border-[#E5E5E5] bg-white overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-[#E5E5E5] bg-neutral-50/50 text-[#6B6B6B] uppercase font-bold text-[10px]">
                    <th class="py-3 px-4">Nama Dokumen</th>
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Ukuran</th>
                    <th class="py-3 px-4">Diunduh</th>
                    <th class="py-3 px-4">Tanggal Publikasi</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @forelse($documents as $doc)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3 px-4">
                            <span class="font-bold text-[#1F1F1F] block">{{ $doc->title }}</span>
                            <span class="text-[11px] text-[#6B6B6B] line-clamp-1 max-w-sm">{{ $doc->description }}</span>
                        </td>
                        <td class="py-3 px-4 font-semibold text-[#8B1E24]">{{ $doc->category }}</td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $doc->file_size ?? 'PDF' }}</td>
                        <td class="py-3 px-4 font-bold">{{ $doc->downloads_count }}x</td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $doc->published_at ? $doc->published_at->format('d/m/Y') : '-' }}</td>
                        <td class="py-3 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('documents.download', $doc->slug) }}" class="px-2.5 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F]">
                                    Unduh
                                </a>
                                <a href="{{ route('admin.documents.edit', $doc) }}" class="px-2.5 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F]">
                                    Ubah
                                </a>
                                <form action="{{ route('admin.documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
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
                        <td colspan="6" class="py-8 text-center text-[#6B6B6B]">Tidak ada data dokumen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $documents->links() }}
    </div>
</div>
@endsection
