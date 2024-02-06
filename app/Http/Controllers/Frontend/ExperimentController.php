<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyExperimentRequest;
use App\Http\Requests\StoreExperimentRequest;
use App\Http\Requests\UpdateExperimentRequest;
use App\Models\BiologicalSet;
use App\Models\Experiment;
use App\Models\Project;
use App\Models\Sample;
use App\Models\Species;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ExperimentController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index()
    {

        $experiments = Experiment::with(['project', 'species', 'created_by'])->get();

        $projects = Project::get();

        $speciess = Species::get();

        $users = User::get();

        return view('frontend.experiments.index', compact('experiments', 'projects', 'speciess', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('experiment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $species = Species::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.experiments.create', compact('projects', 'species'));
    }

    public function store(StoreExperimentRequest $request)
    {
        $experiment = Experiment::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $experiment->id]);
        }

        return redirect()->route('frontend.experiments.index');
    }

    public function edit(Experiment $experiment)
    {
        abort_if(Gate::denies('experiment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $species = Species::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $experiment->load('project', 'species', 'created_by');

        return view('frontend.experiments.edit', compact('experiment', 'projects', 'species'));
    }

    public function update(UpdateExperimentRequest $request, Experiment $experiment)
    {
        $experiment->update($request->all());

        return redirect()->route('frontend.experiments.index');
    }

    public function show(Experiment $experiment)
    {
        $experiment->load('project', 'species', 'created_by', 'experimentBiologicalSets');

        return view('frontend.experiments.show', compact('experiment'));
    }

    public function destroy(Experiment $experiment)
    {
        abort_if(Gate::denies('experiment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiment->delete();

        return back();
    }

    public function massDestroy(MassDestroyExperimentRequest $request)
    {
        Experiment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('experiment_create') && Gate::denies('experiment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Experiment();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function experimentsOfProject($project_id)
    {

        if ($project_id=='undefined'){

            $experiments = Experiment::get();
            $samples = Sample::get();
            $biologicalSets = BiologicalSet::get();
        }elseif ($project_id != 'undefined'){

            $experiments = Experiment::where('project_id', $project_id)->get();
            $samples = Sample::where('project_id', $project_id)->get();
            $biologicalSets = BiologicalSet::whereHas('experiment', function($q) use ($project_id){
                $q->where('project_id', $project_id);
            })->get();
        }else{

            $experiments = Experiment::get();
            $samples = Sample::get();
            $biologicalSets = BiologicalSet::get();
        }

        $response = [
            'experiments'=>$experiments,
            'samples'=>$samples,
            'biologicalSets'=>$biologicalSets,
        ];
        return $response;
    }
}
