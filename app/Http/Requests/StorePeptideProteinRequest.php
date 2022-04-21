<?php

namespace App\Http\Requests;

use App\Models\PeptideProtein;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePeptideProteinRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('peptide_protein_create');
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
