@extends('layouts.admin')

@section('page_title', 'Kelola Pengurus & Struktur')

@section('header_actions')
<a href="{{ route('admin.members.create') }}" class="px-3.5 py-1.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
    + Tambah Pengurus
</a>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Search --}}
    <div class="p-4 border border-[#E5E5E5] bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.members.index') }}" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari nama atau jabatan..."
                   class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden w-64">

            <button type="submit" class="px-3 py-1.5 bg-neutral-100 hover:bg-neutral-200 border border-[#E5E5E5] text-xs font-semibold">
                Cari
            </button>

            @if(request('q'))
                <a href="{{ route('admin.members.index') }}" class="text-xs text-[#8B1E24] hover:underline">Reset</a>
            @endif
        </form>

        <span class="text-xs text-[#6B6B6B]">Total: {{ $members->total() }} anggota terdaftar</span>
    </div>

    {{-- Clean Table --}}
    <div class="border border-[#E5E5E5] bg-white overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-[#E5E5E5] bg-neutral-50/50 text-[#6B6B6B] uppercase font-bold text-[10px]">
                    <th class="py-3 px-4">Urutan</th>
                    <th class="py-3 px-4">Foto & Nama</th>
                    <th class="py-3 px-4">Jabatan</th>
                    <th class="py-3 px-4">Periode</th>
                    <th class="py-3 px-4">Kontak</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @forelse($members as $m)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3 px-4 font-bold text-[#8B1E24]">{{ $m->order }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $m->photo_url }}" alt="{{ $m->name }}" class="w-10 h-10 object-cover border border-[#E5E5E5] flex-shrink-0">
                                <div>
                                    <span class="font-bold text-[#1F1F1F] block">{{ $m->name }}</span>
                                    <span class="text-[11px] text-[#6B6B6B] truncate max-w-xs">{{ $m->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 font-semibold text-[#1F1F1F]">{{ $m->position_title }}</td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $m->period }}</td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $m->phone ?? '-' }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $m->is_active ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-neutral-100 text-neutral-700 border border-neutral-300' }}">
                                {{ $m->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.members.edit', $m) }}" class="px-2.5 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F]">
                                    Ubah
                                </a>
                                <form action="{{ route('admin.members.destroy', $m) }}" method="POST" onsubmit="return confirm('Hapus data pengurus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 text-xs border border-[#E5E5E5] text-[#8B1E24] hover:border-[#8B1E24]">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-[#6B6B6B]">Tidak ada data pengurus.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $members->links() }}
    </div>
</div>
@endsection
