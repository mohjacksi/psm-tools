<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class ExperimentController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('experiment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Experiment::with(['project', 'species', 'created_by'])->select(sprintf('%s.*', (new Experiment())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'experiment_show';
                $editGate = 'experiment_edit';
                $deleteGate = 'experiment_delete';
                $crudRoutePart = 'experiments';

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
            $table->addColumn('project_name', function ($row) {
                return $row->project ? $row->project->name : '';
            });

            $table->editColumn('method', function ($row) {
                return $row->method ? Experiment::METHOD_SELECT[$row->method] : '';
            });
            $table->editColumn('allowed_missed_cleavage', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->allowed_missed_cleavage ? 'checked' : null) . '>';
            });
            $table->editColumn('expression_threshold', function ($row) {
                return $row->expression_threshold ? $row->expression_threshold : '';
            });
            $table->addColumn('species_name', function ($row) {
                return $row->species ? $row->species->name : '';
            });

            $table->editColumn('reference_protein_source', function ($row) {
                return $row->reference_protein_source ? $row->reference_protein_source : '';
            });
            $table->editColumn('other_protein_source', function ($row) {
                return $row->other_protein_source ? $row->other_protein_source : '';
            });
            $table->editColumn('psm_file_name', function ($row) {
                return $row->psm_file_name ? $row->psm_file_name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'project', 'allowed_missed_cleavage', 'species']);

            return $table->make(true);
        }

        $projects = Project::get();
        $speciess = Species::get();
        $users    = User::get();

        return view('admin.experiments.index', compact('projects', 'speciess', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('experiment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $species = Species::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.experiments.create', compact('projects', 'species'));
    }

    public function store(StoreExperimentRequest $request)
    {
        $experiment = Experiment::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $experiment->id]);
        }
        if ($request->ajax()) {
            return $experiment;
        }
        return redirect()->route('admin.experiments.index');
    }

    public function edit(Experiment $experiment)
    {
        abort_if(Gate::denies('experiment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $species = Species::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $experiment->load('project', 'species', 'created_by');

        return view('admin.experiments.edit', compact('experiment', 'projects', 'species'));
    }

    public function update(UpdateExperimentRequest $request, Experiment $experiment)
    {
        $experiment->update($request->all());

        return redirect()->route('admin.experiments.index');
    }

    public function show(Experiment $experiment)
    {
        abort_if(Gate::denies('experiment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $experiment->load('project', 'species', 'created_by', 'experimentUploadForms', 'experimentBiologicalSets');

        return view('admin.experiments.show', compact('experiment'));
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
        if($project_id > 0){
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
