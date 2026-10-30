{{--
    Category Cards — Soft Pastel Style
    Setiap kategori punya warna & elemen dekoratif unik.
    Kalau admin tambah kategori baru, otomatis pakai fallback pink rose yang cantik.

    Kalau mau tambah gambar elemen per kategori:
    → Taruh file PNG/SVG di: public/images/categories/{slug}.png
    → Contoh: public/images/categories/victorian.png
    Gambar otomatis tampil kalau file-nya ada.
--}}

@php
$categoryStyles = [
    'victorian' => [
        'bg'      => '#f9f0ff',
        'border'  => '#d8c7f5',
        'accent'  => '#7c3aed',
        'text'    => '#4c1d95',
        'tagBg'   => '#ede8ff',
        'tags'    => ['Corset', 'Lace', 'Voluminous', 'Royal'],
        'label'   => 'Era 1837–1901',
        'quote'   => 'Elegantia et Gloria',
    ],
    'vintage' => [
        'bg'      => '#fff7f0',
        'border'  => '#f5c6a0',
        'accent'  => '#c2410c',
        'text'    => '#7c2d12',
        'tagBg'   => '#fde8d8',
        'tags'    => ['Retro', 'Film', 'Nostalgia', 'Classic'],
        'label'   => 'Era 1920–1960',
        'quote'   => 'Timeless Nostalgia',
    ],
    'pirate' => [
        'bg'      => '#f0f4ff',
        'border'  => '#b0c4e8',
        'accent'  => '#1e40af',
        'text'    => '#1e3a8a',
        'tagBg'   => '#e0e8f9',
        'tags'    => ['Ruffles', 'Corset', 'Off-Shoulder', 'Drama'],
        'label'   => 'Golden Age of Sail',
        'quote'   => 'Sail & Corset',
    ],
    'igari' => [
        'bg'      => '#fff0f4',
        'border'  => '#f9bec7',
        'accent'  => '#e05269',
        'text'    => '#9f1239',
        'tagBg'   => '#ffe4ec',
        'tags'    => ['Blush', 'Ribbons', 'Coquette', 'Dreamy'],
        'label'   => 'Japanese Coquette',
        'quote'   => '🍓 Sweet & Dreamy',
    ],
    'mori-kei' => [
        'bg'      => '#f0fdf4',
        'border'  => '#86efac',
        'accent'  => '#15803d',
        'text'    => '#14532d',
        'tagBg'   => '#dcfce7',
        'tags'    => ['Botanical', 'Layers', 'Earthy', 'Forest'],
        'label'   => 'Forest Girl',
        'quote'   => '🌿 Nature & Layers',
    ],
    'modern' => [
        'bg'      => '#fdf2f8',
        'border'  => '#f0abcf',
        'accent'  => '#be185d',
        'text'    => '#831843',
        'tagBg'   => '#fce7f3',
        'tags'    => ['Minimalist', 'Sleek', 'Chic', 'Editorial'],
        'label'   => '2020s Contemporary',
        'quote'   => 'Less is More',
    ],
    'elegant' => [
        'bg'      => '#fffbf0',
        'border'  => '#fcd34d',
        'accent'  => '#b45309',
        'text'    => '#78350f',
        'tagBg'   => '#fef3c7',
        'tags'    => ['Satin', 'Couture', 'Gala', 'Luxurious'],
        'label'   => 'Haute Couture',
        'quote'   => '✦ Luxe & Satin',
    ],
];

// Fallback untuk kategori baru yang belum di-define di atas
$defaultStyle = [
    'bg'      => '#fff0f4',
    'border'  => '#f9bec7',
    'accent'  => '#e05269',
    'text'    => '#9f1239',
    'tagBg'   => '#ffe4ec',
    'tags'    => [],
    'label'   => 'Collection',
    'quote'   => '♡ Chérie Style',
];
@endphp

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($categories as $category)
        @php
            $s = $categoryStyles[$category->slug] ?? $defaultStyle;
            // Cek apakah ada gambar custom di public/images/categories/
            $imgPath = 'images/categories/' . $category->slug . '.png';
            $hasImage = file_exists(public_path($imgPath));
        @endphp

        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
           id="cat-{{ $category->slug }}"
           class="group relative rounded-2xl overflow-hidden border transition-all duration-400 hover:-translate-y-1 hover:shadow-lg block"
           style="background: {{ $s['bg'] }}; border-color: {{ $s['border'] }}; min-height: 200px;">

            {{-- Decorative element image (kalau ada file PNG di public/images/categories/) --}}
            @if($hasImage)
                <img src="{{ asset($imgPath) }}" alt=""
                     class="absolute bottom-2 right-2 w-20 h-20 object-contain opacity-20 group-hover:opacity-30 group-hover:scale-110 transition-all duration-500 pointer-events-none select-none" />
            @endif

            {{-- Content --}}
            <div class="relative z-10 p-5 flex flex-col h-full" style="min-height: 200px;">

                {{-- Era label --}}
                <span class="inline-block self-start text-[8px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full border mb-3"
                      style="color: {{ $s['accent'] }}; background: {{ $s['tagBg'] }}; border-color: {{ $s['border'] }};">
                    {{ $s['label'] }}
                </span>

                {{-- Category name --}}
                <h3 class="font-serif-editorial font-bold text-lg leading-tight"
                    style="color: {{ $s['text'] }};">
                    {{ $category->name }}
                </h3>

                {{-- Quote / tagline (italic, soft) --}}
                <p class="text-[10px] mt-1 font-light italic" style="color: {{ $s['accent'] }}; opacity: 0.7;">
                    {{ $s['quote'] }}
                </p>

                {{-- Description: tampil samar, hover jadi jelas --}}
                <p class="text-[10px] leading-relaxed mt-2 opacity-0 max-h-0 overflow-hidden group-hover:opacity-70 group-hover:max-h-16 transition-all duration-500"
                   style="color: {{ $s['text'] }};">
                    {{ $category->description }}
                </p>

                {{-- Spacer --}}
                <div class="flex-1"></div>

                {{-- Tags --}}
                @if(!empty($s['tags']))
                    <div class="flex flex-wrap gap-1 mt-3 mb-2">
                        @foreach($s['tags'] as $tag)
                            <span class="text-[8px] font-semibold uppercase tracking-wider px-1.5 py-px rounded-full border"
                                  style="color: {{ $s['accent'] }}; background: {{ $s['tagBg'] }}; border-color: {{ $s['border'] }};">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Divider + count --}}
                <div class="h-px mt-1 mb-2" style="background: {{ $s['border'] }};"></div>
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
