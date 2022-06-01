<?php

namespace App\Http\Requests;

use App\Models\Psm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePsmRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('psm_create');
    }

    public function rules()
    {
        return [
            'spectra' => [
                'string',
                'required',
            ],
            'fraction_id' => [
                'required',
                'integer',
            ],
            'scan_num' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'precursor' => [
                'numeric',
            ],
            'isotope_error' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'precursor_error' => [
                'numeric',
            ],
            'charge' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'de_novo_score' => [
                'string',
                'nullable',
            ],
            'msgf_score' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'space_evalue' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'evalue' => [
                'string',
                'nullable',
            ],
            'precursor_svm_score' => [
                'string',
                'nullable',
            ],
            'psm_q_value' => [
                'numeric',
            ],
            'peptide_q_value' => [
                'numeric',
            ],
            'missed_clevage' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'experimental_pl' => [
                'numeric',
            ],
            'predicted_pl' => [
                'numeric',
            ],
            'delta_pl' => [
                'numeric',
            ],
        ];
    }
}
