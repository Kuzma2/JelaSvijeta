<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TagTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $tag_number = 10;

        foreach(config('translatable.locales') as $locale){

            foreach(range(1,$tag_number) as $value){
                DB::table('tag_translations')->insert([
                    'tag_id' => $value,
                    'locale' => $locale,
                    //'title' => $faker->sentence(),
                    'title' => 'Tag title '.$value.' name in '.$locale.' language',
                ]);
            } 
    }
    }
}
