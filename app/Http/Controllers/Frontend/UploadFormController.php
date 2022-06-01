<?php

namespace App\Http\Controllers\Frontend;

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

class UploadFormController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('upload_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $uploadForms = UploadForm::with(['project', 'experiment', 'created_by', 'media'])->get();

        return view('frontend.uploadForms.index', compact('uploadForms'));
    }

    public function create()
    {
        abort_if(Gate::denies('upload_form_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $experiments = Experiment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.uploadForms.create', compact('experiments', 'projects'));
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

        return redirect()->route('frontend.upload-forms.index');
    }

    public function edit(UploadForm $uploadForm)
    {
        abort_if(Gate::denies('upload_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $experiments = Experiment::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $uploadForm->load('project', 'experiment', 'created_by');

        return view('frontend.uploadForms.edit', compact('experiments', 'projects', 'uploadForm'));
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

        return redirect()->route('frontend.upload-forms.index');
    }

    public function show(UploadForm $uploadForm)
    {
        abort_if(Gate::denies('upload_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $uploadForm->load('project', 'experiment', 'created_by');

        return view('frontend.uploadForms.show', compact('uploadForm'));
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
