@extends('layouts.admin')

@section('page_title', 'Buat Album Galeri Baru')

@section('header_actions')
<a href="{{ route('admin.gallery.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    &larr; Kembali
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Nama Album *
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title') }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                       placeholder="Contoh: Malam Pangerupukan & Pawai Ogoh-Ogoh Caka 1948">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Kategori Album *
                    </label>
                    <select name="category" id="category" required class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                        @foreach(['Odalan', 'Gotong Royong', 'Lomba', 'Kegiatan Sosial', 'Olahraga', 'Budaya', 'Organisasi', 'Lainnya'] as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
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
                           value="{{ old('event_date', date('Y-m-d')) }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            {{-- Cover image --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 border border-[#E5E5E5] bg-white">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Foto Sampul Album (Cover)
                    </label>
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
                           value="{{ old('cover_image_url') }}"
                           placeholder="https://..."
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            {{-- Multi-upload photos --}}
            <div class="p-4 border border-[#E5E5E5] bg-white">
                <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Unggah Banyak Foto Sekaligus (Multi-Photo Upload)
                </label>
                <input type="file"
                       name="photos[]"
                       multiple
                       accept="image/*"
                       class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-[#1F1F1F] hover:file:bg-neutral-200">
                <span class="block text-[11px] text-[#6B6B6B] mt-1">Tekan Ctrl/Shift untuk memilih beberapa foto sekaligus.</span>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Deskripsi Singkat Album
                </label>
                <textarea name="description"
                          id="description"
                          rows="3"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                          placeholder="Jelaskan momen atau dokumentasi dalam album ini...">{{ old('description') }}</textarea>
            </div>

            <div class="pt-4 border-t border-[#E5E5E5]">
                <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Status Publikasi
                </label>
                <select name="status" id="status" class="w-48 px-3 py-2 bg-white border border-[#E5E5E5] text-xs font-semibold focus:border-[#8B1E24] focus:outline-hidden">
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Tayang)</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                </select>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.gallery.index') }}" class="px-4 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    Simpan Album & Foto
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
