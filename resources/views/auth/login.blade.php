@extends('layouts.app')

@section('content')
<div class="py-16 px-4 max-w-md mx-auto">
    <div class="bg-white rounded-3xl p-8 border border-rose-200 shadow-xl relative overflow-hidden">
        <div class="text-center mb-8">
            <h1 class="font-serif-editorial text-3xl font-bold text-gray-900">Sign In to ChérieRent</h1>
            <p class="text-xs text-gray-500 mt-1">Access your client portal & reservation archive.</p>
        </div>

        <div class="bg-rose-50/70 border border-rose-200 rounded-2xl p-4 mb-6">
            <p class="text-[11px] font-bold text-rose-900 mb-2 text-center uppercase tracking-wider">Quick Demo Login Access:</p>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('demo.login', 'customer') }}" class="text-xs font-semibold bg-white text-rose-700 hover:bg-rose-100 py-2.5 px-3 rounded-xl border border-rose-200 text-center shadow-xs transition">
                    Client Demo
                </a>
                <a href="{{ route('demo.login', 'admin') }}" class="text-xs font-semibold bg-slate-900 text-white hover:bg-slate-800 py-2.5 px-3 rounded-xl text-center shadow-xs transition">
                    Atelier Admin
                </a>
            </div>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
                @error('email') <span class="text-xs text-rose-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
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
