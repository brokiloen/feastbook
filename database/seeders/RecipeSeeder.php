<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainCourse = Category::where('slug', 'main-courses')->first();
        $desserts = Category::where('slug', 'desserts')->first();
        $soups = Category::where('slug', 'soups')->first();
        $breads = Category::where('slug', 'breads')->first();

        // Recipe 1: Roasted Venison
        $venison = Recipe::create([
            'name' => 'Roasted Venison with Herbs',
            'description' => 'A traditional medieval dish of slow-roasted venison, seasoned with aromatic herbs and served with root vegetables. This hearty meal was a favorite at grand feasts and royal banquets throughout the realm.',
            'instructions' => "1. Remove the venison from the cold storage and let it reach room temperature for one hour.\n\n2. Prepare a paste by crushing the garlic cloves with salt, then mix with finely chopped rosemary and thyme.\n\n3. Score the venison leg with a sharp knife and rub the herb paste deeply into the cuts.\n\n4. Place in a roasting vessel and pour the red wine around (not over) the meat.\n\n5. Drizzle with honey and season with pepper.\n\n6. Roast over medium coals for approximately 3 hours, basting occasionally with the pan juices.\n\n7. The meat is ready when the juices run clear. Let rest for 15 minutes before carving.\n\n8. Serve with the pan juices spooned over the sliced meat.",
            'category_id' => $mainCourse->id,
            'last_made' => now()->subDays(5),
        ]);
        $venison->ingredients()->createMany([
            ['name' => 'Venison leg', 'quantity' => 2, 'unit' => 'kg'],
            ['name' => 'Rosemary', 'quantity' => 30, 'unit' => 'g'],
            ['name' => 'Thyme', 'quantity' => 20, 'unit' => 'g'],
            ['name' => 'Garlic cloves', 'quantity' => 8, 'unit' => 'pcs'],
            ['name' => 'Red wine', 'quantity' => 500, 'unit' => 'ml'],
            ['name' => 'Honey', 'quantity' => 3, 'unit' => 'tbsp'],
            ['name' => 'Salt', 'quantity' => 2, 'unit' => 'tsp'],
            ['name' => 'Black pepper', 'quantity' => 1, 'unit' => 'tsp'],
        ]);

        // Recipe 2: Honey Cakes
        $honeyCakes = Recipe::create([
            'name' => 'Medieval Honey Cakes',
            'description' => 'Sweet and fragrant honey cakes spiced with cinnamon and ginger. These delightful treats were commonly served at celebrations and were believed to bring good fortune to those who partook.',
            'instructions' => "1. Warm the honey and butter together in a pot over gentle heat until the butter melts completely.\n\n2. In a large bowl, sift together the flour, cinnamon, ginger, and nutmeg.\n\n3. Make a well in the center and pour in the warm honey mixture.\n\n4. Beat the eggs and add them to the bowl, stirring until a smooth dough forms.\n\n5. Chop the almonds finely and fold them into the dough.\n\n6. Grease small cake molds with butter and fill each three-quarters full.\n\n7. Bake in a moderate oven until golden brown and a knife comes out clean.\n\n8. Allow to cool before removing from molds. Drizzle with extra honey if desired.",
            'category_id' => $desserts->id,
            'last_made' => now()->subDays(12),
        ]);
        $honeyCakes->ingredients()->createMany([
            ['name' => 'Flour', 'quantity' => 400, 'unit' => 'g'],
            ['name' => 'Honey', 'quantity' => 250, 'unit' => 'g'],
            ['name' => 'Butter', 'quantity' => 150, 'unit' => 'g'],
            ['name' => 'Eggs', 'quantity' => 3, 'unit' => 'pcs'],
            ['name' => 'Cinnamon', 'quantity' => 2, 'unit' => 'tsp'],
            ['name' => 'Ginger powder', 'quantity' => 1, 'unit' => 'tsp'],
            ['name' => 'Nutmeg', 'quantity' => 0.5, 'unit' => 'tsp'],
            ['name' => 'Almonds', 'quantity' => 100, 'unit' => 'g'],
        ]);

        // Recipe 3: Pottage
        $pottage = Recipe::create([
            'name' => 'Hearty Vegetable Pottage',
            'description' => 'A thick and nourishing soup made from seasonal vegetables and grains. This was the daily sustenance for peasants and nobles alike, though the ingredients varied greatly based on one\'s station.',
            'instructions' => "1. Rinse the barley thoroughly and soak in cold water for at least one hour.\n\n2. Chop the cabbage into rough pieces, slice the leeks, and dice the turnips.\n\n3. In a large cauldron, bring the vegetable broth to a boil.\n\n4. Add the drained barley and bay leaves, reduce to a simmer.\n\n5. After 30 minutes, add the turnips and continue cooking.\n\n6. After another 15 minutes, add the cabbage and leeks.\n\n7. Season with salt and simmer until all vegetables are tender and the pottage has thickened.\n\n8. Remove the bay leaves, stir in chopped parsley, and serve hot with crusty bread.",
            'category_id' => $soups->id,
            'last_made' => now()->subDays(3),
        ]);
        $pottage->ingredients()->createMany([
            ['name' => 'Cabbage', 'quantity' => 500, 'unit' => 'g'],
            ['name' => 'Leeks', 'quantity' => 300, 'unit' => 'g'],
            ['name' => 'Turnips', 'quantity' => 200, 'unit' => 'g'],
            ['name' => 'Barley', 'quantity' => 150, 'unit' => 'g'],
            ['name' => 'Vegetable broth', 'quantity' => 1.5, 'unit' => 'L'],
            ['name' => 'Bay leaves', 'quantity' => 3, 'unit' => 'pcs'],
            ['name' => 'Salt', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Parsley', 'quantity' => 30, 'unit' => 'g'],
        ]);

        // Recipe 4: Manchet Bread
        $bread = Recipe::create([
            'name' => 'Manchet White Bread',
            'description' => 'The finest white bread of medieval times, reserved for the nobility. Made from finely sifted wheat flour, this bread was a symbol of wealth and status at any dining table.',
            'instructions' => "1. Dissolve the yeast in warm water with the honey. Let stand until frothy, about 10 minutes.\n\n2. Sift the flour with the salt into a large wooden bowl.\n\n3. Melt the butter and add to the yeast mixture.\n\n4. Pour the wet ingredients into the flour and mix until a shaggy dough forms.\n\n5. Turn onto a floured surface and knead vigorously for 10 minutes until smooth and elastic.\n\n6. Place in a greased bowl, cover with a cloth, and let rise in a warm place until doubled.\n\n7. Punch down the dough and shape into round loaves. Let rise again for 30 minutes.\n\n8. Slash the tops with a sharp knife and bake in a hot oven until golden and hollow-sounding when tapped.",
            'category_id' => $breads->id,
            'last_made' => now()->subWeeks(2),
        ]);
        $bread->ingredients()->createMany([
            ['name' => 'White flour', 'quantity' => 500, 'unit' => 'g'],
            ['name' => 'Active yeast', 'quantity' => 7, 'unit' => 'g'],
            ['name' => 'Warm water', 'quantity' => 300, 'unit' => 'ml'],
            ['name' => 'Salt', 'quantity' => 1, 'unit' => 'tsp'],
            ['name' => 'Honey', 'quantity' => 1, 'unit' => 'tbsp'],
            ['name' => 'Butter', 'quantity' => 30, 'unit' => 'g'],
        ]);
    }
}

