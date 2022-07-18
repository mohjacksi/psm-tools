<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'name'=>'Project1',
            'created_at' => now(),
        ]);
        DB::table('projects')->insert([
            'name'=>'Project2',
            'created_at' => now(),
        ]);
        DB::table('projects')->insert([
            'name'=>'Project3',
            'created_at' => now(),
        ]);
        DB::table('projects')->insert([
            'name'=>'Project4',
            'created_at' => now(),
        ]);
    }
}
