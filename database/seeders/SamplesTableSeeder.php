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
        $faker = Factory::create();
        for ($i=1; $i < 11; $i++) { 
            
            DB::table('samples')->insert([
                'name'=>'Sample '.$i,
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }
    }
}
