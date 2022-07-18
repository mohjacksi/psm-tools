<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sample_conditions')->insert([
            'name'=>'Good',
            'created_at' => now(),
        ]);
        DB::table('sample_conditions')->insert([
            'name'=>'Normal',
            'created_at' => now(),
        ]);
        DB::table('sample_conditions')->insert([
            'name'=>'Bad',
            'created_at' => now(),
        ]);
    }
}
