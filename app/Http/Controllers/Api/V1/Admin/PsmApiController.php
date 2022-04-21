<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePsmRequest;
use App\Http\Requests\UpdatePsmRequest;
use App\Http\Resources\Admin\PsmResource;
use App\Models\Psm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PsmApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('psm_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PsmResource(Psm::with(['fraction'])->get());
    }

    public function store(StorePsmRequest $request)
    {
        $psm = Psm::create($request->all());

        return (new PsmResource($psm))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Psm $psm)
    {
        abort_if(Gate::denies('psm_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PsmResource($psm->load(['fraction']));
    }

    public function update(UpdatePsmRequest $request, Psm $psm)
    {
        $psm->update($request->all());

        return (new PsmResource($psm))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Psm $psm)
    {
        abort_if(Gate::denies('psm_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $psm->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
