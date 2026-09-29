@extends('layouts.app')

@section('content')
<div class="py-10 px-4 max-w-7xl mx-auto space-y-12" x-data="dressCalculator({{ $dress->rental_price_per_day }}, {{ $dress->deposit_fee }})">

    <nav class="flex items-center gap-2 text-xs font-medium text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-rose-600">Home</a>
        <span>/</span>
        <a href="{{ route('catalog.index') }}" class="hover:text-rose-600">Gown Archive</a>
        <span>/</span>
        <span class="text-rose-700 font-bold truncate max-w-xs">{{ $dress->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        
        <!-- Left: Image Showcase -->
        <div class="space-y-4">
            <div class="relative aspect-[4/5] rounded-3xl overflow-hidden bg-pink-50 border border-rose-200 shadow-xl">
                <img src="{{ $dress->image_url }}" class="w-full h-full object-cover" alt="{{ $dress->name }}">
                
                <div class="absolute top-4 left-4 igari-pill shadow-md">
                    {{ $dress->category->name ?? 'Coquette Exclusive' }}
                </div>

                <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-4 py-1.5 rounded-full text-xs font-bold text-gray-800 shadow-xs">
                    Client Rating ★ {{ number_format($dress->rating, 1) }}
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 text-center">
                <div class="bg-white p-3 rounded-2xl border border-rose-100 shadow-xs">
                    <span class="text-[10px] text-gray-500 uppercase font-bold block">Sanitation</span>
                    <span class="text-xs text-gray-800 font-semibold">Clean Dry Cared</span>
                </div>
                <div class="bg-white p-3 rounded-2xl border border-rose-100 shadow-xs">
                    <span class="text-[10px] text-gray-500 uppercase font-bold block">Garment Care</span>
                    <span class="text-xs text-gray-800 font-semibold">Storage Bag Incl.</span>
                </div>
                <div class="bg-white p-3 rounded-2xl border border-rose-100 shadow-xs">
                    <span class="text-[10px] text-gray-500 uppercase font-bold block">Packaging</span>
                    <span class="text-xs text-gray-800 font-semibold">Sterile Boxed</span>
                </div>
            </div>
        </div>

        <!-- Right: Information & Reservation Calculator -->
        <div class="space-y-6">
            
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2" x-data>
                        <span class="text-xs font-bold bg-rose-50 text-rose-700 px-3 py-1 rounded-full border border-rose-200">Size {{ $dress->size }}</span>
                        <button type="button" @click="$dispatch('open-fitting-guide')" class="text-[11px] font-bold text-rose-700 hover:text-rose-900 underline">
                            📏 Fitting Chart &amp; Policy
                        </button>
                    </div>
                    <form action="{{ route('catalog.wishlist', $dress->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-1 text-xs text-rose-700 font-semibold bg-rose-50 px-3.5 py-1.5 rounded-full border border-rose-200 hover:bg-rose-100 transition">
                            <span>{{ $isWishlisted ? 'Saved to Wishlist' : 'Add to Wishlist' }}</span>
                        </button>
                    </form>
                </div>

                <h1 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">
                    {{ $dress->name }}
                </h1>
                
                <div class="mt-3 flex items-baseline gap-3">
                    <span class="text-3xl font-bold text-rose-700 font-serif-editorial">{{ $dress->formatted_price }}</span>
                    <span class="text-xs text-gray-500 font-medium">/ daily rate</span>
                    <span class="text-xs bg-amber-50 text-amber-800 px-2.5 py-1 rounded-full font-bold ml-auto border border-amber-200">
                        Refundable Deposit {{ $dress->formatted_deposit }}
                    </span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-rose-100 shadow-xs space-y-2">
                <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Garment Description & Details:</h4>
                <p class="text-xs text-gray-600 leading-relaxed">{{ $dress->description }}</p>
            </div>

            <div class="bg-rose-50/40 p-5 rounded-2xl border border-rose-200 space-y-3">
                <h4 class="text-xs font-bold text-rose-900 uppercase tracking-wider">Specifications & Fabric:</h4>
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div><span class="text-gray-500">Fabric Composition:</span> <strong class="text-gray-800 block">{{ $dress->fabric ?? '-' }}</strong></div>
                    <div><span class="text-gray-500">Color Shade:</span> <strong class="text-gray-800 block">{{ $dress->color ?? '-' }}</strong></div>
                    <div><span class="text-gray-500">Bust Dimensions:</span> <strong class="text-gray-800 block">{{ $dress->chest_size ?? '-' }}</strong></div>
                    <div><span class="text-gray-500">Waist Dimensions:</span> <strong class="text-gray-800 block">{{ $dress->waist_size ?? '-' }}</strong></div>
                    <div><span class="text-gray-500">Garment Length:</span> <strong class="text-gray-800 block">{{ $dress->length ?? '-' }}</strong></div>
                    <div><span class="text-gray-500">Atelier Availability:</span> <strong class="text-emerald-700 block font-bold">{{ $dress->stock }} Unit</strong></div>
                </div>
            </div>

            <!-- Dynamic Rental Calculator & Form -->
            <div class="bg-white p-6 rounded-3xl border-2 border-rose-300 shadow-lg space-y-4">
                <h3 class="font-serif-editorial font-bold text-gray-900 text-xl">
                    Reserve & Schedule Rental
                </h3>

                <form action="{{ route('rental.checkout', $dress->id) }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Start Date</label>
                            <input type="date" name="start_date" x-model="startDate" min="{{ date('Y-m-d') }}" @change="calculateTotal()" required class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 outline-none text-gray-800 font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Return Date</label>
                            <input type="date" name="end_date" x-model="endDate" min="{{ date('Y-m-d') }}" @change="calculateTotal()" required class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 outline-none text-gray-800 font-bold">
                        </div>
                    </div>

                    <div x-show="availabilityMessage" x-transition :class="available ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : 'bg-rose-50 text-rose-800 border-rose-300'" class="p-3 rounded-xl border text-xs font-medium">
                        <span x-text="availabilityMessage"></span>
                    </div>

                    <div class="bg-rose-50/60 p-4 rounded-2xl space-y-2 text-xs">
                        <div class="flex justify-between text-gray-600">
                            <span>Duration:</span>
                            <span class="font-bold text-gray-800" x-text="totalDays + ' Days'"></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Rental Subtotal (<span x-text="totalDays"></span> x {{ $dress->formatted_price }}):</span>
                            <span class="font-bold text-gray-800" x-text="formatRupiah(rentalSubtotal)"></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Security Deposit (Refundable):</span>
                            <span class="font-bold text-amber-800" x-text="formatRupiah(depositFee)"></span>
                        </div>
                        <div class="border-t border-rose-200 pt-2 flex justify-between text-sm font-bold text-rose-700">
                            <span>Estimated Total Amount:</span>
                            <span x-text="formatRupiah(grandTotal)"></span>
                        </div>
                    </div>

                    <button type="submit" :disabled="!available" class="w-full btn-igari-primary py-4 rounded-full font-bold text-xs uppercase tracking-wider shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                        Proceed to Reservation
                    </button>
                </form>
            </div>

        </div>

    </div>

    <!-- REVIEWS SECTION -->
    <div class="bg-white p-8 rounded-3xl border border-rose-100 shadow-xs space-y-6">
        <div class="flex items-center justify-between border-b border-rose-50 pb-4">
            <h3 class="font-serif-editorial font-bold text-gray-900 text-2xl">Client Reviews ({{ $dress->reviews->count() }})</h3>
            <div class="flex items-center gap-1 text-amber-500 font-bold text-sm">
                <span>★ {{ number_format($dress->rating, 1) }} out of 5.0</span>
            </div>
        </div>

        @if($dress->reviews->isEmpty())
            <p class="text-xs text-gray-500 italic">No reviews recorded yet for this piece.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($dress->reviews as $rev)
                    <div class="bg-rose-50/30 p-4 rounded-2xl border border-rose-100 space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <img src="{{ $rev->user->avatar }}" class="w-7 h-7 rounded-full" alt="Avatar">
                                <span class="text-xs font-bold text-gray-800">{{ $rev->user->name }}</span>
                            </div>
                            <span class="text-xs text-amber-500">@for($i=0; $i<$rev->rating; $i++) ★ @endfor</span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">"{{ $rev->comment }}"</p>
                        <span class="text-[10px] text-gray-400 block">{{ $rev->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

<script>
function dressCalculator(dailyPrice, deposit) {
    const today = new Date().toISOString().split('T')[0];
    const defaultEnd = new Date(Date.now() + 2 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];

    return {
        dailyPrice: parseFloat(dailyPrice),
        depositFee: parseFloat(deposit),
        startDate: today,
        endDate: defaultEnd,
        totalDays: 3,
        rentalSubtotal: parseFloat(dailyPrice) * 3,
        grandTotal: (parseFloat(dailyPrice) * 3) + parseFloat(deposit),
        available: true,
        availabilityMessage: 'This gown is available for your selected dates.',

        init() {
            this.calculateTotal();
        },

        calculateTotal() {
            if(!this.startDate || !this.endDate) return;
            const start = new Date(this.startDate);
            const end = new Date(this.endDate);
            
            if (end < start) {
                this.available = false;
                this.availabilityMessage = 'Return date cannot precede start date.';
                return;
            }

            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            this.totalDays = Math.max(1, diffDays);

            this.rentalSubtotal = this.dailyPrice * this.totalDays;
            this.grandTotal = this.rentalSubtotal + this.depositFee;

            this.checkAvailability();
        },

        async checkAvailability() {
            try {
                const res = await fetch(`{{ route('catalog.check-availability', $dress->id) }}?start_date=${this.startDate}&end_date=${this.endDate}`);
                const data = await res.json();
                this.available = data.available;
                this.availabilityMessage = data.message;
            } catch(e) {
                console.error(e);
            }
        },

        formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
        }
    }
}
</script>
@endsection
