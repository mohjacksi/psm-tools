<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeptideProteinRequest;
use App\Http\Requests\UpdatePeptideProteinRequest;
use App\Http\Resources\Admin\PeptideProteinResource;
use App\Models\PeptideProtein;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptideProteinApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('peptide_protein_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptideProteinResource(PeptideProtein::with(['peptide', 'protein'])->get());
    }

    public function store(StorePeptideProteinRequest $request)
    {
        $peptideProtein = PeptideProtein::create($request->all());

        return (new PeptideProteinResource($peptideProtein))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PeptideProtein $peptideProtein)
    {
        abort_if(Gate::denies('peptide_protein_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptideProteinResource($peptideProtein->load(['peptide', 'protein']));
    }

    public function update(UpdatePeptideProteinRequest $request, PeptideProtein $peptideProtein)
    {
        $peptideProtein->update($request->all());

        return (new PeptideProteinResource($peptideProtein))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PeptideProtein $peptideProtein)
    {
        abort_if(Gate::denies('peptide_protein_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideProtein->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
