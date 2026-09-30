@extends('layouts.app')

@section('content')

    {{-- ═══════════════════════════════════════ --}}
    {{-- HERO BANNER --}}
    {{-- ═══════════════════════════════════════ --}}
    <section
        class="relative overflow-hidden igari-bg-gradient py-20 lg:py-28 px-4 sm:px-6 lg:px-8 border-b border-rose-200/80">

        {{-- Decorative floating petals (CSS-animated) --}}
        <div aria-hidden="true" class="coquette-petals-bg absolute inset-0 pointer-events-none overflow-hidden">
            <svg class="petal petal-1" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="20" cy="20" rx="10" ry="18" fill="#f9bec7" fill-opacity="0.55" transform="rotate(20 20 20)" />
            </svg>
            <svg class="petal petal-2" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="20" cy="20" rx="8" ry="16" fill="#fce4ec" fill-opacity="0.6" transform="rotate(-15 20 20)" />
            </svg>
            <svg class="petal petal-3" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="20" cy="20" rx="10" ry="18" fill="#f48fb1" fill-opacity="0.35" transform="rotate(35 20 20)" />
            </svg>
            <svg class="petal petal-4" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="20" cy="20" rx="8" ry="15" fill="#ffd6e0" fill-opacity="0.5" transform="rotate(-30 20 20)" />
            </svg>
            <svg class="petal petal-5" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="20" cy="20" rx="9" ry="17" fill="#f9bec7" fill-opacity="0.4" transform="rotate(50 20 20)" />
            </svg>
            <svg class="petal petal-6" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="20" cy="20" rx="7" ry="14" fill="#fce4ec" fill-opacity="0.5" transform="rotate(-45 20 20)" />
            </svg>
        </div>

        {{-- ✿ Coquette Border Frame with Corner Roses --}}
        <div aria-hidden="true" class="absolute inset-4 sm:inset-6 lg:inset-8 pointer-events-none hidden sm:block"
            style="border: 1.5px solid rgba(224,82,105,0.22); border-radius: 28px;">
            {{-- Dashed inner frame --}}
            <div class="absolute inset-2" style="border: 1px dashed rgba(224,82,105,0.15); border-radius: 22px;"></div>

            {{-- ✿ Top-Left Rose --}}
            <div class="absolute -top-5 -left-5">
                <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- outer petals -->
                    <ellipse cx="26" cy="14" rx="5" ry="9" fill="#f9bec7" opacity="0.85" />
                    <ellipse cx="26" cy="38" rx="5" ry="9" fill="#f9bec7" opacity="0.85" />
                    <ellipse cx="14" cy="26" rx="9" ry="5" fill="#f9bec7" opacity="0.85" />
                    <ellipse cx="38" cy="26" rx="9" ry="5" fill="#f9bec7" opacity="0.85" />
                    <ellipse cx="17" cy="17" rx="5" ry="8" fill="#f8c8d4" opacity="0.75" transform="rotate(45 17 17)" />
                    <ellipse cx="35" cy="17" rx="5" ry="8" fill="#f8c8d4" opacity="0.75" transform="rotate(-45 35 17)" />
                    <ellipse cx="17" cy="35" rx="5" ry="8" fill="#f8c8d4" opacity="0.75" transform="rotate(-45 17 35)" />
                    <ellipse cx="35" cy="35" rx="5" ry="8" fill="#f8c8d4" opacity="0.75" transform="rotate(45 35 35)" />
                    <!-- inner petals -->
                    <ellipse cx="26" cy="19" rx="4" ry="6" fill="#f1a7b2" opacity="0.9" />
                    <ellipse cx="26" cy="33" rx="4" ry="6" fill="#f1a7b2" opacity="0.9" />
                    <ellipse cx="19" cy="26" rx="6" ry="4" fill="#f1a7b2" opacity="0.9" />
                    <ellipse cx="33" cy="26" rx="6" ry="4" fill="#f1a7b2" opacity="0.9" />
                    <!-- center -->
                    <circle cx="26" cy="26" r="6" fill="#e05269" />
                    <circle cx="26" cy="26" r="3.5" fill="#c8374d" />
                    <circle cx="24.5" cy="24.5" r="1" fill="#f9bec7" opacity="0.8" />
                    <!-- stem leaves -->
                    <path d="M26 32 Q20 40 14 44" stroke="#c8a4a8" stroke-width="1.2" fill="none" opacity="0.5" />
                    <ellipse cx="17" cy="42" rx="4" ry="2.5" fill="#d4a0a8" opacity="0.4" transform="rotate(-30 17 42)" />
                </svg>
            </div>

            {{-- ✿ Top-Right Rose --}}
            <div class="absolute -top-5 -right-5">
                <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="26" cy="14" rx="5" ry="9" fill="#fcd5df" opacity="0.85" />
                    <ellipse cx="26" cy="38" rx="5" ry="9" fill="#fcd5df" opacity="0.85" />
                    <ellipse cx="14" cy="26" rx="9" ry="5" fill="#fcd5df" opacity="0.85" />
                    <ellipse cx="38" cy="26" rx="9" ry="5" fill="#fcd5df" opacity="0.85" />
                    <ellipse cx="17" cy="17" rx="5" ry="8" fill="#f9bec7" opacity="0.75" transform="rotate(45 17 17)" />
                    <ellipse cx="35" cy="17" rx="5" ry="8" fill="#f9bec7" opacity="0.75" transform="rotate(-45 35 17)" />
                    <ellipse cx="17" cy="35" rx="5" ry="8" fill="#f9bec7" opacity="0.75" transform="rotate(-45 17 35)" />
                    <ellipse cx="35" cy="35" rx="5" ry="8" fill="#f9bec7" opacity="0.75" transform="rotate(45 35 35)" />
                    <ellipse cx="26" cy="19" rx="4" ry="6" fill="#f48fb1" opacity="0.9" />
                    <ellipse cx="26" cy="33" rx="4" ry="6" fill="#f48fb1" opacity="0.9" />
                    <ellipse cx="19" cy="26" rx="6" ry="4" fill="#f48fb1" opacity="0.9" />
                    <ellipse cx="33" cy="26" rx="6" ry="4" fill="#f48fb1" opacity="0.9" />
                    <circle cx="26" cy="26" r="6" fill="#d1435a" />
                    <circle cx="26" cy="26" r="3.5" fill="#b82d43" />
                    <circle cx="24.5" cy="24.5" r="1" fill="#fce4ec" opacity="0.8" />
                    <path d="M26 32 Q32 40 38 44" stroke="#c8a4a8" stroke-width="1.2" fill="none" opacity="0.5" />
                    <ellipse cx="35" cy="42" rx="4" ry="2.5" fill="#d4a0a8" opacity="0.4" transform="rotate(30 35 42)" />
                </svg>
            </div>

            {{-- ✿ Bottom-Left Rose --}}
            <div class="absolute -bottom-5 -left-5">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"
                    opacity="0.7">
                    <ellipse cx="24" cy="13" rx="4.5" ry="8" fill="#fcd5df" opacity="0.85" />
                    <ellipse cx="24" cy="35" rx="4.5" ry="8" fill="#fcd5df" opacity="0.85" />
                    <ellipse cx="13" cy="24" rx="8" ry="4.5" fill="#fcd5df" opacity="0.85" />
                    <ellipse cx="35" cy="24" rx="8" ry="4.5" fill="#fcd5df" opacity="0.85" />
                    <ellipse cx="16" cy="16" rx="4.5" ry="7" fill="#f9bec7" opacity="0.75" transform="rotate(45 16 16)" />
                    <ellipse cx="32" cy="16" rx="4.5" ry="7" fill="#f9bec7" opacity="0.75" transform="rotate(-45 32 16)" />
                    <ellipse cx="16" cy="32" rx="4.5" ry="7" fill="#f9bec7" opacity="0.75" transform="rotate(-45 16 32)" />
                    <ellipse cx="32" cy="32" rx="4.5" ry="7" fill="#f9bec7" opacity="0.75" transform="rotate(45 32 32)" />
                    <ellipse cx="24" cy="18" rx="3.5" ry="5.5" fill="#f1a7b2" opacity="0.9" />
                    <ellipse cx="24" cy="30" rx="3.5" ry="5.5" fill="#f1a7b2" opacity="0.9" />
                    <ellipse cx="18" cy="24" rx="5.5" ry="3.5" fill="#f1a7b2" opacity="0.9" />
                    <ellipse cx="30" cy="24" rx="5.5" ry="3.5" fill="#f1a7b2" opacity="0.9" />
                    <circle cx="24" cy="24" r="5.5" fill="#e05269" />
                    <circle cx="24" cy="24" r="3" fill="#c8374d" />
                    <circle cx="22.5" cy="22.5" r="0.8" fill="#fce4ec" opacity="0.8" />
                </svg>
            </div>

            {{-- ✿ Bottom-Right Rose --}}
            <div class="absolute -bottom-5 -right-5">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"
                    opacity="0.7">
                    <ellipse cx="24" cy="13" rx="4.5" ry="8" fill="#f9bec7" opacity="0.85" />
                    <ellipse cx="24" cy="35" rx="4.5" ry="8" fill="#f9bec7" opacity="0.85" />
                    <ellipse cx="13" cy="24" rx="8" ry="4.5" fill="#f9bec7" opacity="0.85" />
                    <ellipse cx="35" cy="24" rx="8" ry="4.5" fill="#f9bec7" opacity="0.85" />
                    <ellipse cx="16" cy="16" rx="4.5" ry="7" fill="#fce4ec" opacity="0.75" transform="rotate(45 16 16)" />
                    <ellipse cx="32" cy="16" rx="4.5" ry="7" fill="#fce4ec" opacity="0.75" transform="rotate(-45 32 16)" />
                    <ellipse cx="16" cy="32" rx="4.5" ry="7" fill="#fce4ec" opacity="0.75" transform="rotate(-45 16 32)" />
                    <ellipse cx="32" cy="32" rx="4.5" ry="7" fill="#fce4ec" opacity="0.75" transform="rotate(45 32 32)" />
                    <ellipse cx="24" cy="18" rx="3.5" ry="5.5" fill="#f48fb1" opacity="0.9" />
                    <ellipse cx="24" cy="30" rx="3.5" ry="5.5" fill="#f48fb1" opacity="0.9" />
                    <ellipse cx="18" cy="24" rx="5.5" ry="3.5" fill="#f48fb1" opacity="0.9" />
                    <ellipse cx="30" cy="24" rx="5.5" ry="3.5" fill="#f48fb1" opacity="0.9" />
                    <circle cx="24" cy="24" r="5.5" fill="#d1435a" />
                    <circle cx="24" cy="24" r="3" fill="#b82d43" />
                    <circle cx="22.5" cy="22.5" r="0.8" fill="#fce4ec" opacity="0.8" />
                </svg>
            </div>

            {{-- Mid-side mini roses (left & right edge) --}}
            <div class="absolute -left-4 top-1/2 -translate-y-1/2 hidden xl:block">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" opacity="0.6">
                    <ellipse cx="16" cy="8" rx="3" ry="6" fill="#f9bec7" />
                    <ellipse cx="16" cy="24" rx="3" ry="6" fill="#f9bec7" />
                    <ellipse cx="8" cy="16" rx="6" ry="3" fill="#f9bec7" />
                    <ellipse cx="24" cy="16" rx="6" ry="3" fill="#f9bec7" />
                    <ellipse cx="11" cy="11" rx="3" ry="5" fill="#f1a7b2" opacity="0.8" transform="rotate(45 11 11)" />
                    <ellipse cx="21" cy="11" rx="3" ry="5" fill="#f1a7b2" opacity="0.8" transform="rotate(-45 21 11)" />
                    <ellipse cx="11" cy="21" rx="3" ry="5" fill="#f1a7b2" opacity="0.8" transform="rotate(-45 11 21)" />
                    <ellipse cx="21" cy="21" rx="3" ry="5" fill="#f1a7b2" opacity="0.8" transform="rotate(45 21 21)" />
                    <circle cx="16" cy="16" r="4" fill="#e05269" />
                    <circle cx="16" cy="16" r="2" fill="#c8374d" />
                </svg>
            </div>
            <div class="absolute -right-4 top-1/2 -translate-y-1/2 hidden xl:block">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" opacity="0.6">
                    <ellipse cx="16" cy="8" rx="3" ry="6" fill="#fcd5df" />
                    <ellipse cx="16" cy="24" rx="3" ry="6" fill="#fcd5df" />
                    <ellipse cx="8" cy="16" rx="6" ry="3" fill="#fcd5df" />
                    <ellipse cx="24" cy="16" rx="6" ry="3" fill="#fcd5df" />
                    <ellipse cx="11" cy="11" rx="3" ry="5" fill="#f48fb1" opacity="0.8" transform="rotate(45 11 11)" />
                    <ellipse cx="21" cy="11" rx="3" ry="5" fill="#f48fb1" opacity="0.8" transform="rotate(-45 21 11)" />
                    <ellipse cx="11" cy="21" rx="3" ry="5" fill="#f48fb1" opacity="0.8" transform="rotate(-45 11 21)" />
                    <ellipse cx="21" cy="21" rx="3" ry="5" fill="#f48fb1" opacity="0.8" transform="rotate(45 21 21)" />
                    <circle cx="16" cy="16" r="4" fill="#d1435a" />
                    <circle cx="16" cy="16" r="2" fill="#b82d43" />
                </svg>
            </div>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">

            {{-- Left Hero Text --}}
            <div class="space-y-6 text-center lg:text-left">

                {{-- Decorative label with bow --}}
                <div class="flex items-center gap-3 justify-center lg:justify-start">
                    <span class="coquette-bow-label">
                        <svg width="16" height="10" viewBox="0 0 16 10" fill="none" class="inline-block mr-1">
                            <path d="M8 5 C6 2 1 1 1 5 C1 9 6 8 8 5Z" fill="#c8374d" opacity="0.7" />
                            <path d="M8 5 C10 2 15 1 15 5 C15 9 10 8 8 5Z" fill="#c8374d" opacity="0.7" />
                            <circle cx="8" cy="5" r="1.5" fill="#c8374d" />
                        </svg>
                        Coquette Atelier
                    </span>
                    <span class="coquette-bow-label">Est. 2024</span>
                </div>

                <h1 class="font-serif-editorial text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight text-gray-900">
                    Curated Gowns &amp; Haute Couture for Your <span class="text-gradient-rose">Milestone Moments</span>
                </h1>

                <p class="text-base text-gray-700 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Discover an exclusive archive of <strong>Vintage Coquette, French Lace, Fairytale Tulle, and Botanical
                        Chiffon</strong> gowns for senior portraits, galas, and private celebrations.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('catalog.index') }}"
                        class="btn-igari-primary px-8 py-3.5 rounded-full text-xs font-bold uppercase tracking-wider text-center w-full sm:w-auto shadow-lg">
                        Explore Gown Archive &rarr;
                    </a>
                    <a href="#quiz-section"
                        class="btn-igari-secondary px-6 py-3.5 rounded-full text-xs font-bold uppercase tracking-wider text-center w-full sm:w-auto">
                        Style Matcher Quiz
                    </a>
                </div>

                {{-- Trust Badges --}}
                <div class="grid grid-cols-3 gap-6 pt-6 border-t border-rose-200/60 max-w-lg mx-auto lg:mx-0">
                    <div class="text-center lg:text-left">
                        <p class="font-serif-editorial font-bold text-2xl text-rose-700">100%</p>
                        <p class="text-xs text-gray-600">Sanitized &amp; Cared</p>
                    </div>
                    <div class="text-center lg:text-left">
                        <p class="font-serif-editorial font-bold text-2xl text-rose-700">4.9</p>
                        <p class="text-xs text-gray-600">Client Rating</p>
                    </div>
                    <div class="text-center lg:text-left">
                        <p class="font-serif-editorial font-bold text-2xl text-rose-700">Instant</p>
                        <p class="text-xs text-gray-600">Deposit Return</p>
                    </div>
                </div>
            </div>

            {{-- Right Hero Visual --}}
            <div class="relative">
                {{-- Decorative lace ring behind card --}}
                <div aria-hidden="true"
                    class="absolute -top-4 -right-4 w-full h-full border-2 border-rose-200/50 rounded-3xl border-dashed pointer-events-none">
                </div>

                <div class="igari-card p-4 rounded-3xl relative z-10 max-w-md mx-auto shadow-xl">
                    <div class="relative overflow-hidden rounded-2xl aspect-[4/5] bg-pink-100">
                        <img src="{{ asset('images/web/header.jpg') }}"
                            class="w-full h-full object-cover hover:scale-105 transition duration-700" alt="Featured Gown">

                        <div class="absolute top-4 right-4 igari-pill">Archive Highlight</div>

                        <div
                            class="absolute bottom-4 left-4 right-4 bg-white/90 backdrop-blur-md p-4 rounded-2xl border border-rose-200 shadow-md">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="font-serif-editorial font-bold text-gray-900 text-lg">Chérie Corset Silk Gown
                                </h3>
                                <span
                                    class="text-[10px] bg-rose-50 text-rose-700 font-bold px-2.5 py-0.5 rounded-full border border-rose-200">Size
                                    S</span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">French Satin Silk &amp; Lace Detailing</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-gray-400 block uppercase font-bold">Daily Rate</span>
                                    <span class="font-bold text-rose-700 text-base">Rp 175.000</span>
                                </div>
                                <a href="{{ route('catalog.index') }}"
                                    class="btn-igari-primary text-xs px-4 py-2 rounded-full">View Details &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════ --}}
    {{-- LACE DIVIDER --}}
    {{-- ═══════════════════════════════════════ --}}
    <div aria-hidden="true" class="lace-divider-wrapper">
        <svg class="lace-divider" viewBox="0 0 1440 40" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,20 C120,40 240,0 360,20 C480,40 600,0 720,20 C840,40 960,0 1080,20 C1200,40 1320,0 1440,20"
                stroke="#f8cfd4" stroke-width="2" fill="none" />
            <path d="M0,28 C120,48 240,8 360,28 C480,48 600,8 720,28 C840,48 960,8 1080,28 C1200,48 1320,8 1440,28"
                stroke="#f8cfd4" stroke-width="1" fill="none" opacity="0.5" />
        </svg>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- CATEGORIES SHOWCASE --}}
    {{-- ═══════════════════════════════════════ --}}
    <section class="py-16 px-4 max-w-7xl mx-auto relative">

        {{-- Decorative floral corner --}}
        <div aria-hidden="true" class="absolute top-8 left-0 opacity-10 pointer-events-none hidden md:block">
            <svg width="120" height="120" viewBox="0 0 120 120" fill="none">
                <circle cx="60" cy="60" r="25" stroke="#c8374d" stroke-width="1.5" fill="none" stroke-dasharray="4 6" />
                <circle cx="60" cy="60" r="40" stroke="#c8374d" stroke-width="1" fill="none" stroke-dasharray="2 8" />
                <path d="M60 20 Q70 40 60 60 Q50 40 60 20Z" fill="#e05269" opacity="0.4" />
                <path d="M100 60 Q80 70 60 60 Q80 50 100 60Z" fill="#e05269" opacity="0.4" />
                <path d="M60 100 Q50 80 60 60 Q70 80 60 100Z" fill="#e05269" opacity="0.4" />
                <path d="M20 60 Q40 50 60 60 Q40 70 20 60Z" fill="#e05269" opacity="0.4" />
            </svg>
        </div>

        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="coquette-ornament-line mb-4">
                <svg width="200" height="16" viewBox="0 0 200 16" fill="none" aria-hidden="true">
                    <line x1="0" y1="8" x2="70" y2="8" stroke="#f1a7b2" stroke-width="1.5" />
                    <circle cx="84" cy="8" r="3" fill="#e05269" />
                    <circle cx="100" cy="8" r="5" fill="#e05269" />
                    <circle cx="116" cy="8" r="3" fill="#e05269" />
                    <line x1="130" y1="8" x2="200" y2="8" stroke="#f1a7b2" stroke-width="1.5" />
                </svg>
            </div>
            <span class="igari-pill">Curated Collections</span>
            <h2 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-gray-900 mt-3">Explore By Silhouette &amp;
                Theme</h2>
            <p class="text-sm text-gray-500 mt-2 font-light italic">Tailored for portrait archives, formal evenings, and
                editorial concepts.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                    class="igari-card p-5 rounded-3xl text-center group hover:border-rose-300 transition igari-card-hover relative overflow-hidden">
                    {{-- Background petal on hover --}}
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-rose-50/0 to-rose-50/60 opacity-0 group-hover:opacity-100 transition duration-300 rounded-3xl">
                    </div>
                    <div class="relative z-10">
                        {{-- Category icon using first letter with floral frame --}}
                        <div
                            class="w-14 h-14 bg-rose-50 group-hover:bg-rose-600 text-rose-600 group-hover:text-white rounded-full flex items-center justify-center font-serif-editorial font-bold text-2xl mx-auto mb-3 transition duration-300 border-2 border-rose-200 group-hover:border-rose-600 shadow-sm">
                            {{ strtoupper(substr($category->name, 0, 1)) }}
                        </div>
                        <h3
                            class="font-serif-editorial font-semibold text-gray-900 group-hover:text-rose-700 transition text-sm leading-tight">
                            {{ $category->name }}
                        </h3>
                        <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $category->dresses_count }} Pieces</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════ --}}
    {{-- BOW DIVIDER --}}
    {{-- ═══════════════════════════════════════ --}}
    <div aria-hidden="true" class="flex items-center justify-center gap-4 py-2 px-4">
        <div class="flex-1 h-px bg-gradient-to-r from-transparent to-rose-200 max-w-xs"></div>
        <svg width="48" height="28" viewBox="0 0 48 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 14 C18 6 2 2 2 14 C2 26 18 22 24 14Z" fill="#f9bec7" stroke="#e05269" stroke-width="1" />
            <path d="M24 14 C30 6 46 2 46 14 C46 26 30 22 24 14Z" fill="#f9bec7" stroke="#e05269" stroke-width="1" />
            <circle cx="24" cy="14" r="4" fill="#e05269" />
            <circle cx="24" cy="14" r="2" fill="#fff0f3" />
        </svg>
        <div class="flex-1 h-px bg-gradient-to-l from-transparent to-rose-200 max-w-xs"></div>
    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- FEATURED DRESSES GRID --}}
    {{-- ═══════════════════════════════════════ --}}
    <section class="py-14 px-4 border-t border-b border-rose-100 relative"
        style="background: linear-gradient(180deg,#fff 0%,#fff5f7 100%);">

        {{-- Subtle dot pattern overlay --}}
        <div aria-hidden="true" class="absolute inset-0 pointer-events-none opacity-30"
            style="background-image: radial-gradient(circle, #f1a7b2 1px, transparent 1px); background-size: 28px 28px;">
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        {{-- Mini bow --}}
                        <svg width="18" height="11" viewBox="0 0 18 11" fill="none">
                            <path d="M9 5.5C7 2 1 1 1 5.5C1 10 7 9 9 5.5Z" fill="#e05269" opacity="0.6" />
                            <path d="M9 5.5C11 2 17 1 17 5.5C17 10 11 9 9 5.5Z" fill="#e05269" opacity="0.6" />
                            <circle cx="9" cy="5.5" r="2" fill="#e05269" />
                        </svg>
                        <span class="text-xs text-rose-600 font-bold uppercase tracking-widest">Selected Edition</span>
                    </div>
                    <h2 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-gray-900">Featured Atelier Gowns
                    </h2>
                </div>
                <a href="{{ route('catalog.index') }}"
                    class="text-xs font-bold text-rose-600 hover:text-rose-800 uppercase tracking-wider flex items-center gap-1 mt-4 md:mt-0 group">
                    View Full Archive ({{ \App\Models\Dress::count() }})
                    <span class="group-hover:translate-x-1 transition-transform inline-block">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredDresses->take(3) as $dress)
                    <div
                        class="bg-white rounded-3xl overflow-hidden border border-rose-100 shadow-sm igari-card-hover flex flex-col group">
                        <div class="relative aspect-[4/5] bg-pink-50 overflow-hidden">
                            <img src="{{ $dress->image_url }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                                alt="{{ $dress->name }}">

                            {{-- Category badge --}}
                            <div
                                class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold text-rose-700 border border-rose-200 shadow-sm">
                                {{ $dress->category->name ?? 'Coquette' }}
                            </div>
                            {{-- Size badge --}}
                            <div
                                class="absolute top-4 right-4 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-[10px] font-bold text-gray-800 shadow-xs">
                                Size {{ $dress->size }}
                            </div>
                            {{-- Wishlist button --}}
                            @auth
                                <button
                                    class="absolute bottom-4 right-4 w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center border border-rose-200 hover:bg-rose-50 transition">
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            @endauth
                        </div>

                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-1 text-gray-500 text-xs mb-1.5">
                                    <span class="text-amber-400 font-bold">★ {{ number_format($dress->rating, 1) }}</span>
                                    <span>({{ rand(5, 20) }} reviews)</span>
                                </div>
                                <h3
                                    class="font-serif-editorial font-bold text-gray-900 text-xl hover:text-rose-600 transition leading-tight">
                                    <a href="{{ route('catalog.show', $dress->slug) }}">{{ $dress->name }}</a>
                                </h3>
                                <p class="text-xs text-gray-500 mt-1.5 line-clamp-2 leading-relaxed">{{ $dress->description }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-rose-50 mt-4 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Daily
                                        Rate</span>
                                    <span class="font-bold text-rose-700 text-lg">{{ $dress->formatted_price }}</span>
                                </div>
                                <a href="{{ route('catalog.show', $dress->slug) }}"
                                    class="btn-igari-primary text-xs px-4 py-2 rounded-full font-bold">
                                    Reserve
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($featuredDresses->count() > 3)
                {{-- Show more CTA if >3 dresses --}}
                <div class="text-center mt-10">
                    <a href="{{ route('catalog.index') }}"
                        class="btn-igari-secondary inline-flex items-center gap-2 px-8 py-3 rounded-full text-xs font-bold uppercase tracking-wider border">
                        View All {{ \App\Models\Dress::count() }} Gowns in Archive &rarr;
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════ --}}
    {{-- COQUETTE STYLE MATCHER QUIZ --}}
    {{-- ═══════════════════════════════════════ --}}
    <section id="quiz-section" x-data="quizMatcher()" class="py-20 px-4 max-w-5xl mx-auto">
        <div class="relative overflow-hidden rounded-3xl border border-rose-200 shadow-xl"
            style="background: linear-gradient(135deg,#fff0f3 0%,#ffe5ec 60%,#ffd6e0 100%);">

            {{-- Decorative corner flowers --}}
            <div aria-hidden="true" class="absolute top-4 left-4 opacity-25 pointer-events-none">
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                    <path d="M30 10 Q35 20 30 30 Q25 20 30 10Z" fill="#e05269" />
                    <path d="M50 30 Q40 35 30 30 Q40 25 50 30Z" fill="#e05269" />
                    <path d="M30 50 Q25 40 30 30 Q35 40 30 50Z" fill="#e05269" />
                    <path d="M10 30 Q20 25 30 30 Q20 35 10 30Z" fill="#e05269" />
                    <circle cx="30" cy="30" r="5" fill="#c8374d" />
                </svg>
            </div>
            <div aria-hidden="true" class="absolute top-4 right-4 opacity-25 pointer-events-none">
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                    <path d="M30 10 Q35 20 30 30 Q25 20 30 10Z" fill="#e05269" />
                    <path d="M50 30 Q40 35 30 30 Q40 25 50 30Z" fill="#e05269" />
                    <path d="M30 50 Q25 40 30 30 Q35 40 30 50Z" fill="#e05269" />
                    <path d="M10 30 Q20 25 30 30 Q20 35 10 30Z" fill="#e05269" />
                    <circle cx="30" cy="30" r="5" fill="#c8374d" />
                </svg>
            </div>
            <div aria-hidden="true" class="absolute bottom-4 left-4 opacity-15 pointer-events-none">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                    <circle cx="40" cy="40" r="30" stroke="#c8374d" stroke-width="1" fill="none" stroke-dasharray="5 7" />
                    <circle cx="40" cy="40" r="18" stroke="#c8374d" stroke-width="1" fill="none" stroke-dasharray="3 5" />
                </svg>
            </div>

            <div class="p-8 sm:p-12">
                <div class="max-w-2xl mx-auto text-center space-y-4">
                    {{-- Decorative ornament --}}
                    <div class="flex items-center justify-center gap-3 mb-2">
                        <svg width="40" height="2" fill="none">
                            <line x1="0" y1="1" x2="40" y2="1" stroke="#e05269" stroke-width="1.5" />
                        </svg>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M10 2 Q12 6 10 10 Q8 6 10 2Z" fill="#e05269" />
                            <path d="M18 10 Q14 12 10 10 Q14 8 18 10Z" fill="#e05269" />
                            <path d="M10 18 Q8 14 10 10 Q12 14 10 18Z" fill="#e05269" />
                            <path d="M2 10 Q6 8 10 10 Q6 12 2 10Z" fill="#e05269" />
                            <circle cx="10" cy="10" r="2.5" fill="#c8374d" />
                        </svg>
                        <svg width="40" height="2" fill="none">
                            <line x1="0" y1="1" x2="40" y2="1" stroke="#e05269" stroke-width="1.5" />
                        </svg>
                    </div>

                    <span class="coquette-bow-label">
                        <svg width="14" height="9" viewBox="0 0 14 9" fill="none" class="inline mr-1">
                            <path d="M7 4.5C5.5 2 1 1 1 4.5C1 8 5.5 7 7 4.5Z" fill="#c8374d" />
                            <path d="M7 4.5C8.5 2 13 1 13 4.5C13 8 8.5 7 7 4.5Z" fill="#c8374d" />
                            <circle cx="7" cy="4.5" r="1.5" fill="#8b1a2d" />
                        </svg>
                        Atelier Style Recommendation
                    </span>
                    <h2 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-gray-900">
                        Find Your Matching Silhouette
                    </h2>
                    <p class="text-sm text-gray-600 font-light italic">
                        Select your event type and preferred color aesthetic for a tailored recommendation.
                    </p>

                    <div
                        class="pt-6 space-y-5 bg-white/80 backdrop-blur-md p-6 sm:p-8 rounded-2xl border border-rose-200 text-left shadow-sm">
                        <div>
                            <label class="block text-xs font-bold text-rose-900 uppercase tracking-wider mb-3">1. Select
                                Occasion</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                <template x-for="item in vibes" :key="item.value">
                                    <button @click="selectedVibe = item.value"
                                        :class="selectedVibe === item.value ? 'bg-rose-700 text-white font-bold border-rose-700 shadow-md' : 'bg-rose-50/80 text-gray-700 border-rose-200 hover:bg-rose-100'"
                                        class="py-3 px-3 rounded-xl border text-xs text-center transition">
                                        <span x-text="item.label"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-rose-900 uppercase tracking-wider mb-3">2. Select
                                Color Palette</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                <template x-for="color in colors" :key="color.value">
                                    <button @click="selectedColor = color.value"
                                        :class="selectedColor === color.value ? 'bg-rose-700 text-white font-bold border-rose-700 shadow-md' : 'bg-rose-50/80 text-gray-700 border-rose-200 hover:bg-rose-100'"
                                        class="py-3 px-3 rounded-xl border text-xs text-center transition">
                                        <span x-text="color.label"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <button @click="findMatch()"
                            class="w-full btn-igari-primary py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider shadow-md">
                            Find My Recommended Gown
                        </button>
                    </div>

                    <div x-show="result" x-transition
                        class="mt-6 p-6 bg-white rounded-2xl border border-rose-300 text-left shadow-lg flex flex-col sm:flex-row items-center gap-6">
                        <img :src="result?.image" class="w-28 h-36 object-cover rounded-xl border border-rose-200 shadow-sm"
                            alt="Matched Dress">
                        <div class="space-y-2 flex-1">
                            <span
                                class="text-[10px] bg-rose-50 text-rose-700 font-bold px-3 py-1 rounded-full border border-rose-200"
                                x-text="result?.category"></span>
                            <h3 class="font-serif-editorial text-xl font-bold text-gray-900" x-text="result?.name"></h3>
                            <p class="text-sm font-bold text-rose-700" x-text="result?.price + ' / day'"></p>
                            <p class="text-xs text-gray-500 italic">This piece aligns perfectly with your event theme and
                                color preference.</p>
                            <a :href="result?.url"
                                class="inline-block btn-igari-primary text-xs px-5 py-2.5 rounded-full font-bold">
                                Reserve This Gown &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ --}}
    {{-- HOW IT WORKS --}}
    {{-- ═══════════════════════════════════════ --}}
    <section id="how-it-works" class="py-16 px-4 max-w-7xl mx-auto relative">

        {{-- Floating lace dot ring --}}
        <div aria-hidden="true" class="absolute right-0 top-8 opacity-10 pointer-events-none hidden lg:block">
            <svg width="180" height="180" viewBox="0 0 180 180" fill="none">
                <circle cx="90" cy="90" r="80" stroke="#c8374d" stroke-width="2" fill="none" stroke-dasharray="6 10" />
                <circle cx="90" cy="90" r="55" stroke="#c8374d" stroke-width="1.5" fill="none" stroke-dasharray="3 7" />
                <circle cx="90" cy="90" r="30" stroke="#c8374d" stroke-width="1" fill="none" />
            </svg>
        </div>

        <div class="text-center max-w-2xl mx-auto mb-14">
            <div class="coquette-ornament-line mb-4">
                <svg width="200" height="16" viewBox="0 0 200 16" fill="none" aria-hidden="true">
                    <line x1="0" y1="8" x2="70" y2="8" stroke="#f1a7b2" stroke-width="1.5" />
                    <circle cx="84" cy="8" r="3" fill="#e05269" />
                    <circle cx="100" cy="8" r="5" fill="#e05269" />
                    <circle cx="116" cy="8" r="3" fill="#e05269" />
                    <line x1="130" y1="8" x2="200" y2="8" stroke="#f1a7b2" stroke-width="1.5" />
                </svg>
            </div>
            <span class="igari-pill">Seamless Process</span>
            <h2 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-gray-900 mt-3">How Atelier Rental Works</h2>
            <p class="text-sm text-gray-500 mt-2 font-light italic">Designed for your convenience from start to finish.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">

            {{-- Connecting dashed line between steps (desktop only) --}}
            <div aria-hidden="true"
                class="absolute top-8 left-1/4 right-1/4 h-px border-t-2 border-dashed border-rose-200 hidden lg:block"
                style="left:calc(12.5% + 1rem);right:calc(12.5% + 1rem);"></div>

            @php
                $steps = [
                    ['num' => '01', 'title' => 'Select Gown & Dates', 'desc' => 'Browse our curated archive and choose your desired gown with your preferred rental dates.'],
                    ['num' => '02', 'title' => 'Reserve & Pay', 'desc' => 'Complete the reservation fee and refundable security deposit via instant bank transfer.'],
                    ['num' => '03', 'title' => 'Wear & Celebrate', 'desc' => 'Receive your professionally sanitized, garment-cared gown ready for your special occasion.'],
                    ['num' => '04', 'title' => 'Return & Refund', 'desc' => 'Return the piece upon completion. Security deposit is reimbursed promptly after inspection.'],
                ];
            @endphp

            @foreach($steps as $step)
                <div
                    class="bg-white p-6 rounded-3xl border border-rose-100 shadow-sm text-center space-y-3 hover:shadow-md hover:border-rose-200 transition duration-300 relative">
                    {{-- Floral step number --}}
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-rose-50 to-pink-100 text-rose-700 border-2 border-rose-200 rounded-full flex items-center justify-center font-bold text-sm mx-auto shadow-sm">
                        {{ $step['num'] }}
                    </div>
                    <h3 class="font-serif-editorial font-bold text-gray-900 text-lg leading-tight">{{ $step['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ═══════════════════════════════════════ --}}
    {{-- REVIEWS & TESTIMONIALS --}}
    {{-- ═══════════════════════════════════════ --}}
    <section class="py-16 px-4 border-t border-rose-100 relative overflow-hidden"
        style="background: linear-gradient(180deg,#fff5f7 0%,#fff0f3 100%);">

        {{-- Decorative large lace circle bg --}}
        <div aria-hidden="true" class="absolute -left-16 -bottom-16 opacity-10 pointer-events-none">
            <svg width="280" height="280" viewBox="0 0 280 280" fill="none">
                <circle cx="140" cy="140" r="130" stroke="#c8374d" stroke-width="2" fill="none" stroke-dasharray="8 12" />
                <circle cx="140" cy="140" r="90" stroke="#c8374d" stroke-width="1.5" fill="none" stroke-dasharray="4 8" />
            </svg>
        </div>
        <div aria-hidden="true" class="absolute -right-10 -top-10 opacity-10 pointer-events-none">
            <svg width="200" height="200" viewBox="0 0 200 200" fill="none">
                <circle cx="100" cy="100" r="90" stroke="#c8374d" stroke-width="2" fill="none" stroke-dasharray="6 10" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <div class="coquette-ornament-line mb-4">
                    <svg width="200" height="16" viewBox="0 0 200 16" fill="none" aria-hidden="true">
                        <line x1="0" y1="8" x2="70" y2="8" stroke="#f1a7b2" stroke-width="1.5" />
                        <circle cx="84" cy="8" r="3" fill="#e05269" />
                        <circle cx="100" cy="8" r="5" fill="#e05269" />
                        <circle cx="116" cy="8" r="3" fill="#e05269" />
                        <line x1="130" y1="8" x2="200" y2="8" stroke="#f1a7b2" stroke-width="1.5" />
                    </svg>
                </div>
                <span class="igari-pill">Kind Words</span>
                <h2 class="font-serif-editorial text-3xl font-bold text-gray-900 mt-3">What Our Clients Say</h2>
                <p class="text-sm text-gray-500 mt-1 italic font-light">Real experiences from real clients.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentReviews as $review)
                    <div
                        class="bg-white p-6 rounded-3xl border border-rose-100 shadow-sm space-y-3 hover:shadow-md hover:border-rose-200 transition duration-300 relative overflow-hidden">
                        {{-- Decorative corner quote mark --}}
                        <div aria-hidden="true"
                            class="absolute top-3 right-4 font-serif-editorial text-6xl text-rose-100 leading-none select-none">
                            &ldquo;</div>

                        <div class="flex items-center gap-1 text-amber-400 text-sm">
                            @for($i = 0; $i < $review->rating; $i++) ★ @endfor
                        </div>
                        <p class="text-xs text-gray-700 italic leading-relaxed relative z-10">
                            &ldquo;{{ $review->comment }}&rdquo;</p>
                        <div class="pt-3 border-t border-rose-50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <img src="{{ $review->user->avatar ?? 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . $review->user->name }}"
                                    class="w-8 h-8 rounded-full border-2 border-rose-200" alt="Reviewer">
                                <div>
                                    <p class="text-xs font-bold text-gray-900">{{ $review->user->name }}</p>
                                    <p class="text-[10px] text-rose-500 font-semibold">
                                        {{ $review->dress->name ?? 'Chérie Gown' }}
                                    </p>
                                </div>
                            </div>
                            <span class="text-[10px] text-gray-400 bg-rose-50 px-2 py-0.5 rounded-full">Verified</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════ --}}
    {{-- CTA BANNER --}}
    {{-- ═══════════════════════════════════════ --}}
    <section class="py-16 px-4 relative overflow-hidden"
        style="background: linear-gradient(135deg, #c8374d 0%, #e05269 50%, #d1435a 100%);">
        {{-- Decorative lace overlay --}}
        <div aria-hidden="true" class="absolute inset-0 pointer-events-none opacity-10"
            style="background-image: radial-gradient(circle, rgba(255,255,255,0.6) 1px, transparent 1px); background-size: 24px 24px;">
        </div>

        {{-- Decorative side bow --}}
        <div aria-hidden="true"
            class="absolute left-8 top-1/2 -translate-y-1/2 opacity-20 pointer-events-none hidden lg:block">
            <svg width="60" height="36" viewBox="0 0 60 36" fill="none">
                <path d="M30 18C22 8 2 2 2 18C2 34 22 28 30 18Z" fill="white" />
                <path d="M30 18C38 8 58 2 58 18C58 34 38 28 30 18Z" fill="white" />
                <circle cx="30" cy="18" r="5" fill="white" />
            </svg>
        </div>
        <div aria-hidden="true"
            class="absolute right-8 top-1/2 -translate-y-1/2 opacity-20 pointer-events-none hidden lg:block">
            <svg width="60" height="36" viewBox="0 0 60 36" fill="none">
                <path d="M30 18C22 8 2 2 2 18C2 34 22 28 30 18Z" fill="white" />
                <path d="M30 18C38 8 58 2 58 18C58 34 38 28 30 18Z" fill="white" />
                <circle cx="30" cy="18" r="5" fill="white" />
            </svg>
        </div>

        <div class="max-w-3xl mx-auto text-center relative z-10 space-y-5">
            <div class="flex items-center justify-center gap-3 mb-2">
                <svg width="40" height="2" fill="none">
                    <line x1="0" y1="1" x2="40" y2="1" stroke="rgba(255,255,255,0.5)" stroke-width="1.5" />
                </svg>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8 1 Q9 4 8 8 Q7 4 8 1Z" fill="white" opacity="0.7" />
                    <path d="M15 8 Q12 9 8 8 Q12 7 15 8Z" fill="white" opacity="0.7" />
                    <path d="M8 15 Q7 12 8 8 Q9 12 8 15Z" fill="white" opacity="0.7" />
                    <path d="M1 8 Q4 7 8 8 Q4 9 1 8Z" fill="white" opacity="0.7" />
                    <circle cx="8" cy="8" r="2" fill="white" />
                </svg>
                <svg width="40" height="2" fill="none">
                    <line x1="0" y1="1" x2="40" y2="1" stroke="rgba(255,255,255,0.5)" stroke-width="1.5" />
                </svg>
            </div>
            <h2 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-white">Ready to Find Your Perfect Gown?</h2>
            <p class="text-sm text-rose-100 font-light">Begin your reservation today and let ChérieRent dress your most
                beautiful moments.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('catalog.index') }}"
                    class="bg-white text-rose-700 font-bold px-8 py-3.5 rounded-full text-xs uppercase tracking-wider hover:bg-rose-50 transition shadow-lg w-full sm:w-auto">
                    Explore Archive &rarr;
                </a>
                @guest
                    <a href="{{ route('register') }}"
                        class="border border-white/50 text-white font-bold px-8 py-3.5 rounded-full text-xs uppercase tracking-wider hover:bg-white/10 transition w-full sm:w-auto">
                        Create Account
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <script>
        function quizMatcher() {
            return {
                selectedVibe: 'prom',
                selectedColor: 'pink',
                result: null,
                vibes: [
                    { label: 'Prom & Gala', value: 'prom' },
                    { label: 'Portrait Studio', value: 'photoshoot' },
                    { label: 'Private Reception', value: 'party' },
                    { label: 'Vintage Coquette', value: 'vintage' },
                ],
                colors: [
                    { label: 'Dusty Rose', value: 'pink' },
                    { label: 'Pearl Ivory', value: 'ivory' },
                    { label: 'Pastel Botanical', value: 'floral' },
                    { label: 'Soft Lavender', value: 'lavender' },
                ],
                async findMatch() {
                    try {
                        const response = await fetch('{{ route('quiz.recommendation') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ vibe: this.selectedVibe, color: this.selectedColor })
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.result = data.dress;
                        }
                    } catch (e) {
                        console.error(e);
                    }
                }
            }
        }
    </script>

    {{-- ═══════════════════════════════════════ --}}
    {{-- CONTACT / HUBUNGI KAMI SECTION --}}
    {{-- ═══════════════════════════════════════ --}}
    <section class="py-20 px-4 sm:px-6 lg:px-8 igari-bg-gradient border-t border-rose-200/60" id="contact">
        <div class="max-w-3xl mx-auto">

            {{-- Section Header --}}
            <div class="text-center mb-10">
                <span class="inline-block bg-rose-100 text-rose-700 text-xs font-semibold px-3.5 py-1 rounded-full border border-rose-200 uppercase tracking-wider mb-2.5">Hubungi Kami</span>
                <h2 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-gray-900 mb-3">Kirim Pesan ke Atelier</h2>
                <p class="text-sm text-gray-600 max-w-md mx-auto">Ada pertanyaan soal gaun, ukuran, atau ketersediaan? Silakan kirimkan pesan Anda melalui formulir di bawah ini.</p>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium px-4 py-3.5 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium px-4 py-3.5 rounded-xl">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Contact Form --}}
            <form action="{{ route('contact.send') }}" method="POST"
                class="bg-white border border-rose-200/70 rounded-3xl p-6 sm:p-10 shadow-md shadow-rose-100/40 space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            placeholder="e.g. Sophia Cherie"
                            class="w-full h-11 text-sm border border-gray-200 rounded-xl px-4 bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none text-gray-800 placeholder-gray-400 transition shadow-2xs">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            placeholder="your@email.com"
                            class="w-full h-11 text-sm border border-gray-200 rounded-xl px-4 bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none text-gray-800 placeholder-gray-400 transition shadow-2xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- WhatsApp -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">
                            No. WhatsApp <span class="text-gray-400 font-normal normal-case">(opsional)</span>
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            placeholder="0895-xxxx-xxxx"
                            class="w-full h-11 text-sm border border-gray-200 rounded-xl px-4 bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none text-gray-800 placeholder-gray-400 transition shadow-2xs">
                    </div>

                    <!-- Subjek -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">
                            Subjek <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="subject" required
                                class="w-full h-11 text-sm border border-gray-200 rounded-xl pl-4 pr-10 bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none text-gray-800 transition shadow-2xs appearance-none">
                                <option value="">-- Pilih Subjek --</option>
                                <option value="Pertanyaan Ketersediaan Gaun" {{ old('subject') === 'Pertanyaan Ketersediaan Gaun' ? 'selected' : '' }}>Pertanyaan Ketersediaan Gaun</option>
                                <option value="Konsultasi Ukuran & Fitting" {{ old('subject') === 'Konsultasi Ukuran & Fitting' ? 'selected' : '' }}>Konsultasi Ukuran & Fitting</option>
                                <option value="Promo & Paket Khusus" {{ old('subject') === 'Promo & Paket Khusus' ? 'selected' : '' }}>Promo & Paket Khusus</option>
                                <option value="Keluhan & Feedback" {{ old('subject') === 'Keluhan & Feedback' ? 'selected' : '' }}>Keluhan & Feedback</option>
                                <option value="Lainnya" {{ old('subject') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pesan Textarea -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wider">
                        Pesan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="message" rows="5" required
                        placeholder="Tuliskan pertanyaan atau detail pesanan Anda..."
                        class="w-full text-sm border border-gray-200 rounded-xl p-4 bg-white focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none text-gray-800 placeholder-gray-400 transition resize-none shadow-2xs min-h-[140px]">{{ old('message') }}</textarea>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-rose-100">
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Pesan Anda akan terkirim langsung ke <strong class="text-gray-800 font-semibold">rentcherie@gmail.com</strong>.<br>
                        Balasan otomatis akan dikirim ke email Anda.
                    </p>
                    <button type="submit"
                        class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold uppercase tracking-wider px-8 py-3.5 rounded-xl shadow-xs transition duration-200 whitespace-nowrap">
                        Kirim Pesan &rarr;
                    </button>
                </div>
            </form>

        </div>
    </section>

@endsection