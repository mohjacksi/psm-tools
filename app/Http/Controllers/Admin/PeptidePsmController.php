<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class PeptidePsmController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('peptide_psm_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PeptidePsm::with(['peptide', 'psm'])->select(sprintf('%s.*', (new PeptidePsm())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'peptide_psm_show';
                $editGate = 'peptide_psm_edit';
                $deleteGate = 'peptide_psm_delete';
                $crudRoutePart = 'peptide-psms';

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
            $table->addColumn('peptide_sequence', function ($row) {
                return $row->peptide ? $row->peptide->sequence : '';
            });

            $table->addColumn('psm_spectra', function ($row) {
                return $row->psm ? $row->psm->spectra : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'peptide', 'psm']);

            return $table->make(true);
        }

        $peptides = Peptide::get();
        $psms     = Psm::get();

        return view('admin.peptidePsms.index', compact('peptides', 'psms'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptide_psm_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $psms = Psm::pluck('spectra', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.peptidePsms.create', compact('peptides', 'psms'));
    }

    public function store(StorePeptidePsmRequest $request)
    {
        $peptidePsm = PeptidePsm::create($request->all());

        return redirect()->route('admin.peptide-psms.index');
    }

    public function edit(PeptidePsm $peptidePsm)
    {
        abort_if(Gate::denies('peptide_psm_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $psms = Psm::pluck('spectra', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peptidePsm->load('peptide', 'psm');

        return view('admin.peptidePsms.edit', compact('peptidePsm', 'peptides', 'psms'));
    }

    public function update(UpdatePeptidePsmRequest $request, PeptidePsm $peptidePsm)
    {
        $peptidePsm->update($request->all());

        return redirect()->route('admin.peptide-psms.index');
    }

    public function show(PeptidePsm $peptidePsm)
    {
        abort_if(Gate::denies('peptide_psm_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidePsm->load('peptide', 'psm');

        return view('admin.peptidePsms.show', compact('peptidePsm'));
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
