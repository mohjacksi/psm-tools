<?php

namespace App\Http\Requests;

use App\Models\BiologicalSet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBiologicalSetRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('biological_set_create');
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
