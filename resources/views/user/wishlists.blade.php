@extends('layouts.app')

@section('content')
<div class="py-10 px-4 max-w-7xl mx-auto space-y-8">

    <div class="border-b border-rose-200 pb-4">
        <span class="igari-pill">Saved Pieces</span>
        <h1 class="font-serif-editorial text-3xl font-bold text-gray-900 mt-1">My Saved Wishlist</h1>
    </div>

    @if($wishlists->isEmpty())
        <div class="bg-white p-12 rounded-3xl border border-rose-100 text-center space-y-4">
            <h3 class="font-serif-editorial font-bold text-xl text-gray-800">Your Wishlist is Empty</h3>
            <p class="text-xs text-gray-500 max-w-sm mx-auto">Explore our gown archive and save your favorite silhouettes for future reservations.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block btn-igari-primary text-xs px-6 py-2.5 rounded-full font-bold">Explore Gown Archive</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $item)
                <div class="bg-white rounded-3xl overflow-hidden border border-rose-100 shadow-xs igari-card-hover flex flex-col relative">
                    
                    <form action="{{ route('catalog.wishlist', $item->dress->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                        @csrf
                        <button type="submit" class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-rose-600 shadow-xs hover:scale-110 transition" title="Remove Wishlist">
                            &times;
                        </button>
                    </form>

                    <a href="{{ route('catalog.show', $item->dress->slug) }}" class="relative aspect-[4/5] bg-pink-50 block overflow-hidden">
                        <img src="{{ $item->dress->image_url }}" class="w-full h-full object-cover" alt="Dress">
                    </a>

                    <div class="p-4 flex-1 flex flex-col justify-between space-y-2">
                        <div>
                            <span class="text-[10px] text-rose-700 font-bold bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">{{ $item->dress->category->name ?? 'Coquette' }}</span>
                            <h3 class="font-serif-editorial font-bold text-gray-900 text-base mt-1 truncate">
                                <a href="{{ route('catalog.show', $item->dress->slug) }}">{{ $item->dress->name }}</a>
                            </h3>
                        </div>

                        <div class="pt-2 border-t border-rose-50 flex items-center justify-between">
                            <span class="font-bold text-rose-700 text-sm">{{ $item->dress->formatted_price }}</span>
                            <a href="{{ route('catalog.show', $item->dress->slug) }}" class="btn-igari-primary text-[10px] px-3 py-1.5 rounded-full font-bold">
                                Reserve
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
