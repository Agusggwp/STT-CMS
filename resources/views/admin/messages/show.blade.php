@extends('layouts.admin')

@section('title', 'Detail Pesan - Admin CMS')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between pb-6 border-b border-[#E5E5E5]">
        <div>
            <a href="{{ route('admin.messages.index') }}" class="text-xs font-semibold text-[#6B6B6B] hover:text-[#8B1E24] inline-flex items-center gap-1 mb-2">
                ← Kembali ke Kotak Masuk
            </a>
            <h1 class="text-2xl font-bold tracking-tight text-[#1F1F1F]">{{ $message->subject ?? 'Pesan Masuk' }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.messages.toggle-read', $message) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-3 py-2 text-xs font-semibold text-[#1F1F1F] border border-[#E5E5E5] hover:border-[#8B1E24] bg-white">
                    {{ $message->is_read ? 'Tandai Belum Dibaca' : 'Tandai Dibaca' }}
                </button>
            </form>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-white bg-red-600 hover:bg-red-700">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-white border-l-4 border-green-600 border border-[#E5E5E5] text-sm text-[#1F1F1F]">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-6 bg-white border border-[#E5E5E5] space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-[#E5E5E5]">
            <div class="space-y-1">
                <div class="text-xs text-[#6B6B6B]">Pengirim:</div>
                <div class="text-base font-bold text-[#1F1F1F]">{{ $message->name }}</div>
                <div class="text-xs text-[#6B6B6B] flex flex-wrap gap-4 mt-1">
                    <span>Email: <a href="mailto:{{ $message->email }}" class="text-[#8B1E24] hover:underline">{{ $message->email }}</a></span>
                    @if($message->phone)
                        <span>Telepon/WA: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}" target="_blank" class="text-[#8B1E24] hover:underline">{{ $message->phone }}</a></span>
                    @endif
                </div>
            </div>
            <div class="text-xs text-[#6B6B6B] sm:text-right">
                <div>Waktu Penerimaan:</div>
                <div class="font-medium text-[#1F1F1F] mt-1">{{ $message->created_at->format('d F Y, H:i:s') }} WITA</div>
            </div>
        </div>

        <div class="space-y-2">
            <div class="text-xs font-bold text-[#1F1F1F] uppercase tracking-wider">Isi Pesan:</div>
            <div class="text-sm text-[#1F1F1F] leading-relaxed whitespace-pre-line p-4 bg-neutral-50/50 border border-[#E5E5E5]">
                {{ $message->message }}
            </div>
        </div>

        <div class="pt-4 border-t border-[#E5E5E5] flex items-center justify-between">
            <a href="mailto:{{ $message->email }}?subject=Balasan:%20{{ urlencode($message->subject ?? 'Pesan STT') }}" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#8B1E24] hover:bg-[#6e171c] inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Balas via Email
            </a>
            @if($message->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->phone) }}?text=Halo%20{{ urlencode($message->name) }},%20kami%20dari%20Sekaa%20Teruna%20Teruni%20..." target="_blank" class="px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-[#1F1F1F] border border-[#E5E5E5] hover:border-[#1F1F1F] inline-flex items-center gap-2">
                    Balas via WhatsApp
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
