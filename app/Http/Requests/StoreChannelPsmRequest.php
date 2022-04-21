<?php

namespace App\Http\Requests;

use App\Models\ChannelPsm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreChannelPsmRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('channel_psm_create');
    }

    public function rules()
    {
        return [
            'value' => [
                'string',
                'nullable',
            ],
        ];
    }
}
