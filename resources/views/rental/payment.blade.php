@extends('layouts.app')

@section('content')
<div class="py-12 px-4 max-w-3xl mx-auto space-y-8">

    <div class="text-center space-y-2">
        <span class="igari-pill">Langkah 3 dari 3</span>
        <h1 class="font-serif-editorial text-3xl font-bold text-gray-900">Otorisasi Pembayaran</h1>
        <p class="text-xs text-gray-500">Kode Reservasi: <strong class="text-rose-700 font-mono text-sm bg-rose-50 border border-rose-200 px-3 py-1 rounded-full">{{ $rental->rental_code }}</strong></p>
    </div>

    @if($rental->status === 'cancelled')
        <div class="bg-white p-8 rounded-3xl border-2 border-slate-200 shadow-md text-center space-y-4">
            <div class="w-14 h-14 mx-auto bg-slate-100 text-slate-500 rounded-full flex items-center justify-center text-2xl font-bold">
                ✕
            </div>
            <h2 class="font-serif-editorial text-2xl font-bold text-gray-800">Reservasi Telah Dibatalkan</h2>
            <p class="text-xs text-gray-500 max-w-md mx-auto">
                Batas waktu pembayaran 1 jam telah berakhir atau reservasi telah dibatalkan. Gaun ini kini tersedia kembali untuk tanggal lainnya.
            </p>
            <div class="flex items-center justify-center gap-3 pt-2">
                <a href="{{ route('catalog.index') }}" class="btn-igari-primary text-xs px-6 py-2.5 rounded-full font-bold">
                    Pilih Gaun di Katalog
                </a>
                <a href="{{ route('user.rentals') }}" class="btn-igari-secondary text-xs px-5 py-2.5 rounded-full font-bold">
                    Riwayat Reservasi
                </a>
            </div>
        </div>
    @else
        <!-- Pending Payment Expiry Notice -->
        <div class="bg-amber-50 border border-amber-200 p-4 rounded-3xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs text-amber-900 shadow-xs">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-amber-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <strong class="block text-amber-950 font-bold">Batas Waktu Pembayaran: 1 Jam</strong>
                    <span class="text-[11px] text-amber-800">
                        Selesaikan pembayaran sebelum <strong>{{ $rental->created_at->addHour()->format('H:i') }} WIB</strong> (Sisa waktu: <strong>{{ $rental->remaining_minutes }} Menit</strong>).
                    </span>
                </div>
            </div>
            <form action="{{ route('user.rental.cancel', $rental->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                @csrf
                <button type="submit" class="bg-white hover:bg-rose-50 text-rose-700 text-xs px-3.5 py-1.5 rounded-full font-bold border border-rose-200 shadow-2xs transition whitespace-nowrap">
                    ✕ Batalkan Reservasi
                </button>
            </form>
        </div>

        <div class="bg-white p-8 rounded-3xl border-2 border-rose-300 shadow-xl space-y-8">
        
        <div class="bg-gradient-to-r from-rose-700 to-pink-700 text-white p-6 rounded-2xl text-center space-y-1 shadow-md">
            <span class="text-xs uppercase tracking-wider font-semibold opacity-90">Total Tagihan Pembayaran</span>
            <p class="font-serif-editorial text-3xl font-bold">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
            <p class="text-[10px] opacity-80">(Termasuk biaya sewa gaun + deposit jaminan kembali 100% Rp {{ number_format($rental->deposit_fee, 0, ',', '.') }})</p>
        </div>

        <div class="space-y-4">
            <h3 class="font-serif-editorial font-bold text-gray-900 text-xl text-center">
                Instruksi Pembayaran ({{ strtoupper(str_replace('_', ' ', $rental->payment_method)) }})
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
                            <span x-show="!copied">Salin Rekening</span>
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
                    <span>Kirim Bukti Transfer &amp; Konfirmasi Pembayaran</span>
                </button>
            </form>

        </div>

    </div>
    @endif

</div>
@endsection
