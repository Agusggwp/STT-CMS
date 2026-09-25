@extends('layouts.admin')

@section('page_title', 'Tambah Kegiatan Baru')

@section('header_actions')
<a href="{{ route('admin.activities.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    &larr; Kembali
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Nama Kegiatan *
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title') }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                       placeholder="Contoh: Gotong Royong Resik Sampah Banjar ArtDevata">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Kategori Kegiatan
                    </label>
                    <select name="category_id" id="category_id" class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="event_date" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tanggal Pelaksanaan
                    </label>
                    <input type="date"
                           name="event_date"
                           id="event_date"
                           value="{{ old('event_date', date('Y-m-d')) }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label for="location" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Lokasi Kegiatan
                    </label>
                    <input type="text"
                           name="location"
                           id="location"
                           value="{{ old('location', 'Balai Banjar ArtDevata') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            {{-- Thumbnail options --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 border border-[#E5E5E5] bg-white">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Foto Thumbnail Utama
                    </label>
                    <input type="file"
                           name="thumbnail"
                           accept="image/*"
                           class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-[#1F1F1F] hover:file:bg-neutral-200">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Atau URL Foto Eksternal
                    </label>
                    <input type="url"
                           name="thumbnail_url"
                           value="{{ old('thumbnail_url') }}"
                           placeholder="https://..."
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Unggah Foto Dokumentasi Tambahan (Multi-Upload)
                </label>
                <input type="file"
                       name="gallery_files[]"
                       multiple
                       accept="image/*"
                       class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-[#1F1F1F] hover:file:bg-neutral-200">
                <span class="block text-[11px] text-[#6B6B6B] mt-1">Dapat memilih lebih dari 1 foto sekaligus.</span>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Deskripsi Ringkas
                </label>
                <textarea name="description"
                          id="description"
                          rows="2"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                          placeholder="Penjelasan singkat tujuan dan hasil kegiatan...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="content" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Narasi / Laporan Kegiatan Lengkap (HTML Didukung)
                </label>
                <textarea name="content"
                          id="content"
                          rows="8"
                          class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] font-mono focus:border-[#8B1E24] focus:outline-hidden"
                          placeholder="<p>Laporan pelaksanaan kegiatan...</p>">{{ old('content') }}</textarea>
            </div>

            {{-- Status & Featured --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-[#E5E5E5]">
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Status Publikasi
                    </label>
                    <select name="status" id="status" class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs font-semibold focus:border-[#8B1E24] focus:outline-hidden">
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Tayang)</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                    </select>
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="accent-[#8B1E24]">
                        <span class="text-xs font-bold text-[#1F1F1F]">Tampilkan di Beranda (Featured)</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.activities.index') }}" class="px-4 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    Simpan Kegiatan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
