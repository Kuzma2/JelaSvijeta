<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        $category_number = 5;

        foreach(range(1,$category_number) as $value){
            DB::table('categories')->insert([
                'slug' => 'category-'.$value,
            ]);
        } 
    }
}
