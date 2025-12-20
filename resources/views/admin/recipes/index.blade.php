@extends('layouts.admin')

@section('page-title', 'Recipes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-600">Manage all recipes</p>
    <a href="{{ route('admin.recipes.create') }}" class="bg-burgundy text-white px-4 py-2 rounded hover:bg-burgundy-dark transition-colors">
        + Add Recipe
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipe</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Made</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($recipes as $recipe)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded bg-gray-200 overflow-hidden flex-shrink-0">
                                @if($recipe->photo)
                                    <img src="{{ $recipe->photo_url }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <span class="font-medium text-wood">{{ $recipe->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="bg-burgundy/10 text-burgundy text-xs px-2 py-1 rounded">{{ $recipe->category->name }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">
                        {{ $recipe->last_made ? $recipe->last_made->format('M d, Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">
                        {{ $recipe->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <a href="{{ route('recipes.show', $recipe) }}" class="text-gray-600 hover:underline mr-4" target="_blank">View</a>
                        <a href="{{ route('admin.recipes.edit', $recipe) }}" class="text-burgundy hover:underline mr-4">Edit</a>
                        <form action="{{ route('admin.recipes.destroy', $recipe) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        No recipes yet. <a href="{{ route('admin.recipes.create') }}" class="text-burgundy hover:underline">Add your first recipe!</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

