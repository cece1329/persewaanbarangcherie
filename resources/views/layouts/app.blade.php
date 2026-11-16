<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChérieRent &mdash; Couture & Vintage Dress Rental Atelier</title>
    <meta name="description"
        content="ChérieRent offers a curated archive of vintage, coquette, and evening gowns for portraits, galas, and milestone moments.">

    <link rel="icon" type="image/png" href="{{ asset('images/web/logodomain.png') }}?v={{ time() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/web/logodomain.png') }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('images/web/logodomain.png') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        @media print {
            .no-print, header, footer, [class*="announcement"], #chat-widget-container {
                display: none !important;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
        }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-[#fffbfa] text-[#2b2d42] flex flex-col min-h-screen selection:bg-pink-100 selection:text-rose-900">

    <!-- Top Announcement Bar -->
    <div
        class="bg-gradient-to-r from-rose-600 via-pink-500 to-rose-700 text-white text-xs font-medium py-2.5 px-4 text-center tracking-wide">
        <span class="opacity-90">Jaminan pengembalian deposit aman &amp; tas pelindung gaun gratis untuk setiap reservasi.</span>
        <a href="{{ route('catalog.index') }}"
            class="underline ml-2 hover:text-pink-100 transition font-semibold">Jelajahi Koleksi &rarr;</a>
    </div>

    <!-- Main Navigation Header -->
    <header x-data="{ mobileMenuOpen: false }"
        class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-rose-100 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/web/logodomain.png') }}" alt="ChérieRent Logo"
                    class="w-14 h-16 object-contain group-hover:scale-105 transition">
                <div>
                    <span class="font-serif-editorial text-2xl font-bold tracking-tight text-gray-900">ChérieRent</span>
                    <span class="block text-[9px] tracking-widest text-rose-600 font-semibold uppercase -mt-1">Couture &
                        Rental Atelier</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-xs font-semibold uppercase tracking-wider text-gray-700">
                <a href="{{ route('home') }}"
                    class="hover:text-rose-600 transition {{ request()->routeIs('home') ? 'text-rose-600 font-bold' : '' }}">Beranda</a>
                <a href="{{ route('catalog.index') }}"
                    class="hover:text-rose-600 transition {{ request()->routeIs('catalog.*') ? 'text-rose-600 font-bold' : '' }}">Koleksi
                    Gaun</a>
                <a href="{{ route('home') }}#how-it-works"
                    class="hover:text-rose-600 transition">Panduan Sewa</a>
                <a href="{{ route('home') }}#quiz-section"
                    class="hover:text-rose-600 transition">Kuis Gaya</a>
            </nav>

            <!-- Right Buttons / Auth -->
            <div class="hidden md:flex items-center gap-4 text-xs font-semibold">
                @auth
                    <!-- Wishlist Icon -->
                    <a href="{{ route('user.wishlists') }}" class="p-2 text-rose-600 hover:text-rose-800 transition"
                        title="Gaun Impian">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>

                    <!-- User Dropdown Menu -->
                    <div x-data="{ open: false }" x-cloak class="relative">
                        <button @click="open = !open"
                            class="flex items-center gap-2.5 text-xs font-semibold text-gray-800 hover:text-rose-600 p-1.5 rounded-full border border-rose-200 bg-rose-50/40">
                            <img src="{{ Auth::user()->avatar ?? 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . Auth::user()->name }}"
                                class="w-7 h-7 rounded-full border border-rose-300" alt="Avatar">
                            <span>{{ Str::limit(Auth::user()->name, 14) }}</span>
                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-rose-100 py-2 z-50 text-xs">
                            <div class="px-4 py-2 border-b border-rose-50">
                                <p class="font-bold text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-rose-500 font-medium">{{ Auth::user()->email }}</p>
                            </div>

                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center gap-2 px-4 py-2 text-rose-700 font-bold bg-rose-50 hover:bg-rose-100 transition">
                                    <span>Dashboard Admin</span>
                                </a>
                            @endif

                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-rose-50 hover:text-rose-600 transition">
                                <span>Portal Pelanggan</span>
                            </a>
                            <a href="{{ route('user.rentals') }}"
                                class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-rose-50 hover:text-rose-600 transition">
                                <span>Riwayat Reservasi</span>
                            </a>
                            <a href="{{ route('user.wishlists') }}"
                                class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-rose-50 hover:text-rose-600 transition">
                                <span>Gaun Impian (Wishlist)</span>
                            </a>

                            <div class="border-t border-rose-50 my-1"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-rose-700 hover:bg-rose-50 font-medium transition">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-xs font-semibold text-rose-600 hover:text-rose-700 px-3 py-2">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="btn-igari-primary text-xs px-5 py-2.5 rounded-full uppercase tracking-wider">Daftar</a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-gray-600 hover:text-rose-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" x-transition
            class="md:hidden bg-white border-b border-rose-100 px-4 py-4 space-y-3">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false"
                class="block text-gray-700 hover:text-rose-600 font-medium text-xs uppercase tracking-wider {{ request()->routeIs('home') ? 'text-rose-600 font-bold' : '' }}">Beranda</a>
            <a href="{{ route('catalog.index') }}" @click="mobileMenuOpen = false"
                class="block text-gray-700 hover:text-rose-600 font-medium text-xs uppercase tracking-wider {{ request()->routeIs('catalog.*') ? 'text-rose-600 font-bold' : '' }}">Koleksi
                Gaun</a>
            <a href="{{ route('home') }}#how-it-works" @click="mobileMenuOpen = false"
                class="block text-gray-700 hover:text-rose-600 font-medium text-xs uppercase tracking-wider">Panduan Sewa</a>
            <a href="{{ route('home') }}#quiz-section" @click="mobileMenuOpen = false"
                class="block text-gray-700 hover:text-rose-600 font-medium text-xs uppercase tracking-wider">Kuis Gaya</a>

            @auth
                <div class="pt-3 border-t border-rose-100">
                    <p class="font-bold text-gray-900 text-xs">{{ Auth::user()->name }}</p>
                    <a href="{{ route('dashboard') }}" class="block text-xs text-rose-600 mt-2">Portal Pelanggan</a>
                    <a href="{{ route('user.rentals') }}" class="block text-xs text-rose-600 mt-1">Riwayat Reservasi</a>
                    <a href="{{ route('user.wishlists') }}" class="block text-xs text-rose-600 mt-1">Gaun Impian (Wishlist)</a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block text-xs text-purple-700 font-bold mt-1">Dashboard
                            Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="text-xs text-rose-600 font-bold">Keluar</button>
                    </form>
                </div>
            @else
                <div class="pt-3 border-t border-rose-100 flex gap-2">
                    <a href="{{ route('login') }}"
                        class="btn-igari-secondary text-xs px-4 py-2 rounded-full w-1/2 text-center">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="btn-igari-primary text-xs px-4 py-2 rounded-full w-1/2 text-center">Daftar</a>
                </div>
            @endauth
        </div>
    </header>

    <!-- Notification Toast Alerts -->
    <div x-data="{ notifications: [] }" 
         x-init="window.addEventListener('show-notification', (e) => { notifications.push({ message: e.detail.message, type: e.detail.type || 'success' }); setTimeout(() => notifications.shift(), 5000); })"
         class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 space-y-2">
        <template x-for="notif in notifications" :key="notif.message">
            <div x-show="true" 
                 x-transition
                 :class="notif.type === 'success' ? 'bg-rose-700 border-rose-500' : 'bg-slate-800 border-slate-600'"
                 class="text-white px-6 py-3.5 rounded-xl shadow-2xl flex items-center justify-between gap-4 border text-xs font-medium">
                <p x-text="notif.message"></p>
                <button @click="notifications = notifications.filter(n => n.message !== notif.message)" class="text-white hover:text-rose-200 font-bold">&times;</button>
            </div>
        </template>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-rose-700 text-white px-6 py-3.5 rounded-xl shadow-2xl flex items-center justify-between gap-4 border border-rose-500 text-xs font-medium">
            <p>{{ session('success') }}</p>
            <button @click="show = false" class="text-white hover:text-rose-200 font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
            class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 bg-slate-800 text-white px-6 py-3.5 rounded-xl shadow-2xl flex items-center justify-between gap-4 border border-slate-600 text-xs font-medium">
            <p>{{ session('error') }}</p>
            <button @click="show = false" class="text-white hover:text-slate-300 font-bold">&times;</button>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer
        class="bg-gradient-to-b from-[#fff0f3] to-[#ffe5ec] border-t border-rose-200 pt-16 pb-12 text-gray-600 mt-0 relative overflow-hidden">

        {{-- Decorative lace circles --}}
        <div aria-hidden="true" class="absolute -left-12 -bottom-12 opacity-10 pointer-events-none">
            <svg width="200" height="200" viewBox="0 0 200 200" fill="none">
                <circle cx="100" cy="100" r="90" stroke="#c8374d" stroke-width="2" fill="none"
                    stroke-dasharray="6 10" />
                <circle cx="100" cy="100" r="60" stroke="#c8374d" stroke-width="1.5" fill="none"
                    stroke-dasharray="3 6" />
            </svg>
        </div>
        <div aria-hidden="true" class="absolute -right-12 -top-12 opacity-10 pointer-events-none">
            <svg width="180" height="180" viewBox="0 0 180 180" fill="none">
                <circle cx="90" cy="90" r="80" stroke="#c8374d" stroke-width="2" fill="none" stroke-dasharray="6 10" />
                <circle cx="90" cy="90" r="50" stroke="#c8374d" stroke-width="1" fill="none" stroke-dasharray="3 6" />
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10">

            <!-- Brand Info -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-7 h-7 rounded-full bg-rose-600 text-white flex items-center justify-center font-serif-editorial text-sm font-bold">
                        C
                    </div>
                    <span class="font-serif-editorial text-2xl font-bold text-gray-900 tracking-tight">ChérieRent</span>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Atelier persewaan gaun mewah, vintage coquette, dan haute couture pilihan untuk pemotretan, wisuda, gala dinner, dan perayaan momen berharga Anda.
                </p>
            </div>

            <!-- Collections -->
            <div>
                <h4 class="font-serif-editorial font-bold text-gray-900 mb-4 text-lg">Koleksi Gaun</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('catalog.index', ['category' => 'victorian']) }}"
                            class="hover:text-rose-600 transition">Victorian Couture</a></li>
                    <li><a href="{{ route('catalog.index', ['category' => 'vintage']) }}"
                            class="hover:text-rose-600 transition">Vintage Classics</a></li>
                    <li><a href="{{ route('catalog.index', ['category' => 'pirate']) }}"
                            class="hover:text-rose-600 transition">Pirate Aesthetic</a></li>
                    <li><a href="{{ route('catalog.index', ['category' => 'igari']) }}"
                            class="hover:text-rose-600 transition">Igari Coquette Style</a></li>
                    <li><a href="{{ route('catalog.index', ['category' => 'mori-kei']) }}"
                            class="hover:text-rose-600 transition">Mori Kei Forest</a></li>
                    <li><a href="{{ route('catalog.index', ['category' => 'modern']) }}"
                            class="hover:text-rose-600 transition">Modern Chic</a></li>
                    <li><a href="{{ route('catalog.index', ['category' => 'elegant']) }}"
                            class="hover:text-rose-600 transition">Gaun Pesta Elegan</a></li>
                </ul>
            </div>

            <!-- Atelier Services -->
            <div>
                <h4 class="font-serif-editorial font-bold text-gray-900 mb-4 text-lg">Layanan Atelier</h4>
                <ul class="space-y-2 text-xs" x-data>
                    <li><a href="{{ route('home') }}#how-it-works" class="hover:text-rose-600 transition">Alur &amp; Prosedur Reservasi</a></li>
                    <li><button @click="$dispatch('open-fitting-guide')"
                            class="hover:text-rose-600 transition text-left">Garansi Uang Deposit (100% Kembali)</button></li>
                    <li><button @click="$dispatch('open-fitting-guide')"
                            class="hover:text-rose-600 transition text-left">Panduan Ukuran &amp; Fitting Chart</button></li>
                    <li><button @click="$dispatch('open-fitting-guide')"
                            class="hover:text-rose-600 transition text-left">Perawatan &amp; Dry Cleaning Higienis</button></li>
                </ul>
            </div>

            <!-- Contact & Store -->
            <div>
                <h4 class="font-serif-editorial font-bold text-gray-900 mb-4 text-lg">Lokasi Atelier</h4>
                <p class="text-xs text-gray-800 font-semibold mb-1">ChérieRent Atelier Studio</p>
                <p class="text-xs text-gray-600 mb-1 leading-relaxed">
                    Jl. Senopati No. 42, RT.04/RW.02, Selong, Kebayoran Baru, Kota Jakarta Selatan, DKI Jakarta 12110
                </p>
                <p class="text-[11px] text-rose-700 font-medium mb-1.5">
                    (Lantai 2 Atelier Studio, Seberang Senopati Arcade)
                </p>
                <p class="text-xs text-gray-600 mb-1">
                    <span class="font-semibold text-gray-700">WhatsApp / Telepon:</span>
                    <a href="https://wa.me/62895401643905" target="_blank" class="text-rose-700 font-bold hover:underline">+62 895-4016-43905</a>
                </p>
                <p class="text-xs text-gray-600 mb-1">
                    <span class="font-semibold text-gray-700">Jam Operasional:</span> Senin &ndash; Minggu: 09.00 &ndash; 18.00 WIB
                </p>
                <p class="text-xs text-gray-600">
                    <span class="font-semibold text-gray-700">Email:</span> rentcherie@gmail.com
                </p>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-rose-200/80 mt-12 pt-6 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} ChérieRent Atelier. Hak cipta dilindungi undang-undang.
        </div>
    </footer>

    <!-- Interactive Widgets & Modals -->
    <x-chat-widget />
    <x-fitting-guide-modal />

</body>

</html>