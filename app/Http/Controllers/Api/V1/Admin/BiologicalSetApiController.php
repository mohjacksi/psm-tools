<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBiologicalSetRequest;
use App\Http\Requests\UpdateBiologicalSetRequest;
use App\Http\Resources\Admin\BiologicalSetResource;
use App\Models\BiologicalSet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BiologicalSetApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('biological_set_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BiologicalSetResource(BiologicalSet::with(['experiments', 'strip', 'fragment_method', 'created_by'])->get());
    }

    public function store(StoreBiologicalSetRequest $request)
    {
        $biologicalSet = BiologicalSet::create($request->all());
        $biologicalSet->experiments()->sync($request->input('experiments', []));

        return (new BiologicalSetResource($biologicalSet))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BiologicalSetResource($biologicalSet->load(['experiments', 'strip', 'fragment_method', 'created_by']));
    }

    public function update(UpdateBiologicalSetRequest $request, BiologicalSet $biologicalSet)
    {
        $biologicalSet->update($request->all());
        $biologicalSet->experiments()->sync($request->input('experiments', []));

        return (new BiologicalSetResource($biologicalSet))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BiologicalSet $biologicalSet)
    {
        abort_if(Gate::denies('biological_set_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biologicalSet->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
