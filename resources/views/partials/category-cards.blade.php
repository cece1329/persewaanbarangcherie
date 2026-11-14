{{--
    Kartu Kategori — Soft Pastel Style
    Warna & elemen dekoratif diambil dari database (field card_* di tabel categories).
    Admin bisa atur lewat portal admin → Kelola Kategori.
    Kalau admin tidak mengisi, otomatis pakai warna pink rose default yang cantik.

    Dekorasi emoji yang tersedia:
    rose, cherry, strawberry, butterfly, leaf, star, crown, ribbon, diamond, moon, heart
--}}

@php
$decoEmoji = [
    'rose'       => '🌹',
    'cherry'     => '🍒',
    'strawberry' => '🍓',
    'butterfly'  => '🦋',
    'leaf'       => '🌿',
    'star'       => '✨',
    'crown'      => '👑',
    'ribbon'     => '🎀',
    'diamond'    => '💎',
    'moon'       => '🌙',
    'heart'      => '🩷',
];
@endphp

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($categories as $category)
        @php
            $s = $category->cardStyle();
            $deco = isset($decoEmoji[$s['decoration']]) ? $decoEmoji[$s['decoration']] : '';
        @endphp

        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
           id="cat-{{ $category->slug }}"
           class="group relative rounded-2xl overflow-hidden border transition-all duration-400 hover:-translate-y-1 hover:shadow-lg block"
           style="background: {{ $s['bg'] }}; border-color: {{ $s['border'] }}; min-height: 200px;">

            {{-- Dekorasi emoji watermark (kalau ada) --}}
            @if($deco)
                <div class="absolute bottom-3 right-3 text-5xl opacity-10 group-hover:opacity-20 group-hover:scale-110 transition-all duration-500 select-none pointer-events-none leading-none">
                    {{ $deco }}
                </div>
            @endif

            {{-- Content --}}
            <div class="relative z-10 p-5 flex flex-col h-full" style="min-height: 200px;">

                {{-- Label era --}}
                <span class="inline-block self-start text-[8px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full border mb-3"
                      style="color: {{ $s['accent'] }}; background: {{ $s['tagBg'] }}; border-color: {{ $s['border'] }};">
                    {{ $s['label'] }}
                </span>

                {{-- Nama kategori --}}
                <h3 class="font-serif-editorial font-bold text-lg leading-tight"
                    style="color: {{ $s['text'] }};">
                    {{ $category->name }}
                </h3>

                {{-- Quote / tagline --}}
                <p class="text-[10px] mt-1 font-light italic" style="color: {{ $s['accent'] }}; opacity: 0.7;">
                    {{ $s['quote'] }}
                </p>

                {{-- Deskripsi: muncul saat hover --}}
                <p class="text-[10px] leading-relaxed mt-2 opacity-0 max-h-0 overflow-hidden group-hover:opacity-70 group-hover:max-h-16 transition-all duration-500"
                   style="color: {{ $s['text'] }};">
                    {{ $category->description }}
                </p>

                <div class="flex-1"></div>

                {{-- Divider + jumlah gaun --}}
                <div class="h-px mt-3 mb-2" style="background: {{ $s['border'] }};"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold" style="color: {{ $s['text'] }};">
                        {{ $category->dresses_count }}
                        <span class="font-normal" style="opacity: 0.5;">pieces</span>
                    </span>
                    <span class="w-6 h-6 rounded-full flex items-center justify-center border group-hover:scale-110 transition-transform duration-300"
                          style="background: {{ $s['tagBg'] }}; border-color: {{ $s['border'] }};">
                        <svg class="w-2.5 h-2.5 group-hover:translate-x-px group-hover:-translate-y-px transition-transform duration-300"
                             fill="none" stroke="{{ $s['accent'] }}" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 17L17 7M7 7h10v10"/>
                        </svg>
                    </span>
                </div>
            </div>
        </a>
    @endforeach
</div>
