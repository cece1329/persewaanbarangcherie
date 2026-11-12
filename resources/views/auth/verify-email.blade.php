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
            <div class="relative flex justify-center text-[10px] uppercase font-bold text-gray-400 bg-white px-2">atau verifikasi via link</div>
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

