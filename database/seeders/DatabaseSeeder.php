<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@feastbook.local'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
            ]
        );

        // Run other seeders
        $this->call([
            CategorySeeder::class,
            RecipeSeeder::class,
        ]);
    }
}
