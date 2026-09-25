@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem - Admin CMS')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-[#E5E5E5]">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#1F1F1F]">Log Aktivitas Sistem</h1>
            <p class="text-sm text-[#6B6B6B] mt-1">Audit jejak digital perubahan data, login, dan aksi pengguna pada panel CMS.</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="p-4 bg-white border border-[#E5E5E5] flex flex-col md:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="action" value="{{ request('action') }}" placeholder="Cari tipe aksi (cth: create, update, delete, login)..." class="w-full pl-9 pr-4 py-2 text-xs bg-white border border-[#E5E5E5] focus:outline-none focus:border-[#8B1E24]">
                <svg class="w-4 h-4 text-[#6B6B6B] absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#1F1F1F] hover:bg-black transition-colors">
                Filter
            </button>

            @if(request()->hasAny(['action', 'user_id']))
                <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 text-xs font-semibold text-[#6B6B6B] border border-[#E5E5E5] hover:border-[#1F1F1F] transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-white border border-[#E5E5E5] overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-white border-b border-[#E5E5E5] text-[#1F1F1F] uppercase font-bold tracking-wider">
                <tr>
                    <th class="py-3 px-4">Waktu</th>
                    <th class="py-3 px-4">Pengguna</th>
                    <th class="py-3 px-4">Tindakan / Aksi</th>
                    <th class="py-3 px-4">Keterangan Aktivitas</th>
                    <th class="py-3 px-4">Alamat IP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E5E5E5] font-mono text-[11px]">
                @forelse($logs as $log)
                    <tr class="hover:bg-neutral-50/50">
                        <td class="py-3 px-4 whitespace-nowrap text-[#6B6B6B] font-sans">
                            {{ $log->created_at->format('d M Y, H:i:s') }}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap font-sans font-medium text-[#1F1F1F]">
                            {{ $log->user->name ?? 'Sistem / Tamu' }}
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <span class="inline-block px-2 py-0.5 border border-[#E5E5E5] text-[#8B1E24] bg-white uppercase font-bold text-[10px]">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-sans text-xs text-[#1F1F1F]">
                            {{ $log->description }}
                        </td>
                        <td class="py-3 px-4 text-[#6B6B6B]">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-[#6B6B6B] font-sans text-xs">
                            Belum ada rekam log aktivitas tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $logs->links() }}
    </div>
</div>
@endsection
