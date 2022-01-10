<?php

namespace App\Http\Requests;

use App\Models\Psm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePsmRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('psm_edit');
    }

    public function rules()
    {
        return [
            'psm_info' => [
                'string',
                'nullable',
            ],
        ];
    }
}
