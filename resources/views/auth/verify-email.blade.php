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

        <!-- Alert Bantuan Folder Spam -->
        <div class="mb-5 p-3.5 bg-amber-50/80 border border-amber-200 rounded-2xl text-left text-xs text-amber-900 space-y-1">
            <div class="flex items-center gap-1.5 font-bold text-amber-800">
                <span>⚠️</span>
                <span>Email Belum Muncul di Inbox?</span>
            </div>
            <p class="text-[11px] text-amber-700 leading-relaxed">
                Kadang email verifikasi masuk ke folder <strong>SPAM</strong>, <strong>JUNK</strong>, atau <strong>PROMOTIONS</strong>. Silakan periksa folder tersebut atau gunakan tombol alternatif di bawah:
            </p>
        </div>

        {{-- Form Input Kode 6 Angka (OTP) --}}
        <form method="POST" action="{{ route('verification.verify-code') }}" class="my-5 p-4 bg-rose-50/60 border border-rose-200 rounded-2xl text-left space-y-3">
            @csrf
            <div>
                <label class="block text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-1 text-center">
                    Masukkan 6 Angka Kode Verifikasi
                </label>
                <p class="text-[11px] text-gray-500 text-center mb-2.5">
                    Lihat 6 angka kode yang kami kirimkan ke emailmu:
                </p>
                <input type="text" name="code" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" placeholder="Contoh: 123456" required autofocus
                       value="{{ old('code') }}"
                       class="w-full text-center tracking-[8px] font-mono font-bold text-2xl py-2.5 px-4 rounded-xl border border-rose-300 focus:border-rose-500 focus:ring-2 focus:ring-rose-200 outline-none bg-white">
                @error('code')
                    <span class="block text-xs text-rose-600 font-bold text-center mt-1.5">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full btn-igari-primary py-3 rounded-xl text-xs font-bold uppercase tracking-wider shadow-md">
                Verifikasi Kode Sekarang ✨
            </button>
        </form>

        <div class="relative my-5">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-rose-100"></div></div>
            <div class="relative flex justify-center text-[10px] uppercase font-bold text-gray-400 bg-white px-2">pilihan cepat & darurat</div>
        </div>

        <!-- Tombol Verifikasi Instan jika Email Error/Spam -->
        <div class="space-y-2.5 mb-4">
            <form method="POST" action="{{ route('verification.instant') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 px-3 rounded-2xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-1.5 shadow-2xs">
                    <span>⚡</span>
                    <span>Verifikasi Langsung Akun Ini (Bypass Email / Spam)</span>
                </button>
            </form>

            <a href="{{ route('auth.google') }}" class="w-full py-2.5 px-3 rounded-2xl border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs flex items-center justify-center gap-2 shadow-2xs transition">
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>Masuk dengan Google (Email Otomatis Aktif)</span>
            </a>
        </div>

        {{-- Refresh Reminder Button --}}
        <div class="mb-4">
            <button type="button" onclick="window.location.reload()" class="w-full py-2.5 rounded-2xl border-2 border-rose-200 text-rose-700 bg-rose-50/40 hover:bg-rose-100 font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2">
                <span>🔄</span>
                <span>Sudah Klik Link di Email? Refresh Halaman</span>
            </button>
        </div>

        {{-- Resend Verification Form --}}
        <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
            @csrf
            <button type="submit" class="w-full btn-igari-secondary py-3 rounded-2xl text-xs font-bold uppercase tracking-wider">
                Kirim Ulang Email Verifikasi ✉️
            </button>
        </form>

        {{-- Sign Out / Change Account / Delete Account --}}
        <div class="mt-6 pt-4 border-t border-rose-100 flex items-center justify-between text-xs">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-gray-800 text-[11px] font-medium transition">
                    &larr; Keluar
                </button>
            </form>

            <form method="POST" action="{{ route('user.account.delete') }}" onsubmit="return confirm('Hapus akun ini agar kamu bisa mendaftar ulang dengan email {{ Auth::user()->email ?? '' }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-[11px] transition flex items-center gap-1">
                    <span>🗑️</span>
                    <span>Hapus Akun & Daftar Ulang</span>
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

