@extends('layouts.admin')

@section('page_title', 'Ubah Pengurus: ' . $member->name)

@section('header_actions')
<a href="{{ route('admin.members.index') }}" class="px-3 py-1.5 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
    &larr; Kembali
</a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('admin.members.update', $member) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 sm:p-8 border border-[#E5E5E5] bg-white space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Nama Lengkap *
                    </label>
                    <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', $member->name) }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label for="position_title" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Nama Jabatan *
                    </label>
                    <input type="text"
                       name="position_title"
                       id="position_title"
                       value="{{ old('position_title', $member->position_title) }}"
                       required
                       class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="position_id" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Tingkat Struktur Hirarki
                    </label>
                    <select name="position_id" id="position_id" class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                        <option value="">-- Pilih Level Posisi --</option>
                        @foreach($positions as $p)
                            <option value="{{ $p->id }}" {{ old('position_id', $member->position_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="period" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Periode Kepengurusan *
                    </label>
                    <input type="text"
                           name="period"
                           id="period"
                           value="{{ old('period', $member->period) }}"
                           required
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label for="order" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Urutan Tampil (Sort Order)
                    </label>
                    <input type="number"
                           name="order"
                           id="order"
                           value="{{ old('order', $member->order) }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-[#E5E5E5] text-sm focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            {{-- Photo Upload --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 border border-[#E5E5E5] bg-white">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Ganti Foto Pengurus
                    </label>
                    @if($member->photo)
                        <div class="mb-2">
                            <img src="{{ $member->photo_url }}" alt="Preview" class="w-20 h-24 object-cover border border-[#E5E5E5]">
                        </div>
                    @endif
                    <input type="file"
                           name="photo"
                           accept="image/*"
                           class="text-xs text-[#6B6B6B] file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-100 file:text-[#1F1F1F] hover:file:bg-neutral-200">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Atau URL Foto Eksternal
                    </label>
                    <input type="url"
                           name="photo_url"
                           value="{{ old('photo_url', str_starts_with($member->photo ?? '', 'http') ? $member->photo : '') }}"
                           placeholder="https://..."
                           class="w-full px-3 py-2 bg-white border border-[#E5E5E5] text-xs text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Nomor Kontak
                    </label>
                    <input type="text"
                           name="phone"
                           id="phone"
                           value="{{ old('phone', $member->phone) }}"
                           class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Alamat Email
                    </label>
                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email', $member->email) }}"
                           class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden">
                </div>

                <div>
                    <label for="instagram" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                        Profil Instagram (URL)
                    </label>
                    <input type="url"
                           name="instagram"
                           id="instagram"
                           value="{{ old('instagram', $member->social_links['instagram'] ?? '') }}"
                           class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-xs focus:border-[#8B1E24] focus:outline-hidden">
                </div>
            </div>

            <div>
                <label for="bio" class="block text-xs font-bold uppercase tracking-wider text-[#1F1F1F] mb-1.5">
                    Biografi Singkat / Profil Pengurus
                </label>
                <textarea name="bio"
                          id="bio"
                          rows="3"
                          class="w-full px-3.5 py-2 bg-white border border-[#E5E5E5] text-sm text-[#1F1F1F] focus:border-[#8B1E24] focus:outline-hidden">{{ old('bio', $member->bio) }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} class="accent-[#8B1E24]">
                    <span class="text-xs font-bold text-[#1F1F1F]">Status Pengurus Aktif (Tampilkan di Website)</span>
                </label>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-[#E5E5E5]">
                <a href="{{ route('admin.members.index') }}" class="px-4 py-2 border border-[#E5E5E5] text-xs font-semibold hover:border-[#1F1F1F]">
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
