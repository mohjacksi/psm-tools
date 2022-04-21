<?php

namespace App\Http\Requests;

use App\Models\Tissue;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTissueRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tissue_create');
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
