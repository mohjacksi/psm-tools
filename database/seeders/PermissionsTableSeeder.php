<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'project_create',
            ],
            [
                'id'    => 18,
                'title' => 'project_edit',
            ],
            [
                'id'    => 19,
                'title' => 'project_show',
            ],
            [
                'id'    => 20,
                'title' => 'project_delete',
            ],
            [
                'id'    => 21,
                'title' => 'project_access',
            ],
            [
                'id'    => 22,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 23,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 24,
                'title' => 'person_create',
            ],
            [
                'id'    => 25,
                'title' => 'person_edit',
            ],
            [
                'id'    => 26,
                'title' => 'person_show',
            ],
            [
                'id'    => 27,
                'title' => 'person_delete',
            ],
            [
                'id'    => 28,
                'title' => 'person_access',
            ],
            [
                'id'    => 29,
                'title' => 'sample_create',
            ],
            [
                'id'    => 30,
                'title' => 'sample_edit',
            ],
            [
                'id'    => 31,
                'title' => 'sample_show',
            ],
            [
                'id'    => 32,
                'title' => 'sample_delete',
            ],
            [
                'id'    => 33,
                'title' => 'sample_access',
            ],
            [
                'id'    => 34,
                'title' => 'option_access',
            ],
            [
                'id'    => 35,
                'title' => 'dna_region_create',
            ],
            [
                'id'    => 36,
                'title' => 'dna_region_edit',
            ],
            [
                'id'    => 37,
                'title' => 'dna_region_show',
            ],
            [
                'id'    => 38,
                'title' => 'dna_region_delete',
            ],
            [
                'id'    => 39,
                'title' => 'dna_region_access',
            ],
            [
                'id'    => 40,
                'title' => 'transcript_create',
            ],
            [
                'id'    => 41,
                'title' => 'transcript_edit',
            ],
            [
                'id'    => 42,
                'title' => 'transcript_show',
            ],
            [
                'id'    => 43,
                'title' => 'transcript_delete',
            ],
            [
                'id'    => 44,
                'title' => 'transcript_access',
            ],
            [
                'id'    => 45,
                'title' => 'protein_create',
            ],
            [
                'id'    => 46,
                'title' => 'protein_edit',
            ],
            [
                'id'    => 47,
                'title' => 'protein_show',
            ],
            [
                'id'    => 48,
                'title' => 'protein_delete',
            ],
            [
                'id'    => 49,
                'title' => 'protein_access',
            ],
            [
                'id'    => 50,
                'title' => 'peptide_create',
            ],
            [
                'id'    => 51,
                'title' => 'peptide_edit',
            ],
            [
                'id'    => 52,
                'title' => 'peptide_show',
            ],
            [
                'id'    => 53,
                'title' => 'peptide_delete',
            ],
            [
                'id'    => 54,
                'title' => 'peptide_access',
            ],
            [
                'id'    => 55,
                'title' => 'psm_tab_access',
            ],
            [
                'id'    => 56,
                'title' => 'psm_create',
            ],
            [
                'id'    => 57,
                'title' => 'psm_edit',
            ],
            [
                'id'    => 58,
                'title' => 'psm_show',
            ],
            [
                'id'    => 59,
                'title' => 'psm_delete',
            ],
            [
                'id'    => 60,
                'title' => 'psm_access',
            ],
            [
                'id'    => 61,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
