@extends('layouts.app')

@section('content')
<div class="py-16 px-4 max-w-md mx-auto">
    <div class="bg-white rounded-3xl p-8 border border-rose-200 shadow-xl relative overflow-hidden text-center">

        {{-- Decorative Icon --}}
        <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-rose-50 border border-rose-200 flex items-center justify-center text-3xl shadow-xs">
            💌
        </div>

        <h1 class="font-serif-editorial text-2xl font-bold text-gray-900">Verifikasi Alamat Email</h1>
        <p class="text-xs text-gray-500 mt-2 leading-relaxed">
            Terima kasih telah bergabung di <strong>ChérieRent Atelier</strong>! Silakan verifikasi email kamu untuk mengaktifkan akun dan mulai menyewa gaun impianmu.
        </p>

        {{-- Email Target Info Box --}}
        <div class="my-5 p-3.5 bg-rose-50/50 border border-rose-200/80 rounded-2xl text-xs text-rose-900">
            <span class="block text-[10px] uppercase font-bold tracking-wider text-rose-500 mb-0.5">Tautan Verifikasi Dikirim Ke:</span>
            <span class="font-bold font-mono text-xs break-all">{{ Auth::user()->email ?? 'Email kamu' }}</span>
        </div>

        {{-- Success / Status Alert --}}
        @if (session('status'))
            <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium">
                {{ session('status') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-5 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium">
                {{ session('warning') }}
            </div>
        @endif

        <p class="text-[11px] text-gray-500 mb-6 leading-relaxed">
            Belum menerima email? Periksa folder <strong>Spam / Promosi</strong> di emailmu atau klik tombol di bawah untuk mengirim ulang tautan verifikasi baru.
        </p>

        {{-- Refresh Reminder Button --}}
        <div class="mb-4">
            <button type="button" onclick="window.location.reload()" class="w-full py-3 rounded-2xl border-2 border-rose-300 text-rose-700 bg-rose-50/60 hover:bg-rose-100 font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 shadow-xs">
                <span>🔄</span>
                <span>Sudah Verifikasi di Email? Refresh Halaman Ini</span>
            </button>
        </div>

        {{-- Resend Verification Form --}}
        <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
            @csrf
            <button type="submit" class="w-full btn-igari-secondary py-3 rounded-2xl text-xs font-bold uppercase tracking-wider">
                Kirim Ulang Email Verifikasi ✉️
            </button>
        </form>

        {{-- Sign Out / Change Account --}}
        <div class="mt-6 pt-4 border-t border-rose-100 flex items-center justify-between text-xs">
            <span class="text-gray-400 text-[11px]">Salah alamat email?</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold transition">
                    Keluar / Ganti Akun &rarr;
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

