@extends('layouts.admin')

@section('title', 'Add Gown')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between border-b border-gray-200 pb-4">
        <div>
            <h1 class="font-bold text-xl text-gray-900">Add New Gown to Atelier</h1>
            <p class="text-xs text-gray-500">Specify garment details, daily rental rate, deposit fee, and upload image.</p>
        </div>
        <a href="{{ route('admin.dresses.index') }}" class="text-xs font-bold text-gray-600 hover:text-gray-900">&larr; Cancel & Return</a>
    </div>

    <form action="{{ route('admin.dresses.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl border border-gray-200 shadow-xs space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Gown Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Chérie Corset Ribbon Gown" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none focus:border-rose-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Category</label>
                <select name="category_id" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none font-bold text-gray-800">
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Daily Rental Rate (Rp)</label>
                <input type="number" name="rental_price_per_day" value="{{ old('rental_price_per_day', 150000) }}" required step="5000" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none focus:border-rose-500 font-bold text-rose-700">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Security Deposit Fee (Rp)</label>
                <input type="number" name="deposit_fee" value="{{ old('deposit_fee', 100000) }}" required step="5000" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none focus:border-rose-500 font-bold text-amber-800">
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Size</label>
                <select name="size" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none font-bold">
                    <option value="XS">XS</option>
                    <option value="S" selected>S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="Free Size">Free Size</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Color Shade</label>
                <input type="text" name="color" value="{{ old('color', 'Dusty Rose') }}" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Fabric Composition</label>
                <input type="text" name="fabric" value="{{ old('fabric', 'Silk Satin & French Lace') }}" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Stock Quantity</label>
                <input type="number" name="stock" value="{{ old('stock', 2) }}" min="1" required class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none font-bold">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Bust Measurement</label>
                <input type="text" name="chest_size" value="{{ old('chest_size', '82 - 86 cm') }}" placeholder="82-86 cm" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Waist Measurement</label>
                <input type="text" name="waist_size" value="{{ old('waist_size', '64 - 68 cm') }}" placeholder="64-68 cm" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Length</label>
                <input type="text" name="length" value="{{ old('length', '120 cm') }}" placeholder="120 cm" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Gown Description</label>
            <textarea name="description" rows="4" required placeholder="Describe garment silhouette, lace accents, and recommended events..." class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">{{ old('description') }}</textarea>
        </div>

        <div class="bg-rose-50/40 p-6 rounded-2xl border border-rose-200 space-y-4">
            <h4 class="font-bold text-xs text-rose-900 uppercase tracking-wider">Garment Image</h4>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Option A: Upload Image File</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-rose-100 file:text-rose-800">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Option B: Or Direct Image URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..." class="w-full p-2.5 rounded-xl border border-rose-200 text-xs bg-white outline-none">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" class="rounded text-rose-600">
            <label for="is_featured" class="text-xs font-bold text-gray-700 cursor-pointer">Feature on Homepage Edition</label>
        </div>

        <button type="submit" class="w-full btn-igari-primary py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-md">
            Save Gown Piece
        </button>
    </form>

</div>
@endsection
