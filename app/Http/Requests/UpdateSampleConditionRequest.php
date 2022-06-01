<?php

namespace App\Http\Requests;

use App\Models\SampleCondition;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSampleConditionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sample_condition_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:sample_conditions,name,' . request()->route('sample_condition')->id,
            ],
        ];
    }
}
