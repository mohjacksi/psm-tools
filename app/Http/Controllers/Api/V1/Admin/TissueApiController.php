<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTissueRequest;
use App\Http\Requests\UpdateTissueRequest;
use App\Http\Resources\Admin\TissueResource;
use App\Models\Tissue;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TissueApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tissue_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TissueResource(Tissue::all());
    }

    public function store(StoreTissueRequest $request)
    {
        $tissue = Tissue::create($request->all());

        return (new TissueResource($tissue))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Tissue $tissue)
    {
        abort_if(Gate::denies('tissue_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TissueResource($tissue);
    }

    public function update(UpdateTissueRequest $request, Tissue $tissue)
    {
        $tissue->update($request->all());

        return (new TissueResource($tissue))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Tissue $tissue)
    {
        abort_if(Gate::denies('tissue_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tissue->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
