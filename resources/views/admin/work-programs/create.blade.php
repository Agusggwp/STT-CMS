@extends('layouts.admin')

@section('page_title', 'Tambah Program Kerja')

@section('header_actions')
<a href="{{ route('admin.work-programs.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    &larr; Kembali
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.work-programs.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Nama Program Kerja *
                </label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                       placeholder="Contoh: Revitalisasi Tabuh Gong Kebyar dan Tari Bali">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="pic_name" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Penanggung Jawab (PIC)
                    </label>
                    <input type="text"
                           name="pic_name"
                           id="pic_name"
                           value="{{ old('pic_name') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                           placeholder="Nama Pengurus / Bidang">
                </div>

                <div>
                    <label for="start_date" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tanggal Mulai
                    </label>
                    <input type="date"
                           name="start_date"
                           id="start_date"
                           value="{{ old('start_date') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label for="end_date" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tanggal Berakhir (Target)
                    </label>
                    <input type="date"
                           name="end_date"
                           id="end_date"
                           value="{{ old('end_date') }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div>
                <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Status Program Kerja *
                </label>
                <select name="status" id="status" required class="w-full sm:w-64 px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm font-semibold focus:border-[#8B1E24] focus:outline-hidden">
                    <option value="rencana" {{ old('status') == 'rencana' ? 'selected' : '' }}>Rencana</option>
                    <option value="berjalan" {{ old('status') == 'berjalan' ? 'selected' : '' }}>Sedang Berjalan</option>
                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Deskripsi Ringkas
                </label>
                <textarea name="description"
                          id="description"
                          rows="3"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                          placeholder="Penjelasan latar belakang dan urgensi program...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="objectives" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Tujuan & Target Spesifik
                </label>
                <textarea name="objectives"
                          id="objectives"
                          rows="4"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                          placeholder="1. Meningkatkan keterampilan...\n2. Menghasilkan kas mandiri..."></textarea>
            </div>

            <div>
                <label for="documentation_notes" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Catatan Dokumentasi / Evaluasi (Opsional)
                </label>
                <textarea name="documentation_notes"
                          id="documentation_notes"
                          rows="2"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden"
                          placeholder="Catatan perkembangan atau pencapaian target saat ini...">{{ old('documentation_notes') }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#E5E5E5]">
                <a href="{{ route('admin.work-programs.index') }}" class="px-4 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
                    Simpan Program Kerja
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
