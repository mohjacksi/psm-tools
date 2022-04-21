<?php

namespace App\Http\Requests;

use App\Models\BiologicalSet;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBiologicalSetRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('biological_set_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:biological_sets,id',
        ];
    }
}
