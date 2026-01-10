@extends('layouts.public')

@section('title', 'Всички рецепти')
@section('header-title', 'Feastbook')
@section('header-subtitle', 'Колекция от средновековни пиршества и рецепти')

@section('content')
<div class="mb-8">
    <h2 class="font-medieval-bg text-4xl text-wood mb-2">Нашите рецепти</h2>
    <div class="w-24 h-1 bg-gold"></div>
</div>

@if($recipes->isEmpty())
    <div class="bg-parchment-dark/50 rounded-lg p-12 text-center border-2 border-dashed border-wood/30">
        <svg class="w-16 h-16 mx-auto text-wood/40 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <h3 class="font-medieval-bg text-2xl text-wood mb-2">Все още няма рецепти</h3>
        <p class="text-wood/70 font-medieval-bg text-lg">Кухнята чака първата си рецепта. Проверете отново скоро!</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($recipes as $recipe)
            <a href="{{ route('recipes.show', $recipe) }}" class="recipe-card bg-white rounded-lg overflow-hidden shadow-lg border border-wood/10">
                <div class="aspect-[4/3] overflow-hidden bg-parchment-dark">
                    @if($recipe->photo)
                        <img src="{{ $recipe->photo_url }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-20 h-20 text-wood/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-burgundy text-parchment text-xs font-medieval px-3 py-1 rounded-full">
                            {{ $recipe->category->name }}
                        </span>
                    </div>
                    <h3 class="font-medieval text-xl text-wood font-semibold mb-2">{{ $recipe->name }}</h3>
                    @if($recipe->description)
                        <p class="text-wood/70 text-sm line-clamp-2 mb-3">{{ Str::limit($recipe->description, 100) }}</p>
                    @endif
                    @if($recipe->last_made)
                        <div class="flex items-center gap-2 text-sm text-wood/60">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Последно: {{ $recipe->last_made->format('d.m.Y') }}</span>
                        </div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
@endif
@endsection

