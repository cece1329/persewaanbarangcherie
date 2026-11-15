@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-10 px-3 sm:px-4 max-w-7xl mx-auto space-y-6 sm:space-y-8">

    <div class="border-b border-rose-200 pb-4">
        <span class="igari-pill">Saved Pieces</span>
        <h1 class="font-serif-editorial text-2xl sm:text-3xl font-bold text-gray-900 mt-1">My Saved Wishlist</h1>
    </div>

    @if($wishlists->isEmpty())
        <div class="bg-white p-12 rounded-3xl border border-rose-100 text-center space-y-4">
            <h3 class="font-serif-editorial font-bold text-xl text-gray-800">Your Wishlist is Empty</h3>
            <p class="text-xs text-gray-500 max-w-sm mx-auto">Explore our gown archive and save your favorite silhouettes for future reservations.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block btn-igari-primary text-xs px-6 py-2.5 rounded-full font-bold">Explore Gown Archive</a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
            @foreach($wishlists as $item)
                @if($item->dress)
                <div data-wishlist-dress-id="{{ $item->dress->id }}" class="bg-white rounded-2xl sm:rounded-3xl overflow-hidden border border-rose-100 shadow-xs igari-card-hover flex flex-col relative">
                    
                    <form action="{{ route('catalog.wishlist', $item->dress->id) }}" method="POST" class="absolute top-2.5 right-2.5 sm:top-3 sm:right-3 z-10">
                        @csrf
                        <button type="submit" class="w-7 h-7 sm:w-8 sm:h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-rose-600 shadow-xs hover:scale-110 transition" title="Remove Wishlist">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>

                    <a href="{{ route('catalog.show', $item->dress->slug) }}" class="relative aspect-[4/5] bg-pink-50 block overflow-hidden">
                        <img src="{{ $item->dress->image_url }}" class="w-full h-full object-cover" alt="Dress">
                    </a>

                    <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between space-y-2">
                        <div>
                            <span class="text-[9px] sm:text-[10px] text-rose-700 font-bold bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">{{ $item->dress->category->name ?? 'Coquette' }}</span>
                            <h3 class="font-serif-editorial font-bold text-gray-900 text-sm sm:text-base mt-1 truncate">
                                <a href="{{ route('catalog.show', $item->dress->slug) }}">{{ $item->dress->name }}</a>
                            </h3>
                        </div>

                        <div class="pt-2 border-t border-rose-50 flex items-center justify-between gap-1">
                            <span class="font-bold text-rose-700 text-xs sm:text-sm truncate">{{ $item->dress->formatted_price }}</span>
                            <a href="{{ route('catalog.show', $item->dress->slug) }}" class="btn-igari-primary text-[9px] sm:text-[10px] px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full font-bold whitespace-nowrap">
                                Reserve
                            </a>
                        </div>
                    </div>

                </div>
                @endif
            @endforeach
        </div>
    @endif

</div>

<script>
    (function() {
        var pageLoadedAt = Date.now();

        function syncWishlistState() {
            try {
                var removedId = localStorage.getItem('cherie_wishlist_removed_id');
                if (removedId) {
                    var card = document.querySelector('[data-wishlist-dress-id="' + removedId + '"]');
                    if (card) {
                        card.remove();
                    }
                    localStorage.removeItem('cherie_wishlist_removed_id');
                    var remaining = document.querySelectorAll('[data-wishlist-dress-id]');
                    if (remaining.length === 0) {
                        window.location.reload();
                        return;
                    }
                }
                var lastUpdated = parseInt(localStorage.getItem('cherie_wishlist_updated') || '0', 10);
                if (lastUpdated > pageLoadedAt) {
                    window.location.reload();
                }
            } catch (e) {}
        }

        window.addEventListener('pageshow', function(event) {
            var navEntries = window.performance && window.performance.getEntriesByType ? window.performance.getEntriesByType('navigation') : null;
            var isBackForward = (navEntries && navEntries.length > 0 && navEntries[0].type === 'back_forward') 
                             || (window.performance && window.performance.navigation && window.performance.navigation.type === 2);
            
            if (event.persisted || isBackForward) {
                window.location.reload();
            } else {
                syncWishlistState();
            }
        });

        window.addEventListener('focus', syncWishlistState);
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                syncWishlistState();
            }
        });
    })();
</script>
@endsection
