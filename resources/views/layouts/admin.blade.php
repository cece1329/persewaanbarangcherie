<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atelier Admin &mdash; ChérieRent</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans flex min-h-screen">

    <!-- Sidebar Admin -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col min-h-screen shrink-0 shadow-xl">
        <!-- Logo Header -->
        <div class="p-6 border-b border-slate-800 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-rose-600 flex items-center justify-center font-serif-editorial text-white text-lg font-bold">
                C
            </div>
            <div>
                <h1 class="font-serif-editorial font-bold text-lg text-rose-200">ChérieRent</h1>
                <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Atelier Management</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-4 space-y-1.5 text-xs font-semibold uppercase tracking-wider">
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

    <!-- Main Content Right Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Topbar -->
        <header class="bg-white border-b border-gray-200 h-16 px-8 flex items-center justify-between shadow-xs">
            <h2 class="font-bold text-gray-800 text-base">@yield('title', 'Atelier Dashboard')</h2>
            
            <div class="flex items-center gap-4">
                <span class="text-xs bg-rose-50 text-rose-700 font-bold px-3 py-1 rounded-full border border-rose-200">System Active</span>
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-700">
                    <img src="{{ Auth::user()->avatar }}" class="w-7 h-7 rounded-full border border-rose-300" alt="Avatar">
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <!-- Toast Notifications -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="m-6 bg-slate-900 text-white px-6 py-3.5 rounded-xl shadow-lg flex items-center justify-between text-xs font-medium">
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="text-white font-bold ml-4">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="m-6 bg-rose-700 text-white px-6 py-3.5 rounded-xl shadow-lg flex items-center justify-between text-xs font-medium">
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="text-white font-bold ml-4">&times;</button>
            </div>
        @endif

        <!-- Page Body -->
        <main class="p-8 flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</body>
</html>
