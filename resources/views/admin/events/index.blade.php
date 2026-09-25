@extends('layouts.admin')

@section('page_title', 'Kelola Agenda Kegiatan')

@section('header_actions')
<a href="{{ route('admin.events.create') }}" class="px-3.5 py-1.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
    + Tambah Agenda
</a>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Search & Filter --}}
    <div class="p-4 border border-[#E5E5E5] bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.events.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari nama agenda..."
                   class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden w-48 sm:w-64">

            <select name="status" class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden">
                <option value="">Semua Status</option>
                <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Mendatang</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Berjalan</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            </select>

            <button type="submit" class="px-3 py-1.5 bg-neutral-100 hover:bg-neutral-200 border border-[#E5E5E5] text-xs font-semibold">
                Filter
            </button>
        </form>

        <span class="text-xs text-[#6B6B6B]">Total: {{ $events->total() }} agenda</span>
    </div>

    {{-- Clean Table --}}
    <div class="border border-[#E5E5E5] bg-white overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-[#E5E5E5] bg-neutral-50/50 text-[#6B6B6B] uppercase font-bold text-[10px]">
                    <th class="py-3 px-4">Nama Agenda</th>
                    <th class="py-3 px-4">Tanggal Pelaksanaan</th>
                    <th class="py-3 px-4">Waktu</th>
                    <th class="py-3 px-4">Lokasi</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @forelse($events as $ev)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3 px-4">
                            <a href="{{ route('events.show', $ev->slug) }}" target="_blank" class="font-bold text-[#1F1F1F] hover:text-[#8B1E24]">
                                {{ $ev->title }}
                            </a>
                        </td>
                        <td class="py-3 px-4 font-semibold text-[#8B1E24]">{{ $ev->event_date->format('d/m/Y') }}</td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $ev->start_time ?? '-' }}</td>
                        <td class="py-3 px-4 text-[#6B6B6B]">{{ $ev->location }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $ev->status == 'upcoming' ? 'bg-[#8B1E24] text-white' : 'bg-neutral-100 text-neutral-700 border border-neutral-300' }}">
                                {{ $ev->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.events.edit', $ev) }}" class="px-2.5 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F]">
                                    Ubah
                                </a>
                                <form action="{{ route('admin.events.destroy', $ev) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?')">
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
                        <td colspan="6" class="py-8 text-center text-[#6B6B6B]">Tidak ada data agenda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $events->links() }}
    </div>
</div>
@endsection
