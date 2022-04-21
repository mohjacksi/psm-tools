<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDnaRegionRequest;
use App\Http\Requests\UpdateDnaRegionRequest;
use App\Http\Resources\Admin\DnaRegionResource;
use App\Models\DnaRegion;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DnaRegionApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dna_region_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DnaRegionResource(DnaRegion::all());
    }

    public function store(StoreDnaRegionRequest $request)
    {
        $dnaRegion = DnaRegion::create($request->all());

        return (new DnaRegionResource($dnaRegion))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DnaRegion $dnaRegion)
    {
        abort_if(Gate::denies('dna_region_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DnaRegionResource($dnaRegion);
    }

    public function update(UpdateDnaRegionRequest $request, DnaRegion $dnaRegion)
    {
        $dnaRegion->update($request->all());

        return (new DnaRegionResource($dnaRegion))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DnaRegion $dnaRegion)
    {
        abort_if(Gate::denies('dna_region_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dnaRegion->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
