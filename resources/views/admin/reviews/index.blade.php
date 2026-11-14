@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-serif-editorial text-2xl font-bold text-gray-900">Kelola Reviews</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola ulasan pelanggan yang ditambahkan oleh admin</p>
        </div>
        <a href="{{ route('admin.reviews.create') }}" class="btn-igari-primary text-xs px-4 py-2 rounded-full font-bold">
            + Tambah Review
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-rose-100 shadow-sm overflow-hidden">
        @if($reviews->count() > 0)
            <table class="w-full">
                <thead class="bg-rose-50 border-b border-rose-100">
                    <tr>
                        <th class="text-left text-xs font-bold text-gray-700 uppercase tracking-wider px-6 py-4">User</th>
                        <th class="text-left text-xs font-bold text-gray-700 uppercase tracking-wider px-6 py-4">Dress</th>
                        <th class="text-left text-xs font-bold text-gray-700 uppercase tracking-wider px-6 py-4">Rating</th>
                        <th class="text-left text-xs font-bold text-gray-700 uppercase tracking-wider px-6 py-4">Comment</th>
                        <th class="text-left text-xs font-bold text-gray-700 uppercase tracking-wider px-6 py-4">Tanggal</th>
                        <th class="text-left text-xs font-bold text-gray-700 uppercase tracking-wider px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-rose-50">
                    @foreach($reviews as $review)
                        <tr class="hover:bg-rose-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="text-xs font-semibold text-gray-900">{{ $review->user->name }}</div>
                                <div class="text-[10px] text-gray-500">{{ $review->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-semibold text-gray-900">{{ $review->dress->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">
                                    <span class="text-amber-500 font-bold text-sm">★</span>
                                    <span class="text-xs font-bold text-gray-900">{{ $review->rating }}/5</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs text-gray-600 max-w-xs line-clamp-2">{{ $review->comment }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-gray-500">{{ $review->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.reviews.edit', $review->id) }}" class="text-xs text-rose-600 hover:text-rose-800 font-semibold">Edit</a>
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 border-t border-rose-100">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <p class="text-sm text-gray-500">Belum ada review. Silakan tambah review baru.</p>
            </div>
        @endif
    </div>
</div>
@endsection
