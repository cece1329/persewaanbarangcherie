<!-- Floating Live Chat & WhatsApp Widget -->
<div x-data="{ openChat: false, activeTab: 'faq', chatInput: '', messages: [
    { sender: 'stylist', text: 'Bonjour darling! Welcome to Chérie Atelier Concierge 🎀 How may we assist your gown fitting today?' }
] }" class="fixed bottom-6 right-6 z-50">

    <!-- Floating Chat Button -->
    <button @click="openChat = !openChat" 
            class="relative bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white p-3.5 rounded-full shadow-2xl transition duration-300 transform hover:scale-105 flex items-center gap-2.5 border-2 border-white/80 group">
        
        <!-- Online Dot -->
        <span class="absolute -top-1 -right-1 flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-emerald-500 border-2 border-white"></span>
        </span>

        <!-- Bow & Chat Icon -->
        <svg class="w-6 h-6 text-white transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <span class="text-xs font-bold uppercase tracking-wider pr-1 hidden sm:inline-block">Stylist Chat</span>
    </button>

    <!-- Chat Modal Window -->
    <div x-show="openChat" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         @click.away="openChat = false"
         class="absolute bottom-16 right-0 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-rose-200 overflow-hidden flex flex-col h-[460px]">

        <!-- Chat Header -->
        <div class="bg-gradient-to-r from-slate-900 via-rose-950 to-slate-900 text-white p-4 flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=AdminCherie" class="w-10 h-10 rounded-full border-2 border-rose-300 bg-rose-50" alt="Stylist">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h3 class="font-serif-editorial font-bold text-sm text-rose-100">Chérie Atelier Concierge</h3>
                    <span class="text-[10px] text-rose-200/80 font-medium">Online &bull; Fitting & Size Stylist</span>
                </div>
            </div>
            <button @click="openChat = false" class="text-rose-200 hover:text-white font-bold text-lg p-1">&times;</button>
        </div>

        <!-- Navigation Tabs inside Chat -->
        <div class="flex border-b border-rose-100 bg-rose-50/50 text-[11px] font-bold uppercase tracking-wider">
            <button @click="activeTab = 'faq'" :class="activeTab === 'faq' ? 'border-b-2 border-rose-600 text-rose-800 bg-white' : 'text-gray-500 hover:text-gray-800'" class="flex-1 py-2.5 text-center transition">
                Fitting Assistant
            </button>
            <button @click="activeTab = 'wa'" :class="activeTab === 'wa' ? 'border-b-2 border-rose-600 text-rose-800 bg-white' : 'text-gray-500 hover:text-gray-800'" class="flex-1 py-2.5 text-center transition">
                WhatsApp CS
            </button>
        </div>

        <!-- Tab 1: Interactive FAQ & Assistant -->
        <div x-show="activeTab === 'faq'" class="flex-1 p-4 overflow-y-auto space-y-3 bg-gray-50/30 text-xs">
            <!-- Messages Loop -->
            <template x-for="(msg, idx) in messages" :key="idx">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.sender === 'user' ? 'bg-rose-600 text-white rounded-2xl rounded-tr-none px-3.5 py-2 max-w-[80%] shadow-xs' : 'bg-white text-gray-800 border border-rose-100 rounded-2xl rounded-tl-none px-3.5 py-2 max-w-[85%] shadow-xs'">
                        <p x-text="msg.text" class="leading-relaxed"></p>
                    </div>
                </div>
            </template>

            <!-- Quick Question Chips -->
            <div class="pt-2 space-y-1.5">
                <span class="text-[10px] text-gray-400 font-bold uppercase block tracking-wider">Pertanyaan Cepat:</span>
                
                <button @click="messages.push({sender:'user', text:'Bagaimana cara memilih ukuran gaun yang pas?'}); setTimeout(() => messages.push({sender:'stylist', text:'Kamu bisa mengecek panduan lingkar dada & pinggang di tombol Panduan Fitting, atau kirimkan ukurannmu ke tim kami!'}), 400)" 
                        class="w-full text-left p-2 rounded-xl bg-white border border-rose-200 text-rose-900 text-[11px] font-medium hover:bg-rose-50 transition shadow-2xs flex items-center justify-between">
                    <span>👗 Cara menentukan ukuran gaun?</span>
                    <span class="text-rose-400">&rarr;</span>
                </button>

                <button @click="messages.push({sender:'user', text:'Berapa lama jaminan deposit dikembalikan?'}); setTimeout(() => messages.push({sender:'stylist', text:'100% uang deposit langsung ditransfer balik dalam 24 jam setelah gaun selesai diinspeksi!'}), 400)" 
                        class="w-full text-left p-2 rounded-xl bg-white border border-rose-200 text-rose-900 text-[11px] font-medium hover:bg-rose-50 transition shadow-2xs flex items-center justify-between">
                    <span>💰 Jaminan & Refund Deposit?</span>
                    <span class="text-rose-400">&rarr;</span>
                </button>

                <button @click="$dispatch('open-fitting-guide')" class="w-full text-left p-2 rounded-xl bg-rose-100/80 border border-rose-300 text-rose-900 text-[11px] font-bold hover:bg-rose-200 transition flex items-center justify-between">
                    <span>📏 Buka Tabel Panduan Fitting Lengkap</span>
                    <span class="text-rose-700">&rarr;</span>
                </button>
            </div>
        </div>

        <!-- Tab 2: WhatsApp Direct Link -->
        <div x-show="activeTab === 'wa'" class="flex-1 p-6 flex flex-col items-center justify-center text-center space-y-4 bg-white">
            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl shadow-inner border border-emerald-200">
                💬
            </div>
            <div>
                <h4 class="font-serif-editorial font-bold text-gray-900 text-base">Konsultasi WhatsApp Direct</h4>
                <p class="text-xs text-gray-500 mt-1">Hubungi Personal Stylist Chérie Atelier secara langsung untuk konsultasi fitting, custom booking, &amp; pengiriman ekspres.</p>
            </div>
            <a href="https://wa.me/62895401643905?text=Halo%20Ch%C3%A9rie%20Atelier%2C%20saya%20ingin%20konsultasi%20fitting%20gaun%20persewaan." 
               target="_blank" 
               class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 rounded-2xl shadow-md transition flex items-center justify-center gap-2">
                <span>Hubungi via WhatsApp (+62 895-4016-43905)</span>
            </a>
        </div>

    </div>
</div>
