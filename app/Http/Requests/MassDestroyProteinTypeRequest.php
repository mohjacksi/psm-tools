<?php

namespace App\Http\Requests;

use App\Models\ProteinType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyProteinTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('protein_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:protein_types,id',
        ];
    }
}
