<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTranscriptRequest;
use App\Http\Requests\UpdateTranscriptRequest;
use App\Http\Resources\Admin\TranscriptResource;
use App\Models\Transcript;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TranscriptApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('transcript_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TranscriptResource(Transcript::all());
    }

    public function store(StoreTranscriptRequest $request)
    {
        $transcript = Transcript::create($request->all());

        return (new TranscriptResource($transcript))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Transcript $transcript)
    {
        abort_if(Gate::denies('transcript_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TranscriptResource($transcript);
    }

    public function update(UpdateTranscriptRequest $request, Transcript $transcript)
    {
        $transcript->update($request->all());

        return (new TranscriptResource($transcript))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Transcript $transcript)
    {
        abort_if(Gate::denies('transcript_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transcript->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
