<?php

namespace App\Http\Requests;

use App\Models\Stripe;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStripeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('stripe_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:stripes',
            ],
        ];
    }
}
