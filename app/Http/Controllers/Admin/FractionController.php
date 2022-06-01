<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFractionRequest;
use App\Http\Requests\StoreFractionRequest;
use App\Http\Requests\UpdateFractionRequest;
use App\Models\BiologicalSet;
use App\Models\Fraction;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FractionController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('fraction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Fraction::with(['biological_set'])->select(sprintf('%s.*', (new Fraction())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'fraction_show';
                $editGate = 'fraction_edit';
                $deleteGate = 'fraction_delete';
                $crudRoutePart = 'fractions';

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
            $table->addColumn('biological_set_name', function ($row) {
                return $row->biological_set ? $row->biological_set->name : '';
            });

            $table->editColumn('spectra_file_name', function ($row) {
                return $row->spectra_file_name ? $row->spectra_file_name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'biological_set']);

            return $table->make(true);
        }

        $biological_sets = BiologicalSet::get();

        return view('admin.fractions.index', compact('biological_sets'));
    }

    public function create()
    {
        abort_if(Gate::denies('fraction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biological_sets = BiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.fractions.create', compact('biological_sets'));
    }

    public function store(StoreFractionRequest $request)
    {
        $fraction = Fraction::create($request->all());

        return redirect()->route('admin.fractions.index');
    }

    public function edit(Fraction $fraction)
    {
        abort_if(Gate::denies('fraction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biological_sets = BiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fraction->load('biological_set');

        return view('admin.fractions.edit', compact('biological_sets', 'fraction'));
    }

    public function update(UpdateFractionRequest $request, Fraction $fraction)
    {
        $fraction->update($request->all());

        return redirect()->route('admin.fractions.index');
    }

    public function show(Fraction $fraction)
    {
        abort_if(Gate::denies('fraction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fraction->load('biological_set', 'fractionPsms');

        return view('admin.fractions.show', compact('fraction'));
    }

    public function destroy(Fraction $fraction)
    {
        abort_if(Gate::denies('fraction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fraction->delete();

        return back();
    }

    public function massDestroy(MassDestroyFractionRequest $request)
    {
        Fraction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
