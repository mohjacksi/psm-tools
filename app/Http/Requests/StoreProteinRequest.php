<?php

namespace App\Http\Requests;

use App\Models\Protein;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProteinRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('protein_create');
    }

    public function rules()
    {
        return [
            'protein' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'protein_sequence' => [
                'string',
                'nullable',
            ],
        ];
    }
}
