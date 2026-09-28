@extends('layouts.app')

@section('content')
<div class="py-10 px-4 max-w-7xl mx-auto space-y-8">

    <div class="bg-gradient-to-r from-rose-100 via-pink-100 to-rose-200 rounded-3xl p-8 border border-rose-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <img src="{{ $user->avatar }}" class="w-14 h-14 rounded-full border-2 border-rose-300 shadow-xs" alt="Avatar">
            <div>
                <span class="igari-pill">Client Member</span>
                <h1 class="font-serif-editorial text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Welcome, {{ $user->name }}</h1>
                <p class="text-xs text-gray-600 mt-0.5">{{ $user->email }} &bull; {{ $user->phone ?? 'No phone recorded' }}</p>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('user.rentals') }}" class="btn-igari-primary text-xs px-5 py-2.5 rounded-full font-bold shadow-xs">
                Reservations History
            </a>
            <a href="{{ route('user.wishlists') }}" class="btn-igari-secondary text-xs px-5 py-2.5 rounded-full font-bold">
                Saved Wishlist ({{ $wishlistsCount }})
            </a>
        </div>
    </div>

    <div class="space-y-4">
        <h2 class="font-serif-editorial text-2xl font-bold text-gray-900">
            Active Reservations Status
        </h2>

        @if($activeRentals->isEmpty())
            <div class="bg-white p-8 rounded-3xl border border-rose-100 text-center space-y-3 shadow-xs">
                <p class="text-xs text-gray-500">You currently have no active gown reservations.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block btn-igari-primary text-xs px-5 py-2.5 rounded-full font-bold">
                    Explore Collection Archive &rarr;
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($activeRentals as $rental)
                    <div class="bg-white p-6 rounded-3xl border border-rose-200 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-rose-50 pb-3">
                            <span class="font-mono text-xs font-bold text-gray-700">#{{ $rental->rental_code }}</span>
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold border {{ $rental->status_badge_class }}">
                                {{ $rental->status_label }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4">
                            <img src="{{ $rental->dress->image_url }}" class="w-16 h-20 object-cover rounded-2xl border border-rose-200" alt="Dress">
                            <div class="space-y-1">
                                <h3 class="font-serif-editorial font-bold text-gray-900 text-base">{{ $rental->dress->name }}</h3>
                                <p class="text-xs text-rose-700 font-bold">Size: {{ $rental->dress->size }}</p>
                                <p class="text-[11px] text-gray-500">Dates: {{ $rental->start_date->format('d M') }} &ndash; {{ $rental->end_date->format('d M Y') }} ({{ $rental->total_days }} Days)</p>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-rose-50 flex items-center justify-between text-xs">
                            <span class="font-bold text-rose-700 text-sm">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                            <a href="{{ route('rental.invoice', $rental->rental_code) }}" class="btn-igari-secondary text-xs px-4 py-2 rounded-full font-bold">
                                View Voucher Invoice
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-white p-8 rounded-3xl border border-rose-100 shadow-xs space-y-4 max-w-2xl">
        <h3 class="font-serif-editorial font-bold text-gray-900 text-xl">Account Profile & Address</h3>
        
        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/20 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Phone / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/20 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Default Shipping Address</label>
                <textarea name="address" rows="2" class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/20 outline-none">{{ old('address', $user->address) }}</textarea>
            </div>

            <button type="submit" class="btn-igari-primary text-xs px-6 py-2.5 rounded-full font-bold">
                Update Account Details
            </button>
        </form>
    </div>

</div>
@endsection
