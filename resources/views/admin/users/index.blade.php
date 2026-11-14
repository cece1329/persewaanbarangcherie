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
            <table class="w-full text-left text-xs min-w-[800px]">
                <thead class="bg-slate-100 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">Client</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Status Email</th>
                        <th class="p-4">Phone / Contact</th>
                        <th class="p-4">Shipping Address</th>
                        <th class="p-4 text-center">Reservations</th>
                        <th class="p-4">Joined Date</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $u)
                        <tr class="hover:bg-rose-50/20 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $u->avatar ?? 'https://api.dicebear.com/7.x/adventurer/svg?seed='.$u->name }}" class="w-9 h-9 rounded-full border border-rose-300 shrink-0" alt="Avatar">
                                    <div class="min-w-0">
                                        <strong class="text-gray-900 text-xs block font-bold truncate">{{ $u->name }}</strong>
                                        <span class="text-gray-500 text-[11px] block truncate">{{ $u->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="p-4 whitespace-nowrap">
                                @if($u->isAdmin())
                                    <span class="bg-purple-100 text-purple-700 font-bold px-2.5 py-1 rounded-full text-[10px] inline-block whitespace-nowrap">Admin</span>
                                @else
                                    <span class="bg-rose-50 text-rose-700 border border-rose-200 font-bold px-2.5 py-1 rounded-full text-[10px] inline-block whitespace-nowrap">Member</span>
                                @endif
                            </td>

                            <td class="p-4 whitespace-nowrap">
                                @if($u->isAdmin() || $u->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        ✓ Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        ⏳ Belum Verif
                                    </span>
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

                            <td class="p-4 text-right">
                                @if($u->isAdmin())
                                    <span class="text-gray-400 text-[11px] italic">Admin System</span>
                                @else
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus akun pelanggan {{ $u->name }} ({{ $u->email }})? Data dan riwayat terkait akan ikut terhapus.')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 font-bold text-[11px] transition flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            <span class="hidden sm:inline">Hapus Akun</span>
                                            <span class="sm:hidden">Hapus</span>
                                        </button>
                                    </form>
                                @endif
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
