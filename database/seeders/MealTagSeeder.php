<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MealTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $meal_id_min = 1;
        $meal_id_max = 5;

        $tag_id_min = 1;
        $tag_id_max = 10;

        $meal_tag_number = 10;

        foreach(range(1,$meal_tag_number) as $value){
            DB::table('meal_tag')->insert([
                'meal_id' => $faker->numberBetween($meal_id_min, $meal_id_max),
                'tag_id' => $faker->numberBetween($tag_id_min, $tag_id_max),
            ]);
        }
    }
}
