<?php

namespace App\Http\Requests;

use App\Models\DnaRegion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDnaRegionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dna_region_create');
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
