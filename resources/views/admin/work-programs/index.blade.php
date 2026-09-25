@extends('layouts.admin')

@section('page_title', 'Kelola Program Kerja')

@section('header_actions')
<a href="{{ route('admin.work-programs.create') }}" class="px-3.5 py-1.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
    + Tambah Program Kerja
</a>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Search & Filter --}}
    <div class="p-4 border border-[#E5E5E5] bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.work-programs.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Cari program kerja..."
                   class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden w-48 sm:w-64">

            <select name="status" class="px-3 py-1.5 text-xs bg-white border border-[#E5E5E5] focus:border-[#8B1E24] focus:outline-hidden">
                <option value="">Semua Status</option>
                <option value="rencana" {{ request('status') == 'rencana' ? 'selected' : '' }}>Rencana</option>
                <option value="berjalan" {{ request('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>

            <button type="submit" class="px-3 py-1.5 bg-neutral-100 hover:bg-neutral-200 border border-[#E5E5E5] text-xs font-semibold">
                Filter
            </button>
        </form>

        <span class="text-xs text-[#6B6B6B]">Total: {{ $programs->total() }} program</span>
    </div>

    {{-- Clean Table --}}
    <div class="border border-[#E5E5E5] bg-white overflow-x-auto">
        <table class="w-full text-left border-collapse text-xs">
            <thead>
                <tr class="border-b border-[#E5E5E5] bg-neutral-50/50 text-[#6B6B6B] uppercase font-bold text-[10px]">
                    <th class="py-3 px-4">Nama Program Kerja</th>
                    <th class="py-3 px-4">Penanggung Jawab</th>
                    <th class="py-3 px-4">Periode</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @forelse($programs as $prog)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3 px-4">
                            <span class="font-bold text-[#1F1F1F] block">{{ $prog->name }}</span>
                            <span class="text-[11px] text-[#6B6B6B] line-clamp-1 max-w-md">{{ $prog->description }}</span>
                        </td>
                        <td class="py-3 px-4 text-[#1F1F1F] font-medium">{{ $prog->pic_name ?? '-' }}</td>
                        <td class="py-3 px-4 text-[#6B6B6B] whitespace-nowrap">
                            {{ $prog->start_date ? $prog->start_date->format('M Y') : '-' }} @if($prog->end_date) - {{ $prog->end_date->format('M Y') }} @endif
                        </td>
                        <td class="py-3 px-4">
                            @php $badge = $prog->status_badge; @endphp
                            <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold border uppercase tracking-wider {{ $badge['class'] }}">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.work-programs.edit', $prog) }}" class="px-2.5 py-1 text-xs border border-[#E5E5E5] hover:border-[#1F1F1F]">
                                    Ubah
                                </a>
                                <form action="{{ route('admin.work-programs.destroy', $prog) }}" method="POST" onsubmit="return confirm('Hapus program kerja ini?')">
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
                        <td colspan="5" class="py-8 text-center text-[#6B6B6B]">Tidak ada data program kerja.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $programs->links() }}
    </div>
</div>
@endsection
