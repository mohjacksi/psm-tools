<?php

namespace App\Http\Controllers\Frontend;

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

class ExperimentBiologicalSetController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('experiment_biological_set_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experimentBiologicalSets = ExperimentBiologicalSet::with(['experiment'])->get();

        $experiments = Experiment::get();

        return view('frontend.experimentBiologicalSets.index', compact('experimentBiologicalSets', 'experiments'));
    }

    public function create()
    {
        abort_if(Gate::denies('experiment_biological_set_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiments = Experiment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.experimentBiologicalSets.create', compact('experiments'));
    }

    public function store(StoreExperimentBiologicalSetRequest $request)
    {
        $experimentBiologicalSet = ExperimentBiologicalSet::create($request->all());

        return redirect()->route('frontend.experiment-biological-sets.index');
    }

    public function edit(ExperimentBiologicalSet $experimentBiologicalSet)
    {
        abort_if(Gate::denies('experiment_biological_set_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiments = Experiment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $experimentBiologicalSet->load('experiment');

        return view('frontend.experimentBiologicalSets.edit', compact('experimentBiologicalSet', 'experiments'));
    }

    public function update(UpdateExperimentBiologicalSetRequest $request, ExperimentBiologicalSet $experimentBiologicalSet)
    {
        $experimentBiologicalSet->update($request->all());

        return redirect()->route('frontend.experiment-biological-sets.index');
    }

    public function show(ExperimentBiologicalSet $experimentBiologicalSet)
    {
        abort_if(Gate::denies('experiment_biological_set_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experimentBiologicalSet->load('experiment');

        return view('frontend.experimentBiologicalSets.show', compact('experimentBiologicalSet'));
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
