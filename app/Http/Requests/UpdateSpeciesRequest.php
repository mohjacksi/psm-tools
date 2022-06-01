<?php

namespace App\Http\Requests;

use App\Models\Species;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSpeciesRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('species_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:speciess,name,' . request()->route('species')->id,
            ],
        ];
    }
}
