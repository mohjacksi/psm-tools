<?php

namespace App\Http\Requests;

use App\Models\Protein;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProteinRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('protein_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'peptide_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
