<?php

namespace App\Http\Requests;

use App\Models\PeptideWithModification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePeptideWithModificationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('peptide_with_modification_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:peptide_with_modifications,name,' . request()->route('peptide_with_modification')->id,
            ],
        ];
    }
}
