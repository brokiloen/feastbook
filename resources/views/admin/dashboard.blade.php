@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Recipes</p>
                <p class="text-3xl font-bold text-wood">{{ $recipeCount }}</p>
            </div>
            <div class="bg-burgundy/10 p-3 rounded-full">
                <svg class="w-8 h-8 text-burgundy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.recipes.index') }}" class="text-burgundy text-sm mt-4 inline-block hover:underline">View all &rarr;</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Categories</p>
                <p class="text-3xl font-bold text-wood">{{ $categoryCount }}</p>
            </div>
            <div class="bg-gold/20 p-3 rounded-full">
                <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="text-burgundy text-sm mt-4 inline-block hover:underline">Manage &rarr;</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Quick Actions</p>
            </div>
        </div>
        <div class="mt-4 space-y-2">
            <a href="{{ route('admin.recipes.create') }}" class="block bg-burgundy text-white px-4 py-2 rounded text-center hover:bg-burgundy-dark transition-colors">
                + Add New Recipe
            </a>
            <a href="{{ route('admin.categories.create') }}" class="block bg-wood text-white px-4 py-2 rounded text-center hover:bg-wood/80 transition-colors">
                + Add Category
            </a>
        </div>
    </div>
</div>

<!-- Recent Recipes -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="font-medieval text-xl text-wood">Recent Recipes</h2>
    </div>
    <div class="p-6">
        @if($recentRecipes->isEmpty())
            <p class="text-gray-500 text-center py-8">No recipes yet. <a href="{{ route('admin.recipes.create') }}" class="text-burgundy hover:underline">Add your first recipe!</a></p>
        @else
            <div class="space-y-4">
                @foreach($recentRecipes as $recipe)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
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
                            <div>
                                <h3 class="font-semibold text-wood">{{ $recipe->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $recipe->categories->pluck('name')->join(', ') }} &bull; {{ $recipe->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.recipes.edit', $recipe) }}" class="text-burgundy hover:underline text-sm">Edit</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

