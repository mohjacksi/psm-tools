<?php

namespace App\Http\Requests;

use App\Models\UploadForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUploadFormRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('upload_form_create');
    }

    public function rules()
    {
        return [
            'project_id' => [
                'required',
                'integer',
            ],
            'experiment_id' => [
                'required',
                'integer',
            ],
            'psm_file' => [
                'required',
            ],
        ];
    }
}
