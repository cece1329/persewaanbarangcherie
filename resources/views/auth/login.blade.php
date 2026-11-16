@extends('layouts.app')

@section('content')
<div class="py-16 px-4 max-w-md mx-auto">
    <div class="bg-white rounded-3xl p-8 border border-rose-200 shadow-xl relative overflow-hidden">
        <div class="text-center mb-6">
            <h1 class="font-serif-editorial text-3xl font-bold text-gray-900">Masuk ke ChérieRent</h1>
            <p class="text-xs text-gray-500 mt-1">Akses portal pelanggan &amp; riwayat reservasi gaunmu.</p>
        </div>

        <!-- Login dengan Google -->
        <div class="mb-6">
            <a href="{{ route('auth.google') }}" class="w-full py-3.5 px-4 rounded-2xl border-2 border-gray-200 hover:border-rose-400 bg-white hover:bg-rose-50/30 text-gray-800 font-bold text-xs flex items-center justify-center gap-3 shadow-xs hover:shadow-md transition">
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                <span>Masuk dengan Google</span>
            </a>
        </div>

        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-rose-100"></div></div>
            <div class="relative flex justify-center text-[10px] uppercase font-bold text-gray-400 bg-white px-3">
                atau masuk dengan email biasa
            </div>
        </div>

        <!-- OPSI 2: FORM EMAIL & PASSWORD BIASA -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
                @error('email') <span class="text-xs text-rose-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <div x-data="{ showPassword: false }">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Kata Sandi</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" required class="w-full px-4 py-3 pr-11 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-rose-600 transition focus:outline-none" aria-label="Toggle password visibility">
                        <!-- Eye open icon (show password) -->
                        <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Eye slash icon (hide password) -->
                        <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password') <span class="text-xs text-rose-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                    <input type="checkbox" name="remember" class="rounded text-rose-600 focus:ring-rose-400">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" class="w-full btn-igari-primary py-3.5 rounded-2xl text-xs font-bold uppercase tracking-wider shadow-md">
                Masuk Sekarang
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-6">
            Belum memiliki akun? <a href="{{ route('register') }}" class="text-rose-700 font-bold hover:underline">Daftar Akun Baru</a>
        </p>
    </div>
</div>
@endsection
