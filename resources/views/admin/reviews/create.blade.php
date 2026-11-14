@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.reviews.index') }}" class="text-xs text-rose-600 hover:text-rose-800 font-semibold mb-4 inline-block">
            &larr; Kembali ke Reviews
        </a>
        <h1 class="font-serif-editorial text-2xl font-bold text-gray-900 mt-2">Tambah Review Baru</h1>
        <p class="text-sm text-gray-500 mt-1">Tambah ulasan pelanggan (berdasarkan review via WhatsApp)</p>
    </div>

    <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-8">
        <form action="{{ route('admin.reviews.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- User Name -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama User</label>
                    <input type="text" name="user_name" required placeholder="Masukkan nama user..."
                        class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 outline-none text-gray-700 font-medium">
                </div>

                <!-- Dress Selection -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Dress</label>
                    <select name="dress_id" required class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 outline-none text-gray-700 font-medium">
                        <option value="">-- Pilih Dress --</option>
                        @foreach($dresses as $dress)
                            <option value="{{ $dress->id }}">{{ $dress->name }} - {{ $dress->formatted_price }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Rating</label>
                    <input type="hidden" name="rating" id="rating-input" required>
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <span onclick="setRating({{ $i }})" class="star text-3xl transition cursor-pointer text-gray-300" data-rating="{{ $i }}">★</span>
                        @endfor
                    </div>
                </div>

                <!-- Comment -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Komentar Review</label>
                    <textarea name="comment" rows="4" required minlength="5" placeholder="Masukkan komentar review dari pelanggan..."
                        class="w-full p-3 rounded-xl border border-rose-200 text-xs bg-rose-50/40 outline-none text-gray-700 font-medium resize-none"></textarea>
                    <p class="text-[10px] text-gray-400 mt-1">Minimal 5 karakter</p>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4 pt-4">
                    <a href="{{ route('admin.reviews.index') }}" class="btn-igari-secondary text-xs px-6 py-3 rounded-full font-bold">
                        Batal
                    </a>
                    <button type="submit" class="btn-igari-primary text-xs px-6 py-3 rounded-full font-bold">
                        Simpan Review
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function setRating(rating) {
    document.getElementById('rating-input').value = rating;
    const stars = document.querySelectorAll('.star');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-amber-500');
        } else {
            star.classList.remove('text-amber-500');
            star.classList.add('text-gray-300');
        }
    });
}
</script>
@endsection
