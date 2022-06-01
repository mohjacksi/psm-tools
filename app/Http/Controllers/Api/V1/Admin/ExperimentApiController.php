<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreExperimentRequest;
use App\Http\Requests\UpdateExperimentRequest;
use App\Http\Resources\Admin\ExperimentResource;
use App\Models\Experiment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExperimentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('experiment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExperimentResource(Experiment::with(['project', 'species', 'created_by'])->get());
    }

    public function store(StoreExperimentRequest $request)
    {
        $experiment = Experiment::create($request->all());

        return (new ExperimentResource($experiment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Experiment $experiment)
    {
        abort_if(Gate::denies('experiment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExperimentResource($experiment->load(['project', 'species', 'created_by']));
    }

    public function update(UpdateExperimentRequest $request, Experiment $experiment)
    {
        $experiment->update($request->all());

        return (new ExperimentResource($experiment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Experiment $experiment)
    {
        abort_if(Gate::denies('experiment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
