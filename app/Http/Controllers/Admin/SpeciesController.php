<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySpeciesRequest;
use App\Http\Requests\StoreSpeciesRequest;
use App\Http\Requests\UpdateSpeciesRequest;
use App\Models\Species;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SpeciesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('species_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Species::query()->select(sprintf('%s.*', (new Species())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'species_show';
                $editGate = 'species_edit';
                $deleteGate = 'species_delete';
                $crudRoutePart = 'speciess';

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

        return view('admin.speciess.index');
    }

    public function create()
    {
        abort_if(Gate::denies('species_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.speciess.create');
    }

    public function store(StoreSpeciesRequest $request)
    {
        $species = Species::create($request->all());

        return redirect()->route('admin.speciess.index');
    }

    public function edit(Species $species)
    {
        abort_if(Gate::denies('species_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.speciess.edit', compact('species'));
    }

    public function update(UpdateSpeciesRequest $request, Species $species)
    {
        $species->update($request->all());

        return redirect()->route('admin.speciess.index');
    }

    public function show(Species $species)
    {
        abort_if(Gate::denies('species_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $species->load('speciesSamples', 'speciesExperiments');

        return view('admin.speciess.show', compact('species'));
    }

    public function destroy(Species $species)
    {
        abort_if(Gate::denies('species_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $species->delete();

        return back();
    }

    public function massDestroy(MassDestroySpeciesRequest $request)
    {
        Species::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
