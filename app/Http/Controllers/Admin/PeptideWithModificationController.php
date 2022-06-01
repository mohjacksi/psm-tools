<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class PeptideWithModificationController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('peptide_with_modification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PeptideWithModification::with(['created_by'])->select(sprintf('%s.*', (new PeptideWithModification())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'peptide_with_modification_show';
                $editGate = 'peptide_with_modification_edit';
                $deleteGate = 'peptide_with_modification_delete';
                $crudRoutePart = 'peptide-with-modifications';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.peptideWithModifications.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptide_with_modification_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.peptideWithModifications.create');
    }

    public function store(StorePeptideWithModificationRequest $request)
    {
        $peptideWithModification = PeptideWithModification::create($request->all());

        return redirect()->route('admin.peptide-with-modifications.index');
    }

    public function edit(PeptideWithModification $peptideWithModification)
    {
        abort_if(Gate::denies('peptide_with_modification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideWithModification->load('created_by');

        return view('admin.peptideWithModifications.edit', compact('peptideWithModification'));
    }

    public function update(UpdatePeptideWithModificationRequest $request, PeptideWithModification $peptideWithModification)
    {
        $peptideWithModification->update($request->all());

        return redirect()->route('admin.peptide-with-modifications.index');
    }

    public function show(PeptideWithModification $peptideWithModification)
    {
        abort_if(Gate::denies('peptide_with_modification_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideWithModification->load('created_by', 'peptideWithModificationPsms');

        return view('admin.peptideWithModifications.show', compact('peptideWithModification'));
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
