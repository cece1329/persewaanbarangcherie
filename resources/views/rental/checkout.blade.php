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
                        <span class="text-gray-400 block uppercase font-bold text-[10px]">Start Date:</span>
                        <input type="date" name="start_date" value="{{ $startDate }}" readonly class="font-bold text-gray-800 bg-transparent outline-none mt-1">
                    </div>
                    <div>
                        <span class="text-gray-400 block uppercase font-bold text-[10px]">Return Date:</span>
                        <input type="date" name="end_date" value="{{ $endDate }}" readonly class="font-bold text-gray-800 bg-transparent outline-none mt-1">
                    </div>
                </div>

                <div class="p-3 bg-white/80 rounded-xl border border-rose-100 flex items-start gap-2.5 text-[11px] text-gray-600">
                    <span class="text-rose-500 font-bold text-sm">🚚</span>
                    <div>
                        <strong class="text-rose-900 font-semibold block">Estimasi Jadwal Pengiriman Atelier:</strong>
                        Gaun akan disiapkan dan dikirim H-2 / H-1 sebelum tanggal mulai sewa ({{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}) agar tiba tepat waktu sebelum acaramu dimulai.
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
                    <label class="p-3.5 rounded-2xl border border-rose-200 flex items-center gap-3 cursor-pointer hover:bg-rose-50 transition">
                        <input type="radio" name="payment_method" value="qris" checked class="text-rose-600">
                        <img src="{{ asset('images/payments/qris.png') }}" alt="QRIS" class="h-6 w-auto max-w-[40px] object-contain">
                        <div>
                            <span class="font-bold text-gray-800 block">QRIS</span>
                            <span class="text-[10px] text-gray-500">Instant Payment</span>
                        </div>
                    </label>
                    <label class="p-3.5 rounded-2xl border border-rose-200 flex items-center gap-3 cursor-pointer hover:bg-rose-50 transition">
                        <input type="radio" name="payment_method" value="bca" class="text-rose-600">
                        <img src="{{ asset('images/payments/bca.png') }}" alt="Bank BCA" class="h-6 w-auto max-w-[40px] object-contain">
                        <div>
                            <span class="font-bold text-gray-800 block">Bank BCA</span>
                            <span class="text-[10px] text-gray-500">Virtual Account</span>
                        </div>
                    </label>
                    <label class="p-3.5 rounded-2xl border border-rose-200 flex items-center gap-3 cursor-pointer hover:bg-rose-50 transition">
                        <input type="radio" name="payment_method" value="mandiri" class="text-rose-600">
                        <img src="{{ asset('images/payments/mandiri.png') }}" alt="Bank Mandiri" class="h-6 w-auto max-w-[40px] object-contain">
                        <div>
                            <span class="font-bold text-gray-800 block">Bank Mandiri</span>
                            <span class="text-[10px] text-gray-500">Transfer Bank</span>
                        </div>
                    </label>
                    <label class="p-3.5 rounded-2xl border border-rose-200 flex items-center gap-3 cursor-pointer hover:bg-rose-50 transition">
                        <input type="radio" name="payment_method" value="shopee_pay" class="text-rose-600">
                        <img src="{{ asset('images/payments/shopeepay.png') }}" alt="ShopeePay" class="h-6 w-auto max-w-[40px] object-contain">
                        <div>
                            <span class="font-bold text-gray-800 block">ShopeePay</span>
                            <span class="text-[10px] text-gray-500">E-Wallet Instant</span>
                        </div>
                    </label>
                    <label class="p-3.5 rounded-2xl border border-rose-200 flex items-center gap-3 cursor-pointer hover:bg-rose-50 transition">
                        <input type="radio" name="payment_method" value="dana" class="text-rose-600">
                        <img src="{{ asset('images/payments/dana.png') }}" alt="DANA" class="h-6 w-auto max-w-[40px] object-contain">
                        <div>
                            <span class="font-bold text-gray-800 block">DANA</span>
                            <span class="text-[10px] text-gray-500">E-Wallet Instant</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Identity Guarantee Section -->
            <div x-data="identityCapture()" class="bg-white p-5 sm:p-6 rounded-3xl border border-rose-100 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-rose-50 pb-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg">🪪</span>
                            <h3 class="font-serif-editorial font-bold text-gray-900 text-lg">Jaminan Identitas Penyewa</h3>
                        </div>
                        <p class="text-[11px] text-gray-500 mt-0.5">Untuk simulasi keamanan rental. Bebas foto selfie, kartu pelajar, atau gambar apa saja.</p>
                    </div>
                    <span class="text-[10px] bg-rose-50 text-rose-700 font-bold px-2.5 py-1 rounded-full border border-rose-200 whitespace-nowrap">Simulasi Tugas</span>
                </div>

                <!-- Hidden inputs -->
                <input type="file" name="identity_photo" accept="image/*" class="hidden" x-ref="fileInput" @change="handleFileSelect($event)">
                <input type="hidden" name="identity_photo_data" x-ref="base64Input">

                <!-- 1. Belum ada foto & kamera tidak aktif -->
                <div x-show="!photoPreview && !cameraActive" class="space-y-3">
                    <div class="border-2 border-dashed border-rose-200 rounded-2xl p-6 text-center bg-rose-50/20">
                        <div class="w-12 h-12 mx-auto bg-rose-100 text-rose-600 rounded-full flex items-center justify-center text-xl mb-2">
                            📷
                        </div>
                        <p class="text-xs font-bold text-gray-800">Unggah Foto / Buka Kamera</p>
                        <p class="text-[11px] text-gray-500 max-w-xs mx-auto mt-0.5">Pilih salah satu metode di bawah ini untuk melengkapi jaminan sewa.</p>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5 mt-4">
                            <button type="button" @click="startCamera()" class="w-full sm:w-auto btn-igari-primary text-xs px-4 py-2.5 rounded-full font-bold flex items-center justify-center gap-1.5 shadow-xs">
                                <span>📸</span> Buka Kamera
                            </button>
                            <button type="button" @click="$refs.fileInput.click()" class="w-full sm:w-auto btn-igari-secondary text-xs px-4 py-2.5 rounded-full font-bold flex items-center justify-center gap-1.5">
                                <span>🖼️</span> Pilih dari Galeri
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
                            <span>⚪</span> Jepret Foto
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
