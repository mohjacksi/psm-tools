<?php

namespace App\Http\Requests;

use App\Models\PeptidCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPeptidCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('peptid_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:peptid_categories,id',
        ];
    }
}
