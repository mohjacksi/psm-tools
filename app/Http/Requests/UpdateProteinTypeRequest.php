<?php

namespace App\Http\Requests;

use App\Models\ProteinType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProteinTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('protein_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:protein_types,name,' . request()->route('protein_type')->id,
            ],
        ];
    }
}
