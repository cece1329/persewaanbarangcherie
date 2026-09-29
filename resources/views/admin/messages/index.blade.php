@extends('layouts.admin')

@section('title', 'Pesan Masuk — Inbox Klien')

@section('content')
<div class="space-y-6" x-data="{ openId: null }">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-serif-editorial font-bold text-2xl text-gray-900">Pesan Masuk</h2>
            <p class="text-xs text-gray-500 mt-0.5">
                {{ $unreadCount > 0 ? $unreadCount . ' pesan belum dibaca' : 'Semua pesan sudah dibaca' }}
                &mdash; rentcherie@gmail.com
            </p>
        </div>

        {{-- Filter --}}
        <form method="GET" action="{{ route('admin.messages.index') }}" class="flex items-center gap-2">
            <select name="status" onchange="this.form.submit()"
                class="text-xs border border-gray-200 rounded-xl px-3 py-2 bg-white text-gray-700 font-semibold focus:ring-2 focus:ring-rose-300 outline-none">
                <option value="">Semua Pesan</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                <option value="unreplied" {{ request('status') === 'unreplied' ? 'selected' : '' }}>Belum Dibalas</option>
                <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Sudah Dibalas</option>
            </select>
        </form>
    </div>

    {{-- Messages List --}}
    <div class="space-y-3">
        @forelse($messages as $msg)
            <div class="bg-white rounded-2xl border {{ !$msg->is_read ? 'border-rose-300 shadow-rose-100 shadow-md' : 'border-gray-200' }} overflow-hidden transition-all">

                {{-- Message Header (clickable) --}}
                <div @click="openId = (openId === {{ $msg->id }}) ? null : {{ $msg->id }}"
                    class="flex items-start gap-4 p-5 cursor-pointer hover:bg-gray-50 transition group">

                    {{-- Avatar --}}
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-400 to-pink-300 flex items-center justify-center text-white font-bold text-sm shrink-0 uppercase">
                        {{ substr($msg->name, 0, 1) }}
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-sm text-gray-900">{{ $msg->name }}</span>
                            @if(!$msg->is_read)
                                <span class="bg-rose-100 text-rose-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-rose-200">Baru</span>
                            @endif
                            @if($msg->admin_reply)
                                <span class="bg-emerald-100 text-emerald-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-emerald-200">Sudah Dibalas</span>
                            @else
                                <span class="bg-amber-100 text-amber-700 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-amber-200">Belum Dibalas</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $msg->email }}{{ $msg->phone ? ' · ' . $msg->phone : '' }}</p>
                        <p class="text-sm font-semibold text-gray-800 mt-1 truncate">{{ $msg->subject }}</p>
                    </div>

                    <div class="text-right shrink-0">
                        <span class="text-[10px] text-gray-400 block">{{ $msg->created_at->format('d M Y') }}</span>
                        <span class="text-[10px] text-gray-400 block">{{ $msg->created_at->format('H:i') }}</span>
                        <svg class="w-4 h-4 text-gray-400 mt-2 ml-auto transition-transform group-hover:text-rose-500"
                            :class="{ 'rotate-180': openId === {{ $msg->id }} }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- Expanded Detail + Reply Form --}}
                <div x-show="openId === {{ $msg->id }}"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="border-t border-gray-100">

                    {{-- Customer Message --}}
                    <div class="p-5 bg-gray-50/60">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-2">Pesan dari Klien</p>
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                    </div>

                    {{-- Auto Reply Preview --}}
                    <div class="px-5 py-3 bg-rose-50/60 border-t border-rose-100">
                        <p class="text-[10px] text-rose-600 font-bold uppercase tracking-wider mb-1">Pesan Balasan Otomatis (terkirim)</p>
                        <p class="text-xs text-rose-700/80 leading-relaxed">
                            Halo <strong>{{ $msg->name }}</strong>, terima kasih telah menghubungi Atelier ChérieRent! 🌸<br>
                            Kami telah menerima pesan Anda mengenai "<em>{{ $msg->subject }}</em>".<br>
                            Tim Atelier Concierge kami akan segera menghubungi Anda dalam 1x24 jam melalui email ini.<br><br>
                            Salam hangat,<br>
                            <strong>Tim ChérieRent</strong> — rentcherie@gmail.com
                        </p>
                    </div>

                    {{-- Admin Reply (if exists) --}}
                    @if($msg->admin_reply)
                        <div class="px-5 py-3 bg-emerald-50/60 border-t border-emerald-100">
                            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider mb-1">
                                Balasan Admin — {{ $msg->replied_at?->format('d M Y H:i') }}
                            </p>
                            <p class="text-sm text-emerald-900 leading-relaxed whitespace-pre-line">{{ $msg->admin_reply }}</p>
                        </div>
                    @endif

                    {{-- Reply Form --}}
                    <div class="p-5 border-t border-gray-100 space-y-3">
                        <p class="text-xs font-bold text-gray-700">{{ $msg->admin_reply ? 'Kirim Balasan Baru' : 'Balas Pesan Ini' }}</p>

                        <form action="{{ route('admin.messages.reply', $msg->id) }}" method="POST" class="space-y-3">
                            @csrf

                            {{-- Auto-fill template --}}
                            <div class="flex gap-2 flex-wrap">
                                <button type="button"
                                    onclick="fillReply({{ $msg->id }}, `Halo {{ $msg->name }}, terima kasih atas pesannya! Kami senang bisa membantu. Silahkan hubungi kami kembali jika ada pertanyaan lain. Salam hangat, Tim ChérieRent.`)"
                                    class="text-[10px] font-bold px-3 py-1 rounded-lg border border-rose-200 text-rose-700 bg-rose-50 hover:bg-rose-100 transition">
                                    ✨ Template Ramah
                                </button>
                                <button type="button"
                                    onclick="fillReply({{ $msg->id }}, `Halo {{ $msg->name }}, terima kasih telah menghubungi kami. Gaun yang Anda minati saat ini tersedia. Silahkan lanjutkan proses pemesanan melalui website kami. Salam, Tim ChérieRent.`)"
                                    class="text-[10px] font-bold px-3 py-1 rounded-lg border border-rose-200 text-rose-700 bg-rose-50 hover:bg-rose-100 transition">
                                    👗 Template Ketersediaan
                                </button>
                            </div>

                            <textarea id="reply-{{ $msg->id }}" name="admin_reply" rows="4" required
                                placeholder="Ketik balasan Anda di sini... balasan ini akan ditampilkan sebagai respons admin."
                                class="w-full text-sm border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rose-300 outline-none resize-none text-gray-700 bg-white placeholder-gray-400">{{ $msg->admin_reply ?? '' }}</textarea>

                            <div class="flex items-center gap-3">
                                <button type="submit"
                                    class="bg-rose-700 hover:bg-rose-600 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-sm flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Kirim Balasan
                                </button>

                                @if(!$msg->is_read)
                                    <form action="{{ route('admin.messages.read', $msg->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-gray-500 hover:text-gray-700 font-semibold transition">
                                            Tandai Sudah Dibaca
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-200 p-16 text-center">
                <div class="text-4xl mb-3">💌</div>
                <p class="text-sm font-bold text-gray-700">Belum ada pesan masuk</p>
                <p class="text-xs text-gray-400 mt-1">Pesan dari klien akan muncul di sini</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($messages->hasPages())
        <div class="pt-4">
            {{ $messages->links() }}
        </div>
    @endif

</div>

<script>
function fillReply(id, text) {
    const textarea = document.getElementById('reply-' + id);
    if (textarea) {
        textarea.value = text;
        textarea.focus();
    }
}
</script>
@endsection
