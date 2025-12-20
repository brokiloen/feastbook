<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Appetizers',
            'Main Courses',
            'Desserts',
            'Soups',
            'Breads',
            'Beverages',
            'Side Dishes',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}

