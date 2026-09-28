@extends('layouts.admin')

@section('title', 'Overview & Metrics')

@section('content')
<div class="space-y-8">

    <!-- Action Banner for Reports -->
    <div class="bg-gradient-to-r from-rose-950 via-slate-900 to-rose-900 rounded-2xl p-6 text-white shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <span class="bg-rose-500/20 text-rose-300 text-[10px] font-bold px-3 py-1 rounded-full border border-rose-400/30 uppercase tracking-wider inline-block mb-2">Modul Laporan & Export</span>
            <h2 class="font-serif-editorial text-xl font-bold text-white">Laporan Transaksi & Persewaan Gaun</h2>
            <p class="text-xs text-rose-100/70 mt-1">Cetak laporan PDF resmi atau ekspor spreadsheet Excel/CSV transaksi persewaan.</p>
        </div>
        <a href="{{ route('admin.reports.rentals') }}" class="bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs px-5 py-3 rounded-xl transition shadow-md whitespace-nowrap flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Buka Laporan & Export
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Total Revenue</span>
            <p class="font-serif-editorial font-bold text-3xl text-gray-900 mt-1">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Active Reservations</span>
            <p class="font-serif-editorial font-bold text-3xl text-gray-900 mt-1">
                {{ $activeRentalsCount }} Active
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Gowns in Archive</span>
            <p class="font-serif-editorial font-bold text-3xl text-gray-900 mt-1">
                {{ $totalDressesCount }} Pieces
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block">Registered Clients</span>
            <p class="font-serif-editorial font-bold text-3xl text-gray-900 mt-1">
                {{ $totalUsersCount }} Clients
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-xs p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="font-bold text-gray-900 text-sm">Recent Client Reservations</h3>
                <a href="{{ route('admin.rentals.index') }}" class="text-xs text-rose-700 font-bold hover:underline">View All &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 text-gray-500 font-bold uppercase">
                        <tr>
                            <th class="p-3">Ref Code & Client</th>
                            <th class="p-3">Gown</th>
                            <th class="p-3 text-right">Total</th>
                            <th class="p-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentRentals as $rental)
                            <tr>
                                <td class="p-3">
                                    <strong class="text-gray-900 font-mono text-xs block">#{{ $rental->rental_code }}</strong>
                                    <span class="text-gray-500">{{ $rental->user->name }}</span>
                                </td>
                                <td class="p-3 font-medium text-gray-800">
                                    {{ $rental->dress->name }}
                                </td>
                                <td class="p-3 text-right font-bold text-rose-700">
                                    Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                </td>
                                <td class="p-3 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $rental->status_badge_class }}">
                                        {{ $rental->status_label }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-6 space-y-4">
            <h3 class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-4">Top Reserved Gowns</h3>
            
            <div class="space-y-3">
                @foreach($popularDresses as $dress)
                    <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-rose-50/40 transition">
                        <img src="{{ $dress->image_url }}" class="w-12 h-14 object-cover rounded-xl border border-gray-200" alt="Dress">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-xs text-gray-800 truncate">{{ $dress->name }}</h4>
                            <p class="text-[10px] text-rose-700 font-semibold">{{ $dress->formatted_price }} / day</p>
                            <span class="text-[10px] text-gray-400 block">{{ $dress->rentals_count }} Total Bookings</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
