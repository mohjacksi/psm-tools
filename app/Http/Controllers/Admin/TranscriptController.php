<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTranscriptRequest;
use App\Http\Requests\StoreTranscriptRequest;
use App\Http\Requests\UpdateTranscriptRequest;
use App\Models\DnaRegion;
use App\Models\Transcript;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TranscriptController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('transcript_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transcripts = Transcript::with(['dna_location'])->get();

        return view('admin.transcripts.index', compact('transcripts'));
    }

    public function create()
    {
        abort_if(Gate::denies('transcript_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dna_locations = DnaRegion::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.transcripts.create', compact('dna_locations'));
    }

    public function store(StoreTranscriptRequest $request)
    {
        $transcript = Transcript::create($request->all());

        return redirect()->route('admin.transcripts.index');
    }

    public function edit(Transcript $transcript)
    {
        abort_if(Gate::denies('transcript_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dna_locations = DnaRegion::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transcript->load('dna_location');

        return view('admin.transcripts.edit', compact('dna_locations', 'transcript'));
    }

    public function update(UpdateTranscriptRequest $request, Transcript $transcript)
    {
        $transcript->update($request->all());

        return redirect()->route('admin.transcripts.index');
    }

    public function show(Transcript $transcript)
    {
        abort_if(Gate::denies('transcript_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transcript->load('dna_location');

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
