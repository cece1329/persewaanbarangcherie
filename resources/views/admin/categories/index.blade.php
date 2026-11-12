@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div x-data="categoryEditor()" class="space-y-8">

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
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($categories as $category)
                            @php $s = $category->cardStyle(); @endphp
                            <tr class="hover:bg-rose-50/20 transition">
                                <td class="p-3 font-bold text-gray-900">{{ $category->name }}</td>
                                <td class="p-3 font-mono text-gray-500 text-[11px]">{{ $category->slug }}</td>
                                <td class="p-3 text-gray-600 max-w-xs truncate">{{ $category->description ?? '—' }}</td>
                                <td class="p-3">
                                    {{-- Mini preview warna kartu --}}
                                    <div class="flex items-center gap-1.5">
                                        <div class="w-5 h-5 rounded-full border shadow-2xs"
                                             style="background:{{ $s['bg'] }}; border-color:{{ $s['border'] }};"
                                             title="BG: {{ $s['bg'] }}"></div>
                                        <div class="w-5 h-5 rounded-full border-2 shadow-2xs"
                                             style="background:{{ $s['accent'] }}; border-color:{{ $s['accent'] }};"
                                             title="Aksen: {{ $s['accent'] }}"></div>
                                        @if($category->card_decoration)
                                            <span class="text-sm" title="{{ $category->card_decoration }}">
                                                {{ $decoOptions[$category->card_decoration]['emoji'] ?? '' }}
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
                                <td class="p-3 text-center">
                                    <button type="button"
                                            @click="openEditModal({{ json_encode([
                                                'id'              => $category->id,
                                                'name'            => $category->name,
                                                'description'     => $category->description ?? '',
                                                'card_bg'         => $category->card_bg ?? '',
                                                'card_border'     => $category->card_border ?? '',
                                                'card_accent'     => $category->card_accent ?? '',
                                                'card_text'       => $category->card_text ?? '',
                                                'card_tagbg'      => $category->card_tagbg ?? '',
                                                'card_label'      => $category->card_label ?? '',
                                                'card_quote'      => $category->card_quote ?? '',
                                                'card_decoration' => $category->card_decoration ?? '',
                                                'update_url'      => route('admin.categories.update', $category->id),
                                            ]) }})"
                                            class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-rose-600 text-white font-bold text-[11px] transition shadow-xs inline-flex items-center gap-1.5 whitespace-nowrap">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        <span>Edit Tampilan</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ── MODAL EDIT TAMPILAN & DATA KATEGORI ───────────────────── --}}
    <div x-show="isEditOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6"
         style="display: none;">

        <div @click.away="closeEditModal()"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="bg-white rounded-3xl border border-gray-200 shadow-2xl w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

            {{-- Modal Header --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-rose-50/40">
                <div class="flex items-center gap-2">
                    <span class="text-rose-600 text-lg">✨</span>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">Edit Tampilan & Data Kategori</h3>
                        <p class="text-[11px] text-gray-500">Sesuaikan nama, deskripsi, palet warna, dan elemen visual kartu</p>
                    </div>
                </div>
                <button type="button" @click="closeEditModal()" class="text-gray-400 hover:text-gray-700 p-2 rounded-xl hover:bg-gray-100 transition focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Modal Body Form --}}
            <form :action="editForm.update_url" method="POST" class="p-6 space-y-5 overflow-y-auto flex-1 text-xs">
                @csrf
                @method('PUT')

                {{-- Live Preview Card --}}
                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block mb-2">Live Preview Kartu Kategori</span>
                    <div class="rounded-2xl border p-4 transition-all duration-300 shadow-xs max-w-sm mx-auto text-center"
                         :style="'background:' + (editForm.card_bg || '#fff0f4') + '; border-color:' + (editForm.card_border || '#f9bec7') + ';'">
                        <span class="inline-block text-[9px] font-bold uppercase tracking-widest px-2.5 py-0.5 rounded-full border"
                              :style="'color:' + (editForm.card_accent || '#e05269') + '; background:' + (editForm.card_tagbg || '#ffe4ec') + '; border-color:' + (editForm.card_border || '#f9bec7') + ';'"
                              x-text="editForm.card_label || 'Collection'"></span>
                        <p class="font-serif-editorial font-bold text-lg mt-1.5"
                           :style="'color:' + (editForm.card_text || '#9f1239') + ';'"
                           x-text="editForm.name || 'Nama Kategori'"></p>
                        <p class="text-[11px] italic mt-0.5"
                           :style="'color:' + (editForm.card_accent || '#e05269') + '; opacity: 0.8;'"
                           x-text="editForm.card_quote || '♡ Chérie Style'"></p>
                        <div class="mt-2 text-2xl" x-text="decoEmoji[editForm.card_decoration] || ''"></div>
                    </div>
                </div>

                {{-- Nama & Deskripsi --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" x-model="editForm.name" required
                               class="w-full p-2.5 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none focus:border-rose-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi</label>
                        <input type="text" name="description" x-model="editForm.description" placeholder="Deskripsi singkat..."
                               class="w-full p-2.5 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none focus:border-rose-400">
                    </div>
                </div>

                {{-- Presets Warna Cepat --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Palet Preset Cepat</label>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="p in presets" :key="p.label">
                            <button type="button"
                                    @click="applyPreset(p)"
                                    class="w-8 h-8 rounded-full border-2 border-white shadow hover:scale-110 transition-transform ring-1 ring-gray-200"
                                    :style="'background:' + p.bg + '; box-shadow: inset 0 0 0 3px ' + p.border + ';'"
                                    :title="p.label">
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Atur Warna Manual --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Atur Warna Manual</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div>
                            <span class="text-[9px] text-gray-500 uppercase font-semibold block mb-1">Background</span>
                            <div class="flex items-center gap-1.5">
                                <input type="color" x-model="editForm.card_bg" class="w-8 h-8 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                <input type="text" name="card_bg" x-model="editForm.card_bg" placeholder="#fff0f4" class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                            </div>
                        </div>
                        <div>
                            <span class="text-[9px] text-gray-500 uppercase font-semibold block mb-1">Border</span>
                            <div class="flex items-center gap-1.5">
                                <input type="color" x-model="editForm.card_border" class="w-8 h-8 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                <input type="text" name="card_border" x-model="editForm.card_border" placeholder="#f9bec7" class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                            </div>
                        </div>
                        <div>
                            <span class="text-[9px] text-gray-500 uppercase font-semibold block mb-1">Aksen</span>
                            <div class="flex items-center gap-1.5">
                                <input type="color" x-model="editForm.card_accent" class="w-8 h-8 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                <input type="text" name="card_accent" x-model="editForm.card_accent" placeholder="#e05269" class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                            </div>
                        </div>
                        <div>
                            <span class="text-[9px] text-gray-500 uppercase font-semibold block mb-1">Teks Judul</span>
                            <div class="flex items-center gap-1.5">
                                <input type="color" x-model="editForm.card_text" class="w-8 h-8 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                <input type="text" name="card_text" x-model="editForm.card_text" placeholder="#9f1239" class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                            </div>
                        </div>
                        <div>
                            <span class="text-[9px] text-gray-500 uppercase font-semibold block mb-1">Background Tag</span>
                            <div class="flex items-center gap-1.5">
                                <input type="color" x-model="editForm.card_tagbg" class="w-8 h-8 rounded-lg border border-gray-200 cursor-pointer p-0.5">
                                <input type="text" name="card_tagbg" x-model="editForm.card_tagbg" placeholder="#ffe4ec" class="flex-1 p-1.5 rounded-lg border border-gray-200 text-[10px] font-mono outline-none w-0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Label Era & Quote --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1">Label Tag / Era</label>
                        <input type="text" name="card_label" x-model="editForm.card_label" placeholder="cth: Era 1837–1901" maxlength="100"
                               class="w-full p-2.5 rounded-xl border border-gray-200 text-xs bg-gray-50/50 outline-none focus:border-rose-300">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider mb-1">Tagline / Quote</label>
                        <input type="text" name="card_quote" x-model="editForm.card_quote" placeholder="cth: Elegantia et Gloria" maxlength="150"
                               class="w-full p-2.5 rounded-xl border border-gray-200 text-xs bg-gray-50/50 outline-none focus:border-rose-300">
                    </div>
                </div>

                {{-- Elemen Dekorasi --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-[10px] font-bold text-gray-600 uppercase tracking-wider">Elemen Dekoratif</label>
                        <button type="button" @click="resetToDefault()" class="text-[10px] text-rose-600 hover:underline">
                            Reset Default Pink
                        </button>
                    </div>
                    <input type="hidden" name="card_decoration" :value="editForm.card_decoration">
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                        <template x-for="(label, key) in decoLabels" :key="key">
                            <button type="button"
                                    @click="editForm.card_decoration = key"
                                    class="flex flex-col items-center justify-center gap-1 p-2 rounded-xl border transition text-center"
                                    :class="editForm.card_decoration === key ? 'border-rose-400 bg-rose-50 ring-2 ring-rose-400 font-bold text-rose-700' : 'border-gray-200 hover:border-rose-200 hover:bg-rose-50/30'">
                                <span class="text-base" x-text="decoEmoji[key] || '—'"></span>
                                <span class="text-[8px] truncate w-full text-center" x-text="label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <button type="button" @click="closeEditModal()" class="px-5 py-2.5 rounded-xl border border-gray-300 font-bold text-gray-700 hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="submit" class="btn-igari-primary px-6 py-2.5 rounded-xl font-bold uppercase tracking-wider shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
function categoryEditor() {
    return {
        isEditOpen: false,
        editForm: {
            id: null,
            name: '',
            description: '',
            card_bg: '',
            card_border: '',
            card_accent: '',
            card_text: '',
            card_tagbg: '',
            card_label: '',
            card_quote: '',
            card_decoration: '',
            update_url: '',
        },
        presets: [
            { label: 'Pink (default)', bg: '#fff0f4', border: '#f9bec7', accent: '#e05269', text: '#9f1239', tagbg: '#ffe4ec' },
            { label: 'Lavender',      bg: '#f9f0ff', border: '#d8c7f5', accent: '#7c3aed', text: '#4c1d95', tagbg: '#ede8ff' },
            { label: 'Peach',         bg: '#fff7f0', border: '#f5c6a0', accent: '#c2410c', text: '#7c2d12', tagbg: '#fde8d8' },
            { label: 'Sky Blue',      bg: '#f0f4ff', border: '#b0c4e8', accent: '#1e40af', text: '#1e3a8a', tagbg: '#e0e8f9' },
            { label: 'Sage Green',    bg: '#f0fdf4', border: '#86efac', accent: '#15803d', text: '#14532d', tagbg: '#dcfce7' },
            { label: 'Rose Mauve',    bg: '#fdf2f8', border: '#f0abcf', accent: '#be185d', text: '#831843', tagbg: '#fce7f3' },
            { label: 'Champagne',     bg: '#fffbf0', border: '#fcd34d', accent: '#b45309', text: '#78350f', tagbg: '#fef3c7' },
            { label: 'Dusty Rose',    bg: '#fdf4f5', border: '#f2c4ce', accent: '#be3a5a', text: '#7f1d1d', tagbg: '#fce8ec' },
        ],
        decoEmoji: {
            '': '—', rose: '🌹', cherry: '🍒', strawberry: '🍓',
            butterfly: '🦋', leaf: '🌿', star: '✨', crown: '👑',
            ribbon: '🎀', diamond: '💎', moon: '🌙', heart: '🩷'
        },
        decoLabels: {
            '': 'Tanpa Deko',
            'rose': 'Mawar',
            'cherry': 'Ceri',
            'strawberry': 'Stroberi',
            'butterfly': 'Kupu-kupu',
            'leaf': 'Daun',
            'star': 'Bintang',
            'crown': 'Mahkota',
            'ribbon': 'Pita',
            'diamond': 'Diamond',
            'moon': 'Bulan',
            'heart': 'Hati',
        },
        openEditModal(cat) {
            this.editForm = {
                id: cat.id,
                name: cat.name || '',
                description: cat.description || '',
                card_bg: cat.card_bg || '#fff0f4',
                card_border: cat.card_border || '#f9bec7',
                card_accent: cat.card_accent || '#e05269',
                card_text: cat.card_text || '#9f1239',
                card_tagbg: cat.card_tagbg || '#ffe4ec',
                card_label: cat.card_label || '',
                card_quote: cat.card_quote || '',
                card_decoration: cat.card_decoration || '',
                update_url: cat.update_url,
            };
            this.isEditOpen = true;
        },
        closeEditModal() {
            this.isEditOpen = false;
        },
        applyPreset(preset) {
            this.editForm.card_bg = preset.bg;
            this.editForm.card_border = preset.border;
            this.editForm.card_accent = preset.accent;
            this.editForm.card_text = preset.text;
            this.editForm.card_tagbg = preset.tagbg;
        },
        resetToDefault() {
            this.editForm.card_bg = '#fff0f4';
            this.editForm.card_border = '#f9bec7';
            this.editForm.card_accent = '#e05269';
            this.editForm.card_text = '#9f1239';
            this.editForm.card_tagbg = '#ffe4ec';
            this.editForm.card_label = '';
            this.editForm.card_quote = '';
            this.editForm.card_decoration = '';
        }
    };
}

(function () {
    const defaults = {
        bg: '#fff0f4', border: '#f9bec7', accent: '#e05269',
        text: '#9f1239', tagbg: '#ffe4ec'
    };

    // Elemen DOM form tambah
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

    if (!prevCard) return;

    function updatePreview() {
        const bg     = inpBg.value     || defaults.bg;
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

    function bindColorPair(picker, input) {
        if (!picker || !input) return;
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

    if (inpLabel) inpLabel.addEventListener('input', updatePreview);
    if (inpQuote) inpQuote.addEventListener('input', updatePreview);

    document.querySelectorAll('.preset-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const setBoth = (picker, input, val) => {
                if (picker) picker.value = val;
                if (input) input.value  = val;
            };
            setBoth(pickBg,     inpBg,     btn.dataset.bg);
            setBoth(pickBorder, inpBorder, btn.dataset.border);
            setBoth(pickAccent, inpAccent, btn.dataset.accent);
            setBoth(pickText,   inpText,   btn.dataset.text);
            setBoth(pickTagbg,  inpTagbg,  btn.dataset.tagbg);
            updatePreview();

            document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('ring-2', 'ring-rose-400'));
            btn.classList.add('ring-2', 'ring-rose-400');
        });
    });

    const decoEmoji = {
        '': '—', rose: '🌹', cherry: '🍒', strawberry: '🍓',
        butterfly: '🦋', leaf: '🌿', star: '✨', crown: '👑',
        ribbon: '🎀', diamond: '💎', moon: '🌙', heart: '🩷'
    };

    document.querySelectorAll('.deco-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (inpDeco) inpDeco.value = btn.dataset.deco;
            if (prevDeco) prevDeco.textContent = decoEmoji[btn.dataset.deco] || '';

            document.querySelectorAll('.deco-btn').forEach(b => {
                b.classList.remove('ring-2', 'ring-rose-400', 'bg-rose-50', 'border-rose-300');
            });
            btn.classList.add('ring-2', 'ring-rose-400', 'bg-rose-50', 'border-rose-300');
        });
    });

    const btnReset = document.getElementById('btn-reset-style');
    if (btnReset) {
        btnReset.addEventListener('click', () => {
            [inpBg, inpBorder, inpAccent, inpText, inpTagbg, inpLabel, inpQuote].forEach(el => { if (el) el.value = ''; });
            [pickBg, pickBorder, pickAccent, pickText, pickTagbg].forEach((p, i) => {
                const vals = [defaults.bg, defaults.border, defaults.accent, defaults.text, defaults.tagbg];
                if (p) p.value = vals[i];
            });
            if (inpDeco) inpDeco.value = '';
            if (prevDeco) prevDeco.textContent = '';
            document.querySelectorAll('.deco-btn, .preset-btn').forEach(b =>
                b.classList.remove('ring-2', 'ring-rose-400', 'bg-rose-50', 'border-rose-300'));
            updatePreview();
        });
    }

    const nameInput = document.querySelector('[name="name"]');
    if (nameInput) {
        nameInput.addEventListener('input', function () {
            if (prevName) prevName.textContent = this.value || 'Nama Kategori';
        });
    }

    updatePreview();
})();
</script>
@endpush
@endsection
