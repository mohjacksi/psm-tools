<?php

namespace App\Http\Requests;

use App\Models\ProteinType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProteinTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('protein_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:protein_types',
            ],
        ];
    }
}
