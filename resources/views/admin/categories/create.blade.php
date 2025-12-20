@extends('layouts.admin')

@section('page-title', 'Add Category')

@section('content')
<div class="max-w-xl">
    <a href="{{ route('admin.categories.index') }}" class="text-burgundy hover:underline mb-4 inline-block">&larr; Back to Categories</a>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-burgundy text-white px-6 py-2 rounded hover:bg-burgundy-dark transition-colors">
                    Create Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

