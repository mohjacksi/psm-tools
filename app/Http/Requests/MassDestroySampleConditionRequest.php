<?php

namespace App\Http\Requests;

use App\Models\SampleCondition;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySampleConditionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sample_condition_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:sample_conditions,id',
        ];
    }
}
