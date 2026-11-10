@extends('layouts.app')

@section('content')
<div class="py-16 px-4 max-w-md mx-auto">
    <div class="bg-white rounded-3xl p-8 border border-rose-200 shadow-xl relative overflow-hidden">
        <div class="text-center mb-8">
            <h1 class="font-serif-editorial text-3xl font-bold text-gray-900">Sign In to ChérieRent</h1>
            <p class="text-xs text-gray-500 mt-1">Access your client portal & reservation archive.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
                @error('email') <span class="text-xs text-rose-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <div x-data="{ showPassword: false }">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Password</label>
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
                    <span>Remember Me</span>
                </label>
            </div>

            <button type="submit" class="w-full btn-igari-primary py-3.5 rounded-2xl text-xs font-bold uppercase tracking-wider shadow-md">
                Sign In
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-6">
            Don't have an account? <a href="{{ route('register') }}" class="text-rose-700 font-bold hover:underline">Create Account</a>
        </p>
    </div>
</div>
@endsection
