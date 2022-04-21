<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeptidePsmRequest;
use App\Http\Requests\UpdatePeptidePsmRequest;
use App\Http\Resources\Admin\PeptidePsmResource;
use App\Models\PeptidePsm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptidePsmApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('peptide_psm_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptidePsmResource(PeptidePsm::with(['peptide', 'psm'])->get());
    }

    public function store(StorePeptidePsmRequest $request)
    {
        $peptidePsm = PeptidePsm::create($request->all());

        return (new PeptidePsmResource($peptidePsm))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PeptidePsm $peptidePsm)
    {
        abort_if(Gate::denies('peptide_psm_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptidePsmResource($peptidePsm->load(['peptide', 'psm']));
    }

    public function update(UpdatePeptidePsmRequest $request, PeptidePsm $peptidePsm)
    {
        $peptidePsm->update($request->all());

        return (new PeptidePsmResource($peptidePsm))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PeptidePsm $peptidePsm)
    {
        abort_if(Gate::denies('peptide_psm_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidePsm->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
