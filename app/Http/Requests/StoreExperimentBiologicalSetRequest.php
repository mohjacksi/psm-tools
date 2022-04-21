<?php

namespace App\Http\Requests;

use App\Models\ExperimentBiologicalSet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreExperimentBiologicalSetRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('experiment_biological_set_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'set' => [
                'string',
                'nullable',
            ],
        ];
    }
}
