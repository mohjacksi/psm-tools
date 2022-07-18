<?php

namespace App\Http\Requests;

use App\Models\Strip;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStripRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('strip_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:strips,name,' . request()->route('strip')->id,
            ],
        ];
    }
}
