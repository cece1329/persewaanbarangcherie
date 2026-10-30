@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ── Form Tambah Kategori ──────────────────────────────── --}}
    <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-xs space-y-5">
        <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3">Tambah Kategori</h3>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 text-xs rounded-xl px-4 py-3">
                ✓ {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4" id="form-kategori">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="cth: Evening Ballgown"
                       class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none focus:border-rose-300">
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi</label>
                <textarea name="description" rows="2" placeholder="Deskripsi singkat gaya ini..."
                          class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none focus:border-rose-300"></textarea>
            </div>

            {{-- ── Kustomisasi Kartu (Opsional) ─────────────── --}}
            <details class="group">
                <summary class="cursor-pointer flex items-center gap-2 text-xs font-bold text-rose-600 uppercase tracking-wider select-none">
                    <span class="w-4 h-4 rounded-full border border-rose-300 flex items-center justify-center text-[10px] group-open:rotate-90 transition-transform duration-200">▶</span>
                    Kustomisasi Tampilan Kartu
                    <span class="ml-auto text-gray-400 font-normal normal-case tracking-normal">opsional</span>
                </summary>

                <div class="mt-4 space-y-4 pl-1 border-l-2 border-rose-100">

                    {{-- Preview kartu mini --}}
                    <div class="mb-3">
                        <p class="text-[10px] text-gray-500 mb-2 uppercase tracking-wider font-semibold">Preview Kartu</p>
                        <div id="card-preview"
                             class="rounded-xl border p-3 transition-all duration-300"
                             style="background:#fff0f4; border-color:#f9bec7;">
                            <span id="prev-label"
                                  class="inline-block text-[8px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full border"
                                  style="color:#e05269; background:#ffe4ec; border-color:#f9bec7;">
                                Collection
                            </span>
                            <p id="prev-name" class="font-bold text-sm mt-1" style="color:#9f1239;">Nama Kategori</p>
                            <p id="prev-quote" class="text-[10px] italic mt-0.5" style="color:#e05269; opacity:0.7;">♡ Chérie Style</p>
                            <div id="prev-deco" class="mt-1 text-base opacity-30"></div>
                        </div>
                    </div>

                    {{-- Pilih palet warna jadi (preset) --}}
                    <div>
                        <p class="text-[10px] text-gray-600 font-bold uppercase tracking-wider mb-2">Palet Warna Cepat</p>
                        <div class="flex flex-wrap gap-2">
                            @php
                            $presets = [
                                ['label' => 'Pink (default)', 'bg' => '#fff0f4', 'border' => '#f9bec7', 'accent' => '#e05269', 'text' => '#9f1239', 'tagbg' => '#ffe4ec'],
                                ['label' => 'Lavender',      'bg' => '#f9f0ff', 'border' => '#d8c7f5', 'accent' => '#7c3aed', 'text' => '#4c1d95', 'tagbg' => '#ede8ff'],
                                ['label' => 'Peach',         'bg' => '#fff7f0', 'border' => '#f5c6a0', 'accent' => '#c2410c', 'text' => '#7c2d12', 'tagbg' => '#fde8d8'],
                                ['label' => 'Sky Blue',      'bg' => '#f0f4ff', 'border' => '#b0c4e8', 'accent' => '#1e40af', 'text' => '#1e3a8a', 'tagbg' => '#e0e8f9'],
                                ['label' => 'Sage Green',    'bg' => '#f0fdf4', 'border' => '#86efac', 'accent' => '#15803d', 'text' => '#14532d', 'tagbg' => '#dcfce7'],
                                ['label' => 'Rose Mauve',    'bg' => '#fdf2f8', 'border' => '#f0abcf', 'accent' => '#be185d', 'text' => '#831843', 'tagbg' => '#fce7f3'],
                                ['label' => 'Champagne',     'bg' => '#fffbf0', 'border' => '#fcd34d', 'accent' => '#b45309', 'text' => '#78350f', 'tagbg' => '#fef3c7'],
                                ['label' => 'Dusty Rose',    'bg' => '#fdf4f5', 'border' => '#f2c4ce', 'accent' => '#be3a5a', 'text' => '#7f1d1d', 'tagbg' => '#fce8ec'],
                            ];
                            @endphp
                            @foreach($presets as $preset)
                                <button type="button"
                                        class="preset-btn w-7 h-7 rounded-full border-2 border-white shadow hover:scale-110 transition-transform duration-150 ring-1 ring-gray-200"
                                        style="background: {{ $preset['bg'] }}; box-shadow: inset 0 0 0 3px {{ $preset['border'] }};"
                                        title="{{ $preset['label'] }}"
                                        data-bg="{{ $preset['bg'] }}"
                                        data-border="{{ $preset['border'] }}"
                                        data-accent="{{ $preset['accent'] }}"
                                        data-text="{{ $preset['text'] }}"
                                        data-tagbg="{{ $preset['tagbg'] }}">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Atau custom warna sendiri --}}
                    <div>
                        <p class="text-[10px] text-gray-600 font-bold uppercase tracking-wider mb-2">Atau Atur Manual</p>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[9px] text-gray-500 uppercase tracking-wider block mb-0.5">Background</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" id="pick-bg" value="#fff0f4"
                                           class="w-7 h-7 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                    <input type="text" name="card_bg" id="inp-bg" value=""
                                           placeholder="#fff0f4" maxlength="20"
                                           class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                                </div>
                            </div>
                            <div>
                                <label class="text-[9px] text-gray-500 uppercase tracking-wider block mb-0.5">Border</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" id="pick-border" value="#f9bec7"
                                           class="w-7 h-7 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                    <input type="text" name="card_border" id="inp-border" value=""
                                           placeholder="#f9bec7" maxlength="20"
                                           class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                                </div>
                            </div>
                            <div>
                                <label class="text-[9px] text-gray-500 uppercase tracking-wider block mb-0.5">Aksen</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" id="pick-accent" value="#e05269"
                                           class="w-7 h-7 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                    <input type="text" name="card_accent" id="inp-accent" value=""
                                           placeholder="#e05269" maxlength="20"
                                           class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                                </div>
                            </div>
                            <div>
                                <label class="text-[9px] text-gray-500 uppercase tracking-wider block mb-0.5">Teks Judul</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" id="pick-text" value="#9f1239"
                                           class="w-7 h-7 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                    <input type="text" name="card_text" id="inp-text" value=""
                                           placeholder="#9f1239" maxlength="20"
                                           class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label class="text-[9px] text-gray-500 uppercase tracking-wider block mb-0.5">Background Tag</label>
                                <div class="flex items-center gap-1.5">
                                    <input type="color" id="pick-tagbg" value="#ffe4ec"
                                           class="w-7 h-7 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                    <input type="text" name="card_tagbg" id="inp-tagbg" value=""
                                           placeholder="#ffe4ec" maxlength="20"
                                           class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Label era & tagline --}}
                    <div>
                        <label class="text-[10px] text-gray-600 font-bold uppercase tracking-wider block mb-1">Label Era</label>
                        <input type="text" name="card_label" id="inp-label"
                               placeholder="cth: Era 1837–1901" maxlength="100"
                               class="w-full p-2.5 rounded-xl border border-gray-200 text-xs bg-gray-50/50 outline-none focus:border-rose-300">
                    </div>
                    <div>
                        <label class="text-[10px] text-gray-600 font-bold uppercase tracking-wider block mb-1">Tagline / Quote</label>
                        <input type="text" name="card_quote" id="inp-quote"
                               placeholder="cth: Elegantia et Gloria" maxlength="150"
                               class="w-full p-2.5 rounded-xl border border-gray-200 text-xs bg-gray-50/50 outline-none focus:border-rose-300">
                    </div>

                    {{-- Pilih elemen dekorasi --}}
                    <div>
                        <p class="text-[10px] text-gray-600 font-bold uppercase tracking-wider mb-2">Elemen Dekoratif</p>
                        <input type="hidden" name="card_decoration" id="inp-deco" value="">
                        <div class="grid grid-cols-4 gap-2">
                            @php
                            $decoOptions = [
                                ''          => ['emoji' => '—',  'label' => 'Tanpa Deko'],
                                'rose'      => ['emoji' => '🌹', 'label' => 'Mawar'],
                                'cherry'    => ['emoji' => '🍒', 'label' => 'Ceri'],
                                'strawberry'=> ['emoji' => '🍓', 'label' => 'Stroberi'],
                                'butterfly' => ['emoji' => '🦋', 'label' => 'Kupu-kupu'],
                                'leaf'      => ['emoji' => '🌿', 'label' => 'Daun'],
                                'star'      => ['emoji' => '✨', 'label' => 'Bintang'],
                                'crown'     => ['emoji' => '👑', 'label' => 'Mahkota'],
                                'ribbon'    => ['emoji' => '🎀', 'label' => 'Pita'],
                                'diamond'   => ['emoji' => '💎', 'label' => 'Diamond'],
                                'moon'      => ['emoji' => '🌙', 'label' => 'Bulan'],
                                'heart'     => ['emoji' => '🩷', 'label' => 'Hati'],
                            ];
                            @endphp
                            @foreach($decoOptions as $decoKey => $deco)
                                <button type="button"
                                        class="deco-btn flex flex-col items-center justify-center gap-1 p-2 rounded-xl border border-gray-200 hover:border-rose-300 hover:bg-rose-50 transition-all duration-150 text-center"
                                        data-deco="{{ $decoKey }}"
                                        title="{{ $deco['label'] }}">
                                    <span class="text-lg leading-none">{{ $deco['emoji'] }}</span>
                                    <span class="text-[8px] text-gray-500 truncate w-full text-center">{{ $deco['label'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Reset ke default --}}
                    <button type="button" id="btn-reset-style"
                            class="text-[10px] text-gray-400 hover:text-rose-500 underline transition-colors">
                        Reset ke tampilan default
                    </button>

                </div>
            </details>

            <button type="submit"
                    class="w-full btn-igari-primary py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-md">
                Tambah Kategori
            </button>
        </form>
    </div>

    {{-- ── Daftar Kategori ──────────────────────────────────── --}}
    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-200 shadow-xs p-6 space-y-4">
        <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3">Kategori Terdaftar</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Slug</th>
                        <th class="p-3">Deskripsi</th>
                        <th class="p-3">Tampilan Kartu</th>
                        <th class="p-3 text-center">Gaun</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($categories as $category)
                        @php $s = $category->cardStyle(); @endphp
                        <tr>
                            <td class="p-3 font-bold text-gray-900">{{ $category->name }}</td>
                            <td class="p-3 font-mono text-gray-500 text-[11px]">{{ $category->slug }}</td>
                            <td class="p-3 text-gray-600 max-w-xs truncate">{{ $category->description ?? '—' }}</td>
                            <td class="p-3">
                                {{-- Mini preview warna kartu --}}
                                <div class="flex items-center gap-1.5">
                                    <div class="w-5 h-5 rounded-full border"
                                         style="background:{{ $s['bg'] }}; border-color:{{ $s['border'] }};"
                                         title="BG: {{ $s['bg'] }}"></div>
                                    <div class="w-5 h-5 rounded-full border-2"
                                         style="background:{{ $s['accent'] }}; border-color:{{ $s['accent'] }};"
                                         title="Aksen: {{ $s['accent'] }}"></div>
                                    @if($category->card_decoration)
                                        <span class="text-sm" title="{{ $category->card_decoration }}">
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
                                            {{ $decoEmoji[$category->card_decoration] ?? '' }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-[10px]">—</span>
                                    @endif
                                    @if(!$category->card_bg)
                                        <span class="text-[9px] text-gray-400 italic">default</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-3 text-center">
                                <span class="bg-rose-50 text-rose-700 border border-rose-200 font-bold px-2.5 py-1 rounded-full text-[10px]">
                                    {{ $category->dresses_count }} Pieces
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
(function () {
    const defaults = {
        bg: '#fff0f4', border: '#f9bec7', accent: '#e05269',
        text: '#9f1239', tagbg: '#ffe4ec'
    };

    // Elemen DOM
    const pickBg     = document.getElementById('pick-bg');
    const pickBorder = document.getElementById('pick-border');
    const pickAccent = document.getElementById('pick-accent');
    const pickText   = document.getElementById('pick-text');
    const pickTagbg  = document.getElementById('pick-tagbg');

    const inpBg     = document.getElementById('inp-bg');
    const inpBorder = document.getElementById('inp-border');
    const inpAccent = document.getElementById('inp-accent');
    const inpText   = document.getElementById('inp-text');
    const inpTagbg  = document.getElementById('inp-tagbg');
    const inpLabel  = document.getElementById('inp-label');
    const inpQuote  = document.getElementById('inp-quote');
    const inpDeco   = document.getElementById('inp-deco');

    const prevCard   = document.getElementById('card-preview');
    const prevLabel  = document.getElementById('prev-label');
    const prevName   = document.getElementById('prev-name');
    const prevQuote  = document.getElementById('prev-quote');
    const prevDeco   = document.getElementById('prev-deco');

    function updatePreview() {
        const bg     = inpBg.value    || defaults.bg;
        const border = inpBorder.value || defaults.border;
        const accent = inpAccent.value || defaults.accent;
        const text   = inpText.value   || defaults.text;
        const tagbg  = inpTagbg.value  || defaults.tagbg;
        const label  = inpLabel.value  || 'Collection';
        const quote  = inpQuote.value  || '♡ Chérie Style';

        prevCard.style.background   = bg;
        prevCard.style.borderColor  = border;
        prevLabel.style.color       = accent;
        prevLabel.style.background  = tagbg;
        prevLabel.style.borderColor = border;
        prevLabel.textContent       = label;
        prevName.style.color        = text;
        prevQuote.style.color       = accent;
        prevQuote.textContent       = quote;
    }

    // Sync color picker ↔ text input
    function bindColorPair(picker, input) {
        picker.addEventListener('input', () => {
            input.value = picker.value;
            updatePreview();
        });
        input.addEventListener('input', () => {
            if (/^#[0-9a-fA-F]{6}$/.test(input.value)) {
                picker.value = input.value;
            }
            updatePreview();
        });
    }

    bindColorPair(pickBg,     inpBg);
    bindColorPair(pickBorder, inpBorder);
    bindColorPair(pickAccent, inpAccent);
    bindColorPair(pickText,   inpText);
    bindColorPair(pickTagbg,  inpTagbg);

    inpLabel.addEventListener('input', updatePreview);
    inpQuote.addEventListener('input', updatePreview);

    // Preset palette buttons
    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const setBoth = (picker, input, val) => {
                picker.value = val;
                input.value  = val;
            };
            setBoth(pickBg,     inpBg,     btn.dataset.bg);
            setBoth(pickBorder, inpBorder, btn.dataset.border);
            setBoth(pickAccent, inpAccent, btn.dataset.accent);
            setBoth(pickText,   inpText,   btn.dataset.text);
            setBoth(pickTagbg,  inpTagbg,  btn.dataset.tagbg);
            updatePreview();

            // Visual feedback tombol aktif
            document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('ring-2', 'ring-rose-400'));
            btn.classList.add('ring-2', 'ring-rose-400');
        });
    });

    // Deco buttons
    const decoEmoji = {
        '': '—', rose: '🌹', cherry: '🍒', strawberry: '🍓',
        butterfly: '🦋', leaf: '🌿', star: '✨', crown: '👑',
        ribbon: '🎀', diamond: '💎', moon: '🌙', heart: '🩷'
    };

    document.querySelectorAll('.deco-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            inpDeco.value    = btn.dataset.deco;
            prevDeco.textContent = decoEmoji[btn.dataset.deco] || '';

            document.querySelectorAll('.deco-btn').forEach(b => {
                b.classList.remove('ring-2', 'ring-rose-400', 'bg-rose-50', 'border-rose-300');
            });
            btn.classList.add('ring-2', 'ring-rose-400', 'bg-rose-50', 'border-rose-300');
        });
    });

    // Reset
    document.getElementById('btn-reset-style').addEventListener('click', () => {
        [inpBg, inpBorder, inpAccent, inpText, inpTagbg, inpLabel, inpQuote].forEach(el => el.value = '');
        [pickBg, pickBorder, pickAccent, pickText, pickTagbg].forEach((p, i) => {
            const vals = [defaults.bg, defaults.border, defaults.accent, defaults.text, defaults.tagbg];
            p.value = vals[i];
        });
        inpDeco.value = '';
        prevDeco.textContent = '';
        document.querySelectorAll('.deco-btn, .preset-btn').forEach(b =>
            b.classList.remove('ring-2', 'ring-rose-400', 'bg-rose-50', 'border-rose-300'));
        updatePreview();
    });

    // Sync nama kategori → preview
    document.querySelector('[name="name"]').addEventListener('input', function () {
        prevName.textContent = this.value || 'Nama Kategori';
    });

    updatePreview();
})();
</script>
@endpush
@endsection
