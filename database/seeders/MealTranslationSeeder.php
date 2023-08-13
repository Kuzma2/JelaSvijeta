<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MealTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $meal_number = 10;

        foreach(config('translatable.locales') as $locale){
        foreach(range(1,$meal_number) as $value){
            DB::table('meal_translations')->insert([
                'meal_id' => $value,
                'locale' => $locale,
                //'title' => $faker->word(),
                'title' => 'Meal '.$value.' name in '.$locale.' language',
                //'description' => $faker->sentence(),
                'description' => 'Description '.$value.' for meal in '.$locale.' language.',
            ]);
        } 
    }
    }
}
