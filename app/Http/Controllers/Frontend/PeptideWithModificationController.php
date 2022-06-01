<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPeptideWithModificationRequest;
use App\Http\Requests\StorePeptideWithModificationRequest;
use App\Http\Requests\UpdatePeptideWithModificationRequest;
use App\Models\PeptideWithModification;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptideWithModificationController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('peptide_with_modification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideWithModifications = PeptideWithModification::with(['created_by'])->get();

        $users = User::get();

        return view('frontend.peptideWithModifications.index', compact('peptideWithModifications', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptide_with_modification_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.peptideWithModifications.create');
    }

    public function store(StorePeptideWithModificationRequest $request)
    {
        $peptideWithModification = PeptideWithModification::create($request->all());

        return redirect()->route('frontend.peptide-with-modifications.index');
    }

    public function edit(PeptideWithModification $peptideWithModification)
    {
        abort_if(Gate::denies('peptide_with_modification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideWithModification->load('created_by');

        return view('frontend.peptideWithModifications.edit', compact('peptideWithModification'));
    }

    public function update(UpdatePeptideWithModificationRequest $request, PeptideWithModification $peptideWithModification)
    {
        $peptideWithModification->update($request->all());

        return redirect()->route('frontend.peptide-with-modifications.index');
    }

    public function show(PeptideWithModification $peptideWithModification)
    {
        abort_if(Gate::denies('peptide_with_modification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideWithModification->load('created_by');

        return view('frontend.peptideWithModifications.show', compact('peptideWithModification'));
    }

    public function destroy(PeptideWithModification $peptideWithModification)
    {
        abort_if(Gate::denies('peptide_with_modification_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideWithModification->delete();

        return back();
    }

    public function massDestroy(MassDestroyPeptideWithModificationRequest $request)
    {
        PeptideWithModification::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
