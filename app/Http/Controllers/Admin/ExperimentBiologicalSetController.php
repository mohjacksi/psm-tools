<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyExperimentBiologicalSetRequest;
use App\Http\Requests\StoreExperimentBiologicalSetRequest;
use App\Http\Requests\UpdateExperimentBiologicalSetRequest;
use App\Models\Experiment;
use App\Models\ExperimentBiologicalSet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ExperimentBiologicalSetController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('experiment_biological_set_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ExperimentBiologicalSet::with(['experiment'])->select(sprintf('%s.*', (new ExperimentBiologicalSet())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'experiment_biological_set_show';
                $editGate = 'experiment_biological_set_edit';
                $deleteGate = 'experiment_biological_set_delete';
                $crudRoutePart = 'experiment-biological-sets';

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
            $table->editColumn('set', function ($row) {
                return $row->set ? $row->set : '';
            });
            $table->addColumn('experiment_name', function ($row) {
                return $row->experiment ? $row->experiment->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'experiment']);

            return $table->make(true);
        }

        $experiments = Experiment::get();

        return view('admin.experimentBiologicalSets.index', compact('experiments'));
    }

    public function create()
    {
        abort_if(Gate::denies('experiment_biological_set_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiments = Experiment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.experimentBiologicalSets.create', compact('experiments'));
    }

    public function store(StoreExperimentBiologicalSetRequest $request)
    {
        $experimentBiologicalSet = ExperimentBiologicalSet::create($request->all());

        return redirect()->route('admin.experiment-biological-sets.index');
    }

    public function edit(ExperimentBiologicalSet $experimentBiologicalSet)
    {
        abort_if(Gate::denies('experiment_biological_set_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiments = Experiment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $experimentBiologicalSet->load('experiment');

        return view('admin.experimentBiologicalSets.edit', compact('experimentBiologicalSet', 'experiments'));
    }

    public function update(UpdateExperimentBiologicalSetRequest $request, ExperimentBiologicalSet $experimentBiologicalSet)
    {
        $experimentBiologicalSet->update($request->all());

        return redirect()->route('admin.experiment-biological-sets.index');
    }

    public function show(ExperimentBiologicalSet $experimentBiologicalSet)
    {
        abort_if(Gate::denies('experiment_biological_set_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experimentBiologicalSet->load('experiment', 'experimentBiologicalSetBiologicalSets');

        return view('admin.experimentBiologicalSets.show', compact('experimentBiologicalSet'));
    }

    public function destroy(ExperimentBiologicalSet $experimentBiologicalSet)
    {
        abort_if(Gate::denies('experiment_biological_set_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experimentBiologicalSet->delete();

        return back();
    }

    public function massDestroy(MassDestroyExperimentBiologicalSetRequest $request)
    {
        ExperimentBiologicalSet::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
