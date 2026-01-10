<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function index(): View
    {
        $recipes = Recipe::with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.recipes.index', compact('recipes'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $units = Ingredient::UNITS;

        return view('admin.recipes.create', compact('categories', 'units'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'servings' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'last_made' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'ingredients' => 'nullable|array',
            'ingredients.*.section' => 'nullable|string|max:100',
            'ingredients.*.name' => 'required_with:ingredients|string|max:255',
            'ingredients.*.quantity' => 'nullable|numeric|min:0',
            'ingredients.*.unit' => 'nullable|string|max:20',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('recipes', 'public');
        }

        // Sanitize instructions HTML - allow tags from Quill editor
        $instructions = $validated['instructions'] ?? null;
        if ($instructions) {
            $allowedTags = '<p><br><strong><em><b><i><u><s><ul><ol><li><a><h1><h2><h3><h4><h5><h6><blockquote><img><span>';
            $instructions = strip_tags($instructions, $allowedTags);
        }

        $recipe = Recipe::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'instructions' => $instructions,
            'servings' => $validated['servings'],
            'category_id' => $validated['category_id'],
            'last_made' => $validated['last_made'] ?? null,
            'photo' => $validated['photo'] ?? null,
        ]);

        // Create ingredients
        if (!empty($validated['ingredients'])) {
            foreach ($validated['ingredients'] as $ingredientData) {
                if (!empty($ingredientData['name'])) {
                    $recipe->ingredients()->create([
                        'section' => $ingredientData['section'] ?? null,
                        'name' => $ingredientData['name'],
                        'quantity' => $ingredientData['quantity'] ?? null,
                        'unit' => $ingredientData['unit'] ?? null,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Recipe created successfully.');
    }

    public function show(Recipe $recipe): View
    {
        $recipe->load(['category', 'ingredients']);
        return view('admin.recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe): View
    {
        $recipe->load('ingredients');
        $categories = Category::orderBy('name')->get();
        $units = Ingredient::UNITS;

        return view('admin.recipes.edit', compact('recipe', 'categories', 'units'));
    }

    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'servings' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'last_made' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_photo' => 'nullable|boolean',
            'ingredients' => 'nullable|array',
            'ingredients.*.section' => 'nullable|string|max:100',
            'ingredients.*.name' => 'required_with:ingredients|string|max:255',
            'ingredients.*.quantity' => 'nullable|numeric|min:0',
            'ingredients.*.unit' => 'nullable|string|max:20',
        ]);

        // Handle photo removal
        if ($request->boolean('remove_photo') && $recipe->photo) {
            Storage::disk('public')->delete($recipe->photo);
            $validated['photo'] = null;
        }
        // Handle photo upload
        elseif ($request->hasFile('photo')) {
            // Delete old photo
            if ($recipe->photo) {
                Storage::disk('public')->delete($recipe->photo);
            }
            $validated['photo'] = $request->file('photo')->store('recipes', 'public');
        } else {
            unset($validated['photo']);
        }

        unset($validated['remove_photo']);

        // Sanitize instructions HTML - allow tags from Quill editor
        $instructions = $validated['instructions'] ?? null;
        if ($instructions) {
            $allowedTags = '<p><br><strong><em><b><i><u><s><ul><ol><li><a><h1><h2><h3><h4><h5><h6><blockquote><img><span>';
            $instructions = strip_tags($instructions, $allowedTags);
        }

        $recipe->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'instructions' => $instructions,
            'servings' => $validated['servings'],
            'category_id' => $validated['category_id'],
            'last_made' => $validated['last_made'] ?? null,
            'photo' => $validated['photo'] ?? $recipe->photo,
        ]);

        // Update ingredients
        $recipe->ingredients()->delete();
        if (!empty($validated['ingredients'])) {
            foreach ($validated['ingredients'] as $ingredientData) {
                if (!empty($ingredientData['name'])) {
                    $recipe->ingredients()->create([
                        'section' => $ingredientData['section'] ?? null,
                        'name' => $ingredientData['name'],
                        'quantity' => $ingredientData['quantity'] ?? null,
                        'unit' => $ingredientData['unit'] ?? null,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Recipe updated successfully.');
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        // Delete photo if exists
        if ($recipe->photo) {
            Storage::disk('public')->delete($recipe->photo);
        }

        $recipe->delete();

        return redirect()
            ->route('admin.recipes.index')
            ->with('success', 'Recipe deleted successfully.');
    }
}

