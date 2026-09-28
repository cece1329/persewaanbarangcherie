@extends('layouts.app')

@section('content')
<div class="py-10 px-4 max-w-7xl mx-auto space-y-8">

    <!-- Page Header Title -->
    <div class="bg-gradient-to-r from-rose-100 via-pink-100 to-rose-200 rounded-3xl p-8 border border-rose-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <span class="igari-pill">Full Archive</span>
            <h1 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-gray-900 mt-2">Gown Collection Archive</h1>
            <p class="text-xs text-gray-600 mt-1">Explore available silhouettes, vintage laces, and haute couture pieces.</p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('catalog.index') }}" method="GET" class="w-full md:w-80 flex items-center bg-white rounded-full p-1.5 border border-rose-300 shadow-xs">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search gowns, fabrics, or colors..." class="w-full px-4 py-2 text-xs outline-none bg-transparent text-gray-800">
            <button type="submit" class="btn-igari-primary p-2.5 rounded-full text-xs shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Filter Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-rose-100 shadow-xs space-y-6">
                <div class="flex items-center justify-between border-b border-rose-50 pb-4">
                    <h3 class="font-serif-editorial font-bold text-gray-900 text-base">Filters</h3>
                    @if(request()->hasAny(['category', 'size', 'sort', 'q']))
                        <a href="{{ route('catalog.index') }}" class="text-xs text-rose-600 hover:underline font-semibold">Reset All</a>
                    @endif
                </div>

                <form action="{{ route('catalog.index') }}" method="GET" class="space-y-6">
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Categories</label>
                        <div class="space-y-2 text-xs">
                            <label class="flex items-center justify-between cursor-pointer p-2 rounded-xl hover:bg-rose-50 {{ !request('category') ? 'bg-rose-50 font-bold text-rose-700' : 'text-gray-600' }}">
                                <span class="flex items-center gap-2">
                                    <input type="radio" name="category" value="" onchange="this.form.submit()" {{ !request('category') ? 'checked' : '' }} class="text-rose-600">
                                    <span>All Categories</span>
                                </span>
                            </label>
                            @foreach($categories as $cat)
                                <label class="flex items-center justify-between cursor-pointer p-2 rounded-xl hover:bg-rose-50 {{ request('category') == $cat->slug ? 'bg-rose-50 font-bold text-rose-700' : 'text-gray-600' }}">
                                    <span class="flex items-center gap-2">
                                        <input type="radio" name="category" value="{{ $cat->slug }}" onchange="this.form.submit()" {{ request('category') == $cat->slug ? 'checked' : '' }} class="text-rose-600">
                                        <span>{{ $cat->name }}</span>
                                    </span>
                                    <span class="text-[10px] bg-rose-100 text-rose-700 font-bold px-2 py-0.5 rounded-full">{{ $cat->dresses_count }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Size Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Sizing</label>
                        <div class="grid grid-cols-3 gap-2">
                            @foreach(['XS', 'S', 'M', 'L', 'XL', 'Free Size'] as $sz)
                                <button type="submit" name="size" value="{{ request('size') == $sz ? '' : $sz }}" class="py-2 text-xs font-semibold rounded-xl border transition {{ request('size') == $sz ? 'bg-rose-700 text-white border-rose-700' : 'border-rose-200 text-gray-700 hover:bg-rose-50' }}">
                                    {{ $sz }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sorting Filter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Sort Order</label>
                        <select name="sort" onchange="this.form.submit()" class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 outline-none text-gray-700 font-medium">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Client Rating</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Dress Grid -->
        <div class="lg:col-span-3 space-y-6">
            @if($dresses->isEmpty())
                <div class="bg-white p-12 rounded-3xl border border-rose-100 text-center space-y-4">
                    <h3 class="font-serif-editorial font-bold text-xl text-gray-800">No Gowns Found</h3>
                    <p class="text-xs text-gray-500 max-w-md mx-auto">No archive pieces match your current filter selection. Try adjusting your search parameters.</p>
                    <a href="{{ route('catalog.index') }}" class="inline-block btn-igari-primary text-xs px-6 py-2.5 rounded-full font-bold">Reset Filters</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($dresses as $dress)
                        <div class="bg-white rounded-3xl overflow-hidden border border-rose-100 shadow-xs igari-card-hover flex flex-col relative group">
                            
                            <form action="{{ route('catalog.wishlist', $dress->id) }}" method="POST" class="absolute top-4 right-4 z-20">
                                @csrf
                                <button type="submit" class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-rose-600 shadow-xs hover:scale-110 transition" title="Save to Wishlist">
                                    @if(in_array($dress->id, $userWishlists))
                                        <svg class="w-4 h-4 text-rose-600 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                    @else
                                        <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    @endif
                                </button>
                            </form>

                            <a href="{{ route('catalog.show', $dress->slug) }}" class="relative aspect-[4/5] bg-pink-50 overflow-hidden block">
                                <img src="{{ $dress->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $dress->name }}">
                                
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold text-rose-700 border border-rose-200">
                                    {{ $dress->category->name ?? 'Coquette' }}
                                </div>

                                <div class="absolute bottom-3 left-3 bg-black/60 text-white backdrop-blur px-2.5 py-1 rounded-full text-[10px] font-bold">
                                    Size {{ $dress->size }}
                                </div>
                            </a>

                            <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-center gap-1 text-gray-500 text-xs mb-1">
                                        <span class="text-amber-500 font-bold">★ {{ number_format($dress->rating, 1) }}</span>
                                        <span>({{ rand(4, 25) }})</span>
                                    </div>
                                    <h3 class="font-serif-editorial font-bold text-gray-900 text-lg hover:text-rose-600 transition">
                                        <a href="{{ route('catalog.show', $dress->slug) }}">{{ $dress->name }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $dress->fabric }}</p>
                                </div>

                                <div class="pt-3 border-t border-rose-50 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] text-gray-400 block uppercase font-bold">Daily Rate</span>
                                        <span class="font-bold text-rose-700 text-base">{{ $dress->formatted_price }}</span>
                                    </div>
                                    <a href="{{ route('catalog.show', $dress->slug) }}" class="btn-igari-primary text-xs px-3.5 py-2 rounded-full font-bold">
                                        View Piece
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="pt-6">
                    {{ $dresses->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
