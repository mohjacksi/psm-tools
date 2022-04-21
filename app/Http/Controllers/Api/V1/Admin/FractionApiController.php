<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFractionRequest;
use App\Http\Requests\UpdateFractionRequest;
use App\Http\Resources\Admin\FractionResource;
use App\Models\Fraction;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FractionApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fraction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FractionResource(Fraction::with(['biological_set'])->get());
    }

    public function store(StoreFractionRequest $request)
    {
        $fraction = Fraction::create($request->all());

        return (new FractionResource($fraction))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Fraction $fraction)
    {
        abort_if(Gate::denies('fraction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FractionResource($fraction->load(['biological_set']));
    }

    public function update(UpdateFractionRequest $request, Fraction $fraction)
    {
        $fraction->update($request->all());

        return (new FractionResource($fraction))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Fraction $fraction)
    {
        abort_if(Gate::denies('fraction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fraction->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
