<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $recipeCount = Recipe::count();
        $categoryCount = Category::count();
        $recentRecipes = Recipe::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('recipeCount', 'categoryCount', 'recentRecipes'));
    }
}

