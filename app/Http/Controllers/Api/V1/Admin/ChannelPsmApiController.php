<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChannelPsmRequest;
use App\Http\Requests\UpdateChannelPsmRequest;
use App\Http\Resources\Admin\ChannelPsmResource;
use App\Models\ChannelPsm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChannelPsmApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('channel_psm_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChannelPsmResource(ChannelPsm::with(['channel', 'psm'])->get());
    }

    public function store(StoreChannelPsmRequest $request)
    {
        $channelPsm = ChannelPsm::create($request->all());

        return (new ChannelPsmResource($channelPsm))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ChannelPsm $channelPsm)
    {
        abort_if(Gate::denies('channel_psm_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChannelPsmResource($channelPsm->load(['channel', 'psm']));
    }

    public function update(UpdateChannelPsmRequest $request, ChannelPsm $channelPsm)
    {
        $channelPsm->update($request->all());

        return (new ChannelPsmResource($channelPsm))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ChannelPsm $channelPsm)
    {
        abort_if(Gate::denies('channel_psm_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channelPsm->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
