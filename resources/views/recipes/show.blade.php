@extends('layouts.public')

@section('title', $recipe->name)
@section('header-title', $recipe->name)
@section('header-subtitle', $recipe->category->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Link -->
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-burgundy hover:text-burgundy-dark mb-8 font-medieval transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Recipes
    </a>

    <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-wood/10">
        <!-- Recipe Image -->
        @if($recipe->photo)
            <div class="aspect-[16/9] overflow-hidden">
                <img src="{{ $recipe->photo_url }}" alt="{{ $recipe->name }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-8">
            <!-- Category Badge -->
            <div class="flex items-center justify-between mb-6">
                <span class="bg-burgundy text-parchment text-sm font-medieval px-4 py-2 rounded-full">
                    {{ $recipe->category->name }}
                </span>
                @if($recipe->last_made)
                    <div class="flex items-center gap-2 text-wood/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Last made: {{ $recipe->last_made->format('F d, Y') }}</span>
                    </div>
                @endif
            </div>

            <!-- Description -->
            @if($recipe->description)
                <div class="mb-8">
                    <h2 class="font-medieval text-2xl text-wood mb-4">About this Recipe</h2>
                    <div class="w-16 h-1 bg-gold mb-4"></div>
                    <p class="text-wood/80 leading-relaxed text-lg">{{ $recipe->description }}</p>
                </div>
            @endif

            <!-- Ingredients -->
            @if($recipe->ingredients->isNotEmpty())
                <div class="bg-parchment-dark/30 rounded-lg p-6 mb-8">
                    <h2 class="font-medieval text-2xl text-wood mb-4">Ingredients</h2>
                    <div class="w-16 h-1 bg-gold mb-6"></div>
                    
                    <ul class="space-y-3" id="ingredients-list">
                        @foreach($recipe->ingredients as $ingredient)
                            <li class="flex items-center gap-4 ingredient-item">
                                <label class="flex items-center gap-4 cursor-pointer group flex-1">
                                    <input type="checkbox" 
                                           class="ingredient-checkbox w-5 h-5 rounded border-2 border-burgundy text-burgundy focus:ring-burgundy focus:ring-offset-0 cursor-pointer"
                                           data-ingredient-id="{{ $ingredient->id }}">
                                    <span class="flex-1 text-lg group-hover:text-burgundy transition-colors">
                                        <span class="ingredient-name">{{ $ingredient->name }}</span>
                                        @if($ingredient->quantity || $ingredient->unit)
                                            <span class="text-wood/60 ml-2">
                                                ({{ $ingredient->formatted_quantity }})
                                            </span>
                                        @endif
                                    </span>
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-6 pt-4 border-t border-wood/20">
                        <button type="button" onclick="clearAllCheckboxes()" class="text-burgundy hover:text-burgundy-dark font-medieval text-sm transition-colors">
                            Clear all
                        </button>
                    </div>
                </div>
            @endif

            <!-- Instructions -->
            @if($recipe->instructions)
                <div class="mb-8">
                    <h2 class="font-medieval text-2xl text-wood mb-4">Instructions</h2>
                    <div class="w-16 h-1 bg-gold mb-4"></div>
                    <div class="text-wood/80 leading-relaxed text-lg prose prose-lg max-w-none">
                        {!! nl2br(e($recipe->instructions)) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Save checkbox state to localStorage
    const recipeId = {{ $recipe->id }};
    const storageKey = `feastbook_recipe_${recipeId}_checked`;

    function loadCheckboxState() {
        const saved = localStorage.getItem(storageKey);
        if (saved) {
            const checkedIds = JSON.parse(saved);
            document.querySelectorAll('.ingredient-checkbox').forEach(checkbox => {
                const id = checkbox.dataset.ingredientId;
                checkbox.checked = checkedIds.includes(id);
                updateIngredientStyle(checkbox);
            });
        }
    }

    function saveCheckboxState() {
        const checkedIds = [];
        document.querySelectorAll('.ingredient-checkbox:checked').forEach(checkbox => {
            checkedIds.push(checkbox.dataset.ingredientId);
        });
        localStorage.setItem(storageKey, JSON.stringify(checkedIds));
    }

    function updateIngredientStyle(checkbox) {
        const item = checkbox.closest('.ingredient-item');
        const name = item.querySelector('.ingredient-name');
        if (checkbox.checked) {
            name.classList.add('line-through', 'text-wood/40');
        } else {
            name.classList.remove('line-through', 'text-wood/40');
        }
    }

    function clearAllCheckboxes() {
        document.querySelectorAll('.ingredient-checkbox').forEach(checkbox => {
            checkbox.checked = false;
            updateIngredientStyle(checkbox);
        });
        saveCheckboxState();
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        loadCheckboxState();

        document.querySelectorAll('.ingredient-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateIngredientStyle(this);
                saveCheckboxState();
            });
        });
    });
</script>
@endpush
@endsection

