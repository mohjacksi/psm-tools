<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyChannelRequest;
use App\Http\Requests\StoreChannelRequest;
use App\Http\Requests\UpdateChannelRequest;
use App\Models\BiologicalSet;
use App\Models\Channel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ChannelController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('channel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Channel::with(['biological_set'])->select(sprintf('%s.*', (new Channel())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'channel_show';
                $editGate = 'channel_edit';
                $deleteGate = 'channel_delete';
                $crudRoutePart = 'channels';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('biological_set_name', function ($row) {
                return $row->biological_set ? $row->biological_set->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'biological_set']);

            return $table->make(true);
        }

        $biological_sets = BiologicalSet::get();

        return view('admin.channels.index', compact('biological_sets'));
    }

    public function create()
    {
        abort_if(Gate::denies('channel_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biological_sets = BiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.channels.create', compact('biological_sets'));
    }

    public function store(StoreChannelRequest $request)
    {
        $channel = Channel::create($request->all());

        return redirect()->route('admin.channels.index');
    }

    public function edit(Channel $channel)
    {
        abort_if(Gate::denies('channel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $biological_sets = BiologicalSet::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channel->load('biological_set');

        return view('admin.channels.edit', compact('biological_sets', 'channel'));
    }

    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        $channel->update($request->all());

        return redirect()->route('admin.channels.index');
    }

    public function show(Channel $channel)
    {
        abort_if(Gate::denies('channel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $channel->load('biological_set', 'channelChannelPsms', 'channelSamples');

        return view('admin.channels.show', compact('channel'));
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
