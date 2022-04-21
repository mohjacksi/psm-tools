<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeptideRequest;
use App\Http\Requests\UpdatePeptideRequest;
use App\Http\Resources\Admin\PeptideResource;
use App\Models\Peptide;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptideApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('peptide_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptideResource(Peptide::all());
    }

    public function store(StorePeptideRequest $request)
    {
        $peptide = Peptide::create($request->all());

        return (new PeptideResource($peptide))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptideResource($peptide);
    }

    public function update(UpdatePeptideRequest $request, Peptide $peptide)
    {
        $peptide->update($request->all());

        return (new PeptideResource($peptide))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptide->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
