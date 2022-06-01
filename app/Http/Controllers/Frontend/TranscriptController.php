<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTranscriptRequest;
use App\Http\Requests\StoreTranscriptRequest;
use App\Http\Requests\UpdateTranscriptRequest;
use App\Models\Transcript;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TranscriptController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('transcript_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transcripts = Transcript::all();

        return view('frontend.transcripts.index', compact('transcripts'));
    }

    public function create()
    {
        abort_if(Gate::denies('transcript_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.transcripts.create');
    }

    public function store(StoreTranscriptRequest $request)
    {
        $transcript = Transcript::create($request->all());

        return redirect()->route('frontend.transcripts.index');
    }

    public function edit(Transcript $transcript)
    {
        abort_if(Gate::denies('transcript_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.transcripts.edit', compact('transcript'));
    }

    public function update(UpdateTranscriptRequest $request, Transcript $transcript)
    {
        $transcript->update($request->all());

        return redirect()->route('frontend.transcripts.index');
    }

    public function show(Transcript $transcript)
    {
        abort_if(Gate::denies('transcript_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.transcripts.show', compact('transcript'));
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
