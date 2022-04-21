<?php

namespace App\Http\Requests;

use App\Models\ChannelPsm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateChannelPsmRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('channel_psm_edit');
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
