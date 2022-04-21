<?php

namespace App\Http\Requests;

use App\Models\FragmentMethod;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFragmentMethodRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fragment_method_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
