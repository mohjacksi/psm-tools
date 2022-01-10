<?php

namespace App\Http\Requests;

use App\Models\Peptide;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePeptideRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('peptide_create');
    }

    public function rules()
    {
        return [
            'sequence' => [
                'string',
                'nullable',
            ],
            'genomic_location' => [
                'string',
                'nullable',
            ],
        ];
    }
}
