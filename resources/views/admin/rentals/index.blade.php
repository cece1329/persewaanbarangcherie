@extends('layouts.admin')

@section('title', 'Manage Reservations')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-bold text-xl text-gray-900">Reservations Management</h1>
            <p class="text-xs text-gray-500">Update fulfillment status, track returns, and manage security deposits.</p>
        </div>

        <form action="{{ route('admin.rentals.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search code, client name, gown..." class="px-4 py-2 text-xs border border-gray-300 rounded-xl bg-white outline-none w-64">
            <button type="submit" class="bg-slate-900 text-white text-xs px-4 py-2 rounded-xl font-bold hover:bg-slate-800 transition">
                Search
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">Code & Date</th>
                        <th class="p-4">Client</th>
                        <th class="p-4">Reserved Gown</th>
                        <th class="p-4 text-right">Total Payable</th>
                        <th class="p-4 text-center">Current Status</th>
                        <th class="p-4 text-center">Update Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($rentals as $rental)
                        <tr class="hover:bg-rose-50/20 transition">
                            <td class="p-4">
                                <strong class="font-mono text-sm text-rose-700 block">#{{ $rental->rental_code }}</strong>
                                <span class="text-gray-500 block">{{ $rental->created_at->format('d M Y, H:i') }}</span>
                                <span class="text-[10px] text-gray-400 font-semibold">Schedule: {{ $rental->start_date->format('d/m') }} - {{ $rental->end_date->format('d/m/Y') }}</span>
                            </td>

                            <td class="p-4">
                                <strong class="text-gray-900 text-xs block">{{ $rental->user->name }}</strong>
                                <span class="text-gray-500 block">{{ $rental->user->phone ?? $rental->user->email }}</span>
                                <span class="text-[10px] text-purple-700 font-semibold block">{{ ucfirst($rental->shipping_method) }}</span>
                            </td>

                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $rental->dress->image_url }}" class="w-10 h-12 object-cover rounded-lg border border-gray-200" alt="Dress">
                                    <div>
                                        <strong class="text-gray-900 text-xs block">{{ $rental->dress->name }}</strong>
                                        <span class="text-rose-700 font-bold text-[10px]">Size {{ $rental->dress->size }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="p-4 text-right">
                                <strong class="text-sm text-rose-700 block">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</strong>
                                <span class="text-[10px] text-amber-800 font-semibold block">Deposit: Rp {{ number_format($rental->deposit_fee, 0, ',', '.') }}</span>
                            </td>

                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold border inline-block {{ $rental->status_badge_class }}">
                                    {{ $rental->status_label }}
                                </span>
                            </td>

                            <td class="p-4 text-center">
                                <form action="{{ route('admin.rentals.update-status', $rental->id) }}" method="POST" class="flex items-center justify-center gap-1">
                                    @csrf
                                    <select name="status" class="p-1.5 rounded-lg border border-gray-300 text-[11px] bg-white text-gray-800 font-semibold outline-none">
                                        <option value="pending_payment" {{ $rental->status == 'pending_payment' ? 'selected' : '' }}>Payment Pending</option>
                                        <option value="paid" {{ $rental->status == 'paid' ? 'selected' : '' }}>Reserved / Processing</option>
                                        <option value="shipping" {{ $rental->status == 'shipping' ? 'selected' : '' }}>In Transit / Ready</option>
                                        <option value="in_use" {{ $rental->status == 'in_use' ? 'selected' : '' }}>Active Rental</option>
                                        <option value="returned" {{ $rental->status == 'returned' ? 'selected' : '' }}>Returned (Inspection)</option>
                                        <option value="completed" {{ $rental->status == 'completed' ? 'selected' : '' }}>Completed (Refunded)</option>
                                        <option value="cancelled" {{ $rental->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="bg-rose-700 text-white text-[10px] px-3 py-1.5 rounded-lg font-bold hover:bg-rose-800 transition">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $rentals->links() }}
        </div>
    </div>

</div>
@endsection
