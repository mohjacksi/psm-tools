<?php

namespace App\Http\Requests;

use App\Models\ExperimentBiologicalSet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyExperimentBiologicalSetRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('experiment_biological_set_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:experiment_biological_sets,id',
        ];
    }
}
