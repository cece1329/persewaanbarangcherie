<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atelier Admin &mdash; ChérieRent</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/web/logodomain.png') }}?v={{ time() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/web/logodomain.png') }}?v={{ time() }}">
    <link rel="apple-touch-icon" href="{{ asset('images/web/logodomain.png') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-50 text-gray-800 font-sans min-h-screen flex flex-col lg:flex-row antialiased">

    <!-- Mobile Backdrop -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden"
         style="display: none;"></div>

    <!-- Sidebar Admin -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white flex flex-col shadow-2xl transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 lg:shadow-xl lg:min-h-screen lg:shrink-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        
        <!-- Logo Header & Mobile Close Button -->
        <div class="p-5 sm:p-6 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-rose-600 flex items-center justify-center font-serif-editorial text-white text-lg font-bold">
                    C
                </div>
                <div>
                    <h1 class="font-serif-editorial font-bold text-lg text-rose-200">ChérieRent</h1>
                    <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Atelier Management</span>
                </div>
            </div>

            <!-- Close button on mobile -->
            <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition focus:outline-none" aria-label="Tutup Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-3 sm:p-4 space-y-1.5 text-xs font-semibold uppercase tracking-wider overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-rose-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Overview & Metrics
            </a>
            
            <a href="{{ route('admin.rentals.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.rentals.*') ? 'bg-rose-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Reservations
            </a>

            <a href="{{ route('admin.dresses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dresses.*') ? 'bg-rose-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Gown Collection
            </a>

            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-rose-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Categories
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-rose-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Registered Clients
            </a>

            <a href="{{ route('admin.reports.rentals') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.reports.*') ? 'bg-rose-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                Laporan & Export
            </a>

            @php $unreadMessagesCount = \App\Models\Message::where('is_read', false)->count(); @endphp
            <a href="{{ route('admin.messages.index') }}" class="flex items-center justify-between gap-2 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.messages.*') ? 'bg-rose-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <span>Pesan Masuk</span>
                @if($unreadMessagesCount > 0)
                    <span class="bg-rose-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center leading-tight">{{ $unreadMessagesCount }}</span>
                @endif
            </a>
        </nav>

        <!-- Back to Storefront & Logout -->
        <div class="p-4 border-t border-slate-800 space-y-2">
            <a href="{{ route('home') }}" class="flex items-center justify-center px-4 py-2.5 rounded-xl bg-slate-800 text-xs font-semibold text-rose-300 hover:bg-slate-700 transition">
                View Storefront
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-xs text-rose-400 hover:text-rose-300 font-semibold transition">
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        <!-- Topbar -->
        <header class="bg-white border-b border-gray-200 h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between shadow-xs sticky top-0 z-30">
            <div class="flex items-center gap-3 min-w-0">
                <!-- Mobile Hamburger Button -->
                <button @click="sidebarOpen = true" 
                        class="lg:hidden p-2 -ml-2 rounded-xl text-gray-600 hover:text-rose-600 hover:bg-gray-100 transition focus:outline-none" 
                        aria-label="Buka Menu Navigasi">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h2 class="font-bold text-gray-800 text-sm sm:text-base truncate">@yield('title', 'Atelier Dashboard')</h2>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                <span class="hidden sm:inline-flex text-[11px] bg-rose-50 text-rose-700 font-bold px-2.5 py-1 rounded-full border border-rose-200">System Active</span>
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-700">
                    <img src="{{ Auth::user()->avatar }}" class="w-7 h-7 rounded-full border border-rose-300" alt="Avatar">
                    <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <!-- Toast Notifications -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="m-4 sm:m-6 bg-slate-900 text-white px-5 sm:px-6 py-3.5 rounded-xl shadow-lg flex items-center justify-between text-xs font-medium">
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="text-white font-bold ml-4">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="m-4 sm:m-6 bg-rose-700 text-white px-5 sm:px-6 py-3.5 rounded-xl shadow-lg flex items-center justify-between text-xs font-medium">
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="text-white font-bold ml-4">&times;</button>
            </div>
        @endif

        <!-- Page Body -->
        <main class="p-4 sm:p-6 lg:p-8 flex-1">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
