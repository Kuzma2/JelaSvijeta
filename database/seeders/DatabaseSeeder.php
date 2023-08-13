<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            TagSeeder::class,
            MealSeeder::class,
            StatusSeeder::class,
            CategorySeeder::class,
            IngredientSeeder::class,
            IngredientMealSeeder::class,
            MealTagSeeder::class,
            MealTranslationSeeder::class,
            TagTranslationSeeder::class,
            CategoryTranslationSeeder::class,
            IngredientTranslationSeeder::class,
        ]);
    }
}
