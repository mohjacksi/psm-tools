<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TissuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tissues')->insert([
            'name'=>'connective tissue',
            'created_at' => now(),
        ]);
        DB::table('tissues')->insert([
            'name'=>'epithelial tissue',
            'created_at' => now(),
        ]);
        DB::table('tissues')->insert([
            'name'=>'muscle tissue',
            'created_at' => now(),
        ]);
        DB::table('tissues')->insert([
            'name'=>'nervous tissuetissue',
            'created_at' => now(),
        ]);
    }
}
