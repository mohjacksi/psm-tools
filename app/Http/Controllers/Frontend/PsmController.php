<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPsmRequest;
use App\Http\Requests\StorePsmRequest;
use App\Http\Requests\UpdatePsmRequest;
use App\Models\BiologicalSet;
use App\Models\Experiment;
use App\Models\Fraction;
use App\Models\PeptideWithModification;
use App\Models\Project;
use App\Models\Psm;
use App\Models\Sample;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PsmController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        $psms = Psm::with(['fraction', 'peptide_with_modification', 'created_by'])->limit(20)->get();

        if ($request->ajax()) {


            if (isset($request->tissue) && $request->tissue != null || isset($request['amp;tissue'])&& $request->tissue != null  ){

                $query = Psm::where('tissue_id',$request->tissue)->with(['peptide_with_modification', 'created_by', 'samples','fraction', 'project', 'experiment', 'biological_set'])->select(sprintf('%s.*', (new Psm())->table));

            }else{

                $query = Psm::with(['peptide_with_modification', 'created_by', 'samples','fraction', 'project', 'experiment', 'biological_set'])->select(sprintf('%s.*', (new Psm())->table));

            }
            //$query = Psm::with(['peptide_with_modification', 'created_by', 'samples','fraction', 'project', 'experiment', 'biological_set'])->select(sprintf('%s.*', (new Psm())->table));
            $table = DataTables::of($query);

            // dd($query->samples->project);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'psm_show';
                $editGate = 'psm_edit';
                $deleteGate = 'psm_delete';
                $crudRoutePart = 'psms';

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
            $table->editColumn('spectra', function ($row) {
                return $row->spectra ? $row->spectra : '';
            });
            if (isset($request->sample) && $request->sample != null){
                $table->addColumn('samples', function ($row) {

                    $samples['name']=request('sample');
                    if ($row->samples->count()>0) {
                        foreach ($row->samples as $sample) {
                            $samples['name'] = $samples['name'] ."\r\n".$sample->name;
                        }
                    }
                    return $samples['name'];
                });
            }else{

                $table->addColumn('samples', function ($row) {

                    $samples['name']='';
                    if ($row->samples->count()>0) {
                        foreach ($row->samples as $sample) {
                            $samples['name'] = $samples['name'] ."\r\n".$sample->name;
                        }
                    }
                    return $samples['name'];
                });
            }

            $table->addColumn('project', function ($row) {
                return $row->project ? $row->project : '';
            });
            $table->addColumn('biological_set', function ($row) {
                return $row->biological_set ? $row->biological_set : '';
            });
            $table->addColumn('experiment', function ($row) {
                return $row->experiment ? $row->experiment : '';
            });
            $table->addColumn('fraction_name', function ($row) {
                return $row->fraction ? $row->fraction->name : '';
            });

            $table->editColumn('scan_num', function ($row) {
                return $row->scan_num ? $row->scan_num : '';
            });
            $table->editColumn('precursor', function ($row) {
                return $row->precursor ? $row->precursor : '';
            });
            $table->editColumn('isotope_error', function ($row) {
                return $row->isotope_error ? $row->isotope_error : '';
            });
            $table->editColumn('precursor_error', function ($row) {
                return $row->precursor_error ? $row->precursor_error : '';
            });
            $table->editColumn('charge', function ($row) {
                return $row->charge ? $row->charge : '';
            });
            $table->editColumn('de_novo_score', function ($row) {
                return $row->de_novo_score ? $row->de_novo_score : '';
            });
            $table->editColumn('msgf_score', function ($row) {
                return $row->msgf_score ? $row->msgf_score : '';
            });
            $table->editColumn('space_evalue', function ($row) {
                return $row->space_evalue ? $row->space_evalue : '';
            });
            $table->editColumn('evalue', function ($row) {
                return $row->evalue ? $row->evalue : '';
            });
            $table->editColumn('precursor_svm_score', function ($row) {
                return $row->precursor_svm_score ? $row->precursor_svm_score : '';
            });
            $table->editColumn('psm_q_value', function ($row) {
                return $row->psm_q_value ? $row->psm_q_value : '';
            });
            $table->editColumn('peptide_q_value', function ($row) {
                return $row->peptide_q_value ? $row->peptide_q_value : '';
            });
            $table->editColumn('missed_clevage', function ($row) {
                return $row->missed_clevage ? $row->missed_clevage : '';
            });
            $table->editColumn('experimental_pl', function ($row) {
                return $row->experimental_pl ? $row->experimental_pl : '';
            });
            $table->editColumn('predicted_pl', function ($row) {
                return $row->predicted_pl ? $row->predicted_pl : '';
            });
            $table->editColumn('delta_pl', function ($row) {
                return $row->delta_pl ? $row->delta_pl : '';
            });
            $table->addColumn('peptide_with_modification_name', function ($row) {
                return $row->peptide_with_modification ? $row->peptide_with_modification->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'fraction', 'peptide_with_modification']);

            return $table->make(true);
        }

        $fractions                  = Fraction::get();
        $peptide_with_modifications = PeptideWithModification::get();
        $users                      = User::get();
        $samples                    = Sample::with('psms')->get();
        $projects                   = Project::get();
        $biological_sets             = BiologicalSet::get();
        $experiments                = Experiment::get();


        return view(
            'frontend.psms.index',
            compact('psms', 'fractions', 'peptide_with_modifications', 'users', 'projects', 'experiments', 'biological_sets', 'samples')
        );
    }

    public function create()
    {
        abort_if(Gate::denies('psm_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fractions = Fraction::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peptide_with_modifications = PeptideWithModification::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.psms.create', compact('fractions', 'peptide_with_modifications'));
    }

    public function store(StorePsmRequest $request)
    {
        $psm = Psm::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $psm->id]);
        }

        return redirect()->route('frontend.psms.index');
    }

    public function edit(Psm $psm)
    {
        abort_if(Gate::denies('psm_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fractions = Fraction::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $peptide_with_modifications = PeptideWithModification::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $psm->load('fraction', 'peptide_with_modification', 'created_by');

        return view('frontend.psms.edit', compact('fractions', 'peptide_with_modifications', 'psm'));
    }

    public function update(UpdatePsmRequest $request, Psm $psm)
    {
        $psm->update($request->all());

        return redirect()->route('frontend.psms.index');
    }

    public function show(Psm $psm)
    {
        $psm->load('fraction', 'peptide_with_modification', 'created_by');

        return view('frontend.psms.show', compact('psm'));
    }

    public function destroy(Psm $psm)
    {
        abort_if(Gate::denies('psm_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $psm->delete();

        return back();
    }

    public function massDestroy(MassDestroyPsmRequest $request)
    {
        Psm::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('psm_create') && Gate::denies('psm_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Psm();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
