<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPeptidePsmRequest;
use App\Http\Requests\StorePeptidePsmRequest;
use App\Http\Requests\UpdatePeptidePsmRequest;
use App\Models\Peptide;
use App\Models\PeptidePsm;
use App\Models\Psm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptidePsmController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('peptide_psm_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidePsms = PeptidePsm::with(['peptide', 'psm'])->get();

        $peptides = Peptide::get();

        $psms = Psm::get();

        return view('frontend.peptidePsms.index', compact('peptidePsms', 'peptides', 'psms'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptide_psm_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $psms = Psm::pluck('spectra', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.peptidePsms.create', compact('peptides', 'psms'));
    }

    public function store(StorePeptidePsmRequest $request)
    {
        $peptidePsm = PeptidePsm::create($request->all());

        return redirect()->route('frontend.peptide-psms.index');
    }

    public function edit(PeptidePsm $peptidePsm)
    {
        abort_if(Gate::denies('peptide_psm_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $psms = Psm::pluck('spectra', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peptidePsm->load('peptide', 'psm');

        return view('frontend.peptidePsms.edit', compact('peptidePsm', 'peptides', 'psms'));
    }

    public function update(UpdatePeptidePsmRequest $request, PeptidePsm $peptidePsm)
    {
        $peptidePsm->update($request->all());

        return redirect()->route('frontend.peptide-psms.index');
    }

    public function show(PeptidePsm $peptidePsm)
    {
        abort_if(Gate::denies('peptide_psm_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidePsm->load('peptide', 'psm');

        return view('frontend.peptidePsms.show', compact('peptidePsm'));
    }

    public function destroy(PeptidePsm $peptidePsm)
    {
        abort_if(Gate::denies('peptide_psm_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidePsm->delete();

        return back();
    }

    public function massDestroy(MassDestroyPeptidePsmRequest $request)
    {
        PeptidePsm::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
