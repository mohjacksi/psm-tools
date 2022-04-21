<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyChannelPsmRequest;
use App\Http\Requests\StoreChannelPsmRequest;
use App\Http\Requests\UpdateChannelPsmRequest;
use App\Models\Channel;
use App\Models\ChannelPsm;
use App\Models\Psm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChannelPsmController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('channel_psm_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channelPsms = ChannelPsm::with(['channel', 'psm'])->get();

        $channels = Channel::get();

        $psms = Psm::get();

        return view('frontend.channelPsms.index', compact('channelPsms', 'channels', 'psms'));
    }

    public function create()
    {
        abort_if(Gate::denies('channel_psm_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channels = Channel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $psms = Psm::pluck('spectra', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.channelPsms.create', compact('channels', 'psms'));
    }

    public function store(StoreChannelPsmRequest $request)
    {
        $channelPsm = ChannelPsm::create($request->all());

        return redirect()->route('frontend.channel-psms.index');
    }

    public function edit(ChannelPsm $channelPsm)
    {
        abort_if(Gate::denies('channel_psm_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channels = Channel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $psms = Psm::pluck('spectra', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channelPsm->load('channel', 'psm');

        return view('frontend.channelPsms.edit', compact('channelPsm', 'channels', 'psms'));
    }

    public function update(UpdateChannelPsmRequest $request, ChannelPsm $channelPsm)
    {
        $channelPsm->update($request->all());

        return redirect()->route('frontend.channel-psms.index');
    }

    public function show(ChannelPsm $channelPsm)
    {
        abort_if(Gate::denies('channel_psm_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channelPsm->load('channel', 'psm');

        return view('frontend.channelPsms.show', compact('channelPsm'));
    }

    public function destroy(ChannelPsm $channelPsm)
    {
        abort_if(Gate::denies('channel_psm_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channelPsm->delete();

        return back();
    }

    public function massDestroy(MassDestroyChannelPsmRequest $request)
    {
        ChannelPsm::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
