<?php

namespace App\Http\Requests;

use App\Models\Strip;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStripRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('strip_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:strips',
            ],
        ];
    }
}
