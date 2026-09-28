@extends('layouts.app')

@section('content')
<div class="py-12 px-4 max-w-3xl mx-auto space-y-8">

    <div class="text-center space-y-2">
        <span class="igari-pill">Step 3 of 3</span>
        <h1 class="font-serif-editorial text-3xl font-bold text-gray-900">Payment Authorization</h1>
        <p class="text-xs text-gray-500">Reservation Reference: <strong class="text-rose-700 font-mono text-sm bg-rose-50 border border-rose-200 px-3 py-1 rounded-full">{{ $rental->rental_code }}</strong></p>
    </div>

    <div class="bg-white p-8 rounded-3xl border-2 border-rose-300 shadow-xl space-y-8">
        
        <div class="bg-gradient-to-r from-rose-700 to-pink-700 text-white p-6 rounded-2xl text-center space-y-1 shadow-md">
            <span class="text-xs uppercase tracking-wider font-semibold opacity-90">Total Payable Amount</span>
            <p class="font-serif-editorial text-3xl font-bold">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
            <p class="text-[10px] opacity-80">(Includes rental fee + refundable security deposit Rp {{ number_format($rental->deposit_fee, 0, ',', '.') }})</p>
        </div>

        <div class="space-y-4">
            <h3 class="font-serif-editorial font-bold text-gray-900 text-xl text-center">
                Payment Instructions ({{ strtoupper($rental->payment_method) }})
            </h3>

            @if($rental->payment_method === 'qris' || $rental->payment_method === 'shopee_pay')
                <div class="text-center space-y-3 bg-rose-50/40 p-6 rounded-2xl border border-rose-200">
                    <p class="text-xs text-gray-600 font-medium">Scan the QR code below via Mobile Banking or E-Wallet:</p>
                    <div class="w-48 h-48 bg-white p-3 rounded-2xl border-2 border-rose-300 mx-auto shadow-md flex items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=CHERIE_RENT_{{ $rental->rental_code }}" class="w-full h-full object-contain" alt="QR Code">
                    </div>
                    <span class="text-[10px] text-rose-800 font-bold block">NMK: CHERIE BOUTIQUE INDONESIA</span>
                </div>
            @else
                <div class="bg-rose-50/40 p-6 rounded-2xl border border-rose-200 space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500">Bank Institution:</span>
                        <strong class="text-gray-900 text-sm">BANK BCA</strong>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500">Virtual Account Number:</span>
                        <strong class="text-rose-700 font-mono text-base">8830-1928-4455</strong>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500">Account Name:</span>
                        <strong class="text-gray-900">CHÉRIERENT ATELIER</strong>
                    </div>
                </div>
            @endif
        </div>

        <div class="border-t border-rose-100 pt-6 space-y-4">
            
            <form action="{{ route('rental.process-payment', $rental->rental_code) }}" method="POST">
                @csrf
                <button type="submit" class="w-full btn-igari-primary py-4 rounded-full font-bold text-xs uppercase tracking-wider shadow-md flex items-center justify-center gap-2">
                    <span>Instant Payment Verification (Simulated Demo)</span>
                </button>
            </form>

            <div class="relative flex py-2 items-center">
                <div class="flex-grow border-t border-rose-200"></div>
                <span class="flex-shrink mx-4 text-gray-400 text-[10px] font-bold uppercase tracking-wider">Or Upload Receipt File</span>
                <div class="flex-grow border-t border-rose-200"></div>
            </div>

            <form action="{{ route('rental.process-payment', $rental->rental_code) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <input type="file" name="payment_proof" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-rose-100 file:text-rose-800 hover:file:bg-rose-200">
                </div>
                <button type="submit" class="w-full btn-igari-secondary py-3 rounded-full font-bold text-xs uppercase tracking-wider">
                    Submit Payment Receipt
                </button>
            </form>

        </div>

    </div>

</div>
@endsection
