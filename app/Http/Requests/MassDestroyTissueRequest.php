<?php

namespace App\Http\Requests;

use App\Models\Tissue;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTissueRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('tissue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:tissues,id',
        ];
    }
}
