<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\View\View;

class RecipeController extends Controller
{
    public function index(): View
    {
        $recipes = Recipe::with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('recipes'));
    }

    public function show(Recipe $recipe): View
    {
        $recipe->load(['category', 'ingredients']);

        return view('recipes.show', compact('recipe'));
    }
}

