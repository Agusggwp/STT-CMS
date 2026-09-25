@extends('layouts.admin')

@section('title', 'Kotak Masuk Pesan - Admin CMS')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-[#E5E5E5]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#1F1F1F]">Pesan Masuk</h1>
            <p class="text-sm text-[#6B6B6B] mt-1">Kelola aspirasi warga banjar, pertanyaan kemitraan, dan permohonan informasi.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-white border-l-4 border-green-600 border border-[#E5E5E5] text-sm text-[#1F1F1F]">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="p-4 bg-white border border-[#E5E5E5] flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama pengirim, email, perihal..." class="w-full pl-9 pr-4 py-2 text-xs bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                <svg class="w-4 h-4 text-[#6B6B6B] absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <select name="status" class="py-2 px-3 text-xs bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                <option value="">Semua Status</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
            </select>

            <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#1F1F1F] hover:bg-black transition-colors">
                Filter
            </button>

            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 text-xs font-semibold text-[#6B6B6B] border border-[#E5E5E5] hover:border-[#1F1F1F] transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Message Table -->
    <div class="bg-white border border-[#E5E5E5] overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-white border-b border-[#E5E5E5] text-[#1F1F1F] uppercase font-bold tracking-wider">
                <tr>
                    <th class="py-3 px-4 w-12 text-center">Status</th>
                    <th class="py-3 px-4">Pengirim</th>
                    <th class="py-3 px-4">Subjek / Perihal</th>
                    <th class="py-3 px-4">Tanggal Masuk</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5]">
                @forelse($messages as $msg)
                    <tr class="hover:bg-neutral-50/50 {{ !$msg->is_read ? 'font-semibold bg-neutral-50/30' : '' }}">
                        <td class="py-3.5 px-4 text-center">
                            @if(!$msg->is_read)
                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-[#8B1E24]" title="Belum dibaca"></span>
                            @else
                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-[#E5E5E5]" title="Sudah dibaca"></span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="text-[#1F1F1F]">{{ $msg->name }}</div>
                            <div class="text-[11px] text-[#6B6B6B] font-normal">{{ $msg->email }} {{ $msg->phone ? '• ' . $msg->phone : '' }}</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="text-[#1F1F1F] hover:text-[#8B1E24]">
                                {{ $msg->subject ?? 'Tanpa Perihal' }}
                            </a>
                            <p class="text-[11px] text-[#6B6B6B] truncate max-w-md font-normal mt-0.5">{{ Str::limit($msg->message, 80) }}</p>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap text-[#6B6B6B] font-normal">
                            {{ $msg->created_at->format('d M Y, H:i') }} WITA
                        </td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap space-x-2 font-normal">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="text-xs font-semibold text-[#8B1E24] hover:underline">
                                Buka Pesan
                            </a>
                            <form action="{{ route('admin.messages.toggle-read', $msg) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs text-[#6B6B6B] hover:text-[#1F1F1F]">
                                    {{ $msg->is_read ? 'Tandai Belum' : 'Tandai Dibaca' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Hapus pesan ini secara permanen?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-[#6B6B6B]">
                            Tidak ada pesan yang cocok dengan filter pencarian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $messages->links() }}
    </div>
</div>
@endsection
