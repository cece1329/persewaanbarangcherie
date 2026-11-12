@extends('layouts.app')

@section('content')
<div class="py-16 px-4 max-w-md mx-auto">
    <div class="bg-white rounded-3xl p-8 border border-rose-200 shadow-xl relative overflow-hidden text-center">

        {{-- Decorative Icon --}}
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-emerald-50 border-2 border-emerald-200 flex items-center justify-center text-3xl shadow-xs">
            ✨
        </div>

        <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase tracking-widest rounded-full mb-2">
            Verifikasi Berhasil
        </span>

        <h1 class="font-serif-editorial text-2xl font-bold text-gray-900">Email Berhasil Diverifikasi!</h1>
        <p class="text-xs text-gray-500 mt-1">
            Akun ChérieRent untuk <strong>{{ $user->email ?? Auth::user()->email }}</strong> sekarang sudah aktif.
        </p>

        {{-- Instruction Box (Silakan Refresh Web) --}}
        <div class="my-6 p-4 bg-rose-50/70 border border-rose-200 rounded-2xl text-xs text-rose-950 text-center space-y-2">
            <div class="flex items-center justify-center gap-1.5 font-bold text-rose-700 text-sm">
                <span>🔄</span>
                <span>Silakan Kembali & Refresh Web Kamu</span>
            </div>
            <p class="text-[11px] text-gray-600 leading-relaxed">
                Jika kamu membuka email ini di aplikasi HP atau perangkat terpisah, silakan <strong>kembali ke layar/tab website kamu sebelumnya</strong> lalu lakukan <strong>Refresh (Muat Ulang)</strong> halaman. Akunmu akan otomatis aktif!
            </p>
        </div>

        {{-- Direct Actions (Jika ingin lanjut di tab ini) --}}
        <div class="space-y-3 pt-2">
            <a href="{{ route('dashboard') }}" class="w-full btn-igari-primary block py-3.5 rounded-2xl text-xs font-bold uppercase tracking-wider shadow-md">
                Lanjut di Sini &rarr; Buka Client Portal
            </a>
            <a href="{{ route('catalog.index') }}" class="block text-xs font-bold text-rose-600 hover:text-rose-800 transition py-1">
                Jelajahi Koleksi Gaun (Gown Archive)
            </a>
        </div>

    </div>
</div>
@endsection

