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
                'title' => 'role_access',
            ],
            [
                'id'    => 11,
                'title' => 'user_create',
            ],
            [
                'id'    => 12,
                'title' => 'user_edit',
            ],
            [
                'id'    => 13,
                'title' => 'user_show',
            ],
            [
                'id'    => 14,
                'title' => 'user_delete',
            ],
            [
                'id'    => 15,
                'title' => 'user_access',
            ],
            [
                'id'    => 16,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 18,
                'title' => 'project_create',
            ],
            [
                'id'    => 19,
                'title' => 'project_edit',
            ],
            [
                'id'    => 20,
                'title' => 'project_show',
            ],
            [
                'id'    => 21,
                'title' => 'project_delete',
            ],
            [
                'id'    => 22,
                'title' => 'project_access',
            ],
            [
                'id'    => 23,
                'title' => 'psm_tab_access',
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
                'title' => 'dna_region_create',
            ],
            [
                'id'    => 35,
                'title' => 'dna_region_edit',
            ],
            [
                'id'    => 36,
                'title' => 'dna_region_show',
            ],
            [
                'id'    => 37,
                'title' => 'dna_region_delete',
            ],
            [
                'id'    => 38,
                'title' => 'dna_region_access',
            ],
            [
                'id'    => 39,
                'title' => 'transcript_create',
            ],
            [
                'id'    => 40,
                'title' => 'transcript_edit',
            ],
            [
                'id'    => 41,
                'title' => 'transcript_show',
            ],
            [
                'id'    => 42,
                'title' => 'transcript_delete',
            ],
            [
                'id'    => 43,
                'title' => 'transcript_access',
            ],
            [
                'id'    => 44,
                'title' => 'psm_create',
            ],
            [
                'id'    => 45,
                'title' => 'psm_edit',
            ],
            [
                'id'    => 46,
                'title' => 'psm_show',
            ],
            [
                'id'    => 47,
                'title' => 'psm_delete',
            ],
            [
                'id'    => 48,
                'title' => 'psm_access',
            ],
            [
                'id'    => 49,
                'title' => 'option_access',
            ],
            [
                'id'    => 50,
                'title' => 'experiment_tab_access',
            ],
            [
                'id'    => 51,
                'title' => 'experiment_create',
            ],
            [
                'id'    => 52,
                'title' => 'experiment_edit',
            ],
            [
                'id'    => 53,
                'title' => 'experiment_show',
            ],
            [
                'id'    => 54,
                'title' => 'experiment_delete',
            ],
            [
                'id'    => 55,
                'title' => 'experiment_access',
            ],
            [
                'id'    => 56,
                'title' => 'experiment_biological_set_create',
            ],
            [
                'id'    => 57,
                'title' => 'experiment_biological_set_edit',
            ],
            [
                'id'    => 58,
                'title' => 'experiment_biological_set_show',
            ],
            [
                'id'    => 59,
                'title' => 'experiment_biological_set_delete',
            ],
            [
                'id'    => 60,
                'title' => 'experiment_biological_set_access',
            ],
            [
                'id'    => 61,
                'title' => 'biological_set_create',
            ],
            [
                'id'    => 62,
                'title' => 'biological_set_edit',
            ],
            [
                'id'    => 63,
                'title' => 'biological_set_show',
            ],
            [
                'id'    => 64,
                'title' => 'biological_set_delete',
            ],
            [
                'id'    => 65,
                'title' => 'biological_set_access',
            ],
            [
                'id'    => 66,
                'title' => 'fraction_create',
            ],
            [
                'id'    => 67,
                'title' => 'fraction_edit',
            ],
            [
                'id'    => 68,
                'title' => 'fraction_show',
            ],
            [
                'id'    => 69,
                'title' => 'fraction_delete',
            ],
            [
                'id'    => 70,
                'title' => 'fraction_access',
            ],
            [
                'id'    => 71,
                'title' => 'general_tab_access',
            ],
            [
                'id'    => 72,
                'title' => 'fragment_method_create',
            ],
            [
                'id'    => 73,
                'title' => 'fragment_method_edit',
            ],
            [
                'id'    => 74,
                'title' => 'fragment_method_show',
            ],
            [
                'id'    => 75,
                'title' => 'fragment_method_delete',
            ],
            [
                'id'    => 76,
                'title' => 'fragment_method_access',
            ],
            [
                'id'    => 77,
                'title' => 'stripe_create',
            ],
            [
                'id'    => 78,
                'title' => 'stripe_edit',
            ],
            [
                'id'    => 79,
                'title' => 'stripe_show',
            ],
            [
                'id'    => 80,
                'title' => 'stripe_delete',
            ],
            [
                'id'    => 81,
                'title' => 'stripe_access',
            ],
            [
                'id'    => 82,
                'title' => 'channel_create',
            ],
            [
                'id'    => 83,
                'title' => 'channel_edit',
            ],
            [
                'id'    => 84,
                'title' => 'channel_show',
            ],
            [
                'id'    => 85,
                'title' => 'channel_delete',
            ],
            [
                'id'    => 86,
                'title' => 'channel_access',
            ],
            [
                'id'    => 87,
                'title' => 'channel_psm_create',
            ],
            [
                'id'    => 88,
                'title' => 'channel_psm_edit',
            ],
            [
                'id'    => 89,
                'title' => 'channel_psm_show',
            ],
            [
                'id'    => 90,
                'title' => 'channel_psm_delete',
            ],
            [
                'id'    => 91,
                'title' => 'channel_psm_access',
            ],
            [
                'id'    => 92,
                'title' => 'peptide_protein_tab_access',
            ],
            [
                'id'    => 93,
                'title' => 'other_requirement_tab_access',
            ],
            [
                'id'    => 94,
                'title' => 'protein_create',
            ],
            [
                'id'    => 95,
                'title' => 'protein_edit',
            ],
            [
                'id'    => 96,
                'title' => 'protein_show',
            ],
            [
                'id'    => 97,
                'title' => 'protein_delete',
            ],
            [
                'id'    => 98,
                'title' => 'protein_access',
            ],
            [
                'id'    => 99,
                'title' => 'peptide_create',
            ],
            [
                'id'    => 100,
                'title' => 'peptide_edit',
            ],
            [
                'id'    => 101,
                'title' => 'peptide_show',
            ],
            [
                'id'    => 102,
                'title' => 'peptide_delete',
            ],
            [
                'id'    => 103,
                'title' => 'peptide_access',
            ],
            [
                'id'    => 104,
                'title' => 'peptide_psm_create',
            ],
            [
                'id'    => 105,
                'title' => 'peptide_psm_edit',
            ],
            [
                'id'    => 106,
                'title' => 'peptide_psm_show',
            ],
            [
                'id'    => 107,
                'title' => 'peptide_psm_delete',
            ],
            [
                'id'    => 108,
                'title' => 'peptide_psm_access',
            ],
            [
                'id'    => 109,
                'title' => 'peptide_protein_create',
            ],
            [
                'id'    => 110,
                'title' => 'peptide_protein_edit',
            ],
            [
                'id'    => 111,
                'title' => 'peptide_protein_show',
            ],
            [
                'id'    => 112,
                'title' => 'peptide_protein_delete',
            ],
            [
                'id'    => 113,
                'title' => 'peptide_protein_access',
            ],
            [
                'id'    => 114,
                'title' => 'tissue_create',
            ],
            [
                'id'    => 115,
                'title' => 'tissue_edit',
            ],
            [
                'id'    => 116,
                'title' => 'tissue_show',
            ],
            [
                'id'    => 117,
                'title' => 'tissue_delete',
            ],
            [
                'id'    => 118,
                'title' => 'tissue_access',
            ],
            [
                'id'    => 119,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
