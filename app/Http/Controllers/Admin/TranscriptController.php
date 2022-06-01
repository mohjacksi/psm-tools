<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTranscriptRequest;
use App\Http\Requests\StoreTranscriptRequest;
use App\Http\Requests\UpdateTranscriptRequest;
use App\Models\Transcript;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TranscriptController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('transcript_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Transcript::query()->select(sprintf('%s.*', (new Transcript())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'transcript_show';
                $editGate = 'transcript_edit';
                $deleteGate = 'transcript_delete';
                $crudRoutePart = 'transcripts';

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
            $table->editColumn('transcript', function ($row) {
                return $row->transcript ? $row->transcript : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? Transcript::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('transcript_sequence', function ($row) {
                return $row->transcript_sequence ? $row->transcript_sequence : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.transcripts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('transcript_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transcripts.create');
    }

    public function store(StoreTranscriptRequest $request)
    {
        $transcript = Transcript::create($request->all());

        return redirect()->route('admin.transcripts.index');
    }

    public function edit(Transcript $transcript)
    {
        abort_if(Gate::denies('transcript_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transcripts.edit', compact('transcript'));
    }

    public function update(UpdateTranscriptRequest $request, Transcript $transcript)
    {
        $transcript->update($request->all());

        return redirect()->route('admin.transcripts.index');
    }

    public function show(Transcript $transcript)
    {
        abort_if(Gate::denies('transcript_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.transcripts.show', compact('transcript'));
    }

    public function destroy(Transcript $transcript)
    {
        abort_if(Gate::denies('transcript_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transcript->delete();

        return back();
    }

    public function massDestroy(MassDestroyTranscriptRequest $request)
    {
        Transcript::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
