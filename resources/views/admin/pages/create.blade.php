@extends('layouts.admin')

@section('page_title', 'Buat Halaman Baru')

@section('header_actions')
<a href="{{ route('admin.pages.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    &larr; Kembali
</a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.pages.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Judul Halaman *
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title') }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                       placeholder="Contoh: Sejarah & Prestasi Seni STT">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Slug URL (Opsional)
                    </label>
                    <input type="text"
                           name="slug"
                           id="slug"
                           value="{{ old('slug') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                           placeholder="sejarah-dan-prestasi">
                </div>

                <div>
                    <label for="subtitle" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Subjudul (Subtitle)
                    </label>
                    <input type="text"
                           name="subtitle"
                           id="subtitle"
                           value="{{ old('subtitle') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                           placeholder="Kiprah Pemuda Banjar ArtDevata">
                </div>
            </div>

            <div>
                <label for="content" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Konten Teks Pembuka (Opsional)
                </label>
                <textarea name="content"
                          id="content"
                          rows="4"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                          placeholder="Penjelasan pembuka halaman...">{{ old('content') }}</textarea>
            </div>

            <div>
                <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Status Publikasi
                </label>
                <select name="status" id="status" class="w-full sm:w-48 px-3 py-2 bg-white border border-[#E5E5E5] text-xs font-semibold focus:border-[#8B1E24] focus:outline-hidden">
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Tayang)</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                </select>
            </div>

            {{-- SEO Metadata --}}
            <div class="p-4 border border-[#E5E5E5] bg-white space-y-4">
                <span class="text-xs font-bold uppercase tracking-wider text-[#8B1E24] block">Metadata SEO</span>
                <div>
                    <label class="block text-[11px] font-semibold text-[#1F1F1F] mb-1">SEO Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="w-full px-3 py-1.5 bg-white border border-[#E5E5E5] text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-[#1F1F1F] mb-1">SEO Meta Description</label>
                    <textarea name="meta_description" rows="2" class="w-full px-3 py-1.5 bg-white border border-[#E5E5E5] text-xs">{{ old('meta_description') }}</textarea>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#E5E5E5]">
                <a href="{{ route('admin.pages.index') }}" class="px-4 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    Buat & Lanjut ke Page Builder &rarr;
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
