@extends('layouts.admin')

@section('page-title', 'Edit Recipe')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.recipes.index') }}" class="text-burgundy hover:underline mb-4 inline-block">&larr; Back to Recipes</a>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.recipes.update', $recipe) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Recipe Name *</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $recipe->name) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categories *</label>
                    <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-300 rounded-md p-3 @error('category_ids') border-red-500 @enderror">
                        @php
                            $selectedCategoryIds = old('category_ids', $recipe->categories->pluck('id')->toArray());
                        @endphp
                        @foreach($categories as $category)
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                                <input type="checkbox" 
                                       name="category_ids[]" 
                                       value="{{ $category->id }}"
                                       {{ in_array($category->id, $selectedCategoryIds) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-burgundy focus:ring-burgundy">
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('category_ids')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="w-full border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy @error('description') border-red-500 @enderror">{{ old('description', $recipe->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="servings" class="block text-sm font-medium text-gray-700 mb-2">Servings *</label>
                    <input type="number" 
                           name="servings" 
                           id="servings" 
                           value="{{ old('servings', $recipe->servings) }}"
                           min="1"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy @error('servings') border-red-500 @enderror"
                           required>
                    @error('servings')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_made" class="block text-sm font-medium text-gray-700 mb-2">Last Made</label>
                    <input type="date" 
                           name="last_made" 
                           id="last_made" 
                           value="{{ old('last_made', $recipe->last_made?->format('Y-m-d')) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
                </div>

                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                    @if($recipe->photo)
                        <div class="mb-2 flex items-center gap-4">
                            <img src="{{ $recipe->photo_url }}" alt="Current photo" class="w-20 h-20 object-cover rounded">
                            <label class="flex items-center gap-2 text-sm text-gray-600">
                                <input type="checkbox" name="remove_photo" value="1" class="rounded border-gray-300 text-burgundy focus:ring-burgundy">
                                Remove current photo
                            </label>
                        </div>
                    @endif
                    <input type="file" 
                           name="photo" 
                           id="photo"
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-md shadow-sm p-2 @error('photo') border-red-500 @enderror">
                    @error('photo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ingredients Section -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ingredients</label>
                <p class="text-sm text-gray-500 mb-4">Use sections to group ingredients (e.g., "For the sauce", "For the main dish"). Leave empty for ungrouped ingredients.</p>
                <div id="ingredients-container" class="space-y-3">
                    @forelse($recipe->ingredients as $index => $ingredient)
                        <div class="ingredient-row flex gap-3 items-start">
                            <input type="text" 
                                   name="ingredients[{{ $index }}][section]" 
                                   value="{{ old("ingredients.$index.section", $ingredient->section) }}"
                                   placeholder="Section (optional)"
                                   class="w-40 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy text-sm">
                            <input type="text" 
                                   name="ingredients[{{ $index }}][name]" 
                                   value="{{ old("ingredients.$index.name", $ingredient->name) }}"
                                   placeholder="Ingredient name"
                                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
                            <input type="number" 
                                   name="ingredients[{{ $index }}][quantity]" 
                                   value="{{ old("ingredients.$index.quantity", $ingredient->quantity) }}"
                                   placeholder="Qty"
                                   step="0.01"
                                   min="0"
                                   class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
                            <select name="ingredients[{{ $index }}][unit]" class="w-28 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
                                <option value="">Unit</option>
                                @foreach($units as $value => $label)
                                    <option value="{{ $value }}" {{ old("ingredients.$index.unit", $ingredient->unit) == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="removeIngredient(this)" class="text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @empty
                        <div class="ingredient-row flex gap-3 items-start">
                            <input type="text" 
                                   name="ingredients[0][section]" 
                                   placeholder="Section (optional)"
                                   class="w-40 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy text-sm">
                            <input type="text" 
                                   name="ingredients[0][name]" 
                                   placeholder="Ingredient name"
                                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
                            <input type="number" 
                                   name="ingredients[0][quantity]" 
                                   placeholder="Qty"
                                   step="0.01"
                                   min="0"
                                   class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
                            <select name="ingredients[0][unit]" class="w-28 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
                                <option value="">Unit</option>
                                @foreach($units as $value => $label)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="removeIngredient(this)" class="text-red-500 hover:text-red-700 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    @endforelse
                </div>
                <button type="button" onclick="addIngredient()" class="mt-3 text-burgundy hover:underline text-sm">
                    + Add Ingredient
                </button>
            </div>

            <!-- Instructions Section -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Instructions</label>
                <div id="instructions-editor" class="bg-white border border-gray-300 rounded-md" style="height: 300px;">{!! old('instructions', $recipe->instructions) !!}</div>
                <input type="hidden" name="instructions" id="instructions-input">
                @error('instructions')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-burgundy text-white px-6 py-2 rounded hover:bg-burgundy-dark transition-colors">
                    Update Recipe
                </button>
                <a href="{{ route('admin.recipes.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    // Initialize Quill
    const quill = new Quill('#instructions-editor', {
        theme: 'snow',
        placeholder: 'Step-by-step cooking instructions...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['blockquote'],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Sync Quill content to hidden input
    const instructionsInput = document.getElementById('instructions-input');
    
    // Initialize hidden input with current content
    instructionsInput.value = quill.root.innerHTML;
    
    // Sync on every change
    quill.on('text-change', function() {
        instructionsInput.value = quill.root.innerHTML;
    });
    
    // Also sync on form submit (backup)
    document.querySelector('form').addEventListener('submit', function() {
        instructionsInput.value = quill.root.innerHTML;
    });

    let ingredientIndex = {{ $recipe->ingredients->count() > 0 ? $recipe->ingredients->count() : 1 }};
    const units = @json($units);

    function addIngredient() {
        const container = document.getElementById('ingredients-container');
        const row = document.createElement('div');
        row.className = 'ingredient-row flex gap-3 items-start';
        
        let unitOptions = '<option value="">Unit</option>';
        for (const [value, label] of Object.entries(units)) {
            unitOptions += `<option value="${value}">${value}</option>`;
        }

        row.innerHTML = `
            <input type="text" 
                   name="ingredients[${ingredientIndex}][section]" 
                   placeholder="Section (optional)"
                   class="w-40 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy text-sm">
            <input type="text" 
                   name="ingredients[${ingredientIndex}][name]" 
                   placeholder="Ingredient name"
                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
            <input type="number" 
                   name="ingredients[${ingredientIndex}][quantity]" 
                   placeholder="Qty"
                   step="0.01"
                   min="0"
                   class="w-24 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
            <select name="ingredients[${ingredientIndex}][unit]" class="w-28 border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy">
                ${unitOptions}
            </select>
            <button type="button" onclick="removeIngredient(this)" class="text-red-500 hover:text-red-700 p-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        `;
        container.appendChild(row);
        ingredientIndex++;
    }

    function removeIngredient(button) {
        const row = button.closest('.ingredient-row');
        const container = document.getElementById('ingredients-container');
        if (container.children.length > 1) {
            row.remove();
        } else {
            row.querySelectorAll('input').forEach(input => input.value = '');
            row.querySelector('select').value = '';
        }
    }
</script>
@endpush
@endsection

