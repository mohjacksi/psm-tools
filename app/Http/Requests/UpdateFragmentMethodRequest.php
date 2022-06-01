<?php

namespace App\Http\Requests;

use App\Models\FragmentMethod;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFragmentMethodRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fragment_method_edit');
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
