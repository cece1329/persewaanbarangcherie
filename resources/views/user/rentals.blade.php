@extends('layouts.app')

@section('content')
<div class="py-10 px-4 max-w-7xl mx-auto space-y-8" x-data="{ reviewModalOpen: false, selectedRental: null }">

    <div class="border-b border-rose-200 pb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <span class="igari-pill">Client Record</span>
            <h1 class="font-serif-editorial text-3xl font-bold text-gray-900 mt-1">My Reservations History</h1>
        </div>

        <div class="flex flex-wrap gap-2 text-xs font-semibold">
            <a href="{{ route('user.rentals') }}" class="px-3.5 py-1.5 rounded-full {{ !request('status') ? 'bg-rose-700 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">All</a>
            <a href="{{ route('user.rentals', ['status' => 'pending_payment']) }}" class="px-3.5 py-1.5 rounded-full {{ request('status') == 'pending_payment' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">Pending</a>
            <a href="{{ route('user.rentals', ['status' => 'paid']) }}" class="px-3.5 py-1.5 rounded-full {{ request('status') == 'paid' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-800 hover:bg-rose-100' }}">Reserved</a>
            <a href="{{ route('user.rentals', ['status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-full {{ request('status') == 'completed' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">Completed</a>
        </div>
    </div>

    @if($rentals->isEmpty())
        <div class="bg-white p-12 rounded-3xl border border-rose-100 text-center space-y-4">
            <h3 class="font-serif-editorial font-bold text-xl text-gray-800">No Reservations Found</h3>
            <p class="text-xs text-gray-500 max-w-sm mx-auto">Explore our collection archive to reserve your first haute couture gown.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block btn-igari-primary text-xs px-6 py-2.5 rounded-full font-bold">Explore Archive</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($rentals as $rental)
                <div class="bg-white p-6 rounded-3xl border border-rose-100 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
                    
                    <div class="flex items-center gap-4">
                        <img src="{{ $rental->dress->image_url }}" class="w-16 h-20 object-cover rounded-2xl border border-rose-200" alt="Dress">
                        <div class="space-y-1">
                            <span class="font-mono text-[10px] font-bold text-gray-400">#{{ $rental->rental_code }}</span>
                            <h3 class="font-serif-editorial font-bold text-gray-900 text-base">{{ $rental->dress->name }}</h3>
                            <p class="text-xs text-gray-500">Period: <strong>{{ $rental->start_date->format('d/m/Y') }}</strong> to <strong>{{ $rental->end_date->format('d/m/Y') }}</strong> ({{ $rental->total_days }} Days)</p>
                            <p class="text-xs font-bold text-rose-700">Total Amount: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $rental->status_badge_class }}">
                            {{ $rental->status_label }}
                        </span>

                        <div class="flex gap-2">
                            <a href="{{ route('rental.invoice', $rental->rental_code) }}" class="btn-igari-secondary text-xs px-4 py-2 rounded-full font-bold">
                                View Invoice Voucher
                            </a>

                            @if($rental->status === 'completed' && !$rental->review)
                                <button @click="selectedRental = {{ $rental->id }}; reviewModalOpen = true" class="btn-igari-primary text-xs px-4 py-2 rounded-full font-bold">
                                    Submit Review
                                </button>
                            @elseif($rental->review)
                                <span class="text-xs text-emerald-700 font-bold bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200">Review Submitted</span>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $rentals->links() }}
        </div>
    @endif

    <!-- Review Modal -->
    <div x-show="reviewModalOpen" x-transition class="fixed inset-0 bg-black/50 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full border-2 border-rose-300 shadow-2xl space-y-4">
            <div class="flex justify-between items-center border-b border-rose-100 pb-3">
                <h3 class="font-serif-editorial font-bold text-xl text-gray-900">Submit Gown Review</h3>
                <button @click="reviewModalOpen = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>

            <form action="{{ route('user.review.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="rental_id" :value="selectedRental">

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Star Rating</label>
                    <select name="rating" required class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 font-bold text-amber-600">
                        <option value="5">5 Stars - Exceptional Craftsmanship & Fit</option>
                        <option value="4">4 Stars - Excellent Gown</option>
                        <option value="3">3 Stars - Satisfactory</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Your Feedback & Experience</label>
                    <textarea name="comment" rows="4" required placeholder="Describe your experience regarding fit, fabric feel, and photography experience..." class="w-full p-3 rounded-2xl border border-rose-200 text-xs bg-rose-50/20 outline-none"></textarea>
                </div>

                <button type="submit" class="w-full btn-igari-primary py-3.5 rounded-full font-bold text-xs uppercase tracking-wider shadow-md">
                    Submit Client Review
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
