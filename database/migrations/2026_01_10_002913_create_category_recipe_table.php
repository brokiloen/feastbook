<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create pivot table
        Schema::create('category_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['category_id', 'recipe_id']);
        });

        // Migrate existing data from recipes.category_id to pivot table
        $recipes = DB::table('recipes')->whereNotNull('category_id')->get();
        foreach ($recipes as $recipe) {
            DB::table('category_recipe')->insert([
                'category_id' => $recipe->category_id,
                'recipe_id' => $recipe->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Remove category_id column from recipes table
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add category_id back to recipes
        Schema::table('recipes', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
        });

        // Migrate data back (take first category for each recipe)
        $pivotData = DB::table('category_recipe')
            ->select('recipe_id', DB::raw('MIN(category_id) as category_id'))
            ->groupBy('recipe_id')
            ->get();
        
        foreach ($pivotData as $data) {
            DB::table('recipes')
                ->where('id', $data->recipe_id)
                ->update(['category_id' => $data->category_id]);
        }

        Schema::dropIfExists('category_recipe');
    }
};
