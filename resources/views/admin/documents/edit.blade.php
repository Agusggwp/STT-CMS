@extends('layouts.admin')

@section('page_title', 'Ubah Dokumen: ' . Str::limit($document->title, 40))

@section('header_actions')
<a href="{{ route('admin.documents.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    &larr; Kembali
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Judul Dokumen *
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title', $document->title) }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Kategori Dokumen *
                    </label>
                    <select name="category" id="category" required class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                        @foreach(['AD/ART', 'Proposal', 'Laporan Kegiatan', 'Surat', 'Jadwal', 'Panduan', 'Dokumen Organisasi'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $document->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="published_at" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tanggal Dokumen
                    </label>
                    <input type="date"
                           name="published_at"
                           id="published_at"
                           value="{{ old('published_at', $document->published_at ? $document->published_at->format('Y-m-d') : '') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div class="p-4 border border-[#E5E5E5] bg-white space-y-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F]">
                    Ganti Berkas Dokumen (Opsional)
                </label>
                <div class="text-xs text-[#6B6B6B] mb-2">
                    Berkas saat ini: <strong class="text-[#1F1F1F]">{{ $document->file_path }}</strong> ({{ $document->file_size }})
                </div>
                <input type="file"
                       name="document_file"
                       accept=".pdf,.doc,.docx,.xls,.xlsx"
                       class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-[#1F1F1F] hover:file:bg-neutral-200">
            </div>

            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Keterangan Singkat Isi Dokumen
                </label>
                <textarea name="description"
                          id="description"
                          rows="3"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">{{ old('description', $document->description) }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#E5E5E5]">
                <a href="{{ route('admin.documents.index') }}" class="px-4 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
