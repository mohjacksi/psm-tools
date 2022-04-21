<?php

namespace App\Http\Requests;

use App\Models\PeptideProtein;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePeptideProteinRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('peptide_protein_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
