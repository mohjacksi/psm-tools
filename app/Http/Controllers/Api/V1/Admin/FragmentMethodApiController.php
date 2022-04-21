<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFragmentMethodRequest;
use App\Http\Requests\UpdateFragmentMethodRequest;
use App\Http\Resources\Admin\FragmentMethodResource;
use App\Models\FragmentMethod;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FragmentMethodApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fragment_method_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FragmentMethodResource(FragmentMethod::all());
    }

    public function store(StoreFragmentMethodRequest $request)
    {
        $fragmentMethod = FragmentMethod::create($request->all());

        return (new FragmentMethodResource($fragmentMethod))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FragmentMethod $fragmentMethod)
    {
        abort_if(Gate::denies('fragment_method_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FragmentMethodResource($fragmentMethod);
    }

    public function update(UpdateFragmentMethodRequest $request, FragmentMethod $fragmentMethod)
    {
        $fragmentMethod->update($request->all());

        return (new FragmentMethodResource($fragmentMethod))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FragmentMethod $fragmentMethod)
    {
        abort_if(Gate::denies('fragment_method_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fragmentMethod->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
