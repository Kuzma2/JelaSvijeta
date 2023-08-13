<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            'title' => 'created',
        ]);

        DB::table('statuses')->insert([
            'title' => 'modified',
        ]);

        DB::table('statuses')->insert([
            'title' => 'deleted',
        ]);
    }
}
