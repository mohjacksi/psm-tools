<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUploadFormRequest;
use App\Http\Requests\StoreUploadFormRequest;
use App\Http\Requests\UpdateUploadFormRequest;
use App\Models\Experiment;
use App\Models\Project;
use App\Models\UploadForm;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UploadFormController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('upload_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UploadForm::with(['project', 'experiment', 'created_by'])->select(sprintf('%s.*', (new UploadForm())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'upload_form_show';
                $editGate = 'upload_form_edit';
                $deleteGate = 'upload_form_delete';
                $crudRoutePart = 'upload-forms';

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
            $table->addColumn('project_name', function ($row) {
                return $row->project ? $row->project->name : '';
            });

            $table->addColumn('experiment_name', function ($row) {
                return $row->experiment ? $row->experiment->name : '';
            });

            $table->editColumn('psm_file', function ($row) {
                return $row->psm_file ? '<a href="' . $row->psm_file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'project', 'experiment', 'psm_file']);

            return $table->make(true);
        }

        return view('admin.uploadForms.index');
    }

    public function create()
    {
        abort_if(Gate::denies('upload_form_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $experiments = Experiment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.uploadForms.create', compact('experiments', 'projects'));
    }

    public function store(StoreUploadFormRequest $request)
    {
        $uploadForm = UploadForm::create($request->all());

        if ($request->input('psm_file', false)) {
            $uploadForm->addMedia(storage_path('tmp/uploads/' . basename($request->input('psm_file'))))->toMediaCollection('psm_file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $uploadForm->id]);
        }

        return redirect()->route('admin.upload-forms.index');
    }

    public function edit(UploadForm $uploadForm)
    {
        abort_if(Gate::denies('upload_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $experiments = Experiment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $uploadForm->load('project', 'experiment', 'created_by');

        return view('admin.uploadForms.edit', compact('experiments', 'projects', 'uploadForm'));
    }

    public function update(UpdateUploadFormRequest $request, UploadForm $uploadForm)
    {
        $uploadForm->update($request->all());

        if ($request->input('psm_file', false)) {
            if (!$uploadForm->psm_file || $request->input('psm_file') !== $uploadForm->psm_file->file_name) {
                if ($uploadForm->psm_file) {
                    $uploadForm->psm_file->delete();
                }
                $uploadForm->addMedia(storage_path('tmp/uploads/' . basename($request->input('psm_file'))))->toMediaCollection('psm_file');
            }
        } elseif ($uploadForm->psm_file) {
            $uploadForm->psm_file->delete();
        }

        return redirect()->route('admin.upload-forms.index');
    }

    public function show(UploadForm $uploadForm)
    {
        abort_if(Gate::denies('upload_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $uploadForm->load('project', 'experiment', 'created_by');

        return view('admin.uploadForms.show', compact('uploadForm'));
    }

    public function destroy(UploadForm $uploadForm)
    {
        abort_if(Gate::denies('upload_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $uploadForm->delete();

        return back();
    }

    public function massDestroy(MassDestroyUploadFormRequest $request)
    {
        UploadForm::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('upload_form_create') && Gate::denies('upload_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new UploadForm();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
