@extends('layouts.admin')

@section('page_title', 'Ringkasan Dashboard')

@section('header_actions')
<a href="{{ route('admin.posts.create') }}" class="px-3.5 py-1.5 bg-[#8B1E24] hover:bg-[#73171C] text-white text-xs font-bold uppercase tracking-wider transition-colors">
    + Tulis Berita
</a>
@endsection

@section('content')
<div class="space-y-8">
    {{-- Metric Statistics Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="p-5 border border-[#E5E5E5] bg-white">
            <span class="block text-xs font-semibold text-[#6B6B6B] uppercase tracking-wider">Total Kegiatan</span>
            <span class="block text-3xl font-extrabold text-[#1F1F1F] mt-2">{{ $stats['activities_count'] }}</span>
            <a href="{{ route('admin.activities.index') }}" class="inline-block mt-2 text-xs font-bold text-[#8B1E24] hover:underline">Kelola &rarr;</a>
        </div>

        <div class="p-5 border border-[#E5E5E5] bg-white">
            <span class="block text-xs font-semibold text-[#6B6B6B] uppercase tracking-wider">Berita & Warta</span>
            <span class="block text-3xl font-extrabold text-[#1F1F1F] mt-2">{{ $stats['posts_count'] }}</span>
            <a href="{{ route('admin.posts.index') }}" class="inline-block mt-2 text-xs font-bold text-[#8B1E24] hover:underline">Kelola &rarr;</a>
        </div>

        <div class="p-5 border border-[#E5E5E5] bg-white">
            <span class="block text-xs font-semibold text-[#6B6B6B] uppercase tracking-wider">Agenda Kegiatan</span>
            <span class="block text-3xl font-extrabold text-[#1F1F1F] mt-2">{{ $stats['events_count'] }}</span>
            <a href="{{ route('admin.events.index') }}" class="inline-block mt-2 text-xs font-bold text-[#8B1E24] hover:underline">Kelola &rarr;</a>
        </div>

        <div class="p-5 border border-[#E5E5E5] bg-white">
            <span class="block text-xs font-semibold text-[#6B6B6B] uppercase tracking-wider">Pengurus Aktif</span>
            <span class="block text-3xl font-extrabold text-[#1F1F1F] mt-2">{{ $stats['members_count'] }}</span>
            <a href="{{ route('admin.members.index') }}" class="inline-block mt-2 text-xs font-bold text-[#8B1E24] hover:underline">Kelola &rarr;</a>
        </div>

        <div class="p-5 border border-[#E5E5E5] bg-white">
            <span class="block text-xs font-semibold text-[#6B6B6B] uppercase tracking-wider">Album Galeri</span>
            <span class="block text-3xl font-extrabold text-[#1F1F1F] mt-2">{{ $stats['albums_count'] }}</span>
            <a href="{{ route('admin.gallery.index') }}" class="inline-block mt-2 text-xs font-bold text-[#8B1E24] hover:underline">Kelola &rarr;</a>
        </div>

        <div class="p-5 border border-[#E5E5E5] bg-white">
            <span class="block text-xs font-semibold text-[#6B6B6B] uppercase tracking-wider">Dokumen PDF</span>
            <span class="block text-3xl font-extrabold text-[#1F1F1F] mt-2">{{ $stats['documents_count'] }}</span>
            <a href="{{ route('admin.documents.index') }}" class="inline-block mt-2 text-xs font-bold text-[#8B1E24] hover:underline">Kelola &rarr;</a>
        </div>

        <div class="p-5 border border-[#E5E5E5] bg-white">
            <span class="block text-xs font-semibold text-[#6B6B6B] uppercase tracking-wider">Program Kerja</span>
            <span class="block text-3xl font-extrabold text-[#1F1F1F] mt-2">{{ $stats['programs_count'] }}</span>
            <a href="{{ route('admin.work-programs.index') }}" class="inline-block mt-2 text-xs font-bold text-[#8B1E24] hover:underline">Kelola &rarr;</a>
        </div>

        <div class="p-5 border border-[#8B1E24] bg-white">
            <span class="block text-xs font-semibold text-[#8B1E24] uppercase tracking-wider">Pesan Masuk Baru</span>
            <span class="block text-3xl font-extrabold text-[#8B1E24] mt-2">{{ $stats['unread_messages'] }}</span>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" class="inline-block mt-2 text-xs font-bold text-[#8B1E24] hover:underline">Buka Kotak Masuk &rarr;</a>
        </div>
    </div>

    {{-- 2 Columns: Recent Activities & Recent Messages --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Activities --}}
        <div class="border border-[#E5E5E5] bg-white">
            <div class="p-5 border-b border-[#E5E5E5] flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-[#1F1F1F] uppercase tracking-wider">Kegiatan Terbaru</h2>
                    <span class="text-xs text-[#6B6B6B]">Daftar aktivitas yang dipublikasikan</span>
                </div>
                <a href="{{ route('admin.activities.create') }}" class="text-xs font-bold text-[#8B1E24] hover:underline">+ Tambah</a>
            </div>
            <div class="divide-y divide-[#E5E5E5]">
                @forelse($recentActivities as $act)
                    <div class="p-4 flex items-center justify-between hover:bg-neutral-50/50">
                        <div class="flex items-center gap-3 min-w-0">
                            <img src="{{ $act->thumbnail_url }}" alt="{{ $act->title }}" class="w-10 h-10 object-cover flex-shrink-0 border border-[#E5E5E5]">
                            <div class="min-w-0">
                                <h3 class="text-xs font-bold text-[#1F1F1F] truncate">{{ $act->title }}</h3>
                                <span class="text-[11px] text-[#6B6B6B] block">{{ $act->event_date ? $act->event_date->format('d/m/Y') : '-' }} • {{ $act->category->name ?? 'Kegiatan' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.activities.edit', $act) }}" class="text-xs font-semibold text-[#6B6B6B] hover:text-[#8B1E24] flex-shrink-0 ml-4">
                            Ubah
                        </a>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-[#6B6B6B]">Belum ada kegiatan.</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Contact Messages --}}
        <div class="border border-[#E5E5E5] bg-white">
            <div class="p-5 border-b border-[#E5E5E5] flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-[#1F1F1F] uppercase tracking-wider">Pesan dari Pengunjung</h2>
                    <span class="text-xs text-[#6B6B6B]">Pesan melalui formulir kontak</span>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-bold text-[#8B1E24] hover:underline">Semua Pesan &rarr;</a>
            </div>
            <div class="divide-y divide-[#E5E5E5]">
                @forelse($recentMessages as $msg)
                    <div class="p-4 flex items-center justify-between hover:bg-neutral-50/50">
                        <div class="min-w-0 space-y-0.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-[#1F1F1F] truncate">{{ $msg->name }}</span>
                                @if(!$msg->is_read)
                                    <span class="px-1.5 py-0.2 text-[9px] font-bold text-white bg-[#8B1E24] uppercase">Baru</span>
                                @endif
                            </div>
                            <p class="text-xs text-[#6B6B6B] truncate max-w-sm">{{ $msg->subject ?? $msg->message }}</p>
                        </div>
                        <a href="{{ route('admin.messages.show', $msg) }}" class="text-xs font-semibold text-[#8B1E24] flex-shrink-0 ml-4">
                            Lihat &rarr;
                        </a>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-[#6B6B6B]">Belum ada pesan masuk.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Audit Logs --}}
    <div class="border border-[#E5E5E5] bg-white">
        <div class="p-5 border-b border-[#E5E5E5] flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-[#1F1F1F] uppercase tracking-wider">Log Aktivitas Terakhir</h2>
                <span class="text-xs text-[#6B6B6B]">Jejak audit perubahan data oleh admin</span>
            </div>
            @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.activity-logs.index') }}" class="text-xs font-bold text-[#8B1E24] hover:underline">Semua Log &rarr;</a>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-[#E5E5E5] bg-white text-[#6B6B6B] uppercase font-bold text-[10px]">
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Pengguna</th>
                        <th class="py-3 px-4">Aksi</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4">Alamat IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E5E5] text-[#1F1F1F]">
                    @forelse($recentLogs as $log)
                        <tr class="hover:bg-neutral-50/50">
                            <td class="py-3 px-4 text-[#6B6B6B] whitespace-nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-4 font-semibold">{{ $log->user->name ?? 'Sistem' }}</td>
                            <td class="py-3 px-4"><span class="px-2 py-0.5 border border-[#E5E5E5] uppercase font-mono text-[10px]">{{ $log->action }}</span></td>
                            <td class="py-3 px-4">{{ $log->description ?? '-' }}</td>
                            <td class="py-3 px-4 text-[#6B6B6B] font-mono text-[11px]">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-[#6B6B6B]">Belum ada catatan aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
