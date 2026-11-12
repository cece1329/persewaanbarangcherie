@extends('layouts.app')

@section('content')
<div class="py-10 px-4 max-w-3xl mx-auto space-y-6">

    <!-- Action Toolbar (Hidden on Print) -->
    <div class="flex flex-wrap items-center justify-between gap-3 no-print bg-white p-4 rounded-2xl border border-rose-100 shadow-xs">
        <a href="{{ route('user.rentals') }}" class="text-xs font-bold text-rose-700 hover:text-rose-900 flex items-center gap-1.5 transition">
            <span>&larr;</span> Kembali ke Riwayat Sewa
        </a>
        
        <div class="flex items-center gap-2.5">
            <a href="{{ route('rental.print-thermal', $rental->rental_code) }}" target="_blank" class="bg-amber-500 hover:bg-amber-600 text-white text-xs px-4 py-2 rounded-full font-bold flex items-center gap-1.5 shadow-xs transition">
                <span>🧾</span> Cetak Struk Thermal / Resi
            </a>
            <button onclick="window.print()" class="btn-igari-primary text-xs px-5 py-2 rounded-full font-bold flex items-center gap-1.5 shadow-md">
                <span>🖨️</span> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Printable Invoice Voucher Card -->
    <div id="printable-area" class="bg-white p-8 sm:p-10 rounded-3xl border border-rose-200 shadow-xl space-y-8 relative overflow-hidden">
        
        <!-- Watermark / Stamp for Paid -->
        @if(in_array($rental->status, ['paid', 'shipping', 'in_use', 'returned', 'completed']))
            <div class="absolute right-8 top-28 pointer-events-none opacity-15 rotate-[-15deg] border-4 border-emerald-600 text-emerald-700 font-serif-editorial font-bold text-3xl px-6 py-2 rounded-2xl tracking-widest uppercase">
                PAID &bull; VERIFIED
            </div>
        @endif

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-rose-100 pb-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/web/logodomain.png') }}" class="w-12 h-14 object-contain" alt="ChérieRent Logo">
                <div>
                    <h1 class="font-serif-editorial text-2xl font-bold text-gray-900 tracking-tight">ChérieRent Atelier</h1>
                    <p class="text-[9px] text-rose-600 uppercase tracking-widest font-bold">Official Reservation Voucher &bull; Haute Couture</p>
                    <p class="text-[10px] text-gray-400">Jl. Senopati No. 42, Kebayoran Baru, Jakarta Selatan</p>
                </div>
            </div>

            <div class="sm:text-right">
                <span class="inline-block px-3.5 py-1 rounded-full text-xs font-bold border {{ $rental->status_badge_class }}">
                    {{ $rental->status_label }}
                </span>
                <p class="text-xs font-mono font-bold text-rose-700 mt-1.5">No. #{{ $rental->rental_code }}</p>
                <p class="text-[10px] text-gray-400">{{ $rental->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-rose-50/30 p-5 rounded-2xl border border-rose-100 text-xs">
            <div>
                <span class="text-gray-400 uppercase font-bold text-[10px] block">Customer / Reserved By:</span>
                <strong class="text-gray-900 text-sm block mt-0.5">{{ $rental->user->name }}</strong>
                <span class="text-gray-600 block">{{ $rental->user->email }}</span>
                <span class="text-gray-600 block">Telp: {{ $rental->user->phone ?? '-' }}</span>
            </div>

            <div>
                <span class="text-gray-400 uppercase font-bold text-[10px] block">Fulfillment & Destination:</span>
                <div class="flex items-center gap-2 mt-0.5">
                    <span class="bg-purple-100 text-purple-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">
                        {{ $rental->shipping_method === 'delivery' ? 'Express Courier' : 'Atelier Self Pickup' }}
                    </span>
                    <span class="text-gray-500 text-[11px]">| Bayar via: <strong>{{ strtoupper(str_replace('_', ' ', $rental->payment_method)) }}</strong></span>
                </div>
                <p class="text-gray-700 leading-relaxed mt-1 text-[11px]">{{ $rental->shipping_address }}</p>
                @if($rental->notes)
                    <p class="text-gray-500 italic text-[10px] mt-1 border-t border-rose-100/60 pt-1">
                        <strong>Catatan:</strong> {{ $rental->notes }}
                    </p>
                @endif
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
                            <th class="p-3 text-right">Rental Rate</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-50">
                        <tr>
                            <td class="p-4 flex items-center gap-3">
                                <img src="{{ $rental->dress->image_url }}" class="w-12 h-14 object-cover rounded-xl border border-rose-200" alt="Dress">
                                <div>
                                    <strong class="text-gray-900 text-sm block">{{ $rental->dress->name }}</strong>
                                    <span class="text-rose-700 font-semibold">Size {{ $rental->dress->size }}</span> | <span class="text-gray-500">{{ $rental->dress->color }}</span>
                                    <span class="block text-[10px] text-gray-400 mt-0.5">{{ $rental->dress->category->name ?? 'Haute Couture' }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <span class="block font-bold text-gray-800">{{ $rental->start_date->format('d M Y') }}</span>
                                <span class="text-[10px] text-rose-500 font-semibold">sampai</span>
                                <span class="block font-bold text-gray-800">{{ $rental->end_date->format('d M Y') }}</span>
                            </td>
                            <td class="p-4 text-right font-bold text-gray-800">
                                {{ $rental->total_days }} Hari
                            </td>
                            <td class="p-4 text-right font-bold text-rose-700">
                                Rp {{ number_format($rental->rental_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 pt-2">
            <div class="text-[11px] text-gray-500 max-w-sm space-y-1">
                <p class="font-bold text-gray-700">Catatan Jaminan & Pengembalian:</p>
                <p>&bull; Harap kembalikan gaun sesuai batas tanggal sewa untuk menghindari denda keterlambatan.</p>
                <p>&bull; Uang deposit jaminan sebesar <strong>Rp {{ number_format($rental->deposit_fee, 0, ',', '.') }}</strong> akan dikembalikan penuh (100%) setelah gaun diinspeksi oleh atelier kami.</p>
                <p>&bull; Dilarang mencuci sendiri gaun demi menjaga kelestarian bahan atelier.</p>
            </div>

            <div class="w-full sm:w-72 space-y-2 text-xs bg-rose-50/40 p-4 rounded-2xl border border-rose-200">
                <div class="flex justify-between text-gray-600">
                    <span>Biaya Sewa Gaun:</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($rental->rental_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Deposit Jaminan (Refundable):</span>
                    <span class="font-bold text-amber-800">Rp {{ number_format($rental->deposit_fee, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-rose-200 pt-2 flex justify-between text-base font-bold text-rose-700">
                    <span>Total Dibayar:</span>
                    <span>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="border-t border-rose-100 pt-6 flex flex-col sm:flex-row items-center justify-between text-[10px] text-gray-400 gap-2">
            <div>
                <p>Terima kasih telah mempercayakan busana Anda kepada <strong>ChérieRent Atelier</strong>.</p>
                <p>Voucher nota ini sah dan diterbitkan secara digital oleh sistem Chérie Atelier.</p>
            </div>
            <div class="text-center sm:text-right">
                <p class="font-mono text-gray-600 font-bold">VERIFIED #{{ $rental->rental_code }}</p>
                <p>Dokumen Resmi Pelanggan</p>
            </div>
        </div>

    </div>

</div>

@push('styles')
<style>
@media print {
    body {
        background: #ffffff !important;
        color: #000000 !important;
        font-size: 11pt !important;
    }
    .no-print, header, footer {
        display: none !important;
    }
    #printable-area {
        box-shadow: none !important;
        border: 1px solid #d1d5db !important;
        border-radius: 8px !important;
        padding: 24px !important;
        margin: 0 auto !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    .py-10 {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    @page {
        size: A4;
        margin: 12mm;
    }
}
</style>
@endpush
@endsection
