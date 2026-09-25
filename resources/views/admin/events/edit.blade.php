@extends('layouts.admin')

@section('page_title', 'Ubah Agenda: ' . Str::limit($event->title, 40))

@section('header_actions')
<a href="{{ route('admin.events.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    &larr; Kembali
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Nama Agenda / Kegiatan *
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title', $event->title) }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="event_date" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tanggal Acara *
                    </label>
                    <input type="date"
                           name="event_date"
                           id="event_date"
                           value="{{ old('event_date', $event->event_date ? $event->event_date->format('Y-m-d') : '') }}"
                           required
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label for="start_time" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Waktu Mulai
                    </label>
                    <input type="text"
                           name="start_time"
                           id="start_time"
                           value="{{ old('start_time', $event->start_time) }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label for="end_time" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Waktu Selesai (Opsional)
                    </label>
                    <input type="text"
                           name="end_time"
                           id="end_time"
                           value="{{ old('end_time', $event->end_time) }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div>
                <label for="location" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Lokasi Agenda *
                </label>
                <input type="text"
                       name="location"
                       id="location"
                       value="{{ old('location', $event->location) }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 border border-[#E5E5E5] bg-white">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Poster Acara Baru
                    </label>
                    @if($event->poster)
                        <div class="mb-2">
                            <img src="{{ $event->poster_url }}" alt="Preview" class="w-20 h-28 object-cover border border-[#E5E5E5]">
                        </div>
                    @endif
                    <input type="file"
                           name="poster"
                           accept="image/*"
                           class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-[#1F1F1F] hover:file:bg-neutral-200">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Atau URL Poster Eksternal
                    </label>
                    <input type="url"
                           name="poster_url"
                           value="{{ old('poster_url', str_starts_with($event->poster ?? '', 'http') ? $event->poster : '') }}"
                           placeholder="https://..."
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div>
                <label for="registration_link" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Link Konfirmasi / Pendaftaran
                </label>
                <input type="url"
                       name="registration_link"
                       id="registration_link"
                       value="{{ old('registration_link', $event->registration_link) }}"
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
            </div>

            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Keterangan & Rincian Agenda
                </label>
                <textarea name="description"
                          id="description"
                          rows="5"
                          class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-[#E5E5E5]">
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Status Agenda
                    </label>
                    <select name="status" id="status" class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs font-semibold focus:border-[#8B1E24] focus:outline-hidden">
                        <option value="upcoming" {{ old('status', $event->status) == 'upcoming' ? 'selected' : '' }}>Upcoming (Mendatang)</option>
                        <option value="ongoing" {{ old('status', $event->status) == 'ongoing' ? 'selected' : '' }}>Ongoing (Sedang Berlangsung)</option>
                        <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                        <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                    </select>
                </div>

                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }} class="accent-[#8B1E24]">
                        <span class="text-xs font-bold text-[#1F1F1F]">Tampilkan di Beranda</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('admin.events.index') }}" class="px-4 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
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
