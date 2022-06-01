<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyChannelRequest;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use App\Models\BiologicalSet;
use App\Models\Channel;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChannelController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('channel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channels = Channel::with(['biological_set', 'created_by'])->get();

        $biological_sets = BiologicalSet::get();

        $users = User::get();

        return view('frontend.channels.index', compact('biological_sets', 'channels', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('channel_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biological_sets = BiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.channels.create', compact('biological_sets'));
    }

    public function store(StoreChannelRequest $request)
    {
        $channel = Channel::create($request->all());

        return redirect()->route('frontend.channels.index');
    }

    public function edit(Channel $channel)
    {
        abort_if(Gate::denies('channel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biological_sets = BiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channel->load('biological_set', 'created_by');

        return view('frontend.channels.edit', compact('biological_sets', 'channel'));
    }

    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $channel->update($request->all());

        return redirect()->route('frontend.channels.index');
    }

    public function show(Channel $channel)
    {
        abort_if(Gate::denies('channel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channel->load('biological_set', 'created_by', 'channelSamples');

        return view('frontend.channels.show', compact('channel'));
    }

    public function destroy(Channel $channel)
    {
        abort_if(Gate::denies('channel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channel->delete();

        return back();
    }

    public function massDestroy(MassDestroyChannelRequest $request)
    {
        Channel::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
