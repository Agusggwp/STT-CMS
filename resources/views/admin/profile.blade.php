@extends('layouts.admin')

@section('title', 'Profil Saya - Admin CMS')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="pb-6 border-b border-[#E5E5E5]">
        <h1 class="text-2xl font-bold tracking-tight text-[#1F1F1F]">Pengaturan Profil</h1>
        <p class="text-sm text-[#6B6B6B] mt-1">Kelola data profil personal, foto avatar, dan kata sandi login Anda.</p>
    </div>

    @if(session('success'))
        <div class="p-4 bg-white border-l-4 border-green-600 border border-[#E5E5E5] text-sm text-[#1F1F1F]">
            {{ session('success') }}
        </div>
    @endif

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

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Data Profil -->
        <div class="p-6 bg-white border border-[#E5E5E5] space-y-6">
            <h2 class="text-base font-bold text-[#1F1F1F] border-b border-[#E5E5E5] pb-3">Informasi Akun</h2>

            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-full bg-[#8B1E24] text-white flex items-center justify-center font-bold text-2xl overflow-hidden border border-[#E5E5E5]">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-1">Ganti Foto Profil</label>
                    <input type="file" name="avatar" accept="image/*" class="text-xs text-[#6B6B6B] file:mr-4 file:py-1.5 file:px-3 file:border file:border-[#E5E5E5] file:text-xs file:font-semibold file:bg-white hover:file:border-[#8B1E24]">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Peran Akun</label>
                    <input type="text" disabled value="{{ strtoupper($user->role) }}" class="w-full px-4 py-2.5 text-sm bg-neutral-100/50 border border-[#E5E5E5] text-[#6B6B6B] cursor-not-allowed">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Bio Singkat</label>
                    <textarea name="bio" rows="2" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">{{ old('bio', $user->bio) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Keamanan & Ganti Sandi -->
        <div class="p-6 bg-white border border-[#E5E5E5] space-y-6">
            <h2 class="text-base font-bold text-[#1F1F1F] border-b border-[#E5E5E5] pb-3">Pergantian Kata Sandi</h2>
            <p class="text-xs text-[#6B6B6B]">Kosongkan bagian ini jika Anda tidak bermaksud mengganti kata sandi.</p>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Kata Sandi Baru</label>
                        <input type="password" name="password" minlength="8" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1F1F1F] uppercase tracking-wider mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" minlength="8" class="w-full px-4 py-2.5 text-sm bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end p-6 bg-white border border-[#E5E5E5]">
            <button type="submit" class="px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#6e171c] transition-colors">
                Perbarui Profil
            </button>
        </div>
    </form>
</div>
@endsection
