<?php

namespace App\Http\Requests;

use App\Models\Experiment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyExperimentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('experiment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:experiments,id',
        ];
    }
}
