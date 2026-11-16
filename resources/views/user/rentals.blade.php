@extends('layouts.app')

@section('content')
<div class="py-10 px-4 max-w-7xl mx-auto space-y-8" x-data="{ reviewModalOpen: false, selectedRental: null, returnModalOpen: false, returnRentalId: null, returnRentalCode: '' }">

    <div class="border-b border-rose-200 pb-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <span class="igari-pill">Catatan Pelanggan</span>
            <h1 class="font-serif-editorial text-3xl font-bold text-gray-900 mt-1">Riwayat Reservasi Saya</h1>
        </div>

        <div class="flex flex-wrap gap-2 text-xs font-semibold">
            <a href="{{ route('user.rentals') }}" class="px-3.5 py-1.5 rounded-full {{ !request('status') ? 'bg-rose-700 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">Semua</a>
            <a href="{{ route('user.rentals', ['status' => 'pending_payment']) }}" class="px-3.5 py-1.5 rounded-full {{ request('status') == 'pending_payment' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-800 hover:bg-amber-100' }}">Menunggu Bayar</a>
            <a href="{{ route('user.rentals', ['status' => 'paid']) }}" class="px-3.5 py-1.5 rounded-full {{ request('status') == 'paid' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-800 hover:bg-rose-100' }}">Dipesan</a>
            <a href="{{ route('user.rentals', ['status' => 'in_use']) }}" class="px-3.5 py-1.5 rounded-full {{ request('status') == 'in_use' ? 'bg-pink-600 text-white' : 'bg-pink-50 text-pink-800 hover:bg-pink-100' }}">Sedang Digunakan</a>
            <a href="{{ route('user.rentals', ['status' => 'returned']) }}" class="px-3.5 py-1.5 rounded-full {{ request('status') == 'returned' ? 'bg-indigo-700 text-white' : 'bg-indigo-50 text-indigo-800 hover:bg-indigo-100' }}">Dikembalikan</a>
            <a href="{{ route('user.rentals', ['status' => 'completed']) }}" class="px-3.5 py-1.5 rounded-full {{ request('status') == 'completed' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">Selesai</a>
            <a href="{{ route('user.rentals', ['status' => 'cancelled']) }}" class="px-3.5 py-1.5 rounded-full {{ request('status') == 'cancelled' ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">Dibatalkan</a>
        </div>
    </div>

    @if($rentals->isEmpty())
        <div class="bg-white p-12 rounded-3xl border border-rose-100 text-center space-y-4">
            <h3 class="font-serif-editorial font-bold text-xl text-gray-800">Belum Ada Reservasi</h3>
            <p class="text-xs text-gray-500 max-w-sm mx-auto">Jelajahi koleksi gaun kami untuk mulai menyewa gaun impianmu.</p>
            <a href="{{ route('catalog.index') }}" class="inline-block btn-igari-primary text-xs px-6 py-2.5 rounded-full font-bold">Jelajahi Koleksi</a>
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
                            <p class="text-xs text-gray-500">Jadwal Sewa: <strong>{{ $rental->start_date->format('d/m/Y') }}</strong> s/d <strong>{{ $rental->end_date->format('d/m/Y') }}</strong> ({{ $rental->total_days }} Hari)</p>
                            <p class="text-xs font-bold text-rose-700">Total Biaya: Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>

                            @if($rental->status === 'returned')
                                <div class="mt-2 p-2.5 bg-indigo-50 rounded-xl border border-indigo-200 text-xs text-indigo-950 flex items-start gap-2">
                                    <svg class="w-4 h-4 text-indigo-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    <div>
                                        <strong class="text-indigo-900 font-bold block">Gaun Telah Dikembalikan (Dalam Pemeriksaan)</strong>
                                        <span class="text-[11px] text-indigo-700 block">Sedang diperiksa tim atelier. Deposit Rp {{ number_format($rental->deposit_fee, 0, ',', '.') }} akan dikembalikan penuh setelah inspeksi selesai.</span>
                                        @if($rental->return_tracking_number)
                                            <span class="inline-block text-[10px] bg-white text-indigo-800 font-mono px-2 py-0.5 rounded border border-indigo-200 mt-1">Resi: {{ $rental->return_tracking_number }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <div class="space-y-1">
                            <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border inline-block whitespace-nowrap {{ $rental->status_badge_class }}">
                                {{ $rental->status_label }}
                            </span>
                            @if($rental->status === 'pending_payment')
                                <span class="block text-[10px] text-amber-700 font-bold">
                                    Batas: {{ $rental->remaining_minutes }} Menit lagi
                                </span>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            @if($rental->status === 'pending_payment')
                                <a href="{{ route('rental.payment', $rental->rental_code) }}" class="btn-igari-primary text-xs px-3.5 py-1.5 rounded-full font-bold shadow-xs flex items-center gap-1">
                                    <span>Bayar Sekarang</span>
                                </a>
                                <form action="{{ route('user.rental.cancel', $rental->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')">
                                    @csrf
                                    <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs px-3 py-1.5 rounded-full font-bold border border-rose-200 transition">
                                        ✕ Batalkan
                                    </button>
                                </form>
                            @endif

                            @if(in_array($rental->status, ['paid', 'shipping', 'in_use']))
                                <button @click="returnRentalId = {{ $rental->id }}; returnRentalCode = '{{ $rental->rental_code }}'; returnModalOpen = true" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs px-3.5 py-1.5 rounded-full font-bold border border-indigo-200 transition flex items-center gap-1">
                                    <span>Kembalikan Gaun</span>
                                </button>
                            @endif

                            <a href="{{ route('rental.invoice', $rental->rental_code) }}" class="btn-igari-secondary text-xs px-3.5 py-1.5 rounded-full font-bold flex items-center gap-1">
                                <span>Nota PDF</span>
                            </a>

                            @if($rental->status !== 'cancelled')
                                <a href="{{ route('rental.print-thermal', $rental->rental_code) }}" target="_blank" class="bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs px-3.5 py-1.5 rounded-full font-bold flex items-center gap-1 transition">
                                    <span>Resi Thermal</span>
                                </a>
                            @endif

                            @if($rental->status === 'completed' && !$rental->review)
                                <button @click="selectedRental = {{ $rental->id }}; reviewModalOpen = true" class="btn-igari-primary text-xs px-4 py-1.5 rounded-full font-bold">
                                    Beri Ulasan Gaun
                                </button>
                            @elseif($rental->review)
                                <span class="text-xs text-emerald-700 font-bold bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200">Ulasan Terkirim</span>
                            @endif

                            <form action="{{ route('user.rental.destroy', $rental->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat reservasi #{{ $rental->rental_code }} ini dari akun Anda?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus Riwayat Reservasi" class="bg-gray-50 hover:bg-red-50 text-gray-500 hover:text-red-700 text-xs px-3 py-1.5 rounded-full font-bold border border-gray-200 hover:border-red-200 transition flex items-center gap-1">
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                                </button>
                            </form>
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
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full border-2 border-rose-300 shadow-2xl space-y-4" x-data="{ userRating: 5, hoverRating: 0 }">
            <div class="flex justify-between items-center border-b border-rose-100 pb-3">
                <div>
                    <h3 class="font-serif-editorial font-bold text-xl text-gray-900">Ulasan Pengalaman Gaun</h3>
                    <p class="text-[11px] text-gray-500">Berikan penilaian pengalaman sewa gaun atelier.</p>
                </div>
                <button @click="reviewModalOpen = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>

            <form action="{{ route('user.review.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="rental_id" :value="selectedRental">
                <input type="hidden" name="rating" :value="userRating" required>

                <!-- Interactive Star Rating -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Penilaian Bintang</label>
                    <div class="flex items-center gap-2 bg-rose-50/40 p-3.5 rounded-2xl border border-rose-100 justify-between">
                        <div class="flex items-center gap-1.5">
                            <template x-for="star in 5" :key="star">
                                <button type="button" 
                                    @click="userRating = star"
                                    @mouseenter="hoverRating = star"
                                    @mouseleave="hoverRating = 0"
                                    class="text-3xl sm:text-4xl transition transform hover:scale-110 focus:outline-none cursor-pointer"
                                    :class="(hoverRating || userRating) >= star ? 'text-amber-400' : 'text-gray-300'">
                                    ★
                                </button>
                            </template>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-bold text-amber-600 block" x-text="userRating + ' Bintang'"></span>
                            <span class="text-[10px] text-gray-400 font-semibold" x-text="userRating === 5 ? 'Sangat Sempurna' : (userRating === 4 ? 'Sangat Bagus' : (userRating === 3 ? 'Cukup Baik' : (userRating === 2 ? 'Kurang Memuaskan' : 'Mengecewakan')))"></span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Pengalaman &amp; Ulasanmu</label>
                    <textarea name="comment" rows="4" required placeholder="Ceritakan pengalamanmu terkait kerapihan, keindahan bahan, dan kecocokan gaun saat dipakai..." class="w-full p-3 rounded-2xl border border-rose-200 text-xs bg-rose-50/20 outline-none"></textarea>
                </div>

                <button type="submit" class="w-full btn-igari-primary py-3.5 rounded-full font-bold text-xs uppercase tracking-wider shadow-md">
                    Kirim Ulasan Gaun
                </button>
            </form>
        </div>
    </div>

    <!-- Return Gown Modal -->
    <div x-show="returnModalOpen" x-transition class="fixed inset-0 bg-black/50 backdrop-blur-xs z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full border-2 border-indigo-200 shadow-2xl space-y-4">
            <div class="flex justify-between items-center border-b border-rose-100 pb-3">
                <div>
                    <h3 class="font-serif-editorial font-bold text-xl text-gray-900">Form Pengembalian Gaun</h3>
                    <span class="text-[10px] font-mono font-bold text-indigo-700" x-text="'#' + returnRentalCode"></span>
                </div>
                <button @click="returnModalOpen = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
            </div>

            <form :action="'/rentals/' + returnRentalId + '/return'" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Metode / No. Resi Pengembalian</label>
                    <input type="text" name="return_tracking_number" placeholder="Contoh: JNE / SiCepat / GoSend / Antar Sendiri ke Atelier" class="w-full p-3 rounded-xl border border-gray-200 text-xs bg-rose-50/20 outline-none focus:border-indigo-500">
                    <p class="text-[10px] text-gray-400 mt-1">Tulis nomor resi ekspedisi atau tulis "Antar Sendiri ke Atelier" jika dikembalikan langsung.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Catatan Pengembalian (Opsional)</label>
                    <textarea name="return_notes" rows="2" placeholder="Catatan kondisi gaun atau informasi kurir..." class="w-full p-3 rounded-xl border border-gray-200 text-xs bg-rose-50/20 outline-none focus:border-indigo-500"></textarea>
                </div>

                <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-[11px] text-amber-900 flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Setelah konfirmasi pengembalian, status akan berubah menjadi <strong>Dikembalikan (Pemeriksaan Fisik)</strong>. Deposit jaminanmu akan dicairkan oleh atelier setelah pemeriksaan selesai.</span>
                </div>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" @click="returnModalOpen = false" class="btn-igari-secondary text-xs px-4 py-2 rounded-full font-bold">Batal</button>
                    <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 text-white text-xs px-5 py-2 rounded-full font-bold shadow-md transition">
                        Konfirmasi Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
