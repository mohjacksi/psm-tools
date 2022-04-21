<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class PeptideProteinController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('peptide_protein_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = PeptideProtein::with(['peptide', 'protein'])->select(sprintf('%s.*', (new PeptideProtein())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'peptide_protein_show';
                $editGate = 'peptide_protein_edit';
                $deleteGate = 'peptide_protein_delete';
                $crudRoutePart = 'peptide-proteins';

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

            $table->addColumn('protein_protein', function ($row) {
                return $row->protein ? $row->protein->protein : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'peptide', 'protein']);

            return $table->make(true);
        }

        $peptides = Peptide::get();
        $proteins = Protein::get();

        return view('admin.peptideProteins.index', compact('peptides', 'proteins'));
    }

    public function create()
    {
        abort_if(Gate::denies('peptide_protein_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $proteins = Protein::pluck('protein', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.peptideProteins.create', compact('peptides', 'proteins'));
    }

    public function store(StorePeptideProteinRequest $request)
    {
        $peptideProtein = PeptideProtein::create($request->all());

        return redirect()->route('admin.peptide-proteins.index');
    }

    public function edit(PeptideProtein $peptideProtein)
    {
        abort_if(Gate::denies('peptide_protein_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptides = Peptide::pluck('sequence', 'id')->prepend(trans('global.pleaseSelect'), '');

        $proteins = Protein::pluck('protein', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peptideProtein->load('peptide', 'protein');

        return view('admin.peptideProteins.edit', compact('peptideProtein', 'peptides', 'proteins'));
    }

    public function update(UpdatePeptideProteinRequest $request, PeptideProtein $peptideProtein)
    {
        $peptideProtein->update($request->all());

        return redirect()->route('admin.peptide-proteins.index');
    }

    public function show(PeptideProtein $peptideProtein)
    {
        abort_if(Gate::denies('peptide_protein_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptideProtein->load('peptide', 'protein');

        return view('admin.peptideProteins.show', compact('peptideProtein'));
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
