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
            <!-- Category Badge & Actions -->
            <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                <div class="flex items-center gap-4 flex-wrap">
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
                
                <a href="{{ route('recipes.make', $recipe) }}" 
                   class="inline-flex items-center gap-2 bg-gold hover:bg-gold-light text-wood font-medieval px-5 py-2 rounded-full shadow-md hover:shadow-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Make Today
                </a>
            </div>
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

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
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-medieval text-2xl text-wood">Ingredients</h2>
                        
                        <!-- Servings Adjuster -->
                        <div class="flex items-center gap-3">
                            <span class="text-wood/70 text-sm font-medieval">Servings:</span>
                            <div class="flex items-center bg-white rounded-lg shadow-sm border border-wood/20">
                                <button type="button" 
                                        onclick="adjustServings(-1)" 
                                        class="px-3 py-2 text-burgundy hover:bg-parchment-dark/50 rounded-l-lg transition-colors font-bold text-lg">
                                    −
                                </button>
                                <span id="current-servings" class="px-4 py-2 font-medieval text-lg text-wood min-w-[3rem] text-center">
                                    {{ $recipe->servings }}
                                </span>
                                <button type="button" 
                                        onclick="adjustServings(1)" 
                                        class="px-3 py-2 text-burgundy hover:bg-parchment-dark/50 rounded-r-lg transition-colors font-bold text-lg">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
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
                                            <span class="ingredient-quantity text-wood/60 ml-2"
                                                  data-base-quantity="{{ $ingredient->quantity }}"
                                                  data-unit="{{ $ingredient->unit }}">
                                                (<span class="quantity-value">{{ $ingredient->quantity ? rtrim(rtrim(number_format($ingredient->quantity, 2), '0'), '.') : '' }}</span>{{ $ingredient->unit ? ' ' . $ingredient->unit : '' }})
                                            </span>
                                        @endif
                                    </span>
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-6 pt-4 border-t border-wood/20 flex items-center justify-between">
                        <button type="button" onclick="clearAllCheckboxes()" class="text-burgundy hover:text-burgundy-dark font-medieval text-sm transition-colors">
                            Clear all
                        </button>
                        <button type="button" onclick="resetServings()" class="text-burgundy hover:text-burgundy-dark font-medieval text-sm transition-colors">
                            Reset servings
                        </button>
                    </div>
                </div>
            @endif

            <!-- Instructions -->
            @if($recipe->instructions)
                <div class="mb-8">
                    <h2 class="font-medieval text-2xl text-wood mb-4">Instructions</h2>
                    <div class="w-16 h-1 bg-gold mb-4"></div>
                    <div class="recipe-instructions">
                        {!! $recipe->instructions !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Recipe and servings data
    const recipeId = {{ $recipe->id }};
    const baseServings = {{ $recipe->servings }};
    let currentServings = baseServings;
    
    // Storage keys
    const checkboxStorageKey = `feastbook_recipe_${recipeId}_checked`;
    const servingsStorageKey = `feastbook_recipe_${recipeId}_servings`;

    // Servings adjustment
    function adjustServings(delta) {
        const newServings = currentServings + delta;
        if (newServings >= 1 && newServings <= 100) {
            currentServings = newServings;
            updateServingsDisplay();
            recalculateQuantities();
            saveServingsState();
        }
    }

    function resetServings() {
        currentServings = baseServings;
        updateServingsDisplay();
        recalculateQuantities();
        saveServingsState();
    }

    function updateServingsDisplay() {
        document.getElementById('current-servings').textContent = currentServings;
    }

    function recalculateQuantities() {
        const ratio = currentServings / baseServings;
        
        document.querySelectorAll('.ingredient-quantity').forEach(el => {
            const baseQuantity = parseFloat(el.dataset.baseQuantity);
            if (!isNaN(baseQuantity) && baseQuantity > 0) {
                const newQuantity = baseQuantity * ratio;
                const quantityEl = el.querySelector('.quantity-value');
                if (quantityEl) {
                    // Format nicely: remove trailing zeros
                    let formatted;
                    if (newQuantity % 1 === 0) {
                        formatted = newQuantity.toString();
                    } else if (newQuantity < 0.1) {
                        formatted = newQuantity.toFixed(3).replace(/\.?0+$/, '');
                    } else {
                        formatted = newQuantity.toFixed(2).replace(/\.?0+$/, '');
                    }
                    quantityEl.textContent = formatted;
                }
            }
        });
    }

    function saveServingsState() {
        localStorage.setItem(servingsStorageKey, currentServings.toString());
    }

    function loadServingsState() {
        const saved = localStorage.getItem(servingsStorageKey);
        if (saved) {
            const savedServings = parseInt(saved);
            if (!isNaN(savedServings) && savedServings >= 1 && savedServings <= 100) {
                currentServings = savedServings;
                updateServingsDisplay();
                recalculateQuantities();
            }
        }
    }

    // Checkbox state management
    function loadCheckboxState() {
        const saved = localStorage.getItem(checkboxStorageKey);
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
        localStorage.setItem(checkboxStorageKey, JSON.stringify(checkedIds));
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
        loadServingsState();
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

