<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySampleRequest;
use App\Http\Requests\StoreSampleRequest;
use App\Http\Requests\UpdateSampleRequest;
use App\Models\Channel;
use App\Models\Project;
use App\Models\Sample;
use App\Models\SampleCondition;
use App\Models\Species;
use App\Models\Tissue;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class SampleController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index()
    {

        $samples = Sample::with(['project', 'channels', 'species', 'tissue', 'sample_condition', 'created_by'])->get();

        $projects = Project::get();

        $channels = Channel::get();

        $speciess = Species::get();

        $tissues = Tissue::get();

        $sample_conditions = SampleCondition::get();

        $users = User::get();

        return view('frontend.samples.index', compact('channels', 'projects', 'sample_conditions', 'samples', 'speciess', 'tissues', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('sample_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channels = Channel::pluck('name', 'id');

        $species = Species::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tissues = Tissue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sample_conditions = SampleCondition::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.samples.create', compact('channels', 'projects', 'sample_conditions', 'species', 'tissues'));
    }

    public function store(StoreSampleRequest $request)
    {
        $sample = Sample::create($request->all());
        $sample->channels()->sync($request->input('channels', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $sample->id]);
        }

        return redirect()->route('frontend.samples.index');
    }

    public function edit(Sample $sample)
    {
        abort_if(Gate::denies('sample_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channels = Channel::pluck('name', 'id');

        $species = Species::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tissues = Tissue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sample_conditions = SampleCondition::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sample->load('project', 'channels', 'species', 'tissue', 'sample_condition', 'created_by');

        return view('frontend.samples.edit', compact('channels', 'projects', 'sample', 'sample_conditions', 'species', 'tissues'));
    }

    public function update(UpdateSampleRequest $request, Sample $sample)
    {
        $sample->update($request->all());
        $sample->channels()->sync($request->input('channels', []));

        return redirect()->route('frontend.samples.index');
    }

    public function show(Sample $sample)
    {

        $sample->load('project', 'channels', 'species', 'tissue', 'sample_condition', 'created_by');

        return view('frontend.samples.show', compact('sample'));
    }

    public function destroy(Sample $sample)
    {
        abort_if(Gate::denies('sample_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sample->delete();

        return back();
    }

    public function massDestroy(MassDestroySampleRequest $request)
    {
        Sample::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('sample_create') && Gate::denies('sample_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Sample();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
