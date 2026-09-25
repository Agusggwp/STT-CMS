@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru - Admin CMS')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="pb-6 border-b border-[#E5E5E5]">
        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-[#6B6B6B] hover:text-[#8B1E24] inline-flex items-center gap-1 mb-2">
            ← Kembali ke Daftar Pengguna
        </a>
        <h1 class="text-2xl font-bold tracking-tight text-[#1F1F1F]">Tambah Pengguna Baru</h1>
        <p class="text-sm text-[#6B6B6B] mt-1">Buat akun untuk administrator sistem, sekretaris/editor berita, atau pengurus bidang.</p>
    </div>

    @if($errors->any())
        <div class="p-4 bg-white border-l-4 border-red-600 border border-[#E5E5E5] text-sm text-[#1F1F1F] space-y-1">
            <div class="font-bold">Terjadi kesalahan input:</div>
            <ul class="list-disc pl-5 text-xs text-red-600 space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 bg-white border border-[#E5E5E5] space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="cth: I Made Suardana" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="pengurus@sttbali.id" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Password Awal</label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Peran / Role</label>
                <select name="role" required class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    <option value="pengurus" {{ old('role') == 'pengurus' ? 'selected' : '' }}>Pengurus (Hak akses input program kerja & agenda)</option>
                    <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Editor (Hak akses kelola berita, kegiatan, dan galeri)</option>
                    <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin (Hak akses penuh seluruh sistem)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Status Akun</label>
                <select name="status" required class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif (Suspend)</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp (Opsional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+62 812..." class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Bio / Catatan Organisasi (Opsional)</label>
                <textarea name="bio" rows="2" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">{{ old('bio') }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-[#E5E5E5]">
            <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-[#6B6B6B] border border-[#E5E5E5] hover:border-[#1F1F1F]">Batal</a>
            <button type="submit" class="px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#6e171c]">Simpan Pengguna</button>
        </div>
    </form>
</div>
@endsection
