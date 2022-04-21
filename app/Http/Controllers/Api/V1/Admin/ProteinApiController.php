<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProteinRequest;
use App\Http\Requests\UpdateProteinRequest;
use App\Http\Resources\Admin\ProteinResource;
use App\Models\Protein;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProteinApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('protein_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProteinResource(Protein::all());
    }

    public function store(StoreProteinRequest $request)
    {
        $protein = Protein::create($request->all());

        return (new ProteinResource($protein))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Protein $protein)
    {
        abort_if(Gate::denies('protein_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProteinResource($protein);
    }

    public function update(UpdateProteinRequest $request, Protein $protein)
    {
        $protein->update($request->all());

        return (new ProteinResource($protein))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Protein $protein)
    {
        abort_if(Gate::denies('protein_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $protein->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
