<?php

namespace App\Http\Requests;

use App\Models\PeptideWithModification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePeptideWithModificationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('peptide_with_modification_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:peptide_with_modifications',
            ],
        ];
    }
}
