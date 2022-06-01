<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProteinTypeRequest;
use App\Http\Requests\UpdateProteinTypeRequest;
use App\Http\Resources\Admin\ProteinTypeResource;
use App\Models\ProteinType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProteinTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('protein_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProteinTypeResource(ProteinType::with(['created_by'])->get());
    }

    public function store(StoreProteinTypeRequest $request)
    {
        $proteinType = ProteinType::create($request->all());

        return (new ProteinTypeResource($proteinType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProteinType $proteinType)
    {
        abort_if(Gate::denies('protein_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProteinTypeResource($proteinType->load(['created_by']));
    }

    public function update(UpdateProteinTypeRequest $request, ProteinType $proteinType)
    {
        $proteinType->update($request->all());

        return (new ProteinTypeResource($proteinType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProteinType $proteinType)
    {
        abort_if(Gate::denies('protein_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proteinType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
