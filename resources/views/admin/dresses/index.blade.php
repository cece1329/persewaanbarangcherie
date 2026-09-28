@extends('layouts.admin')

@section('title', 'Gown Collection')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-bold text-xl text-gray-900">Atelier Gown Collection</h1>
            <p class="text-xs text-gray-500">Manage archive pieces, daily rental rates, deposit fees, and stock status.</p>
        </div>

        <a href="{{ route('admin.dresses.create') }}" class="btn-igari-primary text-xs px-5 py-2.5 rounded-full font-bold shadow-xs flex items-center gap-2">
            <span>Add New Gown</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">Gown Piece</th>
                        <th class="p-4">Category</th>
                        <th class="p-4">Sizing & Fabric</th>
                        <th class="p-4 text-right">Daily Rate</th>
                        <th class="p-4 text-right">Deposit</th>
                        <th class="p-4 text-center">Stock</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($dresses as $dress)
                        <tr class="hover:bg-rose-50/20 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $dress->image_url }}" class="w-12 h-14 object-cover rounded-xl border border-gray-200" alt="Dress">
                                    <div>
                                        <strong class="text-gray-900 text-xs block font-bold">{{ $dress->name }}</strong>
                                        <span class="text-[10px] text-amber-500 font-bold">★ {{ number_format($dress->rating, 1) }}</span>
                                        @if($dress->is_featured)
                                            <span class="text-[9px] bg-rose-50 text-rose-700 border border-rose-200 font-bold px-2 py-0.5 rounded-full ml-1">Featured</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="p-4">
                                <span class="bg-purple-50 text-purple-700 font-bold px-2.5 py-1 rounded-full text-[10px]">
                                    {{ $dress->category->name ?? '-' }}
                                </span>
                            </td>

                            <td class="p-4">
                                <strong class="text-gray-800 text-xs block">Size {{ $dress->size }}</strong>
                                <span class="text-gray-500 text-[10px] block">{{ $dress->fabric ?? '-' }}</span>
                            </td>

                            <td class="p-4 text-right font-bold text-rose-700 text-sm">
                                {{ $dress->formatted_price }}
                            </td>

                            <td class="p-4 text-right font-bold text-amber-800 text-xs">
                                {{ $dress->formatted_deposit }}
                            </td>

                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $dress->stock }} Unit
                                </span>
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.dresses.edit', $dress->id) }}" class="bg-slate-100 text-slate-700 hover:bg-slate-200 px-3 py-1.5 rounded-lg font-bold text-[11px] transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.dresses.destroy', $dress->id) }}" method="POST" onsubmit="return confirm('Remove this gown from collection?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 text-rose-700 hover:bg-rose-100 px-3 py-1.5 rounded-lg font-bold text-[11px] transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-100">
            {{ $dresses->links() }}
        </div>
    </div>

</div>
@endsection
