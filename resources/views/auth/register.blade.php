@extends('layouts.app')

@section('content')
<div class="py-16 px-4 max-w-md mx-auto">
    <div class="bg-white rounded-3xl p-8 border border-rose-200 shadow-xl relative overflow-hidden">
        <div class="text-center mb-8">
            <h1 class="font-serif-editorial text-3xl font-bold text-gray-900">Create Client Account</h1>
            <p class="text-xs text-gray-500 mt-1">Join ChérieRent to reserve haute couture & vintage gowns.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
                @error('name') <span class="text-xs text-rose-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
                @error('email') <span class="text-xs text-rose-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Phone / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+62 812-xxxx-xxxx" class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
                @error('phone') <span class="text-xs text-rose-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Default Delivery Address (Optional)</label>
                <textarea name="address" rows="2" placeholder="Street Name, City, Postal Code" class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">{{ old('address') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
                @error('password') <span class="text-xs text-rose-600 font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-rose-200 focus:border-rose-500 focus:ring-2 focus:ring-rose-100 outline-none text-xs bg-rose-50/20 transition">
            </div>

            <button type="submit" class="w-full btn-igari-primary py-3.5 rounded-2xl text-xs font-bold uppercase tracking-wider shadow-md">
                Register Account
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-6">
            Already registered? <a href="{{ route('login') }}" class="text-rose-700 font-bold hover:underline">Sign In</a>
        </p>
    </div>
</div>
@endsection
