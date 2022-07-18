<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            ProjectsTableSeeder::class,
            ExperimentsTableSeeder::class,
            SpeciessTableSeeder::class,
            TissuesTableSeeder::class,
            SampleConditionsTableSeeder::class,
            SamplesTableSeeder::class,
        ]);
    }
}
