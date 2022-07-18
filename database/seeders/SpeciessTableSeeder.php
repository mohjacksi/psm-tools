<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('speciess')->insert([
            'name'=>'Human',
            'created_at' => now(),
        ]);
        DB::table('speciess')->insert([
            'name'=>'Rohu',
            'created_at' => now(),
        ]);
        DB::table('speciess')->insert([
            'name'=>'mice',
            'created_at' => now(),
        ]);
    }
}
