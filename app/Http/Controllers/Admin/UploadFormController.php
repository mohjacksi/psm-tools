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
use App\Imports\PsmImport;
use App\Models\BiologicalSet;
use App\Models\Fraction;
use App\Models\FragmentMethod;
use App\Models\Peptide;
use App\Models\PeptideWithModification;
use App\Models\Psm;
use App\Models\Sample;
use App\Models\ChannelSample;
use App\Models\Channel;
use App\Models\User;
use App\Models\Species;
use App\Models\Tissue;
use App\Models\SampleCondition;
use CreateBiologicalSetExperimentPivotTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

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

        $samples = Sample::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $species = Species::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $channels = Channel::pluck('name', 'id');
        $tissues = Tissue::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $sample_conditions = SampleCondition::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.uploadForms.create', compact('experiments', 'projects','samples','created_bies','species','channels','tissues','sample_conditions'));
    }

    public function store(StoreUploadFormRequest $request)
    {
        // dd($request->all());

        if($request->input('peptide_file') != null){
            app('App\Http\Controllers\Admin\PeptideController')->uploadTsv($request);
        }
        if($request->input('protein_file') != null){
            app('App\Http\Controllers\Admin\ProteinController')->uploadTsv($request);
        }

        $uploadForm = UploadForm::create($request->all());

        if ($request->input('psm_file', false)) {
            DB::beginTransaction();
            $psmFile = storage_path('tmp/uploads/' . basename($request->input('psm_file')));
            $psmAsArray = Excel::toArray('', $psmFile);
            $psmFields = array(
                "SpectraFile",
                "Biological set",
                "SpecID",
                "ScanNum",
                "FragMethod",
                "Precursor",
                "IsotopeError",
                "PrecursorError(ppm)",
                "Charge",
                "Peptide",
                "Protein",
                "DeNovoScore",
                "MSGFScore",
                "SpecEValue",
                "EValue",
                "percolator svm-score",
                "PSM q-value",
                "peptide q-value"
            );
            $fieldsOrder = [];
            foreach ($psmFields as $field) {
                $fieldsOrder[$field] = array_search($field, $psmAsArray[0][0]);
            }
            $experiment = Experiment::find($request->input('experiment_id'));
            $project = Project::find($request->input('project_id'));
            foreach ($psmAsArray[0] as $key => $psm) {
                if ($key > 0) {
                    $FragmentMethod = FragmentMethod::where('name', $psm[$fieldsOrder['FragMethod']])->firstOrCreate(
                        [
                            'name' => $psm[$fieldsOrder['FragMethod']],
                            'created_by_id' => auth()->user()->id
                        ]
                    );
                    $BiologicalSet = BiologicalSet::where('name', $psm[$fieldsOrder['Biological set']])->firstOrCreate(
                        [
                            'name' => $psm[$fieldsOrder['Biological set']],
                            'created_by_id' => auth()->user()->id,
                            'fragment_method_id' => $FragmentMethod->id,
                            'experiment_id' => $experiment->id,
                        ]
                    );
                    // if (!$BiologicalSet->hasExperiment($experiment)) {
                    //     $BiologicalSet->experiments()->attach($experiment);
                    // }
                    // if (!$experiment->hasBiologicalSet($BiologicalSet)) {
                    //     $experiment->experimentBiologicalSets()->attach($BiologicalSet);
                    // }
                    $Fraction = Fraction::where('name', $psm[$fieldsOrder['SpectraFile']])->firstOrCreate(
                        [
                            'name' => $psm[$fieldsOrder['SpectraFile']],
                            'spectra_file_name' => $psm[$fieldsOrder['SpectraFile']],
                            'biological_set_id' => $BiologicalSet->id,
                        ]
                    );
                    $PeptideWithModification = PeptideWithModification::where('name', $psm[$fieldsOrder['Peptide']])->firstOrCreate(
                        [
                            'name' => $psm[$fieldsOrder['Peptide']],
                            'created_by_id' => auth()->user()->id
                        ]
                    );
                    $PeptideAZ = preg_replace("/[^A-Z]+/", "", $psm[$fieldsOrder['Peptide']]);
                    $Peptide = Peptide::where('sequence', $PeptideAZ)->firstOrCreate(
                        [
                            'sequence' => $PeptideAZ,
                            'created_by_id' => auth()->user()->id
                        ]
                    );

                    $newPsm = Psm::create([
                        'spectra' => $psm[$fieldsOrder['SpectraFile']],
                        'peptide_modification' => $psm[$fieldsOrder['Peptide']],
                        'scan_num' => $psm[$fieldsOrder['ScanNum']],
                        'precursor' => $psm[$fieldsOrder['Precursor']],
                        'isotope_error' => $psm[$fieldsOrder['IsotopeError']],
                        'precursor_error' => $psm[$fieldsOrder['PrecursorError(ppm)']],
                        'charge' => $psm[$fieldsOrder['Charge']],
                        'de_novo_score' => $psm[$fieldsOrder['DeNovoScore']],
                        'msgf_score' => $psm[$fieldsOrder['MSGFScore']],
                        'space_evalue' => $psm[$fieldsOrder['SpecEValue']],
                        'evalue' => $psm[$fieldsOrder['EValue']],
                        'precursor_svm_score' => $psm[$fieldsOrder['percolator svm-score']],
                        'psm_q_value' => $psm[$fieldsOrder['PSM q-value']],
                        'peptide_q_value' => $psm[$fieldsOrder['peptide q-value']],
                        'fraction_id' => $Fraction->id,
                        'project_id' => $project->id,
                        'experiment_id' => $experiment->id,
                        'species_id' => $experiment->species_id,
                        'biological_set_id' => $BiologicalSet->id,
                        'peptide_with_modification_id' => $PeptideWithModification->id,
                        'peptideid' => $Peptide->id,
                        'created_by_id' => auth()->user()->id,
                    ]);

                    if($request->all()['sample_number'] > 0){
                        foreach ($request->all()['samples'] as $key=>$sample){
                            $channelOdrer=array_search($request->all()['chennels'][$key], $psmAsArray[0][0]);
                            if($channelOdrer){
                                $newChennel = Channel::where('name', $request->all()['chennels'][$key])->firstOrCreate(
                                    [
                                        'name' => $request->all()['chennels'][$key],
                                        'created_by_id' => auth()->user()->id
                                    ]
                                );
                                $channelSample = ChannelSample::where('channel_id', $newChennel->id)
                                ->where('psm_id', $newPsm->id)
                                ->where('sample_id', $sample)
                                ->firstOrCreate(
                                    [
                                        'channel_id' => $newChennel->id,
                                        'psm_id' => $newPsm->id,
                                        'sample_id' => $sample,
                                        'channel_value' => $psm[$channelOdrer],
                                    ]
                                );
                            }

                        }
                    }
                }
            }


            $uploadForm->addMedia(storage_path('tmp/uploads/' . basename($request->input('psm_file'))))->toMediaCollection('psm_file');
            DB::commit();
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
