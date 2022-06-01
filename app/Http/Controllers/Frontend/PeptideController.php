<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPeptideRequest;
use App\Http\Requests\StorePeptideRequest;
use App\Http\Requests\UpdatePeptideRequest;
use App\Models\PeptidCategory;
use App\Models\Peptide;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptideController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('peptide_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::with(['category', 'created_by'])->get();

        $peptid_categories = PeptidCategory::get();

        $users = User::get();

        return view('frontend.peptides.index', compact('peptid_categories', 'peptides', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptide_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = PeptidCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.peptides.create', compact('categories'));
    }

    public function store(StorePeptideRequest $request)
    {
        $peptide = Peptide::create($request->all());

        return redirect()->route('frontend.peptides.index');
    }

    public function edit(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = PeptidCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peptide->load('category', 'created_by');

        return view('frontend.peptides.edit', compact('categories', 'peptide'));
    }

    public function update(UpdatePeptideRequest $request, Peptide $peptide)
    {
        $peptide->update($request->all());

        return redirect()->route('frontend.peptides.index');
    }

    public function show(Peptide $peptide)
    {
        abort_if(Gate::denies('peptide_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptide->load('category', 'created_by', 'peptideProteins');

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
