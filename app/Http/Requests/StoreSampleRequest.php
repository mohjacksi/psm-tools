<?php

namespace App\Http\Requests;

use App\Models\Sample;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSampleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sample_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'replicate_number' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'channels.*' => [
                'integer',
            ],
            'channels' => [
                'array',
            ],
        ];
    }
}
