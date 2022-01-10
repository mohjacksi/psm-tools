<?php

namespace App\Http\Requests;

use App\Models\Person;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePersonRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('person_edit');
    }

    public function rules()
    {
        return [
            'patient_name' => [
                'string',
                'nullable',
            ],
            'birth_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
