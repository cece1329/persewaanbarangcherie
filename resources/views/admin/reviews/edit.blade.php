@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.reviews') }}" class="text-xs text-rose-600 hover:text-rose-800 font-semibold mb-4 inline-block">
            &larr; Kembali ke Reviews
        </a>
        <h1 class="font-serif-editorial text-2xl font-bold text-gray-900 mt-2">Edit Review</h1>
        <p class="text-sm text-gray-500 mt-1">Edit ulasan pelanggan</p>
    </div>

    <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-8">
        <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- User Selection -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih User</label>
                    <select name="user_id" required class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 outline-none text-gray-700 font-medium">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $review->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dress Selection -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Dress</label>
                    <select name="dress_id" required class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 outline-none text-gray-700 font-medium">
                        <option value="">-- Pilih Dress --</option>
                        @foreach($dresses as $dress)
                            <option value="{{ $dress->id }}" {{ $review->dress_id == $dress->id ? 'selected' : '' }}>{{ $dress->name }} - {{ $dress->formatted_price }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Rating</label>
                    <div class="flex items-center gap-4">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" required class="hidden peer" {{ $review->rating == $i ? 'checked' : '' }}>
                                <span class="text-2xl text-gray-300 peer-checked:text-amber-500 transition">★</span>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Comment -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Komentar Review</label>
                    <textarea name="comment" rows="4" required minlength="5" placeholder="Masukkan komentar review..."
                        class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 outline-none text-gray-700 font-medium resize-none">{{ $review->comment }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4 pt-4">
                    <a href="{{ route('admin.reviews') }}" class="btn-igari-secondary text-xs px-6 py-3 rounded-full font-bold">
                        Batal
                    </a>
                    <button type="submit" class="btn-igari-primary text-xs px-6 py-3 rounded-full font-bold">
                        Update Review
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
