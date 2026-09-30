@extends('layouts.app')

@section('content')
<div class="py-12 px-4 max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between no-print">
        <a href="{{ route('user.rentals') }}" class="text-xs font-bold text-rose-700 hover:underline flex items-center gap-1">
            &larr; Back to Reservation History
        </a>
        <button onclick="window.print()" class="btn-igari-secondary text-xs px-4 py-2 rounded-full font-bold flex items-center gap-1 shadow-xs">
            Print Voucher Invoice
        </button>
    </div>

    <!-- Printable Invoice Voucher Card -->
    <div id="printable-area" class="bg-white p-8 sm:p-10 rounded-3xl border border-rose-200 shadow-xl space-y-8 relative overflow-hidden">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-rose-100 pb-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/web/logo.png') }}" alt="ChérieRent Logo" class="h-14 w-auto object-contain">
                <div>
                    <h1 class="font-serif-editorial text-2xl font-bold text-gray-900">ChérieRent Atelier</h1>
                    <p class="text-[9px] text-gray-500 uppercase tracking-widest font-semibold">Official Reservation Voucher</p>
                </div>
            </div>

            <div class="sm:text-right">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ $rental->status_badge_class }}">
                    {{ $rental->status_label }}
                </span>
                <p class="text-xs font-mono font-bold text-gray-800 mt-1">#{{ $rental->rental_code }}</p>
                <p class="text-[10px] text-gray-400">{{ $rental->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-rose-50/30 p-5 rounded-2xl border border-rose-100 text-xs">
            <div>
                <span class="text-gray-400 uppercase font-bold text-[10px] block">Reserved By (Client):</span>
                <strong class="text-gray-900 text-sm block mt-0.5">{{ $rental->user->name }}</strong>
                <span class="text-gray-600 block">{{ $rental->user->email }}</span>
                <span class="text-gray-600 block">{{ $rental->user->phone ?? '+62 812-xxxx-xxxx' }}</span>
            </div>

            <div>
                <span class="text-gray-400 uppercase font-bold text-[10px] block">Fulfillment & Destination:</span>
                <strong class="text-gray-900 block mt-0.5">{{ ucfirst($rental->shipping_method) }}</strong>
                <p class="text-gray-600 leading-relaxed mt-0.5">{{ $rental->shipping_address }}</p>
            </div>
        </div>

        <div>
            <h3 class="font-serif-editorial font-bold text-gray-900 text-xl mb-3">Reserved Garment Summary</h3>
            <div class="border border-rose-100 rounded-2xl overflow-hidden text-xs">
                <table class="w-full text-left">
                    <thead class="bg-rose-50 text-rose-900 font-bold uppercase">
                        <tr>
                            <th class="p-3">Gown & Specification</th>
                            <th class="p-3 text-center">Rental Schedule</th>
                            <th class="p-3 text-right">Duration</th>
                            <th class="p-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-50">
                        <tr>
                            <td class="p-4 flex items-center gap-3">
                                <img src="{{ $rental->dress->image_url }}" class="w-12 h-14 object-cover rounded-xl border border-rose-200" alt="Dress">
                                <div>
                                    <strong class="text-gray-900 text-sm block">{{ $rental->dress->name }}</strong>
                                    <span class="text-rose-700 font-semibold">Size {{ $rental->dress->size }}</span> | <span class="text-gray-500">{{ $rental->dress->color }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="block font-bold text-gray-800">{{ $rental->start_date->format('d/m/Y') }}</span>
                                <span class="text-[10px] text-gray-400">to</span>
                                <span class="block font-bold text-gray-800">{{ $rental->end_date->format('d/m/Y') }}</span>
                            </td>
                            <td class="p-4 text-right font-bold text-gray-800">
                                {{ $rental->total_days }} Days
                            </td>
                            <td class="p-4 text-right font-bold text-rose-700">
                                Rp {{ number_format($rental->rental_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end">
            <div class="w-full sm:w-72 space-y-2 text-xs bg-rose-50/40 p-4 rounded-2xl border border-rose-200">
                <div class="flex justify-between text-gray-600">
                    <span>Rental Subtotal:</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($rental->rental_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Security Deposit (Refundable):</span>
                    <span class="font-bold text-amber-800">Rp {{ number_format($depositFee ?? $rental->deposit_fee, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-rose-200 pt-2 flex justify-between text-sm font-bold text-rose-700">
                    <span>Total Amount Paid:</span>
                    <span>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="border-t border-rose-100 pt-4 text-center text-[10px] text-gray-400 leading-relaxed">
            <p>Thank you for choosing <strong>ChérieRent Atelier</strong>.</p>
            <p>This invoice voucher serves as an official confirmation of your reservation.</p>
        </div>

    </div>

</div>
@endsection
