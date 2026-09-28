@extends('layouts.admin')

@section('title', 'Registered Clients')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-bold text-xl text-gray-900">Registered Atelier Clients</h1>
            <p class="text-xs text-gray-500">Client list registered on ChérieRent.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">Client</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Phone / Contact</th>
                        <th class="p-4">Shipping Address</th>
                        <th class="p-4 text-center">Reservations</th>
                        <th class="p-4">Joined Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $u)
                        <tr class="hover:bg-rose-50/20 transition">
                            <td class="p-4 flex items-center gap-3">
                                <img src="{{ $u->avatar ?? 'https://api.dicebear.com/7.x/adventurer/svg?seed='.$u->name }}" class="w-9 h-9 rounded-full border border-rose-300" alt="Avatar">
                                <div>
                                    <strong class="text-gray-900 text-xs block font-bold">{{ $u->name }}</strong>
                                    <span class="text-gray-500 text-[11px] block">{{ $u->email }}</span>
                                </div>
                            </td>

                            <td class="p-4">
                                @if($u->isAdmin())
                                    <span class="bg-purple-100 text-purple-700 font-bold px-2.5 py-1 rounded-full text-[10px]">Admin</span>
                                @else
                                    <span class="bg-rose-50 text-rose-700 border border-rose-200 font-bold px-2.5 py-1 rounded-full text-[10px]">Client Member</span>
                                @endif
                            </td>

                            <td class="p-4 text-gray-700 font-medium">
                                {{ $u->phone ?? '-' }}
                            </td>

                            <td class="p-4 text-gray-600 max-w-xs truncate">
                                {{ $u->address ?? '-' }}
                            </td>

                            <td class="p-4 text-center font-bold text-rose-700">
                                {{ $u->rentals_count }} Bookings
                            </td>

                            <td class="p-4 text-gray-400 text-[11px]">
                                {{ $u->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
