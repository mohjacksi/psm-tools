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
                'title' => 'sample_create',
            ],
            [
                'id'    => 25,
                'title' => 'sample_edit',
            ],
            [
                'id'    => 26,
                'title' => 'sample_show',
            ],
            [
                'id'    => 27,
                'title' => 'sample_delete',
            ],
            [
                'id'    => 28,
                'title' => 'sample_access',
            ],
            [
                'id'    => 29,
                'title' => 'dna_region_create',
            ],
            [
                'id'    => 30,
                'title' => 'dna_region_edit',
            ],
            [
                'id'    => 31,
                'title' => 'dna_region_show',
            ],
            [
                'id'    => 32,
                'title' => 'dna_region_delete',
            ],
            [
                'id'    => 33,
                'title' => 'dna_region_access',
            ],
            [
                'id'    => 34,
                'title' => 'transcript_create',
            ],
            [
                'id'    => 35,
                'title' => 'transcript_edit',
            ],
            [
                'id'    => 36,
                'title' => 'transcript_show',
            ],
            [
                'id'    => 37,
                'title' => 'transcript_delete',
            ],
            [
                'id'    => 38,
                'title' => 'transcript_access',
            ],
            [
                'id'    => 39,
                'title' => 'psm_create',
            ],
            [
                'id'    => 40,
                'title' => 'psm_edit',
            ],
            [
                'id'    => 41,
                'title' => 'psm_show',
            ],
            [
                'id'    => 42,
                'title' => 'psm_delete',
            ],
            [
                'id'    => 43,
                'title' => 'psm_access',
            ],
            [
                'id'    => 44,
                'title' => 'option_access',
            ],
            [
                'id'    => 45,
                'title' => 'experiment_tab_access',
            ],
            [
                'id'    => 46,
                'title' => 'experiment_create',
            ],
            [
                'id'    => 47,
                'title' => 'experiment_edit',
            ],
            [
                'id'    => 48,
                'title' => 'experiment_show',
            ],
            [
                'id'    => 49,
                'title' => 'experiment_delete',
            ],
            [
                'id'    => 50,
                'title' => 'experiment_access',
            ],
            [
                'id'    => 51,
                'title' => 'biological_set_create',
            ],
            [
                'id'    => 52,
                'title' => 'biological_set_edit',
            ],
            [
                'id'    => 53,
                'title' => 'biological_set_show',
            ],
            [
                'id'    => 54,
                'title' => 'biological_set_delete',
            ],
            [
                'id'    => 55,
                'title' => 'biological_set_access',
            ],
            [
                'id'    => 56,
                'title' => 'fraction_create',
            ],
            [
                'id'    => 57,
                'title' => 'fraction_edit',
            ],
            [
                'id'    => 58,
                'title' => 'fraction_show',
            ],
            [
                'id'    => 59,
                'title' => 'fraction_delete',
            ],
            [
                'id'    => 60,
                'title' => 'fraction_access',
            ],
            [
                'id'    => 61,
                'title' => 'general_tab_access',
            ],
            [
                'id'    => 62,
                'title' => 'fragment_method_create',
            ],
            [
                'id'    => 63,
                'title' => 'fragment_method_edit',
            ],
            [
                'id'    => 64,
                'title' => 'fragment_method_show',
            ],
            [
                'id'    => 65,
                'title' => 'fragment_method_delete',
            ],
            [
                'id'    => 66,
                'title' => 'fragment_method_access',
            ],
            [
                'id'    => 67,
                'title' => 'strip_create',
            ],
            [
                'id'    => 68,
                'title' => 'strip_edit',
            ],
            [
                'id'    => 69,
                'title' => 'strip_show',
            ],
            [
                'id'    => 70,
                'title' => 'strip_delete',
            ],
            [
                'id'    => 71,
                'title' => 'strip_access',
            ],
            [
                'id'    => 72,
                'title' => 'channel_create',
            ],
            [
                'id'    => 73,
                'title' => 'channel_edit',
            ],
            [
                'id'    => 74,
                'title' => 'channel_show',
            ],
            [
                'id'    => 75,
                'title' => 'channel_delete',
            ],
            [
                'id'    => 76,
                'title' => 'channel_access',
            ],
            [
                'id'    => 77,
                'title' => 'peptide_protein_tab_access',
            ],
            [
                'id'    => 78,
                'title' => 'other_requirement_tab_access',
            ],
            [
                'id'    => 79,
                'title' => 'protein_create',
            ],
            [
                'id'    => 80,
                'title' => 'protein_edit',
            ],
            [
                'id'    => 81,
                'title' => 'protein_show',
            ],
            [
                'id'    => 82,
                'title' => 'protein_delete',
            ],
            [
                'id'    => 83,
                'title' => 'protein_access',
            ],
            [
                'id'    => 84,
                'title' => 'peptide_create',
            ],
            [
                'id'    => 85,
                'title' => 'peptide_edit',
            ],
            [
                'id'    => 86,
                'title' => 'peptide_show',
            ],
            [
                'id'    => 87,
                'title' => 'peptide_delete',
            ],
            [
                'id'    => 88,
                'title' => 'peptide_access',
            ],
            [
                'id'    => 89,
                'title' => 'tissue_create',
            ],
            [
                'id'    => 90,
                'title' => 'tissue_edit',
            ],
            [
                'id'    => 91,
                'title' => 'tissue_show',
            ],
            [
                'id'    => 92,
                'title' => 'tissue_delete',
            ],
            [
                'id'    => 93,
                'title' => 'tissue_access',
            ],
            [
                'id'    => 94,
                'title' => 'sample_condition_create',
            ],
            [
                'id'    => 95,
                'title' => 'sample_condition_edit',
            ],
            [
                'id'    => 96,
                'title' => 'sample_condition_show',
            ],
            [
                'id'    => 97,
                'title' => 'sample_condition_delete',
            ],
            [
                'id'    => 98,
                'title' => 'sample_condition_access',
            ],
            [
                'id'    => 99,
                'title' => 'species_create',
            ],
            [
                'id'    => 100,
                'title' => 'species_edit',
            ],
            [
                'id'    => 101,
                'title' => 'species_show',
            ],
            [
                'id'    => 102,
                'title' => 'species_delete',
            ],
            [
                'id'    => 103,
                'title' => 'species_access',
            ],
            [
                'id'    => 104,
                'title' => 'peptide_with_modification_create',
            ],
            [
                'id'    => 105,
                'title' => 'peptide_with_modification_edit',
            ],
            [
                'id'    => 106,
                'title' => 'peptide_with_modification_show',
            ],
            [
                'id'    => 107,
                'title' => 'peptide_with_modification_delete',
            ],
            [
                'id'    => 108,
                'title' => 'peptide_with_modification_access',
            ],
            [
                'id'    => 109,
                'title' => 'peptid_category_create',
            ],
            [
                'id'    => 110,
                'title' => 'peptid_category_edit',
            ],
            [
                'id'    => 111,
                'title' => 'peptid_category_show',
            ],
            [
                'id'    => 112,
                'title' => 'peptid_category_delete',
            ],
            [
                'id'    => 113,
                'title' => 'peptid_category_access',
            ],
            [
                'id'    => 114,
                'title' => 'protein_type_create',
            ],
            [
                'id'    => 115,
                'title' => 'protein_type_edit',
            ],
            [
                'id'    => 116,
                'title' => 'protein_type_show',
            ],
            [
                'id'    => 117,
                'title' => 'protein_type_delete',
            ],
            [
                'id'    => 118,
                'title' => 'protein_type_access',
            ],
            [
                'id'    => 119,
                'title' => 'upload_form_create',
            ],
            [
                'id'    => 120,
                'title' => 'upload_form_edit',
            ],
            [
                'id'    => 121,
                'title' => 'upload_form_show',
            ],
            [
                'id'    => 122,
                'title' => 'upload_form_delete',
            ],
            [
                'id'    => 123,
                'title' => 'upload_form_access',
            ],
            [
                'id'    => 124,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
