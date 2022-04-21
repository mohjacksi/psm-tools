<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperimentBiologicalSetRequest;
use App\Http\Requests\UpdateExperimentBiologicalSetRequest;
use App\Http\Resources\Admin\ExperimentBiologicalSetResource;
use App\Models\ExperimentBiologicalSet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExperimentBiologicalSetApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('experiment_biological_set_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExperimentBiologicalSetResource(ExperimentBiologicalSet::with(['experiment'])->get());
    }

    public function store(StoreExperimentBiologicalSetRequest $request)
    {
        $experimentBiologicalSet = ExperimentBiologicalSet::create($request->all());

        return (new ExperimentBiologicalSetResource($experimentBiologicalSet))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ExperimentBiologicalSet $experimentBiologicalSet)
    {
        abort_if(Gate::denies('experiment_biological_set_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExperimentBiologicalSetResource($experimentBiologicalSet->load(['experiment']));
    }

    public function update(UpdateExperimentBiologicalSetRequest $request, ExperimentBiologicalSet $experimentBiologicalSet)
    {
        $experimentBiologicalSet->update($request->all());

        return (new ExperimentBiologicalSetResource($experimentBiologicalSet))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ExperimentBiologicalSet $experimentBiologicalSet)
    {
        abort_if(Gate::denies('experiment_biological_set_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experimentBiologicalSet->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
