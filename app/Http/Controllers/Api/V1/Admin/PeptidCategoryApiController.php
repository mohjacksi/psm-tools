<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeptidCategoryRequest;
use App\Http\Requests\UpdatePeptidCategoryRequest;
use App\Http\Resources\Admin\PeptidCategoryResource;
use App\Models\PeptidCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PeptidCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('peptid_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptidCategoryResource(PeptidCategory::with(['created_by'])->get());
    }

    public function store(StorePeptidCategoryRequest $request)
    {
        $peptidCategory = PeptidCategory::create($request->all());

        return (new PeptidCategoryResource($peptidCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PeptidCategory $peptidCategory)
    {
        abort_if(Gate::denies('peptid_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PeptidCategoryResource($peptidCategory->load(['created_by']));
    }

    public function update(UpdatePeptidCategoryRequest $request, PeptidCategory $peptidCategory)
    {
        $peptidCategory->update($request->all());

        return (new PeptidCategoryResource($peptidCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PeptidCategory $peptidCategory)
    {
        abort_if(Gate::denies('peptid_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $peptidCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
