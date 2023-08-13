<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Meal;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $meal_number = 10;

        $status_id_min = 1;
        $status_id_max = 3;

        $category_id_min = 1;
        $category_id_max = 5;

        $nullProbability = 20;
                
        foreach(range(1,$meal_number) as $value){
            $createdAt = $faker->dateTimeBetween('-1 year', 'now');
            DB::table('meals')->insert([
                'status_id' => $faker->numberBetween($status_id_min, $status_id_max),
                'category_id' => $faker->boolean($nullProbability) ? null : $faker->numberBetween($category_id_min, $category_id_max),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        } 
    }
}
