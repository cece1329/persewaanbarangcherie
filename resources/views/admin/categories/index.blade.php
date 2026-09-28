@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-xs space-y-4">
        <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3">Add Category</h3>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Category Name</label>
                <input type="text" name="name" required placeholder="e.g. Evening Ballgown" class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Description</label>
                <textarea name="description" rows="3" placeholder="Brief category concept description..." class="w-full p-3 rounded-xl border border-gray-300 text-xs bg-gray-50/50 outline-none"></textarea>
            </div>

            <button type="submit" class="w-full btn-igari-primary py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-md">
                Add Category
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-200 shadow-xs p-6 space-y-4">
        <h3 class="font-bold text-gray-900 text-base border-b border-gray-100 pb-3">Registered Categories</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-3">Category Name</th>
                        <th class="p-3">Slug</th>
                        <th class="p-3">Description</th>
                        <th class="p-3 text-center">Gown Count</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($categories as $category)
                        <tr>
                            <td class="p-3 font-bold text-gray-900">{{ $category->name }}</td>
                            <td class="p-3 font-mono text-gray-500 text-[11px]">{{ $category->slug }}</td>
                            <td class="p-3 text-gray-600 max-w-xs truncate">{{ $category->description ?? '-' }}</td>
                            <td class="p-3 text-center">
                                <span class="bg-rose-50 text-rose-700 border border-rose-200 font-bold px-2.5 py-1 rounded-full text-[10px]">
                                    {{ $category->dresses_count }} Pieces
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
