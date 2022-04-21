<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySampleRequest;
use App\Http\Requests\StoreSampleRequest;
use App\Http\Requests\UpdateSampleRequest;
use App\Models\Channel;
use App\Models\Person;
use App\Models\Project;
use App\Models\Sample;
use App\Models\Tissue;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SampleController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sample_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Sample::with(['person', 'project', 'channel', 'tissue'])->select(sprintf('%s.*', (new Sample())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'sample_show';
                $editGate = 'sample_edit';
                $deleteGate = 'sample_delete';
                $crudRoutePart = 'samples';

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
            $table->editColumn('sample_type', function ($row) {
                return $row->sample_type ? Sample::SAMPLE_TYPE_SELECT[$row->sample_type] : '';
            });
            $table->addColumn('person_name', function ($row) {
                return $row->person ? $row->person->name : '';
            });

            $table->addColumn('project_name', function ($row) {
                return $row->project ? $row->project->name : '';
            });

            $table->addColumn('channel_name', function ($row) {
                return $row->channel ? $row->channel->name : '';
            });

            $table->addColumn('tissue_name', function ($row) {
                return $row->tissue ? $row->tissue->name : '';
            });

            $table->editColumn('sample_condition', function ($row) {
                return $row->sample_condition ? $row->sample_condition : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'person', 'project', 'channel', 'tissue']);

            return $table->make(true);
        }

        $people   = Person::get();
        $projects = Project::get();
        $channels = Channel::get();
        $tissues  = Tissue::get();

        return view('admin.samples.index', compact('people', 'projects', 'channels', 'tissues'));
    }

    public function create()
    {
        abort_if(Gate::denies('sample_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channels = Channel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tissues = Tissue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.samples.create', compact('channels', 'people', 'projects', 'tissues'));
    }

    public function store(StoreSampleRequest $request)
    {
        $sample = Sample::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $sample->id]);
        }

        return redirect()->route('admin.samples.index');
    }

    public function edit(Sample $sample)
    {
        abort_if(Gate::denies('sample_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $people = Person::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $channels = Channel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tissues = Tissue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sample->load('person', 'project', 'channel', 'tissue');

        return view('admin.samples.edit', compact('channels', 'people', 'projects', 'sample', 'tissues'));
    }

    public function update(UpdateSampleRequest $request, Sample $sample)
    {
        $sample->update($request->all());

        return redirect()->route('admin.samples.index');
    }

    public function show(Sample $sample)
    {
        abort_if(Gate::denies('sample_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sample->load('person', 'project', 'channel', 'tissue');

        return view('admin.samples.show', compact('sample'));
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
