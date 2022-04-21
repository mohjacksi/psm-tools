<?php

namespace App\Http\Requests;

use App\Models\PeptidePsm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePeptidePsmRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('peptide_psm_create');
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
