<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStripeRequest;
use App\Http\Requests\UpdateStripeRequest;
use App\Http\Resources\Admin\StripeResource;
use App\Models\Stripe;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StripeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('stripe_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StripeResource(Stripe::all());
    }

    public function store(StoreStripeRequest $request)
    {
        $stripe = Stripe::create($request->all());

        return (new StripeResource($stripe))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Stripe $stripe)
    {
        abort_if(Gate::denies('stripe_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StripeResource($stripe);
    }

    public function update(UpdateStripeRequest $request, Stripe $stripe)
    {
        $stripe->update($request->all());

        return (new StripeResource($stripe))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Stripe $stripe)
    {
        abort_if(Gate::denies('stripe_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stripe->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
