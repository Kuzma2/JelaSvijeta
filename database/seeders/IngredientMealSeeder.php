<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class IngredientMealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $faker = Faker::create();

        $ingredient_id_min = 1;
        $ingredient_id_max = 15;

        $meal_id_min = 1;
        $meal_id_max = 5;

        $ingredient_meal_number = 10;
                
        foreach(range(1,$ingredient_meal_number) as $value){
            DB::table('ingredient_meal')->insert([
                'ingredient_id' => $faker->numberBetween($ingredient_id_min, $ingredient_id_max),
                'meal_id' => $faker->numberBetween($meal_id_min, $meal_id_max),
            ]);
        }
    }
}
