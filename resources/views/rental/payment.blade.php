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
                Payment Instructions ({{ strtoupper(str_replace('_', ' ', $rental->payment_method)) }})
            </h3>

            @if(in_array($rental->payment_method, ['qris','shopee_pay','dana']))
                <div class="text-center space-y-3 bg-rose-50/40 p-6 rounded-2xl border border-rose-200">
                    <div class="flex items-center justify-center gap-2 mb-1">
                        @if($rental->payment_method === 'shopee_pay')
                            <img src="{{ asset('images/payments/shopeepay.png') }}" alt="ShopeePay" class="h-7 w-auto object-contain">
                        @elseif($rental->payment_method === 'dana')
                            <img src="{{ asset('images/payments/dana.png') }}" alt="DANA" class="h-7 w-auto object-contain">
                        @else
                            <img src="{{ asset('images/payments/qris.png') }}" alt="QRIS" class="h-7 w-auto object-contain">
                        @endif
                    </div>
                    <p class="text-xs text-gray-600 font-medium">Scan QR Code di bawah melalui ShopeePay, DANA, GoPay, OVO, atau Mobile Banking:</p>
                    <div class="w-48 h-48 bg-white p-3 rounded-2xl border-2 border-rose-300 mx-auto shadow-md flex items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=CHERIE_RENT_ATELIER_DUMMY_QRIS_{{ $rental->rental_code }}" class="w-full h-full object-contain" alt="QR Code">
                    </div>
                    <div class="text-[10px] text-gray-500 font-mono">
                        <strong class="text-rose-800 font-bold block">NMK: CHERIE BOUTIQUE INDONESIA (DUMMY QRIS)</strong>
                        <span>NMID: ID1020261115890</span>
                    </div>
                </div>
            @else
                <div x-data="{ copied: false }" class="bg-rose-50/40 p-6 rounded-2xl border border-rose-200 space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-500">Bank Tujuan (Admin Dummy):</span>
                        <div class="flex items-center gap-2">
                            @if($rental->payment_method === 'mandiri')
                                <img src="{{ asset('images/payments/mandiri.png') }}" alt="Mandiri" class="h-5 w-auto object-contain">
                                <strong class="text-gray-900 text-sm">BANK MANDIRI</strong>
                            @else
                                <img src="{{ asset('images/payments/bca.png') }}" alt="BCA" class="h-5 w-auto object-contain">
                                <strong class="text-gray-900 text-sm">BANK BCA</strong>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs bg-white p-3.5 rounded-xl border border-rose-100">
                        <div>
                            <span class="text-gray-400 block text-[10px] font-semibold">Nomor Rekening Tujuan:</span>
                            <strong class="text-rose-700 font-mono text-base tracking-wider block" id="accNumber">{{ $rental->payment_method === 'mandiri' ? '1370-0192-8445-5' : '8830-1928-4455' }}</strong>
                            <span class="text-[11px] text-gray-600 block mt-0.5">Atas Nama: <strong class="text-gray-900">CHÉRIERENT ATELIER (DUMMY)</strong></span>
                        </div>
                        <button type="button" @click="navigator.clipboard.writeText('{{ $rental->payment_method === 'mandiri' ? '1370019284455' : '883019284455' }}'); copied = true; setTimeout(() => copied = false, 2500)" class="btn-igari-secondary text-xs px-3 py-1.5 rounded-xl font-bold flex items-center gap-1 self-start sm:self-center shadow-2xs">
                            <span x-show="!copied">📋 Salin Rekening</span>
                            <span x-show="copied" x-cloak class="text-emerald-600 font-bold">✓ Tersalin!</span>
                        </button>
                    </div>
                    <p class="text-[10px] text-gray-500">*Gunakan m-Banking atau ATM untuk transfer ke rekening admin di atas.</p>
                </div>
            @endif
        </div>

        <div class="border-t border-rose-100 pt-6 space-y-4">
            
            <form action="{{ route('rental.process-payment', $rental->rental_code) }}" method="POST" enctype="multipart/form-data" x-data="{ proofPreview: null }" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-800">
                        Unggah Bukti Struk / Screenshot Transfer
                    </label>
                    <input type="file" name="payment_proof" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-rose-100 file:text-rose-800 hover:file:bg-rose-200" @change="const file = $event.target.files[0]; if(file){ const r = new FileReader(); r.onload = (e) => proofPreview = e.target.result; r.readAsDataURL(file); }">
                    
                    <div x-show="proofPreview" x-cloak class="mt-2 p-2 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center gap-3">
                        <img :src="proofPreview" class="w-14 h-14 object-cover rounded-lg border border-emerald-300" alt="Preview Bukti">
                        <span class="text-xs text-emerald-800 font-bold">✓ Bukti Transfer Siap Diunggah</span>
                    </div>
                </div>

                <button type="submit" class="w-full btn-igari-primary py-3.5 rounded-full font-bold text-xs uppercase tracking-wider shadow-md flex items-center justify-center gap-2">
                    <span>🧾 Kirim Bukti Transfer & Konfirmasi Pembayaran</span>
                </button>
            </form>

        </div>

    </div>

</div>
@endsection
