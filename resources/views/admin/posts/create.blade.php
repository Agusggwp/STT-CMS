@extends('layouts.admin')

@section('page_title', 'Tulis Berita Baru')

@section('header_actions')
<a href="{{ route('admin.posts.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    &larr; Kembali
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Judul Berita *
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title') }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                       placeholder="Masukkan judul berita organisasi...">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Kategori Berita
                    </label>
                    <select name="category_id" id="category_id" class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="author_name" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Nama Penulis / Redaksi
                    </label>
                    <input type="text"
                           name="author_name"
                           id="author_name"
                           value="{{ old('author_name', auth()->user()->name) }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            {{-- Thumbnail options --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 border border-[#E5E5E5] bg-white">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Unggah Gambar Thumbnail
                    </label>
                    <input type="file"
                           name="thumbnail"
                           accept="image/*"
                           class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-[#1F1F1F] hover:file:bg-neutral-200">
                    <span class="block text-[11px] text-[#6B6B6B] mt-1">Maks. 3 MB (JPG, PNG, WebP)</span>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Atau URL Gambar Eksternal
                    </label>
                    <input type="url"
                           name="thumbnail_url"
                           value="{{ old('thumbnail_url') }}"
                           placeholder="https://..."
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div>
                <label for="summary" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Ringkasan Singkat (Lead Excerpt)
                </label>
                <textarea name="summary"
                          id="summary"
                          rows="2"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                          placeholder="Penjelasan singkat 1-2 kalimat pengantar...">{{ old('summary') }}</textarea>
            </div>

            <div>
                <label for="content" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Isi Konten Berita * (HTML Didukung)
                </label>
                <textarea name="content"
                          id="content"
                          rows="10"
                          required
                          class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] font-mono focus:border-[#8B1E24] focus:outline-hidden"
                          placeholder="<p>Tuliskan narasi berita lengkap di sini...</p>">{{ old('content') }}</textarea>
                <span class="text-[11px] text-[#6B6B6B] mt-1 block">Anda dapat menggunakan tag HTML seperti &lt;p&gt;, &lt;h3&gt;, &lt;ul&gt;, &lt;li&gt;, &lt;blockquote&gt; dsb.</span>
            </div>

            {{-- Status & Featured --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4 border-t border-[#E5E5E5]">
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Status Publikasi
                    </label>
                    <select name="status" id="status" class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs font-semibold focus:border-[#8B1E24] focus:outline-hidden">
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Tayang)</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                    </select>
                </div>

                <div>
                    <label for="published_at" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tanggal Terbit
                    </label>
                    <input type="date"
                           name="published_at"
                           id="published_at"
                           value="{{ old('published_at', date('Y-m-d')) }}"
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="accent-[#8B1E24]">
                        <span class="text-xs font-bold text-[#1F1F1F]">Jadikan Berita Utama (Featured)</span>
                    </label>
                </div>
            </div>

            {{-- SEO Metadata --}}
            <div class="p-4 border border-[#E5E5E5] bg-white space-y-4">
                <span class="text-xs font-bold uppercase tracking-wider text-[#8B1E24] block">Metadata SEO (Opsional)</span>
                <div>
                    <label class="block text-[11px] font-semibold text-[#1F1F1F] mb-1">SEO Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="w-full px-3 py-1.5 bg-white border border-[#E5E5E5] text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-[#1F1F1F] mb-1">Meta Description</label>
                    <textarea name="meta_description" rows="2" class="w-full px-3 py-1.5 bg-white border border-[#E5E5E5] text-xs">{{ old('meta_description') }}</textarea>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    Simpan & Publikasikan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
