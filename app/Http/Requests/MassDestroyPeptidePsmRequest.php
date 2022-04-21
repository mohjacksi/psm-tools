<?php

namespace App\Http\Requests;

use App\Models\PeptidePsm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPeptidePsmRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('peptide_psm_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:peptide_psms,id',
        ];
    }
}
