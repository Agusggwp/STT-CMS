@extends('layouts.admin')

@section('title', 'Manajemen Pengguna & Hak Akses - Admin CMS')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-[#E5E5E5]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#1F1F1F]">Pengguna & Hak Akses</h1>
            <p class="text-sm text-[#6B6B6B] mt-1">Kelola akun administrator, editor konten, dan pengurus STT.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#6e171c] transition-colors shadow-sm self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-white border-l-4 border-green-600 border border-[#E5E5E5] text-sm text-[#1F1F1F]">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-white border-l-4 border-red-600 border border-[#E5E5E5] text-sm text-[#1F1F1F]">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white border border-[#E5E5E5] overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-white border-b border-[#E5E5E5] text-[#1F1F1F] uppercase font-bold tracking-wider">
                <tr>
                    <th class="py-3 px-4">Pengguna</th>
                    <th class="py-3 px-4">Role</th>
                    <th class="py-3 px-4">Kontak</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Terdaftar</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @foreach($users as $user)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#8B1E24] text-white flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-[#1F1F1F]">{{ $user->name }}</div>
                                    <div class="text-[11px] text-[#6B6B6B]">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-block px-2 py-0.5 text-[10px] uppercase font-bold tracking-wider border {{ $user->role === 'superadmin' ? 'border-[#8B1E24] text-[#8B1E24]' : ($user->role === 'editor' ? 'border-[#C49A3A] text-[#C49A3A]' : 'border-[#E5E5E5] text-[#6B6B6B]') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-[#6B6B6B]">
                            {{ $user->phone ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1.5 text-xs {{ $user->status === 'active' ? 'text-green-700' : 'text-[#6B6B6B]' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->status === 'active' ? 'bg-green-600' : 'bg-[#E5E5E5]' }}"></span>
                                {{ $user->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-[#6B6B6B] whitespace-nowrap">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-xs font-semibold text-[#8B1E24] hover:underline">
                                Edit
                            </a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus akun pengguna ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:underline">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $users->links() }}
    </div>
</div>
@endsection
