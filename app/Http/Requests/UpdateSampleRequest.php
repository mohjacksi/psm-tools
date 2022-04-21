<?php

namespace App\Http\Requests;

use App\Models\Sample;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSampleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sample_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'sample_condition' => [
                'string',
                'nullable',
            ],
        ];
    }
}
