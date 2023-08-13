<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredient_number = 15;

        foreach(range(1,$ingredient_number) as $value){
            DB::table('ingredients')->insert([
                'slug' => 'ingredient-'.$value,
            ]);
        } 
    }
}
