<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExperimentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('experiments')->insert([
            'name'=>'Experiments1',
            'project_id'=>'1',
            'created_at' => now(),
        ]);
        DB::table('experiments')->insert([
            'name'=>'Experiments2',
            'project_id'=>'1',
            'created_at' => now(),
        ]);
        DB::table('experiments')->insert([
            'name'=>'Experiments3',
            'project_id'=>'2',
            'created_at' => now(),
        ]);
        DB::table('experiments')->insert([
            'name'=>'Experiments4',
            'project_id'=>'2',
            'created_at' => now(),
        ]);
        DB::table('experiments')->insert([
            'name'=>'Experiments5',
            'project_id'=>'3',
            'created_at' => now(),
        ]);
    }
}
