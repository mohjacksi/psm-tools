<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPeptideProteinRequest;
use App\Http\Requests\StorePeptideProteinRequest;
use App\Http\Requests\UpdatePeptideProteinRequest;
use App\Models\Peptide;
use App\Models\PeptideProtein;
use App\Models\Protein;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptideProteinController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('peptide_protein_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideProteins = PeptideProtein::with(['peptide', 'protein'])->get();

        $peptides = Peptide::get();

        $proteins = Protein::get();

        return view('frontend.peptideProteins.index', compact('peptideProteins', 'peptides', 'proteins'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptide_protein_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $proteins = Protein::pluck('protein', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.peptideProteins.create', compact('peptides', 'proteins'));
    }

    public function store(StorePeptideProteinRequest $request)
    {
        $peptideProtein = PeptideProtein::create($request->all());

        return redirect()->route('frontend.peptide-proteins.index');
    }

    public function edit(PeptideProtein $peptideProtein)
    {
        abort_if(Gate::denies('peptide_protein_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $proteins = Protein::pluck('protein', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peptideProtein->load('peptide', 'protein');

        return view('frontend.peptideProteins.edit', compact('peptideProtein', 'peptides', 'proteins'));
    }

    public function update(UpdatePeptideProteinRequest $request, PeptideProtein $peptideProtein)
    {
        $peptideProtein->update($request->all());

        return redirect()->route('frontend.peptide-proteins.index');
    }

    public function show(PeptideProtein $peptideProtein)
    {
        abort_if(Gate::denies('peptide_protein_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideProtein->load('peptide', 'protein');

        return view('frontend.peptideProteins.show', compact('peptideProtein'));
    }

    public function destroy(PeptideProtein $peptideProtein)
    {
        abort_if(Gate::denies('peptide_protein_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideProtein->delete();

        return back();
    }

    public function massDestroy(MassDestroyPeptideProteinRequest $request)
    {
        PeptideProtein::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
