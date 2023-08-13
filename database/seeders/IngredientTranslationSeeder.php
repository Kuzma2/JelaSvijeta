<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class IngredientTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredient_number = 15;
        foreach(config('translatable.locales') as $locale){

            foreach(range(1,$ingredient_number) as $value){
                DB::table('ingredient_translations')->insert([
                    'ingredient_id' => $value,
                    'locale' => $locale,
                    'title' => 'Ingredient '.$value.' name in '.$locale.' language',
                ]);
            } 
    }
    }
}
