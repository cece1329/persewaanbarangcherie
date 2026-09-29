<!-- Fitting Guide & Rental Policy Modal -->
<div x-data="{ open: false }" 
     @open-fitting-guide.window="open = true" 
     x-show="open" 
     x-cloak 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true">
    
    <!-- Backdrop -->
    <div x-show="open" 
         x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" 
         @click="open = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-6">
        <div x-show="open" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-rose-200">

            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-rose-950 via-slate-900 to-rose-950 px-6 py-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-rose-300 font-serif-editorial text-lg font-bold">Chérie Atelier</span>
                    <span class="text-xs text-rose-200/60 font-medium">| Size Guide & Rental Policy</span>
                </div>
                <button @click="open = false" class="text-rose-200 hover:text-white font-bold text-xl">&times;</button>
            </div>

            <!-- Modal Content Body -->
            <div class="p-6 space-y-6 max-h-[75vh] overflow-y-auto text-xs text-gray-700">

                <!-- Section 1: Fitting Size Chart -->
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                        <h3 class="font-bold text-sm text-gray-900 uppercase tracking-wider">Tabel Ukuran & Fitting Gaun</h3>
                    </div>
                    <p class="text-gray-500 leading-relaxed">
                        Gunakan pita ukur dalam centimeter (cm) untuk mengukur Lingkar Dada (Bust), Lingkar Pinggang (Waist), dan Panjang Gaun (Length) dari bahu ke bawah.
                    </p>

                    <div class="overflow-x-auto rounded-2xl border border-gray-200">
                        <table class="w-full text-left">
                            <thead class="bg-rose-50 text-rose-900 font-bold uppercase text-[10px]">
                                <tr>
                                    <th class="p-3">Size</th>
                                    <th class="p-3">Lingkar Dada (Bust)</th>
                                    <th class="p-3">Lingkar Pinggang (Waist)</th>
                                    <th class="p-3">Panjang (Length)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-800 font-medium">
                                <tr class="hover:bg-rose-50/20">
                                    <td class="p-3 font-bold text-rose-700">XS</td>
                                    <td class="p-3">78 - 82 cm</td>
                                    <td class="p-3">60 - 64 cm</td>
                                    <td class="p-3">118 - 122 cm</td>
                                </tr>
                                <tr class="hover:bg-rose-50/20">
                                    <td class="p-3 font-bold text-rose-700">S</td>
                                    <td class="p-3">82 - 86 cm</td>
                                    <td class="p-3">64 - 68 cm</td>
                                    <td class="p-3">120 - 125 cm</td>
                                </tr>
                                <tr class="hover:bg-rose-50/20">
                                    <td class="p-3 font-bold text-rose-700">M</td>
                                    <td class="p-3">86 - 90 cm</td>
                                    <td class="p-3">68 - 72 cm</td>
                                    <td class="p-3">125 - 130 cm</td>
                                </tr>
                                <tr class="hover:bg-rose-50/20">
                                    <td class="p-3 font-bold text-rose-700">L</td>
                                    <td class="p-3">90 - 95 cm</td>
                                    <td class="p-3">72 - 76 cm</td>
                                    <td class="p-3">128 - 132 cm</td>
                                </tr>
                                <tr class="hover:bg-rose-50/20">
                                    <td class="p-3 font-bold text-rose-700">XL</td>
                                    <td class="p-3">95 - 100 cm</td>
                                    <td class="p-3">76 - 82 cm</td>
                                    <td class="p-3">130 - 135 cm</td>
                                </tr>
                                <tr class="hover:bg-rose-50/20 bg-rose-50/10">
                                    <td class="p-3 font-bold text-rose-700">Free Size</td>
                                    <td class="p-3">80 - 92 cm (Flex)</td>
                                    <td class="p-3">62 - 78 cm (Elastic)</td>
                                    <td class="p-3">125 cm</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 2: Security Deposit Terms -->
                <div class="bg-amber-50/60 p-4 rounded-2xl border border-amber-200/80 space-y-2">
                    <div class="flex items-center gap-2 text-amber-900 font-bold text-xs uppercase tracking-wider">
                        <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>Ketentuan Garansi Deposit (Security Deposit)</span>
                    </div>
                    <ul class="space-y-1.5 text-amber-950 text-[11px] list-disc list-inside">
                        <li>Setiap transaksi sewa mencakup **Uang Deposit Keamanan** (mulai dari Rp 80.000 &ndash; Rp 150.000).</li>
                        <li>Uang deposit akan **100% dikembalikan** ke rekening/QRIS penyewa maksimal 1x24 jam setelah gaun dikembalikan dan selesai diinspeksi.</li>
                        <li>Penyewa tidak dikenakan biaya tambahan apabila gaun dalam kondisi utuh tanpa kotoran permanen atau kerusakan parah.</li>
                    </ul>
                </div>

                <!-- Section 3: Fabric Care Policy -->
                <div class="space-y-2">
                    <h4 class="font-bold text-gray-900 text-xs uppercase tracking-wider">Perawatan &amp; Dry Cleaning</h4>
                    <p class="text-gray-500 leading-relaxed">
                        Semua gaun di ChérieRent disterilisasi dan di-dry clean profesional secara khusus oleh atelier sebelum dikirim. **Penyewa TIDAK perlu mencuci gaun** saat mengembalikan.
                    </p>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-right">
                <button @click="open = false" class="bg-slate-900 text-white font-bold text-xs px-5 py-2.5 rounded-xl hover:bg-slate-800 transition">
                    Mengerti &amp; Tutup
                </button>
            </div>

        </div>
    </div>
</div>
