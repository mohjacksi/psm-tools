<?php

namespace App\Http\Requests;

use App\Models\Experiment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreExperimentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('experiment_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'expression_threshold' => [
                'numeric',
            ],
            'species' => [
                'string',
                'nullable',
            ],
            'reference_protein_source' => [
                'string',
                'nullable',
            ],
            'other_protein_source' => [
                'string',
                'nullable',
            ],
            'psm_file_name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
