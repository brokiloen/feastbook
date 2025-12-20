@extends('layouts.admin')

@section('page-title', 'Categories')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-600">Manage recipe categories</p>
    <a href="{{ route('admin.categories.create') }}" class="bg-burgundy text-white px-4 py-2 rounded hover:bg-burgundy-dark transition-colors">
        + Add Category
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipes</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($categories as $category)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-wood">{{ $category->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">{{ $category->slug }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $category->recipes_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-burgundy hover:underline mr-4">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        No categories yet. <a href="{{ route('admin.categories.create') }}" class="text-burgundy hover:underline">Create your first category!</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

