<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Facades\DB;
use App\Models\Sample;
use Illuminate\Database\Seeder;

class SamplesTableSeeder extends Seeder
{
    public function run()
    {
        for ($i=1; $i < 11; $i++) {
            DB::table('samples')->insert([
                'name'=>'Sample '.$i,
                'project_id'=>'1',
                'species_id'=>'1',
                'tissue_id'=>rand(1,2),
                'sample_condition_id'=>rand(1,3),
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }
    }
}
