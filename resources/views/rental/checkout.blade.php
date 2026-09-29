@extends('layouts.app')

@section('content')
<div class="py-10 px-4 max-w-5xl mx-auto space-y-8">
    
    <div class="border-b border-rose-200 pb-4">
        <span class="igari-pill">Step 2 of 3</span>
        <h1 class="font-serif-editorial text-3xl font-bold text-gray-900 mt-2">Reservation & Delivery Details</h1>
    </div>

    <form action="{{ route('rental.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        <input type="hidden" name="dress_id" value="{{ $dress->id }}">

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white p-4 rounded-3xl border border-rose-100 shadow-xs flex items-center gap-4">
                <img src="{{ $dress->image_url }}" class="w-20 h-24 object-cover rounded-2xl border border-rose-200" alt="Dress">
                <div class="space-y-1">
                    <span class="text-[10px] bg-rose-50 text-rose-700 font-bold px-2.5 py-0.5 rounded-full border border-rose-200">{{ $dress->category->name ?? 'Coquette' }}</span>
                    <h3 class="font-serif-editorial font-bold text-gray-900 text-lg">{{ $dress->name }}</h3>
                    <p class="text-xs text-gray-500">Size: <strong>{{ $dress->size }}</strong> | Color: <strong>{{ $dress->color }}</strong></p>
                </div>
            </div>

            <div class="bg-rose-50/50 p-5 rounded-3xl border border-rose-200 space-y-3">
                <h3 class="font-serif-editorial font-bold text-gray-900 text-lg">
                    Rental Duration Schedule
                </h3>

                <div class="grid grid-cols-2 gap-3 text-xs bg-white p-4 rounded-2xl border border-rose-100">
                    <div>
                        <span class="text-gray-400 block uppercase font-bold text-[10px]">Start Date:</span>
                        <input type="date" name="start_date" value="{{ $startDate }}" readonly class="font-bold text-gray-800 bg-transparent outline-none mt-1">
                    </div>
                    <div>
                        <span class="text-gray-400 block uppercase font-bold text-[10px]">Return Date:</span>
                        <input type="date" name="end_date" value="{{ $endDate }}" readonly class="font-bold text-gray-800 bg-transparent outline-none mt-1">
                    </div>
                </div>
            </div>

            <div x-data="{ method: 'delivery' }" class="bg-white p-6 rounded-3xl border border-rose-100 shadow-xs space-y-4">
                <h3 class="font-serif-editorial font-bold text-gray-900 text-lg">
                    Fulfillment Method
                </h3>

                <div class="grid grid-cols-2 gap-3">
                    <label class="p-4 rounded-2xl border cursor-pointer transition flex items-center gap-3" :class="method === 'delivery' ? 'bg-rose-50 border-rose-600 font-bold text-rose-900' : 'border-rose-200 text-gray-600'">
                        <input type="radio" name="shipping_method" value="delivery" x-model="method" class="text-rose-600">
                        <div>
                            <span class="block text-xs">Direct Express Delivery</span>
                            <span class="text-[10px] text-gray-400 font-normal">Courier Delivery to Your Address</span>
                        </div>
                    </label>

                    <label class="p-4 rounded-2xl border cursor-pointer transition flex items-center gap-3" :class="method === 'pickup' ? 'bg-rose-50 border-rose-600 font-bold text-rose-900' : 'border-rose-200 text-gray-600'">
                        <input type="radio" name="shipping_method" value="pickup" x-model="method" class="text-rose-600">
                        <div>
                            <span class="block text-xs">Atelier Self Pickup</span>
                            <span class="text-[10px] text-gray-400 font-normal">Chérie Atelier Jakarta Boutique</span>
                        </div>
                    </label>
                </div>

                <div x-show="method === 'delivery'" x-transition class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Delivery Address</label>
                    <textarea name="shipping_address" rows="3" required placeholder="Street Name, Building/Suite, City, Postal Code" class="w-full p-3 rounded-2xl border border-rose-200 text-xs bg-rose-50/20 outline-none focus:border-rose-500">{{ old('shipping_address', $user->address) }}</textarea>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-rose-100 shadow-xs space-y-4">
                <h3 class="font-serif-editorial font-bold text-gray-900 text-lg">
                    Payment Method
                </h3>

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <label class="p-3.5 rounded-2xl border border-rose-200 flex items-center gap-3 cursor-pointer hover:bg-rose-50">
                        <input type="radio" name="payment_method" value="qris" checked class="text-rose-600">
                        <span class="font-bold text-gray-800">QRIS Instant Payment</span>
                    </label>
                    <label class="p-3.5 rounded-2xl border border-rose-200 flex items-center gap-3 cursor-pointer hover:bg-rose-50">
                        <input type="radio" name="payment_method" value="bca" class="text-rose-600">
                        <span class="font-bold text-gray-800">Bank BCA Virtual Account</span>
                    </label>
                    <label class="p-3.5 rounded-2xl border border-rose-200 flex items-center gap-3 cursor-pointer hover:bg-rose-50">
                        <input type="radio" name="payment_method" value="mandiri" class="text-rose-600">
                        <span class="font-bold text-gray-800">Bank Mandiri Transfer</span>
                    </label>
                    <label class="p-3.5 rounded-2xl border border-rose-200 flex items-center gap-3 cursor-pointer hover:bg-rose-50">
                        <input type="radio" name="payment_method" value="shopee_pay" class="text-rose-600">
                        <span class="font-bold text-gray-800">E-Wallet (ShopeePay / DANA)</span>
                    </label>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-rose-100 shadow-xs space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Special Handling Instructions (Optional)</label>
                    <input type="text" name="notes" placeholder="Any specific notes for garment fitting or delivery timing..." class="w-full p-3 rounded-2xl border border-rose-200 text-xs bg-rose-50/20 outline-none">
                </div>

                <div class="pt-3 border-t border-rose-50">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="agree_terms" required class="mt-0.5 rounded text-rose-600 focus:ring-rose-400">
                        <span class="text-xs text-gray-600 leading-relaxed">
                            I accept the Atelier Rental Terms & Conditions (Maintaining garment condition, returning within agreed dates, and avoiding self-washing).
                        </span>
                    </label>
                </div>
            </div>

        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border-2 border-rose-300 shadow-lg space-y-4 sticky top-28">
                <h3 class="font-serif-editorial font-bold text-gray-900 text-xl border-b border-rose-100 pb-3">
                    Summary Statement
                </h3>

                <div class="space-y-3 text-xs text-gray-600">
                    <div class="flex justify-between">
                        <span>Garment Piece:</span>
                        <span class="font-semibold text-gray-800">{{ $dress->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Rental Duration:</span>
                        <span class="font-bold text-gray-800">{{ $totalDays }} Days</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Rental Rate:</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($rentalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Security Deposit:</span>
                        <span class="font-bold text-amber-800">Rp {{ number_format($depositFee, 0, ',', '.') }}</span>
                    </div>

                    <div class="border-t border-rose-200 pt-3 flex justify-between text-base font-bold text-rose-700">
                        <span>Total Payable:</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="p-3.5 bg-rose-50 rounded-2xl text-[11px] text-rose-900 leading-relaxed border border-rose-200" x-data>
                    <strong>Deposit Note:</strong> Uang deposit sebesar Rp {{ number_format($depositFee, 0, ',', '.') }} akan dikembalikan 100% setelah gaun diinspeksi. 
                    <button type="button" @click="$dispatch('open-fitting-guide')" class="font-bold underline text-rose-700 hover:text-rose-900 block mt-1">
                        📏 Lihat Panduan Fitting &amp; Syarat Ketentuan Lengkap &rarr;
                    </button>
                </div>

                <button type="submit" class="w-full btn-igari-primary py-4 rounded-full font-bold text-xs uppercase tracking-wider shadow-md text-center">
                    Proceed to Payment &rarr;
                </button>
            </div>
        </div>

    </form>
</div>
@endsection
