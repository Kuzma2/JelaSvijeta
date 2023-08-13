<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        /*
        DB::table('tags')->insert([
            'title' => 'Title tag 1 in ENG language',
            'slug' => 'tag-1',
        ]);

        DB::table('tags')->insert([
            'title' => 'Title tag 2 in ENG language',
            'slug' => 'tag-2',
        ]);*/

        $tag_number = 10;

        foreach(range(1,$tag_number) as $value){
            DB::table('tags')->insert([
                'slug' => 'tag-'.$value,
            ]);
        } 
    }
}
