<?php

namespace App\Http\Requests;

use App\Models\UploadForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUploadFormRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('upload_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:upload_forms,id',
        ];
    }
}
