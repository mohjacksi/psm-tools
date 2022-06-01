<?php

namespace App\Http\Requests;

use App\Models\Fraction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFractionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fraction_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'spectra_file_name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
