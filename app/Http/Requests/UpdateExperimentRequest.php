<?php

namespace App\Http\Requests;

use App\Models\Experiment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateExperimentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('experiment_edit');
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
