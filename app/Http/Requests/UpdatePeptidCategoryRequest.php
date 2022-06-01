<?php

namespace App\Http\Requests;

use App\Models\PeptidCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePeptidCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('peptid_category_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:peptid_categories,name,' . request()->route('peptid_category')->id,
            ],
        ];
    }
}
