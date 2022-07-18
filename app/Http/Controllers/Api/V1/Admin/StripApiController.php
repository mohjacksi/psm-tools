<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStripRequest;
use App\Http\Requests\UpdateStripRequest;
use App\Http\Resources\Admin\StripResource;
use App\Models\Strip;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StripApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('strip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StripResource(Strip::all());
    }

    public function store(StoreStripRequest $request)
    {
        $strip = Strip::create($request->all());

        return (new StripResource($strip))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Strip $strip)
    {
        abort_if(Gate::denies('strip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StripResource($strip);
    }

    public function update(UpdateStripRequest $request, Strip $strip)
    {
        $strip->update($request->all());

        return (new StripResource($strip))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Strip $strip)
    {
        abort_if(Gate::denies('strip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $strip->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
