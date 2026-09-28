@extends('layouts.admin')

@section('title', 'Edit Gown')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between border-b border-gray-200 pb-4">
        <div>
            <h1 class="font-bold text-xl text-gray-900">Edit Gown Piece: {{ $dress->name }}</h1>
            <p class="text-xs text-gray-500">Update rates, dimensions, description, or garment image.</p>
        </div>
        <a href="{{ route('admin.dresses.index') }}" class="text-xs font-bold text-gray-600 hover:text-gray-900">&larr; Return to Gown Collection</a>
    </div>

    <form action="{{ route('admin.dresses.update', $dress->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl border border-gray-200 shadow-xs space-y-6">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-4 bg-rose-50/50 p-4 rounded-2xl border border-rose-200">
            <img src="{{ $dress->image_url }}" class="w-16 h-20 object-cover rounded-xl border border-rose-300" alt="Current Photo">
            <div>
                <span class="text-xs font-bold text-rose-900">Current Garment Image</span>
                <p class="text-[10px] text-gray-500">Leaving image inputs empty will preserve the current photograph.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Gown Name</label>
                <input type="text" name="name" value="{{ old('name', $dress->name) }}" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Category</label>
                <select name="category_id" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none font-bold text-gray-800">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $dress->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Daily Rental Rate (Rp)</label>
                <input type="number" name="rental_price_per_day" value="{{ old('rental_price_per_day', (int)$dress->rental_price_per_day) }}" required step="5000" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none font-bold text-rose-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Security Deposit Fee (Rp)</label>
                <input type="number" name="deposit_fee" value="{{ old('deposit_fee', (int)$dress->deposit_fee) }}" required step="5000" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none font-bold text-amber-800">
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Size</label>
                <select name="size" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none font-bold">
                    @foreach(['XS', 'S', 'M', 'L', 'XL', 'Free Size'] as $sz)
                        <option value="{{ $sz }}" {{ old('size', $dress->size) == $sz ? 'selected' : '' }}>{{ $sz }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Color Shade</label>
                <input type="text" name="color" value="{{ old('color', $dress->color) }}" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Fabric Composition</label>
                <input type="text" name="fabric" value="{{ old('fabric', $dress->fabric) }}" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Stock Quantity</label>
                <input type="number" name="stock" value="{{ old('stock', $dress->stock) }}" min="0" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none font-bold">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Bust Measurement</label>
                <input type="text" name="chest_size" value="{{ old('chest_size', $dress->chest_size) }}" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Waist Measurement</label>
                <input type="text" name="waist_size" value="{{ old('waist_size', $dress->waist_size) }}" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Length</label>
                <input type="text" name="length" value="{{ old('length', $dress->length) }}" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Garment Description</label>
            <textarea name="description" rows="4" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">{{ old('description', $dress->description) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Availability Status</label>
            <select name="status" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none font-bold">
                <option value="available" {{ $dress->status == 'available' ? 'selected' : '' }}>Available for Reservation</option>
                <option value="maintenance" {{ $dress->status == 'maintenance' ? 'selected' : '' }}>Under Maintenance / Laundry (Unavailable)</option>
            </select>
        </div>

        <div class="bg-rose-50/40 p-6 rounded-2xl border border-rose-200 space-y-4">
            <h4 class="font-bold text-xs text-rose-900 uppercase tracking-wider">Update Garment Image (Optional)</h4>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Option A: Upload New Image File</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-rose-100 file:text-rose-800">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Option B: Or Direct Image URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..." class="w-full p-2.5 rounded-xl border border-rose-200 text-xs bg-white outline-none">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ $dress->is_featured ? 'checked' : '' }} class="rounded text-rose-600">
            <label for="is_featured" class="text-xs font-bold text-gray-700 cursor-pointer">Feature on Homepage Edition</label>
        </div>

        <button type="submit" class="w-full btn-igari-primary py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-md">
            Save Garment Changes
        </button>
    </form>

</div>
@endsection
