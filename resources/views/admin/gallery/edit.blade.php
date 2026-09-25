@extends('layouts.admin')

@section('page_title', 'Kelola Album: ' . Str::limit($album->title, 40))

@section('header_actions')
<a href="{{ route('admin.gallery.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    &larr; Kembali
</a>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    {{-- Edit Album Form --}}
    <form action="{{ route('admin.gallery.update', $album) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-[#E5E5E5]">
                <h2 class="text-sm font-bold uppercase tracking-wider text-[#1F1F1F]">Informasi Album</h2>
                <a href="{{ route('gallery.show', $album->slug) }}" target="_blank" class="text-xs text-[#8B1E24] hover:underline font-semibold">
                    Lihat di Website &rarr;
                </a>
            </div>

            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Nama Album *
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title', $album->title) }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Kategori Album *
                    </label>
                    <select name="category" id="category" required class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                        @foreach(['Odalan', 'Gotong Royong', 'Lomba', 'Kegiatan Sosial', 'Olahraga', 'Budaya', 'Organisasi', 'Lainnya'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $album->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="event_date" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tanggal Acara / Dokumentasi
                    </label>
                    <input type="date"
                           name="event_date"
                           id="event_date"
                           value="{{ old('event_date', $album->event_date ? $album->event_date->format('Y-m-d') : '') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            {{-- Cover image --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 border border-[#E5E5E5] bg-white">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Ganti Foto Sampul (Cover)
                    </label>
                    @if($album->cover_image)
                        <div class="mb-2">
                            <img src="{{ $album->cover_image_url }}" alt="Cover" class="w-24 h-16 object-cover border border-[#E5E5E5]">
                        </div>
                    @endif
                    <input type="file"
                           name="cover_image"
                           accept="image/*"
                           class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-[#1F1F1F] hover:file:bg-neutral-200">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Atau URL Foto Sampul
                    </label>
                    <input type="url"
                           name="cover_image_url"
                           value="{{ old('cover_image_url', str_starts_with($album->cover_image ?? '', 'http') ? $album->cover_image : '') }}"
                           placeholder="https://..."
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            {{-- Upload more photos --}}
            <div class="p-4 border border-[#8B1E24] bg-white">
                <label class="block text-xs font-bold uppercase tracking-wider text-[#8B1E24] mb-1.5">
                    + Tambah Foto ke Album Ini (Multi-Upload)
                </label>
                <input type="file"
                       name="photos[]"
                       multiple
                       accept="image/*"
                       class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-[#8B1E24] file:text-white hover:file:bg-[#73171C]">
                <span class="block text-[11px] text-[#6B6B6B] mt-1">Pilih beberapa file sekaligus untuk ditambahkan ke album.</span>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Deskripsi Singkat Album
                </label>
                <textarea name="description"
                          id="description"
                          rows="3"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">{{ old('description', $album->description) }}</textarea>
            </div>

            <div class="pt-4 border-t border-[#E5E5E5] flex items-center justify-between">
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Status Publikasi
                    </label>
                    <select name="status" id="status" class="w-48 px-3 py-2 bg-white border border-[#E5E5E5] text-xs font-semibold focus:border-[#8B1E24] focus:outline-hidden">
                        <option value="published" {{ old('status', $album->status) == 'published' ? 'selected' : '' }}>Published (Tayang)</option>
                        <option value="draft" {{ old('status', $album->status) == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="px-6 py-2.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Existing Photos Management --}}
    <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-[#E5E5E5]">
            <h2 class="text-sm font-bold uppercase tracking-wider text-[#1F1F1F]">Daftar Foto Dalam Album ({{ $album->images->count() }})</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($album->images as $img)
                <div class="border border-[#E5E5E5] p-2 bg-white flex flex-col justify-between group">
                    <img src="{{ $img->image_url }}" alt="Foto" class="w-full h-28 object-cover">
                    <div class="mt-2 pt-2 border-t border-[#E5E5E5] flex items-center justify-between">
                        <span class="text-[10px] text-[#6B6B6B]">#{{ $img->order }}</span>
                        <form action="{{ route('admin.gallery.delete-image', $img) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari album?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[10px] font-bold text-[#8B1E24] hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-6 text-center py-8 text-xs text-[#6B6B6B]">
                    Belum ada foto dalam album ini. Unggah foto baru menggunakan form di atas.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
