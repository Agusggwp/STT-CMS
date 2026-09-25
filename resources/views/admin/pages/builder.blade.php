@extends('layouts.admin')

@section('page_title', 'Page Builder: ' . $page->title)

@section('header_actions')
<div class="flex items-center gap-2">
    @if($page->slug === 'home')
        <a href="{{ route('home') }}" target="_blank" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
            Lihat Halaman &rarr;
        </a>
    @else
        <a href="{{ route('pages.show', $page->slug) }}" target="_blank" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
            Lihat Halaman &rarr;
        </a>
    @endif
    <a href="{{ route('admin.pages.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
        &larr; Kembali ke Daftar
    </a>
</div>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-8" x-data="{ addSectionModal: false }">

    {{-- Page Info Banner --}}
    <div class="p-6 border border-[#E5E5E5] bg-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-[#8B1E24]">Pengaturan Bagian Konten</span>
            <h2 class="text-xl font-bold text-[#1F1F1F] mt-0.5">{{ $page->title }}</h2>
            <p class="text-xs text-[#6B6B6B] mt-1">Susun konten halaman secara modular (Text, Image, Text+Image, Gallery, Event, News, CTA, FAQ, Stats).</p>
        </div>

        <button @click="addSectionModal = true" class="px-4 py-2 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors flex items-center gap-2 flex-shrink-0">
            <span>+ Tambah Section</span>
        </button>
    </div>

    {{-- Sections List --}}
    <div class="space-y-4">
        @forelse($page->sections as $index => $sec)
            <div class="border border-[#E5E5E5] p-5 bg-white space-y-4 hover:border-[#1F1F1F] transition-colors" x-data="{ expanded: false }">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4 min-w-0">
                        {{-- Order Badge --}}
                        <div class="w-8 h-8 border border-[#E5E5E5] bg-white flex items-center justify-center font-bold text-xs text-[#8B1E24]">
                            {{ $sec->order }}
                        </div>

                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider border border-[#8B1E24] text-[#8B1E24]">
                                    {{ strtoupper($sec->type) }}
                                </span>
                                <span class="text-xs text-[#6B6B6B] font-mono">{{ $sec->section_key }}</span>
                            </div>
                            <h3 class="text-sm font-bold text-[#1F1F1F] mt-1 truncate">
                                {{ $sec->title ?? '(Tanpa Judul)' }}
                            </h3>
                            @if($sec->subtitle)
                                <span class="text-[11px] text-[#6B6B6B] block truncate">{{ $sec->subtitle }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3 flex-shrink-0">
                        {{-- Toggle Active --}}
                        <form action="{{ route('admin.page-sections.toggle', $sec) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-2.5 py-1 text-xs border uppercase tracking-wider font-bold {{ $sec->is_active ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-neutral-100 text-neutral-600 border-neutral-300' }}">
                                {{ $sec->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>

                        <button @click="expanded = !expanded" class="px-3 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F] font-semibold">
                            <span x-text="expanded ? 'Tutup' : 'Ubah Konten'"></span>
                        </button>

                        <form action="{{ route('admin.page-sections.destroy', $sec) }}" method="POST" onsubmit="return confirm('Hapus bagian ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 text-xs border border-[#E5E5E5] text-[#8B1E24] hover:border-[#8B1E24]">
                                &times;
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Edit Panel Collapsible --}}
                <div x-show="expanded" class="pt-4 border-t border-[#E5E5E5] space-y-4" x-cloak>
                    <form action="{{ route('admin.page-sections.update', $sec) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#1F1F1F] mb-1">Judul Section</label>
                                <input type="text" name="title" value="{{ $sec->title }}" class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#1F1F1F] mb-1">Subjudul Section</label>
                                <input type="text" name="subtitle" value="{{ $sec->subtitle }}" class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#1F1F1F] mb-1">Konten Teks / HTML</label>
                            <textarea name="content" rows="4" class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs font-mono">{{ $sec->content }}</textarea>
                        </div>

                        @if(in_array($sec->type, ['image', 'text_image']))
                            <div class="p-3 border border-[#E5E5E5] bg-white">
                                <label class="block text-[11px] font-bold uppercase text-[#1F1F1F] mb-1">Unggah / Ganti Gambar Section</label>
                                @if(!empty($sec->data['image']))
                                    <div class="mb-2">
                                        <img src="{{ $sec->data['image'] }}" alt="Section preview" class="w-24 h-16 object-cover border border-[#E5E5E5]">
                                    </div>
                                @endif
                                <input type="file" name="section_image" accept="image/*" class="text-xs text-[#6B6B6B]">
                            </div>
                        @endif

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="expanded = false" class="px-3 py-1.5 border border-[#E5E5E5] text-xs">Batal</button>
                            <button type="submit" class="px-4 py-1.5 bg-[#8B1E24] text-white text-xs font-bold uppercase hover:bg-[#73171C]">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-xs text-[#6B6B6B] border border-[#E5E5E5]">
                Belum ada section yang ditambahkan pada halaman ini. Klik tombol "+ Tambah Section" di atas.
            </div>
        @endforelse
    </div>

    {{-- Add Section Modal --}}
    <div x-show="addSectionModal"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
         @keydown.escape.window="addSectionModal = false"
         x-cloak>
        <div class="bg-white max-w-lg w-full p-6 sm:p-8 border border-[#E5E5E5] space-y-6" @click.away="addSectionModal = false">
            <div class="flex items-center justify-between pb-3 border-b border-[#E5E5E5]">
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#1F1F1F]">Tambah Bagian (Section) Baru</h3>
                <button @click="addSectionModal = false" class="text-lg text-[#6B6B6B] hover:text-[#1F1F1F]">&times;</button>
            </div>

            <form action="{{ route('admin.page-sections.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="page_id" value="{{ $page->id }}">
                <input type="hidden" name="page_key" value="{{ $page->slug }}">

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tipe Bagian (Section Type) *
                    </label>
                    <select name="type" required class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs font-semibold focus:border-[#8B1E24] focus:outline-hidden">
                        <option value="text">Text (Teks Paragraf Editorial)</option>
                        <option value="image">Image (Foto & Dokumentasi Penuh)</option>
                        <option value="text_image">Text + Image (Teks & Foto Bersebelahan)</option>
                        <option value="cta">CTA (Call To Action & Tombol Tautan)</option>
                        <option value="faq">FAQ (Tanya Jawab Krama)</option>
                        <option value="statistics">Statistics (Angka Kunci / Prestasi)</option>
                        <option value="custom">Custom (Khusus)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Judul Bagian *
                    </label>
                    <input type="text"
                           name="title"
                           required
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden"
                           placeholder="Contoh: Sambutan Ketua / Nilai Filosofis">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Subjudul (Subtitle)
                    </label>
                    <input type="text"
                           name="subtitle"
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden"
                           placeholder="Contoh: Tri Hita Karana">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Isi Konten Awal
                    </label>
                    <textarea name="content"
                              rows="3"
                              class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden"
                              placeholder="Tuliskan narasi singkat..."></textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#E5E5E5]">
                    <button type="button" @click="addSectionModal = false" class="px-4 py-2 border border-[#E5E5E5] text-xs font-semibold">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider">
                        Tambahkan Bagian
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
