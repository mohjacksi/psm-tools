<?php

namespace App\Http\Requests;

use App\Models\PeptidCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePeptidCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('peptid_category_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:peptid_categories',
            ],
        ];
    }
}
