@extends('layouts.app')

@section('content')
<div class="py-10 px-4 max-w-5xl mx-auto space-y-8">
    
    <div class="border-b border-rose-200 pb-4">
        <span class="igari-pill">Step 2 of 3</span>
        <h1 class="font-serif-editorial text-3xl font-bold text-gray-900 mt-2">Reservation & Delivery Details</h1>
    </div>

    <form action="{{ route('rental.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
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
                        <span class="text-gray-400 block uppercase font-bold text-[10px]">Tanggal Mulai Sewa:</span>
                        <input type="date" name="start_date" value="{{ $startDate }}" readonly class="font-bold text-gray-800 bg-transparent outline-none mt-1">
                    </div>
                    <div>
                        <span class="text-gray-400 block uppercase font-bold text-[10px]">Tanggal Pengembalian:</span>
                        <input type="date" name="end_date" value="{{ $endDate }}" readonly class="font-bold text-gray-800 bg-transparent outline-none mt-1">
                    </div>
                </div>

                <div class="p-3 bg-white/80 rounded-xl border border-rose-100 flex items-start gap-2.5 text-[11px] text-gray-600">
                    <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <strong class="text-rose-900 font-semibold block">Estimasi Jadwal Pengiriman Atelier:</strong>
                        Gaun akan disiapkan dan dikirim H-2 / H-1 sebelum tanggal mulai sewa ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}) agar tiba tepat waktu sebelum acaramu dimulai.
                    </div>
                </div>
            </div>

            <div x-data="{ method: 'delivery' }" class="bg-white p-6 rounded-3xl border border-rose-100 shadow-xs space-y-4">
                <h3 class="font-serif-editorial font-bold text-gray-900 text-lg">
                    Metode Pengambilan &amp; Pengiriman
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="p-4 rounded-2xl border cursor-pointer transition flex items-center gap-3" :class="method === 'delivery' ? 'bg-rose-50 border-rose-600 font-bold text-rose-900' : 'border-rose-200 text-gray-600'">
                        <input type="radio" name="shipping_method" value="delivery" x-model="method" class="text-rose-600">
                        <div>
                            <span class="block text-xs">Pengiriman Kurir Ekspedisi</span>
                            <span class="text-[10px] text-gray-400 font-normal">Dikirim langsung ke alamat rumah Anda</span>
                        </div>
                    </label>

                    <label class="p-4 rounded-2xl border cursor-pointer transition flex items-center gap-3" :class="method === 'pickup' ? 'bg-rose-50 border-rose-600 font-bold text-rose-900' : 'border-rose-200 text-gray-600'">
                        <input type="radio" name="shipping_method" value="pickup" x-model="method" class="text-rose-600">
                        <div>
                            <span class="block text-xs">Ambil Sendiri di Atelier</span>
                            <span class="text-[10px] text-gray-400 font-normal">ChérieRent Atelier Jakarta Selatan</span>
                        </div>
                    </label>
                </div>

                <div x-show="method === 'delivery'" x-transition class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Alamat Pengiriman Lengkap</label>
                    <textarea name="shipping_address" rows="3" required placeholder="Nama Jalan, Nomor Rumah, RT/RW, Kelurahan/Kecamatan, Kota, Kode Pos" class="w-full p-3 rounded-2xl border border-rose-200 text-xs bg-rose-50/20 outline-none focus:border-rose-500">{{ old('shipping_address', $user->address) }}</textarea>
                </div>

                <div x-show="method === 'pickup'" x-transition class="p-4 bg-rose-50/60 rounded-2xl border border-rose-200 text-xs space-y-1.5">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                        <strong class="text-rose-900 font-bold">Lokasi Pengambilan Gaun:</strong>
                    </div>
                    <p class="text-gray-800 font-semibold">ChérieRent Atelier Studio</p>
                    <p class="text-gray-600 leading-relaxed">
                        Jl. Senopati No. 42, RT.04/RW.02, Selong, Kebayoran Baru, Jakarta Selatan 12110<br>
                        <span class="text-rose-700 font-medium">(Lantai 2 Atelier Studio, Seberang Senopati Arcade)</span>
                    </p>
                    <div class="pt-1 text-[11px] text-gray-500 flex flex-wrap gap-4">
                        <span>Jam Buka: <strong>09.00 - 18.00 WIB (Setiap Hari)</strong></span>
                        <span>Concierge: <strong>+62 895-4016-43905</strong></span>
                    </div>
                </div>
            </div>

            <!-- Payment Method Section -->
            <div x-data="{
                category: 'ewallet',
                method: 'qris',
                copied: false,
                proofPreview: null,
                bankAccounts: {
                    bca: { name: 'Bank BCA', number: '8830-1928-4455', holder: 'CHÉRIERENT ATELIER (DUMMY)' },
                    mandiri: { name: 'Bank Mandiri', number: '1370-0192-8445-5', holder: 'CHÉRIERENT ATELIER (DUMMY)' }
                },
                copyAccountNumber() {
                    const acc = this.bankAccounts[this.method] ? this.bankAccounts[this.method].number : '8830-1928-4455';
                    navigator.clipboard.writeText(acc.replace(/-/g, ''));
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2500);
                },
                handleProofUpload(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            this.proofPreview = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },
                removeProof() {
                    this.proofPreview = null;
                    this.$refs.proofInput.value = '';
                }
            }" class="bg-white p-5 sm:p-6 rounded-3xl border border-rose-100 shadow-xs space-y-5">
                
                <div class="flex items-center justify-between border-b border-rose-50 pb-3">
                    <div>
                        <h3 class="font-serif-editorial font-bold text-gray-900 text-lg">
                            Metode Pembayaran & Bukti Transfer
                        </h3>
                        <p class="text-[11px] text-gray-500 mt-0.5">Pilih jalur pembayaran E-Wallet / QRIS atau Transfer Bank resmi atelier.</p>
                    </div>
                </div>

                <!-- Category Tabs: E-Wallet vs Bank Transfer -->
                <div class="grid grid-cols-2 gap-2 p-1.5 bg-rose-50/70 rounded-2xl border border-rose-100">
                    <button type="button" 
                        @click="category = 'ewallet'; method = 'qris'" 
                        :class="category === 'ewallet' ? 'bg-white text-rose-700 shadow-xs font-bold border border-rose-200' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="py-2.5 px-3 rounded-xl text-xs flex items-center justify-center gap-1.5 transition">
                        <span>E-Wallet &amp; QRIS</span>
                    </button>
                    <button type="button" 
                        @click="category = 'bank'; method = 'bca'" 
                        :class="category === 'bank' ? 'bg-white text-rose-700 shadow-xs font-bold border border-rose-200' : 'text-gray-600 hover:text-gray-900 font-semibold'"
                        class="py-2.5 px-3 rounded-xl text-xs flex items-center justify-center gap-1.5 transition">
                        <span>Transfer Bank</span>
                    </button>
                </div>

                <!-- 1. Pilihan E-Wallet & QRIS -->
                <div x-show="category === 'ewallet'" x-transition class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs">
                        <!-- QRIS -->
                        <label class="p-3 rounded-2xl border cursor-pointer transition flex items-center gap-3"
                            :class="method === 'qris' ? 'bg-rose-50 border-rose-600 font-bold text-rose-950 shadow-xs' : 'border-rose-100 hover:bg-rose-50/40 text-gray-700'">
                            <input type="radio" name="payment_method" value="qris" x-model="method" class="text-rose-600 focus:ring-rose-500">
                            <img src="{{ asset('images/payments/qris.png') }}" alt="QRIS" class="h-6 w-auto max-w-[38px] object-contain flex-shrink-0">
                            <div class="min-w-0">
                                <span class="block font-bold truncate">QRIS</span>
                                <span class="text-[10px] text-gray-500 block truncate">Semua E-Wallet</span>
                            </div>
                        </label>

                        <!-- ShopeePay -->
                        <label class="p-3 rounded-2xl border cursor-pointer transition flex items-center gap-3"
                            :class="method === 'shopee_pay' ? 'bg-rose-50 border-rose-600 font-bold text-rose-950 shadow-xs' : 'border-rose-100 hover:bg-rose-50/40 text-gray-700'">
                            <input type="radio" name="payment_method" value="shopee_pay" x-model="method" class="text-rose-600 focus:ring-rose-500">
                            <img src="{{ asset('images/payments/shopeepay.png') }}" alt="ShopeePay" class="h-6 w-auto max-w-[38px] object-contain flex-shrink-0">
                            <div class="min-w-0">
                                <span class="block font-bold truncate">ShopeePay</span>
                                <span class="text-[10px] text-gray-500 block truncate">E-Wallet Instant</span>
                            </div>
                        </label>

                        <!-- DANA -->
                        <label class="p-3 rounded-2xl border cursor-pointer transition flex items-center gap-3"
                            :class="method === 'dana' ? 'bg-rose-50 border-rose-600 font-bold text-rose-950 shadow-xs' : 'border-rose-100 hover:bg-rose-50/40 text-gray-700'">
                            <input type="radio" name="payment_method" value="dana" x-model="method" class="text-rose-600 focus:ring-rose-500">
                            <img src="{{ asset('images/payments/dana.png') }}" alt="DANA" class="h-6 w-auto max-w-[38px] object-contain flex-shrink-0">
                            <div class="min-w-0">
                                <span class="block font-bold truncate">DANA</span>
                                <span class="text-[10px] text-gray-500 block truncate">E-Wallet Instant</span>
                            </div>
                        </label>
                    </div>

                    <!-- QRIS Dummy Showcase Card -->
                    <div class="bg-gradient-to-b from-rose-50/50 to-pink-50/30 p-4 sm:p-5 rounded-2xl border border-rose-200 text-center space-y-3">
                        <div class="inline-flex items-center gap-2 bg-white px-3 py-1 rounded-full border border-rose-200 shadow-2xs">
                            <img src="{{ asset('images/payments/qris.png') }}" alt="QRIS" class="h-4 w-auto object-contain">
                            <span class="text-[10px] font-bold text-rose-800 uppercase tracking-wider">QRIS Standar Pembayaran Nasional</span>
                        </div>
                        <p class="text-xs text-gray-600 max-w-sm mx-auto">Scan QR Code di bawah menggunakan ShopeePay, DANA, GoPay, OVO, atau Mobile Banking apa saja:</p>
                        
                        <div class="w-44 h-44 bg-white p-2.5 rounded-2xl border-2 border-rose-300 mx-auto shadow-md flex items-center justify-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=CHERIE_RENT_DUMMY_QRIS_OFFICIAL" class="w-full h-full object-contain" alt="QRIS Dummy Atelier">
                        </div>

                        <div class="space-y-0.5 text-xs">
                            <strong class="text-gray-900 block font-bold">CHÉRIERENT ATELIER (DUMMY QRIS)</strong>
                            <span class="text-[10px] text-gray-500 font-mono block">NMID: ID1020261115890 &bull; DUMMY RESMI</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Pilihan Transfer Bank Manual -->
                <div x-show="category === 'bank'" x-transition class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                        <!-- Bank BCA -->
                        <label class="p-3.5 rounded-2xl border cursor-pointer transition flex items-center gap-3"
                            :class="method === 'bca' ? 'bg-rose-50 border-rose-600 font-bold text-rose-950 shadow-xs' : 'border-rose-100 hover:bg-rose-50/40 text-gray-700'">
                            <input type="radio" name="payment_method" value="bca" x-model="method" class="text-rose-600 focus:ring-rose-500">
                            <img src="{{ asset('images/payments/bca.png') }}" alt="Bank BCA" class="h-6 w-auto max-w-[42px] object-contain flex-shrink-0">
                            <div class="min-w-0">
                                <span class="block font-bold truncate">Bank BCA</span>
                                <span class="text-[10px] text-gray-500 block truncate">Transfer Rekening Bank</span>
                            </div>
                        </label>

                        <!-- Bank Mandiri -->
                        <label class="p-3.5 rounded-2xl border cursor-pointer transition flex items-center gap-3"
                            :class="method === 'mandiri' ? 'bg-rose-50 border-rose-600 font-bold text-rose-950 shadow-xs' : 'border-rose-100 hover:bg-rose-50/40 text-gray-700'">
                            <input type="radio" name="payment_method" value="mandiri" x-model="method" class="text-rose-600 focus:ring-rose-500">
                            <img src="{{ asset('images/payments/mandiri.png') }}" alt="Bank Mandiri" class="h-6 w-auto max-w-[42px] object-contain flex-shrink-0">
                            <div class="min-w-0">
                                <span class="block font-bold truncate">Bank Mandiri</span>
                                <span class="text-[10px] text-gray-500 block truncate">Transfer Rekening Bank</span>
                            </div>
                        </label>
                    </div>

                    <!-- Bank Account Details Card -->
                    <div class="bg-gradient-to-r from-rose-50/60 to-pink-50/40 p-4 sm:p-5 rounded-2xl border border-rose-200 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-rose-800 bg-white px-2.5 py-1 rounded-full border border-rose-200 shadow-2xs">
                                Rekening Tujuan Admin (Dummy)
                            </span>
                            <span class="text-[10px] text-gray-400 font-semibold" x-text="method === 'bca' ? 'BCA Transfer' : 'Mandiri Transfer'"></span>
                        </div>

                        <div class="bg-white p-3.5 rounded-xl border border-rose-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                            <div>
                                <span class="text-[10px] text-gray-400 block font-semibold" x-text="method === 'bca' ? 'Nomor Rekening BCA:' : 'Nomor Rekening Mandiri:'"></span>
                                <strong class="font-mono text-base sm:text-lg text-rose-700 block tracking-wider" x-text="bankAccounts[method] ? bankAccounts[method].number : '8830-1928-4455'"></strong>
                                <span class="text-[11px] text-gray-600 block mt-0.5">Atas Nama: <strong class="text-gray-900" x-text="bankAccounts[method] ? bankAccounts[method].holder : 'CHÉRIERENT ATELIER (DUMMY)'"></strong></span>
                            </div>
                            <button type="button" @click="copyAccountNumber()" class="btn-igari-secondary text-xs px-3.5 py-2 rounded-xl font-bold flex items-center justify-center gap-1.5 shadow-2xs self-start sm:self-center">
                                <span x-show="!copied">Salin Rekening</span>
                                <span x-show="copied" x-cloak class="text-emerald-600 font-bold">✓ Tersalin!</span>
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-500 text-center sm:text-left">
                            *Gunakan nomor rekening di atas saat melakukan transfer ATM / m-Banking.
                        </p>
                    </div>
                </div>

                <!-- Bagian Kirim Bukti Transfer / Pembayaran -->
                <div class="border-t border-rose-100 pt-4 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-gray-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Unggah Bukti Transfer / Pembayaran</span>
                        </label>
                        <span class="text-[10px] text-rose-600 font-semibold">Bisa upload sekarang / nanti</span>
                    </div>
                    <p class="text-[11px] text-gray-500">Unggah foto struk ATM, screenshot m-banking, atau bukti pembayaran e-wallet agar admin dapat langsung memverifikasi pesananmu.</p>

                    <input type="file" name="payment_proof" accept="image/*" class="hidden" x-ref="proofInput" @change="handleProofUpload($event)">

                    <!-- Preview or Upload Button -->
                    <div x-show="!proofPreview" class="border-2 border-dashed border-rose-200 rounded-2xl p-4 text-center bg-rose-50/20 hover:bg-rose-50/40 transition cursor-pointer" @click="$refs.proofInput.click()">
                        <div class="flex items-center justify-center gap-2 text-rose-700 font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            <span>Klik untuk Pilih Bukti Transfer (Foto/Screenshot)</span>
                        </div>
                        <span class="text-[10px] text-gray-400 block mt-1">Format: JPG, PNG, atau Screenshot (Maksimal 5MB)</span>
                    </div>

                    <div x-show="proofPreview" x-cloak class="flex items-center gap-3 bg-emerald-50/50 p-3 rounded-2xl border border-emerald-200">
                        <img :src="proofPreview" class="w-14 h-14 object-cover rounded-xl border border-emerald-300 shadow-2xs" alt="Bukti Transfer">
                        <div class="flex-grow min-w-0 text-xs">
                            <span class="font-bold text-emerald-800 block truncate">✓ Bukti Transfer Siap Dikirim</span>
                            <span class="text-[10px] text-emerald-600 block">Akan dikirim bersama data reservasi</span>
                        </div>
                        <button type="button" @click="removeProof()" class="text-xs text-rose-600 hover:text-rose-800 font-bold px-2 py-1">
                            Ganti
                        </button>
                    </div>
                </div>

            </div>

            <!-- Identity Guarantee Section -->
            <div x-data="identityCapture()" class="bg-white p-5 sm:p-6 rounded-3xl border border-rose-100 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-rose-50 pb-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                            <h3 class="font-serif-editorial font-bold text-gray-900 text-lg">Jaminan Identitas Penyewa</h3>
                        </div>
                        <p class="text-[11px] text-gray-500 mt-0.5">Jaminan identitas untuk penyewaan busana atelier. Unggah kartu identitas, kartu pelajar, atau foto diri.</p>
                    </div>
                    <span class="text-[10px] bg-emerald-50 text-emerald-700 font-bold px-2.5 py-1 rounded-full border border-emerald-200 whitespace-nowrap">Keamanan Terverifikasi</span>
                </div>

                <!-- Hidden inputs -->
                <input type="file" name="identity_photo" accept="image/*" class="hidden" x-ref="fileInput" @change="handleFileSelect($event)">
                <input type="hidden" name="identity_photo_data" x-ref="base64Input">

                <!-- 1. Belum ada foto & kamera tidak aktif -->
                <div x-show="!photoPreview && !cameraActive" class="space-y-3">
                    <div class="border-2 border-dashed border-rose-200 rounded-2xl p-6 text-center bg-rose-50/20">
                        <div class="w-12 h-12 mx-auto bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-800">Unggah Foto / Buka Kamera</p>
                        <p class="text-[11px] text-gray-500 max-w-xs mx-auto mt-0.5">Pilih salah satu metode di bawah ini untuk melengkapi jaminan sewa.</p>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5 mt-4">
                            <button type="button" @click="startCamera()" class="w-full sm:w-auto btn-igari-primary text-xs px-4 py-2.5 rounded-full font-bold flex items-center justify-center gap-1.5 shadow-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Buka Kamera</span>
                            </button>
                            <button type="button" @click="$refs.fileInput.click()" class="w-full sm:w-auto btn-igari-secondary text-xs px-4 py-2.5 rounded-full font-bold flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Pilih dari Galeri</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 2. Kamera sedang aktif -->
                <div x-show="cameraActive" x-cloak class="space-y-3">
                    <div class="relative bg-black rounded-2xl overflow-hidden aspect-[4/3] max-w-sm mx-auto shadow-md">
                        <video x-ref="video" autoplay playsinline class="w-full h-full object-cover"></video>
                        
                        <!-- Viewfinder overlay frame -->
                        <div class="absolute inset-4 sm:inset-6 border-2 border-dashed border-rose-300/80 rounded-xl pointer-events-none flex items-center justify-center">
                            <span class="bg-black/60 text-white text-[10px] sm:text-xs font-semibold px-3 py-1 rounded-full backdrop-blur-xs">
                                Posisikan Objek / Foto di Sini
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-3">
                        <button type="button" @click="takeSnapshot()" class="btn-igari-primary text-xs px-6 py-2.5 rounded-full font-bold flex items-center gap-1.5 shadow-md">
                            Ambil Foto
                        </button>
                        <button type="button" @click="stopCamera()" class="btn-igari-secondary text-xs px-4 py-2.5 rounded-full font-bold">
                            Batal
                        </button>
                    </div>
                </div>

                <!-- 3. Preview Foto yang sudah diambil/diupload -->
                <div x-show="photoPreview" x-cloak class="space-y-3">
                    <div class="relative bg-pink-50 rounded-2xl p-2 border border-rose-200 max-w-xs mx-auto">
                        <img :src="photoPreview" class="w-full h-44 sm:h-52 object-cover rounded-xl shadow-xs" alt="Preview Foto">
                        <div class="absolute top-4 right-4 bg-emerald-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                            ✓ Foto Terlampir
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="button" @click="removePhoto()" class="text-xs text-rose-600 hover:text-rose-800 font-bold underline">
                            Ganti / Hapus Foto
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-rose-100 shadow-xs space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Catatan Khusus Sewa (Opsional)</label>
                    <input type="text" name="notes" placeholder="Catatan ukuran, patokan alamat kurir, atau instruksi khusus..." class="w-full p-3 rounded-2xl border border-rose-200 text-xs bg-rose-50/20 outline-none">
                </div>

                <div class="pt-3 border-t border-rose-50">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="agree_terms" required class="mt-0.5 rounded text-rose-600 focus:ring-rose-400">
                        <span class="text-xs text-gray-600 leading-relaxed">
                            Saya menyetujui Syarat &amp; Ketentuan Sewa Atelier (menjaga kondisi gaun, mengembalikan sesuai jadwal, dan tidak mencuci sendiri gaun).
                        </span>
                    </label>
                </div>
            </div>

        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border-2 border-rose-300 shadow-lg space-y-4 sticky top-28">
                <h3 class="font-serif-editorial font-bold text-gray-900 text-xl border-b border-rose-100 pb-3">
                    Ringkasan Pembayaran
                </h3>

                <div class="space-y-3 text-xs text-gray-600">
                    <div class="flex justify-between">
                        <span>Gaun Pilihan:</span>
                        <span class="font-semibold text-gray-800">{{ $dress->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Durasi Sewa:</span>
                        <span class="font-bold text-gray-800">{{ $totalDays }} Hari</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Sewa:</span>
                        <span class="font-bold text-gray-800">Rp {{ number_format($rentalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Deposit Jaminan:</span>
                        <span class="font-bold text-amber-800">Rp {{ number_format($depositFee, 0, ',', '.') }}</span>
                    </div>

                    <div class="border-t border-rose-200 pt-3 flex justify-between text-base font-bold text-rose-700">
                        <span>Total Pembayaran:</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="p-3.5 bg-rose-50 rounded-2xl text-[11px] text-rose-900 leading-relaxed border border-rose-200" x-data>
                    <strong>Catatan Deposit:</strong> Uang deposit sebesar Rp {{ number_format($depositFee, 0, ',', '.') }} akan dikembalikan 100% setelah gaun diinspeksi. 
                    <button type="button" @click="$dispatch('open-fitting-guide')" class="font-bold underline text-rose-700 hover:text-rose-900 block mt-1">
                        Lihat Panduan Ukuran &amp; Ketentuan Lengkap &rarr;
                    </button>
                </div>

                <button type="submit" class="w-full btn-igari-primary py-4 rounded-full font-bold text-xs uppercase tracking-wider shadow-md text-center">
                    Lanjut ke Pembayaran &rarr;
                </button>
            </div>
        </div>

    </form>
</div>

<script>
function identityCapture() {
    return {
        photoPreview: null,
        cameraActive: false,
        stream: null,
        async startCamera() {
            try {
                this.stream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'environment', width: { ideal: 1280 }, height: { ideal: 720 } },
                    audio: false
                });
                this.$refs.video.srcObject = this.stream;
                this.cameraActive = true;
            } catch (err) {
                console.error(err);
                alert('Tidak dapat mengakses kamera. Silakan pilih foto dari galeri HP atau laptop.');
                this.$refs.fileInput.click();
            }
        },
        takeSnapshot() {
            const video = this.$refs.video;
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth || 640;
            canvas.height = video.videoHeight || 480;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
            this.photoPreview = dataUrl;
            this.$refs.base64Input.value = dataUrl;
            this.stopCamera();
        },
        stopCamera() {
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
                this.stream = null;
            }
            this.cameraActive = false;
        },
        handleFileSelect(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.photoPreview = event.target.result;
                    this.$refs.base64Input.value = '';
                };
                reader.readAsDataURL(file);
            }
        },
        removePhoto() {
            this.photoPreview = null;
            this.$refs.base64Input.value = '';
            this.$refs.fileInput.value = '';
            this.stopCamera();
        }
    };
}
</script>
@endsection
