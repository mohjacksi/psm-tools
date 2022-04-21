<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPeptideRequest;
use App\Http\Requests\StorePeptideRequest;
use App\Http\Requests\UpdatePeptideRequest;
use App\Models\Peptide;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptideController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('peptide_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::all();

        return view('frontend.peptides.index', compact('peptides'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptide_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.peptides.create');
    }

    public function store(StorePeptideRequest $request)
    {
        $peptide = Peptide::create($request->all());

        return redirect()->route('frontend.peptides.index');
    }

    public function edit(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.peptides.edit', compact('peptide'));
    }

    public function update(UpdatePeptideRequest $request, Peptide $peptide)
    {
        $peptide->update($request->all());

        return redirect()->route('frontend.peptides.index');
    }

    public function show(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.peptides.show', compact('peptide'));
    }

    public function destroy(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptide->delete();

        return back();
    }

    public function massDestroy(MassDestroyPeptideRequest $request)
    {
        Peptide::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
