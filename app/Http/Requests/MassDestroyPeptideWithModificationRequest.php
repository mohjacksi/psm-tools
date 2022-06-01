<?php

namespace App\Http\Requests;

use App\Models\PeptideWithModification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPeptideWithModificationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('peptide_with_modification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:peptide_with_modifications,id',
        ];
    }
}
