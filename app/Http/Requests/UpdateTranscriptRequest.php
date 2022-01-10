<?php

namespace App\Http\Requests;

use App\Models\Transcript;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTranscriptRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('transcript_edit');
    }

    public function rules()
    {
        return [
            'transcript' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'transcript_sequence' => [
                'string',
                'nullable',
            ],
        ];
    }
}
