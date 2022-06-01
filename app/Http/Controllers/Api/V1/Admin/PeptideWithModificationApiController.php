<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeptideWithModificationRequest;
use App\Http\Requests\UpdatePeptideWithModificationRequest;
use App\Http\Resources\Admin\PeptideWithModificationResource;
use App\Models\PeptideWithModification;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptideWithModificationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('peptide_with_modification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptideWithModificationResource(PeptideWithModification::with(['created_by'])->get());
    }

    public function store(StorePeptideWithModificationRequest $request)
    {
        $peptideWithModification = PeptideWithModification::create($request->all());

        return (new PeptideWithModificationResource($peptideWithModification))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PeptideWithModification $peptideWithModification)
    {
        abort_if(Gate::denies('peptide_with_modification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptideWithModificationResource($peptideWithModification->load(['created_by']));
    }

    public function update(UpdatePeptideWithModificationRequest $request, PeptideWithModification $peptideWithModification)
    {
        $peptideWithModification->update($request->all());

        return (new PeptideWithModificationResource($peptideWithModification))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PeptideWithModification $peptideWithModification)
    {
        abort_if(Gate::denies('peptide_with_modification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideWithModification->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
