@extends('layouts.admin')

@section('title', 'Laporan & Export Transaksi')

@section('content')
<style>
@media print {
    /* Hide non-printable elements */
    aside, header, nav, .no-print, button, form, .toast {
        display: none !important;
    }
    body {
        background: #white !important;
        color: #000 !important;
    }
    main {
        padding: 0 !important;
    }
    .print-header {
        display: block !important;
    }
    .print-table {
        width: 100% !important;
        border-collapse: collapse !important;
    }
    .print-table th, .print-table td {
        border: 1px solid #ccc !important;
        padding: 8px !important;
        font-size: 11px !important;
    }
}
</style>

<div class="space-y-6">

    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 no-print">
        <div>
            <h1 class="font-bold text-xl text-gray-900">Laporan Transaksi Persewaan</h1>
            <p class="text-xs text-gray-500">Cetak laporan PDF atau ekspor data persewaan ke Excel/CSV untuk keperluan rekapitulasi.</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak / Simpan PDF
            </button>

            <a href="{{ route('admin.reports.rentals.export', request()->all()) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Ekspor Excel / CSV
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs no-print">
        <form action="{{ route('admin.reports.rentals') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-xl bg-gray-50 focus:bg-white focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-xl bg-gray-50 focus:bg-white focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Status Transaksi</label>
                <select name="status" class="w-full px-3 py-2 text-xs border border-gray-300 rounded-xl bg-gray-50 focus:bg-white focus:outline-none font-semibold">
                    <option value="all">Semua Status</option>
                    <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid / Reserved</option>
                    <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>In Transit</option>
                    <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-slate-900 text-white text-xs font-bold py-2 rounded-xl hover:bg-slate-800 transition">
                    Filter Laporan
                </button>
                <a href="{{ route('admin.reports.rentals') }}" class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-2 rounded-xl hover:bg-gray-200 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Print Header Only visible when printing -->
    <div class="hidden print-header mb-6 text-center border-b pb-4">
        <h2 class="text-xl font-bold text-gray-900">CHÉRIÉRENT ATELIER</h2>
        <p class="text-xs text-gray-600">Laporan Persewaan Gaun & Transaksi Client</p>
        <p class="text-[10px] text-gray-500 mt-1">Dicetak pada: {{ date('d F Y H:i') }}</p>
    </div>

    <!-- Summary Metrics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Total Transaksi</span>
            <strong class="text-xl font-bold text-gray-900">{{ number_format($totalTransactions) }}</strong>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Total Pendapatan</span>
            <strong class="text-xl font-bold text-rose-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Persewaan Aktif</span>
            <strong class="text-xl font-bold text-amber-600">{{ number_format($activeCount) }}</strong>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Persewaan Selesai</span>
            <strong class="text-xl font-bold text-emerald-600">{{ number_format($completedCount) }}</strong>
        </div>
    </div>

    <!-- Report Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs print-table">
                <thead class="bg-slate-100 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">No & Kode</th>
                        <th class="p-4">Client / Penyewa</th>
                        <th class="p-4">Gaun & Ukuran</th>
                        <th class="p-4">Periode Sewa</th>
                        <th class="p-4 text-right">Nominal (Rp)</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rentals as $index => $rental)
                        <tr class="hover:bg-rose-50/20 transition">
                            <td class="p-4">
                                <span class="text-[10px] text-gray-400 font-mono block">#{{ $index + 1 }}</span>
                                <strong class="font-mono text-xs text-rose-700 block">{{ $rental->rental_code }}</strong>
                                <span class="text-[10px] text-gray-400 block">{{ $rental->created_at->format('d/m/Y H:i') }}</span>
                            </td>

                            <td class="p-4">
                                <strong class="text-gray-900 text-xs block">{{ $rental->user->name ?? 'Guest' }}</strong>
                                <span class="text-[10px] text-gray-500 block">{{ $rental->user->email ?? '-' }}</span>
                            </td>

                            <td class="p-4">
                                <strong class="text-gray-900 text-xs block">{{ $rental->dress->name ?? '-' }}</strong>
                                <span class="text-[10px] text-rose-700 font-bold">Size: {{ $rental->dress->size ?? '-' }}</span>
                            </td>

                            <td class="p-4">
                                <span class="text-xs font-medium text-gray-700 block">{{ $rental->start_date->format('d M') }} &mdash; {{ $rental->end_date->format('d M Y') }}</span>
                                <span class="text-[10px] text-gray-400 block">{{ $rental->total_days }} Hari</span>
                            </td>

                            <td class="p-4 text-right">
                                <strong class="text-xs text-gray-900 block">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong>
                                <span class="text-[10px] text-gray-400 block">Dep: Rp {{ number_format($rental->deposit_fee, 0, ',', '.') }}</span>
                            </td>

                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border inline-block {{ $rental->status_badge_class }}">
                                    {{ $rental->status_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 text-xs">
                                Tidak ada data persewaan yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
