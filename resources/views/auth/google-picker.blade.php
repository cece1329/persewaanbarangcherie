@extends('layouts.app')

@section('content')
<div class="py-12 px-4 max-w-md mx-auto">
    <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-xl relative overflow-hidden space-y-6">
        
        <!-- Google Header -->
        <div class="text-center space-y-2">
            <div class="w-12 h-12 mx-auto flex items-center justify-center bg-white rounded-full shadow-xs border border-gray-100 p-2">
                <svg class="w-8 h-8" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-gray-900">Login dengan Google</h1>
            <p class="text-xs text-gray-500">Pilih atau masukkan akun Google untuk masuk ke <strong class="text-rose-700">ChérieRent Atelier</strong></p>
        </div>

        <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-200 text-xs text-emerald-800 flex items-start gap-2">
            <span class="text-sm">✨</span>
            <div>
                <strong class="block font-bold">Email Langsung Terverifikasi Otomatis</strong>
                <span class="text-[11px] text-emerald-700">Masuk dengan akun Google tidak memerlukan kode OTP email atau cek folder spam.</span>
            </div>
        </div>

        <!-- Quick One-Click Google Accounts -->
        <div class="space-y-2">
            <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400 block px-1">Pilih Akun Tersedia:</span>

            <!-- Sample Account 1 -->
            <form action="{{ route('auth.google.quick') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="citra.arifera@gmail.com">
                <input type="hidden" name="name" value="Citra Arifera">
                <button type="submit" class="w-full p-3 rounded-2xl border border-gray-200 hover:border-rose-400 hover:bg-rose-50/30 transition flex items-center justify-between text-left group">
                    <div class="flex items-center gap-3">
                        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=citra.arifera@gmail.com" class="w-10 h-10 rounded-full border border-rose-200" alt="Avatar">
                        <div>
                            <strong class="text-xs font-bold text-gray-900 block group-hover:text-rose-700">Citra Arifera</strong>
                            <span class="text-[11px] text-gray-500 font-mono">citra.arifera@gmail.com</span>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-rose-600 font-bold">&rarr;</span>
                </button>
            </form>

            <!-- Sample Account 2 -->
            <form action="{{ route('auth.google.quick') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="rentcherie@gmail.com">
                <input type="hidden" name="name" value="Chérie Atelier">
                <button type="submit" class="w-full p-3 rounded-2xl border border-gray-200 hover:border-rose-400 hover:bg-rose-50/30 transition flex items-center justify-between text-left group">
                    <div class="flex items-center gap-3">
                        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=rentcherie@gmail.com" class="w-10 h-10 rounded-full border border-rose-200" alt="Avatar">
                        <div>
                            <strong class="text-xs font-bold text-gray-900 block group-hover:text-rose-700">Chérie Atelier Client</strong>
                            <span class="text-[11px] text-gray-500 font-mono">rentcherie@gmail.com</span>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 group-hover:text-rose-600 font-bold">&rarr;</span>
                </button>
            </form>
        </div>

        <div class="relative">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
            <div class="relative flex justify-center text-[10px] uppercase font-bold text-gray-400 bg-white px-2">atau gunakan akun google lain</div>
        </div>

        <!-- Custom Google Email Input Form -->
        <form action="{{ route('auth.google.quick') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" placeholder="Nama Anda" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs outline-none focus:border-rose-500 bg-gray-50/50">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Alamat Email Google (@gmail.com)</label>
                <input type="email" name="email" required placeholder="nama@gmail.com" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-xs outline-none focus:border-rose-500 bg-gray-50/50">
            </div>
            <button type="submit" class="w-full btn-igari-primary py-3 rounded-xl text-xs font-bold shadow-md flex items-center justify-center gap-2">
                <span>Lanjutkan dengan Akun Google Ini</span>
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="{{ route('login') }}" class="text-xs text-gray-500 hover:text-gray-800 font-semibold">
                &larr; Kembali ke Form Login Biasa
            </a>
        </div>

    </div>
</div>
@endsection

