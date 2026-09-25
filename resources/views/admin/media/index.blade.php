@extends('layouts.admin')

@section('title', 'Media Library - Admin CMS')

@section('content')
<div class="space-y-6" x-data="{ uploadModal: false, activeMedia: null }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-[#E5E5E5]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#1F1F1F]">Media Library</h1>
            <p class="text-sm text-[#6B6B6B] mt-1">Kelola arsip foto kegiatan, poster acara, dokumen, dan aset digital organisasi.</p>
        </div>
        <button @click="uploadModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#6e171c] transition-colors shadow-sm self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Upload Media
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-white border-l-4 border-green-600 border border-[#E5E5E5] text-sm text-[#1F1F1F]">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="p-4 bg-white border border-[#E5E5E5] flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.media.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama berkas, teks alt..." class="w-full pl-9 pr-4 py-2 text-xs bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                <svg class="w-4 h-4 text-[#6B6B6B] absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <select name="folder" class="py-2 px-3 text-xs bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                <option value="">Semua Folder</option>
                @foreach($folders as $folder)
                    <option value="{{ $folder }}" {{ request('folder') == $folder ? 'selected' : '' }}>Folder: {{ $folder }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#1F1F1F] hover:bg-black transition-colors">
                Filter
            </button>

            @if(request()->hasAny(['q', 'folder']))
                <a href="{{ route('admin.media.index') }}" class="px-4 py-2 text-xs font-semibold text-[#6B6B6B] border border-[#E5E5E5] hover:border-[#1F1F1F] transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Media Grid -->
    @if($mediaItems->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($mediaItems as $item)
                @php
                    $isImage = str_starts_with($item->mime_type ?? '', 'image/');
                    $assetUrl = asset('storage/' . $item->file_path);
                @endphp
                <div class="group relative bg-white border border-[#E5E5E5] hover:border-[#8B1E24] transition-colors flex flex-col justify-between">
                    <div class="aspect-square bg-white flex items-center justify-center overflow-hidden p-2 border-b border-[#E5E5E5]">
                        @if($isImage)
                            <img src="{{ $assetUrl }}" alt="{{ $item->alt_text ?? $item->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-3">
                                <svg class="w-10 h-10 mx-auto text-[#6B6B6B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px] font-mono uppercase text-[#6B6B6B] mt-1 block">{{ pathinfo($item->file_name, PATHINFO_EXTENSION) }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-3">
                        <p class="text-xs font-medium text-[#1F1F1F] truncate" title="{{ $item->name }}">{{ $item->name }}</p>
                        <div class="flex items-center justify-between text-[11px] text-[#6B6B6B] mt-1">
                            <span>{{ number_format(($item->file_size ?? 0) / 1024, 0) }} KB</span>
                            <span class="text-[10px] px-1 bg-white border border-[#E5E5E5] text-[#6B6B6B]">{{ $item->folder }}</span>
                        </div>

                        <!-- Action buttons -->
                        <div class="mt-3 pt-2 border-t border-[#E5E5E5] flex items-center justify-between">
                            <button type="button" @click="navigator.clipboard.writeText('{{ $assetUrl }}'); alert('Tautan media disalin!')" title="Salin URL" class="text-[#6B6B6B] hover:text-[#8B1E24]">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>

                            <button type="button" @click="activeMedia = {{ json_encode($item) }}" title="Edit Info" class="text-[#6B6B6B] hover:text-[#1F1F1F]">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>

                            <form action="{{ route('admin.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus berkas media ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus" class="text-[#6B6B6B] hover:text-red-600">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $mediaItems->links() }}
        </div>
    @else
        <div class="p-12 text-center bg-white border border-[#E5E5E5]">
            <svg class="w-12 h-12 mx-auto text-[#6B6B6B] mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-base font-bold text-[#1F1F1F]">Belum ada berkas media</h3>
            <p class="text-xs text-[#6B6B6B] mt-1 mb-4">Mulai unggah foto kegiatan, poster, atau berkas pendukung lainnya.</p>
            <button @click="uploadModal = true" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#6e171c] transition-colors">
                Unggah Berkas Baru
            </button>
        </div>
    @endif

    <!-- Upload Modal -->
    <div x-show="uploadModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-black/40" @click="uploadModal = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white border border-[#E5E5E5] w-full max-w-lg p-6 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-[#E5E5E5]">
                    <h3 class="text-base font-bold text-[#1F1F1F]">Unggah Berkas Media</h3>
                    <button @click="uploadModal = false" class="text-[#6B6B6B] hover:text-[#1F1F1F]">✕</button>
                </div>

                <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Folder Tujuan</label>
                        <input type="text" name="folder" value="uploads" placeholder="cth: kegiatan, pengurus, gallery, umum" class="w-full px-3 py-2 text-xs bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Pilih Berkas (Bisa pilih banyak)</label>
                        <input type="file" name="files[]" multiple required accept="image/*,.pdf,.doc,.docx" class="w-full text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border file:border-[#E5E5E5] file:text-xs file:font-semibold file:bg-white hover:file:border-[#8B1E24]">
                        <p class="text-[11px] text-[#6B6B6B] mt-1">Format didukung: JPG, PNG, WEBP, GIF, SVG, PDF. Maks 10MB per file.</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#E5E5E5]">
                        <button type="button" @click="uploadModal = false" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#6B6B6B] border border-[#E5E5E5] hover:border-[#1F1F1F]">Batal</button>
                        <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#6e171c]">Mulai Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Info Modal -->
    <div x-show="activeMedia" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-black/40" @click="activeMedia = null"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white border border-[#E5E5E5] w-full max-w-lg p-6 space-y-4" x-if="activeMedia">
                <div class="flex items-center justify-between pb-3 border-b border-[#E5E5E5]">
                    <h3 class="text-base font-bold text-[#1F1F1F]">Edit Metadata Media</h3>
                    <button @click="activeMedia = null" class="text-[#6B6B6B] hover:text-[#1F1F1F]">✕</button>
                </div>

                <form :action="'/admin/media/' + activeMedia?.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Nama Tampilan</label>
                        <input type="text" name="name" :value="activeMedia?.name" required class="w-full px-3 py-2 text-xs bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Teks Alt (Aksesibilitas / SEO)</label>
                        <input type="text" name="alt_text" :value="activeMedia?.alt_text" class="w-full px-3 py-2 text-xs bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Caption / Keterangan</label>
                        <textarea name="caption" rows="2" :value="activeMedia?.caption" class="w-full px-3 py-2 text-xs bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#E5E5E5]">
                        <button type="button" @click="activeMedia = null" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#6B6B6B] border border-[#E5E5E5] hover:border-[#1F1F1F]">Batal</button>
                        <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#6e171c]">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
