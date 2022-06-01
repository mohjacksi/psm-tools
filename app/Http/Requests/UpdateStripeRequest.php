<?php

namespace App\Http\Requests;

use App\Models\Stripe;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStripeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('stripe_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:stripes,name,' . request()->route('stripe')->id,
            ],
        ];
    }
}
