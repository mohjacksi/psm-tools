<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStripeRequest;
use App\Http\Requests\StoreStripeRequest;
use App\Http\Requests\UpdateStripeRequest;
use App\Models\Stripe;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StripeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('stripe_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stripes = Stripe::all();

        return view('frontend.stripes.index', compact('stripes'));
    }

    public function create()
    {
        abort_if(Gate::denies('stripe_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.stripes.create');
    }

    public function store(StoreStripeRequest $request)
    {
        $stripe = Stripe::create($request->all());

        return redirect()->route('frontend.stripes.index');
    }

    public function edit(Stripe $stripe)
    {
        abort_if(Gate::denies('stripe_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.stripes.edit', compact('stripe'));
    }

    public function update(UpdateStripeRequest $request, Stripe $stripe)
    {
        $stripe->update($request->all());

        return redirect()->route('frontend.stripes.index');
    }

    public function show(Stripe $stripe)
    {
        abort_if(Gate::denies('stripe_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stripe->load('stripeBiologicalSets');

        return view('frontend.stripes.show', compact('stripe'));
    }

    public function destroy(Stripe $stripe)
    {
        abort_if(Gate::denies('stripe_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stripe->delete();

        return back();
    }

    public function massDestroy(MassDestroyStripeRequest $request)
    {
        Stripe::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
